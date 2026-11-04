<?php
require_once __DIR__ . '/entry-data.php';
try {
  $today = (new DateTimeImmutable('today', new DateTimeZone('Europe/Oslo')))->format('Y-m-d');
  $upcomingEvents = array_values(array_filter(
    loadSectionEntries('events'),
    fn(array $entry): bool => ($entry['metadata']['event_date'] ?? '') >= $today
  ));
  usort($upcomingEvents, fn(array $left, array $right): int => strcmp($left['metadata']['event_date'], $right['metadata']['event_date']));
  $nextEvent = $upcomingEvents[0] ?? null;
} catch (RuntimeException $error) {
  error_log('Unable to load homepage events: ' . $error->getMessage());
  http_response_code(500);
  exit('Unable to load homepage events.');
}
?>
<!DOCTYPE html>
<html>

<head>
  <?php require($_SERVER['DOCUMENT_ROOT'] . "/head.php"); ?>
</head>

<body>

  <?php require($_SERVER['DOCUMENT_ROOT'] . "/toc.php"); ?>

  <div class="page-introduction padded center-on-medium-screen colored">
    Hi. I'm MC Peko or DJ Peko or Ole Peko Sørensen. Most of the time I make lofi beats on my phone.
  </div>

  <div class="top-line">
    <div class="images">
      <svg class="icons" aria-hidden="true">
        <use href="/icons.svg#calendar"></use>
      </svg>
    </div>
    <h1>Events</h1>
    <div class="images">
      <svg class="icons show-pointer"
        role="button"
        tabindex="0"
        aria-label="Expand/collapse"
        onclick="toggleDiv('eventsContainer')">
        <title>Expand/collapse</title>
        <use href="/icons.svg#triangle_down"></use>
      </svg>
    </div>
  </div>

  <div class="padded center-on-medium-screen colored" id="eventsContainer">
    Concerts, DJ sets and other performances.
    <?php if ($nextEvent !== null): ?>
      <p>
        Next up: <?php echo isset($nextEvent['url']) ? renderEntryLink($nextEvent['title'], $nextEvent['url']) : htmlspecialchars($nextEvent['title'], ENT_QUOTES, 'UTF-8'); ?>
        <?php if (isset($nextEvent['metadata']['venue'])): ?>
          at <?php
          $venue = $nextEvent['metadata']['venue'];
          $venueUrl = $nextEvent['metadata_links']['venue'] ?? null;
          echo $venueUrl !== null
            ? renderEntryLink($venue, $venueUrl)
            : htmlspecialchars($venue, ENT_QUOTES, 'UTF-8');
          ?>
        <?php endif; ?>
        <?php if (isset($nextEvent['metadata']['city'])): ?>, <?php echo htmlspecialchars($nextEvent['metadata']['city'], ENT_QUOTES, 'UTF-8'); ?>,<?php else: ?>,<?php endif; ?>
        <?php echo htmlspecialchars(formatEntryMetadata('event_date', $nextEvent['metadata']['event_date']), ENT_QUOTES, 'UTF-8'); ?>.
      </p>
    <?php endif; ?>
    <a href="/events.php">Upcoming and Previous dates</a>.
  </div>

  <?php require($_SERVER['DOCUMENT_ROOT'] . "/footer.php"); ?>

</body>

</html>