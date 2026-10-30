// Shared helpers for the HTTP integration suite. Runs against the Docker stack
// (see docs/TEST_REPORT.md) seeded with database/seeds/seed_mock_data.php.
import { execFileSync } from 'node:child_process';
import assert from 'node:assert/strict';

export const BASE = process.env.BASE_URL || 'http://localhost:8091';
export const API_KEY = process.env.API_KEY || 'mock-api-key';
export const MOCK_PASSWORD = 'MockPass123!';
const DB_CONTAINER = process.env.DB_CONTAINER || 'deltaone-review-db-1';
const DB_PASS = process.env.DB_PASS || 'codereg';

// Runs SQL in the test DB container and returns rows as arrays of strings.
export function sql(query) {
  const out = execFileSync('docker', ['exec', DB_CONTAINER, 'mysql', '-uroot', `-p${DB_PASS}`, 'stock', '-N', '-B', '-e', query], { encoding: 'utf8', stdio: ['ignore', 'pipe', 'ignore'] });
  return out.trim() ? out.trim().split('\n').map((l) => l.split('\t')) : [];
}
export const one = (query) => sql(query)[0]?.[0];

export class Client {
  cookies = {};

  async req(path, { method = 'GET', form, body, headers = {} } = {}) {
    const h = { ...headers };
    const jar = Object.entries(this.cookies).map(([k, v]) => `${k}=${v}`).join('; ');
    if (jar) h.cookie = jar;
    if (form) {
      body = new URLSearchParams();
      for (const [k, v] of Object.entries(form)) {
        for (const item of [].concat(v)) body.append(k, item);
      }
    }
    if (body) method = 'POST';
    const send = () => fetch(BASE + path, { method, body, headers: h, redirect: 'manual' });
    // sql() blocks the event loop past Apache's keep-alive timeout, so a pooled socket
    // can already be closed by the server; the request never reached it, so resend once.
    const res = await send().catch((e) => (e.message === 'fetch failed' && !e.cause?.code?.startsWith?.('ECONNREFUSED') ? send() : Promise.reject(e)));
    for (const c of res.headers.getSetCookie()) {
      const [pair] = c.split(';');
      const [k, v] = pair.split('=');
      if (v === 'deleted' || /expires=Thu, 01-Jan-1970/i.test(c)) delete this.cookies[k];
      else this.cookies[k] = v;
    }
    res.text_ = await res.text();
    return res;
  }

  login(email, password = MOCK_PASSWORD) {
    return this.req('/auth/login', { form: { email, password } });
  }
}

// CodeIgniter's redirect($uri, 'refresh') sends a Refresh header instead of Location.
export function redirectTarget(res) {
  const r = res.headers.get('refresh') || res.headers.get('location') || '';
  return r.replace(/^\d+;\s*url=/i, '').replace(BASE, '');
}

export async function as(role) {
  const c = new Client();
  const res = await c.login(`${role}@mock.test`);
  assert.equal(redirectTarget(res), '/dashboard', `login as ${role} failed`);
  return c;
}

// Page rendered by the framework without PHP notices, DB errors or a bounce.
export function assertCleanPage(res, label) {
  assert.equal(res.status, 200, `${label}: HTTP ${res.status}`);
  assert.equal(redirectTarget(res), '', `${label}: redirected to ${redirectTarget(res)}`);
  assert.doesNotMatch(res.text_, /A PHP Error was encountered|A Database Error Occurred|An uncaught Exception|Fatal error|Parse error/, `${label}: error output`);
}
