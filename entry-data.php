<?php
function entryLinkUrl(string $url): string
{
  return in_array($url, ['http://peko.net', 'https://peko.net', 'http://peko.net/', 'https://peko.net/', 'http://www.peko.net', 'https://www.peko.net', 'http://www.peko.net/', 'https://www.peko.net/'], true) ? '/' : $url;
}

function renderEntryLink(string $text, string $url): string
{
  $url = entryLinkUrl($url);
  return '<a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">'
    . htmlspecialchars($text, ENT_QUOTES, 'UTF-8')
    . ($url === '/' ? '' : ' <svg class="entry-external-icon" aria-hidden="true"><use href="/icons.svg#external"></use></svg>')
    . '</a>';
}

function renderEntryLinkedText(string $text, array $links): string
{
  $destinations = [];
  foreach ($links as $link) {
    $destinations[$link['label']] = $link['url'];
  }
  $labels = array_keys($destinations);
  usort($labels, fn(string $left, string $right): int => strlen($right) <=> strlen($left));
  if ($labels === []) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
  }
  $pattern = '~(' . implode('|', array_map(fn(string $label): string => preg_quote($label, '~'), $labels)) . ')~u';
  $parts = preg_split($pattern, $text, -1, PREG_SPLIT_DELIM_CAPTURE);
  $html = '';
  foreach ($parts as $index => $part) {
    $escaped = htmlspecialchars($part, ENT_QUOTES, 'UTF-8');
    $html .= $index % 2 === 1
      ? renderEntryLink($part, $destinations[$part])
      : $escaped;
  }
  return $html;
}

function entryMetadataFields(): array
{
  return [
    'artists' => ['Artist', 'list', 'person'],
    'release_date' => ['Release date', 'date', 'calendar'],
    'published_date' => ['Published', 'date', 'calendar'],
    'event_date' => ['Date', 'date', 'calendar'],
    'duration_ms' => ['Duration', 'duration', 'clock'],
    'label' => ['Label', 'text', 'label'],
    'catalogue_number' => ['Catalogue number', 'text', 'hash'],
    'album' => ['Album', 'text', 'record'],
    'album_release_date' => ['Album release date', 'date', 'calendar'],
    'album_catalogue_number' => ['Album catalogue number', 'text', 'hash'],
    'written_by' => ['Written by', 'list', 'pen'],
    'remixed_by' => ['Remixed by', 'list', 'turntable'],
    'produced_by' => ['Produced by', 'list', 'settings'],
    'performed_by' => ['Performed by', 'list', 'band'],
    'video_by' => ['Video by', 'list', 'film'],
    'directed_by' => ['Directed by', 'list', 'film'],
    'filmed_by' => ['Filmed by', 'list', 'film'],
    'edited_by' => ['Edited by', 'list', 'pen'],
    'mixed_by' => ['Mixed by', 'list', 'settings'],
    'mastered_by' => ['Mastered by', 'list', 'sound'],
    'studio' => ['Studio', 'text', 'home'],
    'bpm' => ['BPM', 'number', 'metronome'],
    'key' => ['Key', 'text', 'piano'],
    'format' => ['Format', 'text', 'tag'],
    'edition' => ['Edition', 'text', 'record'],
    'track_count' => ['Tracks', 'number', 'hash'],
    'copies' => ['Copies', 'number', 'hash'],
    'manufacturer' => ['Manufacturer', 'text', 'home'],
    'participation_year' => ['Date', 'year', 'calendar'],
    'role' => ['Role', 'text', 'person'],
    'character' => ['Character', 'text', 'person'],
    'production_company' => ['Production company', 'text', 'home'],
    'casting' => ['Casting', 'text', 'band'],
    'broadcaster' => ['Broadcaster', 'text', 'speaker'],
    'venue' => ['Venue', 'text', 'home'],
    'event_name' => ['Event', 'text', 'calendar'],
    'location' => ['Location', 'text', 'home'],
    'city' => ['City', 'text', 'world'],
    'original_copyright' => ['Original recording copyright', 'text', 'asterisk']
  ];
}

function entryTextValid(mixed $value): bool
{
  return is_string($value) && trim($value) !== '';
}

function entryUrlValid(mixed $value, bool $allowSource = false): bool
{
  if (!entryTextValid($value)) {
    return false;
  }
  if ($allowSource && preg_match('~^/(releases|releases_lofi|film|events)/[\p{L}0-9_-]+\.txt$~u', $value)) {
    return is_file(__DIR__ . $value);
  }
  return filter_var($value, FILTER_VALIDATE_URL) !== false
    && in_array(parse_url($value, PHP_URL_SCHEME), ['http', 'https'], true);
}

function entryMetadataValid(string $type, mixed $value): bool
{
  if ($type === 'list') {
    return is_array($value) && array_is_list($value) && $value !== []
      && count(array_filter($value, 'entryTextValid')) === count($value);
  }
  if ($type === 'duration' || $type === 'number') {
    return is_int($value) && $value > 0;
  }
  if ($type === 'date' || $type === 'year') {
    if (!is_string($value) || !preg_match('/^[1-9][0-9]{3}$/', substr($value, 0, 4))) {
      return false;
    }
    if (strlen($value) === 4) {
      return true;
    }
    if ($type === 'year' || !preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $value)) {
      return false;
    }
    return checkdate((int) substr($value, 5, 2), (int) substr($value, 8, 2), (int) substr($value, 0, 4));
  }
  return entryTextValid($value);
}

function validateSectionEntries(mixed $data): array
{
  if (!is_array($data) || ($data['schema_version'] ?? null) !== 1
    || !isset($data['entries']) || !is_array($data['entries']) || !array_is_list($data['entries'])
    || array_diff(array_keys($data), ['schema_version', 'entries'])) {
    throw new RuntimeException('Expected schema_version 1 and an entries list.');
  }
  $metadataFields = entryMetadataFields();
  $ids = [];
  foreach ($data['entries'] as $index => $entry) {
    $context = 'Entry ' . ($index + 1);
    if (!is_array($entry) || !isset($entry['id'], $entry['title'])
      || !is_string($entry['id']) || !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $entry['id'])
      || isset($ids[$entry['id']]) || !entryTextValid($entry['title'])
      || array_diff(array_keys($entry), ['id', 'title', 'description', 'url', 'image', 'poster_url', 'links', 'metadata', 'metadata_links', 'sources'])) {
      throw new RuntimeException($context . ': invalid record, title or unique ID.');
    }
    $ids[$entry['id']] = true;
    if (array_key_exists('description', $entry) && !entryTextValid($entry['description'])) {
      throw new RuntimeException($context . ': invalid description.');
    }
    if (array_key_exists('url', $entry) && !entryUrlValid($entry['url'])) {
      throw new RuntimeException($context . ': invalid URL.');
    }
    if (array_key_exists('image', $entry) && (!is_string($entry['image'])
      || !preg_match('~^/(img|film_photos|events_photos|bands_photos)/[a-z0-9/_-]+\.(jpg|png|webp)$~', $entry['image'])
      || !is_file(__DIR__ . $entry['image']))) {
      throw new RuntimeException($context . ': invalid or missing image.');
    }
    if (array_key_exists('poster_url', $entry)
      && (!array_key_exists('image', $entry) || !entryUrlValid($entry['poster_url']))) {
      throw new RuntimeException($context . ': invalid poster URL.');
    }
    if (array_key_exists('metadata', $entry)) {
      if (!is_array($entry['metadata']) || $entry['metadata'] === [] || array_is_list($entry['metadata'])) {
        throw new RuntimeException($context . ': metadata must be a nonempty object.');
      }
      foreach ($entry['metadata'] as $field => $value) {
        if (!isset($metadataFields[$field]) || !entryMetadataValid($metadataFields[$field][1], $value)) {
          throw new RuntimeException($context . ': invalid metadata field ' . $field . '.');
        }
      }
    }
    if (array_key_exists('metadata_links', $entry)) {
      if (!is_array($entry['metadata_links']) || $entry['metadata_links'] === [] || array_is_list($entry['metadata_links'])) {
        throw new RuntimeException($context . ': metadata_links must be a nonempty object.');
      }
      foreach ($entry['metadata_links'] as $field => $url) {
        if (!isset($entry['metadata'][$field], $metadataFields[$field])
          || $metadataFields[$field][1] !== 'text' || !entryUrlValid($url)) {
          throw new RuntimeException($context . ': invalid metadata link ' . $field . '.');
        }
      }
    }
    foreach (['links', 'sources'] as $listName) {
      if (!array_key_exists($listName, $entry)) {
        continue;
      }
      if (!is_array($entry[$listName]) || !array_is_list($entry[$listName])) {
        throw new RuntimeException($context . ': ' . $listName . ' must be a list.');
      }
      foreach ($entry[$listName] as $link) {
        $isSource = $listName === 'sources';
        if (!is_array($link) || !isset($link['label'], $link['url']) || !entryTextValid($link['label'])
          || !entryUrlValid($link['url'], $isSource)
          || array_diff(array_keys($link), $isSource ? ['label', 'url', 'fields'] : ['label', 'url'])) {
          throw new RuntimeException($context . ': invalid ' . $listName . ' link.');
        }
        if ($isSource && (!isset($link['fields']) || !entryMetadataValid('list', $link['fields'])
          || array_diff($link['fields'], array_keys($entry['metadata'] ?? [])))) {
          throw new RuntimeException($context . ': source fields must refer to existing metadata.');
        }
      }
    }
  }
  return $data['entries'];
}

function loadSectionEntries(string $sectionSlug): array
{
  if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $sectionSlug)) {
    throw new RuntimeException('Invalid section slug.');
  }
  $file = __DIR__ . '/data/' . $sectionSlug . '.json';
  return validateSectionEntries(loadDataJson($file));
}

function loadDataJson(string $file): mixed
{
  if (!is_readable($file)) {
    throw new RuntimeException('Unable to read ' . $file . '.');
  }
  $json = file_get_contents($file);
  if ($json === false) {
    throw new RuntimeException('Unable to read ' . $file . '.');
  }
  try {
    $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
  } catch (JsonException $error) {
    throw new RuntimeException('Invalid JSON in ' . $file . ': ' . $error->getMessage(), 0, $error);
  }
  return $data;
}

function loadMetadataWebsites(): array
{
  $data = loadDataJson(__DIR__ . '/data/metadata-websites.json');
  if (!is_array($data) || ($data['schema_version'] ?? null) !== 1
    || !isset($data['websites']) || !is_array($data['websites']) || array_is_list($data['websites'])
    || array_diff(array_keys($data), ['schema_version', 'websites'])) {
    throw new RuntimeException('Invalid metadata websites data.');
  }
  foreach ($data['websites'] as $name => $url) {
    if (!entryTextValid($name) || !entryUrlValid($url)) {
      throw new RuntimeException('Invalid metadata website for ' . $name . '.');
    }
  }
  return $data['websites'];
}

function formatEntryMetadata(string $field, mixed $value): string
{
  $fields = entryMetadataFields();
  if (!isset($fields[$field]) || !entryMetadataValid($fields[$field][1], $value)) {
    throw new RuntimeException('Cannot format invalid metadata field ' . $field . '.');
  }
  $type = $fields[$field][1];
  if ($type === 'list') {
    return implode(', ', $value);
  }
  if ($type === 'duration') {
    $seconds = intdiv($value, 1000);
    return $seconds >= 3600
      ? sprintf('%d:%02d:%02d', intdiv($seconds, 3600), intdiv($seconds, 60) % 60, $seconds % 60)
      : sprintf('%d:%02d', intdiv($seconds, 60), $seconds % 60);
  }
  if ($field === 'event_date' && strlen($value) === 10) {
    $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
    return $date->format('l d-m-Y');
  }
  if ($type === 'date' && strlen($value) === 10) {
    $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
    return $date->format('d-m-Y');
  }
  return (string) $value;
}
