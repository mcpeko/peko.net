<?php
$displayTitle = $entry['title'];
$eventType = (['concert' => 'Concert', 'DJ' => 'DJ set'][$entry['description'] ?? ''] ?? $entry['description'] ?? null);
?>
<article class="section-entry padded colored">
  <?php if (isset($entry['image'])): ?>
    <img class="entry-cover entry-event-photo" src="<?php echo htmlspecialchars($entry['image'], ENT_QUOTES, 'UTF-8'); ?>"
      alt="<?php echo htmlspecialchars($entry['title'] . ' event photo', ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
  <?php else: ?>
    <div class="entry-placeholder entry-poster-placeholder" role="img" aria-label="Poster not available">
      <svg aria-hidden="true"><use href="/icons.svg#calendar"></use></svg>
    </div>
  <?php endif; ?>
  <div class="entry-text">
    <h2>
      <?php if (isset($entry['url'])): ?>
        <a href="<?php echo htmlspecialchars(entryLinkUrl($entry['url']), ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($displayTitle, ENT_QUOTES, 'UTF-8'); ?></a>
      <?php else: ?>
        <?php echo renderEntryLinkedText($displayTitle, $entry['links'] ?? []); ?>
      <?php endif; ?>
    </h2>
    <?php if (isset($entry['description']) && $eventType === null): ?>
      <p><?php echo renderEntryLinkedText($entry['description'], $entry['links'] ?? []); ?></p>
    <?php endif; ?>
    <?php if (isset($entry['metadata'])): ?>
      <dl class="entry-metadata">
        <?php if ($eventType !== null): ?>
          <div>
            <dt><svg class="entry-metadata-icon" aria-hidden="true"><use href="/icons.svg#calendar"></use></svg> Event</dt>
            <dd><?php echo renderEntryLinkedText($eventType, $entry['links'] ?? []); ?></dd>
          </div>
        <?php endif; ?>
        <?php
        $orderedMetadataFields = $eventType === null
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
                  $inlineLinks = in_array($type, ['text', 'list'], true) ? ($entry['links'] ?? []) : [];
                  $hasInlineLink = false;
                  foreach ($inlineLinks as $link) {
                    if (str_contains($value, $link['label'])) {
                      $hasInlineLink = true;
                      break;
                    }
                  }
                  $url = $entry['metadata_links'][$field] ?? (!$hasInlineLink && in_array($type, ['text', 'list'], true) ? ($metadataWebsites[$value] ?? null) : null);
                  ?>
                  <?php if ($url !== null): ?>
                    <?php echo renderEntryLink($value, $url); ?><?php
                  else:
                    echo renderEntryLinkedText($value, $inlineLinks);
                  endif;
                endforeach; ?>
              </dd>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </dl>
    <?php endif; ?>
  </div>
</article>
