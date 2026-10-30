
import { BrowserMultiFormatReader } from 'https://cdn.jsdelivr.net/npm/@zxing/library@0.19.1/esm/index.min.js';

const codeReader = new BrowserMultiFormatReader();

window.addEventListener('load', () => {
codeReader
.listVideoInputDevices()
.then(videoInputDevices => {
// Pick the front camera if available
const frontCamera = videoInputDevices.find(device =>
device.label.toLowerCase().includes('front')
) || videoInputDevices[0];

codeReader.decodeFromVideoDevice(frontCamera.deviceId, 'video', (result, err) => {
if (result) {
    document.getElementById('result').textContent = result.text;
alert(`QR Code detected: ${encodeURIComponent(result.text)}`);
}
});
});
});
