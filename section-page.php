<?php
$sections = [
  'lofi-hip-hop' => [
    'title' => 'Lofi hip hop',
    'icon' => 'spotify',
    'content' => <<<'HTML'
<a href="https://open.spotify.com/artist/5p4HgZHdHOOWlE9q7aJ9ZM">Here they are on Spotify</a>, and you can find them on other outlets as well. Instrumental, around two minutes and 70 BPM kinda stuff with sufficient crackle, shuffle and microtonality.
HTML
  ],
  'bands' => [
    'title' => 'Bands',
    'icon' => 'band',
    'content' => <<<'HTML'
I played bass in <a href="https://open.spotify.com/artist/74JX7v2IC9YPFTBmhuRV1X">Howlin' of the Wolf</a>, and drums and various instruments in <a href="https://open.spotify.com/artist/4trI2gf2BoSN6vTc8XrPYe">Silentlab</a>. And I'm in a vinyl only rehabilly band called <a href="http://bronson.no">Bronson Comet Lighter</a>, that you'll have to search around in the real world to get a hold of. <a href="https://arcticaantarctica.com">Arctica / Antarctica</a> was a polar ambient band that did some lovely concerts.
HTML
  ],
  'remixes' => [
    'title' => 'Remixes',
    'icon' => 'turntable',
    'content' => <<<'HTML'
I've done remixes of two of the Silentlab songs, and one by The Sky's Gone Out.
HTML
  ],
  'music-videos' => [
    'title' => 'Music videos',
    'icon' => 'youtube',
    'content' => <<<'HTML'
Sometimes we make music videos. Pop corn and turn on the YouTube with MC Peko, Bronson Comet Lighter, The Sky's Gone Out and Silentlab.
HTML
  ],
  'polarized' => [
    'title' => '(Polarized)',
    'icon' => 'soundcloud',
    'content' => <<<'HTML'
Enjoy some ice cold, SoundCloud only, <a href="https://soundcloud.com/mc-peko/sets/polarized">polar ambient remixes</a> of some tracks from some friends of mine.
HTML
  ],
  'movie-extra' => [
    'title' => 'Movie extra',
    'icon' => 'film',
    'content' => <<<'HTML'
I do some movie extra (statist) stuff from time to time. At your service, hit me up.
HTML
  ],
  'releases' => [
    'title' => 'Releases',
    'icon' => 'lp',
    'content' => 'Records and other releases I have been involved with, including different editions. Newest releases are listed first.'
  ],
  'events' => [
    'title' => 'Events',
    'icon' => 'calendar',
    'content' => 'Concerts, DJ sets and other performances. Upcoming and Previous dates.'
  ]
];

if (!isset($sectionSlug, $sections[$sectionSlug])) {
  http_response_code(404);
  exit('Page not found.');
}

$section = $sections[$sectionSlug];
require_once __DIR__ . '/entry-data.php';
try {
  $entries = loadSectionEntries($sectionSlug);
  $metadataWebsites = loadMetadataWebsites();
} catch (RuntimeException $error) {
  error_log('Unable to load section entries for ' . $sectionSlug . ': ' . $error->getMessage());
  http_response_code(500);
  exit('Unable to load page entries.');
}
$metadataFields = entryMetadataFields();
if ($sectionSlug === 'movie-extra') {
  usort($entries, fn(array $left, array $right): int => (int) $right['metadata']['participation_year'] <=> (int) $left['metadata']['participation_year']);
}
if ($sectionSlug === 'polarized') {
  usort($entries, fn(array $left, array $right): int => strcmp($right['metadata']['published_date'], $left['metadata']['published_date']));
}
$entryGroups = ['' => $entries];
if ($sectionSlug === 'events') {
  $today = (new DateTimeImmutable('today', new DateTimeZone('Europe/Oslo')))->format('Y-m-d');
  $entryGroups = ['Upcoming' => [], 'Previous' => []];
  foreach ($entries as $entry) {
    $group = ($entry['metadata']['event_date'] ?? '') >= $today ? 'Upcoming' : 'Previous';
    $entryGroups[$group][] = $entry;
  }
}
$pageTitle = $section['title'] . ' - MC Peko';
$canonicalUrl = 'https://peko.net/' . $sectionSlug . '.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php require __DIR__ . '/head.php'; ?>
</head>

<body>

  <?php require __DIR__ . '/toc.php'; ?>

  <div class="top-line">
    <div class="images">
      <svg class="icons" aria-hidden="true">
        <use href="/icons.svg#<?php echo htmlspecialchars($section['icon'], ENT_QUOTES, 'UTF-8'); ?>"></use>
      </svg>
    </div>
    <h1><?php echo htmlspecialchars($section['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
    <div class="images">
      <svg class="icons" aria-hidden="true">
        <use href="/icons.svg#<?php echo htmlspecialchars($section['icon'], ENT_QUOTES, 'UTF-8'); ?>"></use>
      </svg>
    </div>
  </div>

  <?php if ($section['content'] !== ''): ?>
    <div class="padded center-on-medium-screen colored">
      <?php echo $section['content']; ?>
    </div>
  <?php endif; ?>

  <?php if ($sectionSlug === 'releases'): ?>
    <div class="release-filter padded colored" role="group" aria-label="Release type">
      <?php foreach (['physical' => 'Physical', 'digital' => 'Digital', 'all' => 'All'] as $value => $label): ?>
        <label><input type="radio" name="release-type" value="<?php echo $value; ?>"<?php echo $value === 'all' ? ' checked' : ''; ?>> <?php echo $label; ?></label>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php foreach ($entryGroups as $groupTitle => $groupEntries): ?>
    <?php if ($groupTitle !== ''): ?>
      <div class="event-group-heading padded">
        <h2><?php echo htmlspecialchars($groupTitle, ENT_QUOTES, 'UTF-8'); ?></h2>
      </div>
    <?php endif; ?>
  <?php foreach ($groupEntries as $entry): ?>
    <?php $displayTitle = in_array($sectionSlug, ['bands', 'events'], true) ? $entry['title'] : '"' . $entry['title'] . '"'; ?>
    <article class="section-entry padded colored"<?php if ($sectionSlug === 'releases'): ?> data-release-type="<?php echo strtolower($entry['metadata']['edition']) === 'digital' ? 'digital' : 'physical'; ?>"<?php endif; ?>>
      <?php if (isset($entry['image'])): ?>
        <img class="entry-cover<?php echo $sectionSlug === 'events' ? ' entry-event-photo' : ($sectionSlug === 'bands' ? ' entry-band-photo' : ''); ?>" src="<?php echo htmlspecialchars($entry['image'], ENT_QUOTES, 'UTF-8'); ?>"
          alt="<?php echo htmlspecialchars($entry['title'] . ($sectionSlug === 'events' ? ' event photo' : ($sectionSlug === 'bands' ? ' band photo' : (in_array($sectionSlug, ['music-videos', 'movie-extra'], true) ? ' still' : ' cover'))), ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
      <?php elseif (in_array($sectionSlug, ['movie-extra', 'events'], true)): ?>
        <div class="entry-placeholder<?php echo $sectionSlug === 'events' ? ' entry-poster-placeholder' : ''; ?>" role="img" aria-label="<?php echo $sectionSlug === 'events' ? 'Poster not available' : 'Still not available'; ?>">
          <svg aria-hidden="true"><use href="/icons.svg#<?php echo $sectionSlug === 'events' ? 'calendar' : 'film'; ?>"></use></svg>
        </div>
      <?php endif; ?>
      <div class="entry-text">
        <h2>
          <?php if (isset($entry['url'])): ?>
            <a href="<?php echo htmlspecialchars(entryLinkUrl($entry['url']), ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($displayTitle, ENT_QUOTES, 'UTF-8'); ?></a>
          <?php else: ?>
            <?php echo $sectionSlug === 'events' ? renderEntryLinkedText($displayTitle, $entry['links'] ?? []) : htmlspecialchars($displayTitle, ENT_QUOTES, 'UTF-8'); ?>
          <?php endif; ?>
        </h2>
        <?php $eventType = $sectionSlug === 'events' ? (['concert' => 'Concert', 'DJ' => 'DJ set'][$entry['description'] ?? ''] ?? $entry['description'] ?? null) : null; ?>
        <?php if (isset($entry['description']) && $eventType === null): ?>
          <p><?php echo $sectionSlug === 'events' ? renderEntryLinkedText($entry['description'], $entry['links'] ?? []) : htmlspecialchars($entry['description'], ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <?php if (isset($entry['metadata'])): ?>
          <?php
          $artistWebsite = null;
          if ($sectionSlug === 'releases') {
            foreach ($entry['links'] ?? [] as $link) {
              if ($link['label'] === 'Artist website') {
                $artistWebsite = $link['url'];
                break;
              }
            }
          }
          ?>
          <dl class="entry-metadata">
            <?php if ($eventType !== null): ?>
              <div>
                <dt><svg class="entry-metadata-icon" aria-hidden="true"><use href="/icons.svg#calendar"></use></svg> Event</dt>
                <dd><?php echo renderEntryLinkedText($eventType, $entry['links'] ?? []); ?></dd>
              </div>
            <?php endif; ?>
            <?php
            $orderedMetadataFields = $sectionSlug === 'events' && $eventType === null
              ? ['event_name' => $metadataFields['event_name']] + $metadataFields
              : $metadataFields;
            ?>
            <?php foreach ($orderedMetadataFields as $field => [$label, $type, $icon]): ?>
              <?php if (array_key_exists($field, $entry['metadata'])): ?>
                <div>
                  <dt><svg class="entry-metadata-icon" aria-hidden="true"><use href="/icons.svg#<?php echo htmlspecialchars($icon, ENT_QUOTES, 'UTF-8'); ?>"></use></svg> <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></dt>
                  <dd>
                    <?php $values = $type === 'list' ? $entry['metadata'][$field] : [formatEntryMetadata($field, $entry['metadata'][$field])]; ?>
                    <?php foreach ($values as $index => $value): ?>
                      <?php if ($index > 0) echo ', '; ?>
                      <?php
                      $inlineLinks = $sectionSlug === 'events' && in_array($type, ['text', 'list'], true) ? ($entry['links'] ?? []) : [];
                      $hasInlineLink = false;
                      foreach ($inlineLinks as $link) {
                        if (str_contains($value, $link['label'])) {
                          $hasInlineLink = true;
                          break;
                        }
                      }
                      $url = $entry['metadata_links'][$field] ?? (!$hasInlineLink && in_array($type, ['text', 'list'], true) ? ($metadataWebsites[$value] ?? null) : null);
                      if ($url === null && $field === 'artists') {
                        $url = $artistWebsite;
                      }
                      $displayValue = $field === 'album' ? '"' . $value . '"' : $value;
                      ?>
                      <?php if ($url !== null): ?>
                        <?php echo renderEntryLink($displayValue, $url); ?><?php
                      else:
                        echo renderEntryLinkedText($displayValue, $inlineLinks);
                      endif;
                    endforeach; ?>
                  </dd>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </dl>
        <?php endif; ?>
        <?php $entryLinks = array_values(array_filter($entry['links'] ?? [], fn(array $link): bool => $sectionSlug !== 'releases' || $link['label'] !== 'Artist website')); ?>
        <?php if ($sectionSlug !== 'events' && $entryLinks !== []): ?>
          <?php if ($sectionSlug === 'releases'): ?>
            <dl class="entry-metadata">
              <?php foreach ($entryLinks as $link): ?>
                <?php $linkIcon = ['Spotify' => 'spotify', 'SoundCloud' => 'soundcloud', 'YouTube' => 'youtube'][$link['label']] ?? 'asterisk'; ?>
                <div>
                  <dt><svg class="entry-metadata-icon" aria-hidden="true"><use href="/icons.svg#<?php echo $linkIcon; ?>"></use></svg> <?php echo htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8'); ?></dt>
                  <dd><?php echo renderEntryLink($link['url'], $link['url']); ?></dd>
                </div>
              <?php endforeach; ?>
            </dl>
          <?php else: ?>
          <p class="entry-links">
            <?php foreach ($entryLinks as $link): ?>
              <a href="<?php echo htmlspecialchars($link['url'], ENT_QUOTES, 'UTF-8'); ?>"><?php if ($sectionSlug === 'bands'): ?><?php $linkIcon = ['Website' => 'world', 'Facebook' => 'facebook', 'Spotify' => 'spotify', 'SoundCloud' => 'soundcloud'][$link['label']] ?? 'asterisk'; ?><svg class="entry-metadata-icon" aria-hidden="true"><use href="/icons.svg#<?php echo $linkIcon; ?>"></use></svg> <?php endif; ?><?php echo htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8'); ?></a>
            <?php endforeach; ?>
          </p>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </article>
  <?php endforeach; ?>
  <?php endforeach; ?>

  <?php require __DIR__ . '/footer.php'; ?>

</body>

</html>
