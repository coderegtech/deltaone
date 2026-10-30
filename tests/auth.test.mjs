import { test } from 'node:test';
import assert from 'node:assert/strict';
import { Client, as, redirectTarget, assertCleanPage } from './helpers.mjs';

test('login page renders', async () => {
  const res = await new Client().req('/auth/login');
  assertCleanPage(res, 'login');
  assert.match(res.text_, /name="email"/);
});

test('empty login form shows validation errors', async () => {
  const res = await new Client().req('/auth/login', { form: { email: '', password: '' } });
  assertCleanPage(res, 'empty login');
  assert.match(res.text_, /field is required/);
});

test('unknown email is rejected', async () => {
  const res = await new Client().login('nobody@mock.test');
  assert.equal(redirectTarget(res), '');
  assert.match(res.text_, /Email does not exists/);
});

test('wrong password is rejected', async () => {
  const res = await new Client().login('superadmin@mock.test', 'wrong-password');
  assert.equal(redirectTarget(res), '');
  assert.match(res.text_, /Incorrect username\/password/);
});

test('SQL-injection style email does not log in', async () => {
  const res = await new Client().login("' OR '1'='1", "' OR '1'='1");
  assert.equal(redirectTarget(res), '');
});

for (const role of ['superadmin', 'manager', 'clerk', 'viewer', 'requester', 'checker', 'approver', 'noperm']) {
  test(`${role} can log in and see a clean dashboard`, async () => {
    const c = await as(role);
    assertCleanPage(await c.req('/dashboard'), `${role} dashboard`);
  });
}

test('account without a group can log in without PHP errors', async () => {
  const c = new Client();
  assert.equal(redirectTarget(await c.login('nogroup@mock.test')), '/dashboard');
  assertCleanPage(await c.req('/dashboard'), 'no-group dashboard');
  // and is still denied everything
  assert.equal(redirectTarget(await c.req('/users')), '/dashboard');
});

test('protected pages bounce anonymous users to login', async () => {
  for (const path of ['/dashboard', '/products', '/orders', '/users', '/work_order', '/reports']) {
    const res = await new Client().req(path);
    assert.match(redirectTarget(res), /auth\/login|dashboard/, path);
  }
});

test('logout ends the session', async () => {
  const c = await as('viewer');
  await c.req('/auth/logout');
  assert.equal(redirectTarget(await c.req('/dashboard')), '/auth/login');
});

test('logged-in user visiting login is sent to dashboard', async () => {
  const c = await as('viewer');
  assert.equal(redirectTarget(await c.req('/auth/login')), '/dashboard');
});
