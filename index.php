<?php
require_once __DIR__ . '/entry-data.php';
try {
  $today = (new DateTimeImmutable('today', new DateTimeZone('Europe/Oslo')))->format('Y-m-d');
  $upcomingEvents = array_values(array_filter(
    loadSectionEntries('events'),
    fn(array $entry): bool => ($entry['metadata']['event_date'] ?? '') >= $today
  ));
  $metadataWebsites = loadMetadataWebsites();
  $metadataFields = entryMetadataFields();
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

    <?php if ($nextEvent !== null): ?>
      <?php
      $sectionSlug = 'events';
      $entry = $nextEvent;
      require __DIR__ . '/event-entry.php';
      ?>
    <?php endif; ?>

  <section class="label-feature padded colored">
    <a href="https://fuzzpop.no" title="Fuzz Pop">
      <img class="label-logo" src="/img/fuzz_pop.svg" alt="Fuzz Pop">
    </a>
    <p>MC Peko is an artist on the Fuzz Pop label.</p>
  </section>

  <?php require($_SERVER['DOCUMENT_ROOT'] . "/footer.php"); ?>

</body>

</html>