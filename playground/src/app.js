import { renderFlextml } from '../../../js/index.js';
import { toFlextmlJson } from '../../../js/utils/toFlextmlJson.js';

const inputArea = document.getElementById('json-input');
const renderBtn = document.getElementById('render-btn');
const outputArea = document.getElementById('render-output');
const roundTripArea = document.getElementById('roundtrip-json');

renderBtn.addEventListener('click', () => {
  try {
    const raw = inputArea.value.trim();
    const json = JSON.parse(raw);
    const dom = renderFlextml(json);
    
    outputArea.innerHTML = '';
    outputArea.appendChild(dom);

    const roundTrip = toFlextmlJson(dom);
    roundTripArea.textContent = JSON.stringify(roundTrip, null, 2);
  } catch (e) {
    outputArea.textContent = '⚠️ Error: ' + e.message;
    roundTripArea.textContent = '';
  }
});
