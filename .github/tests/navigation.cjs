const assert = require('node:assert/strict');
const { execFileSync } = require('node:child_process');
const path = require('node:path');
const test = require('node:test');

test('TOC marks only the current page', () => {
  for (const [request, expected] of [['/', '/'], ['/lofi?filter=one', '/lofi'], ['/updates', '/updates'], ['/missing', null]]) {
    const html = execFileSync('php', ['-r', '$_SERVER["REQUEST_URI"] = $argv[2]; require $argv[1];',
      path.join(__dirname, '..', '..', 'burger.php'), request], { encoding: 'utf8' });
    const selected = [...html.matchAll(/<a href="([^"]+)" aria-current="page"/g)].map(match => match[1]);
    assert.deepEqual(selected, expected === null ? [] : [expected], request);
  }
});
