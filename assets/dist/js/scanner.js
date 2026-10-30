
// Loaded on every page by the header, but only a page with <video id="video"> has a scanner:
// skip everywhere else instead of asking for the camera (or throwing when there is none).
window.addEventListener('load', async () => {
if (!document.getElementById('video')) return;

const { BrowserMultiFormatReader } = await import('https://cdn.jsdelivr.net/npm/@zxing/library@0.19.1/esm/index.min.js');
const codeReader = new BrowserMultiFormatReader();

codeReader
.listVideoInputDevices()
.then(videoInputDevices => {
// Pick the front camera if available
const frontCamera = videoInputDevices.find(device =>
device.label.toLowerCase().includes('front')
) || videoInputDevices[0];
if (!frontCamera) return;

codeReader.decodeFromVideoDevice(frontCamera.deviceId, 'video', (result, err) => {
if (result) {
    document.getElementById('result').textContent = result.text;
alert(`QR Code detected: ${encodeURIComponent(result.text)}`);
}
});
});
});
