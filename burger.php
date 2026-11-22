<div id="burger-container" class="menu-container">
  <button id="toggle-menu-button" type="button" class="settings-toggle" title="Menu" aria-label="Menu" aria-controls="toc" aria-expanded="false">
    <svg class="icons" aria-hidden="true"><use href="/icons.svg#burger"></use></svg>
  </button>

  <nav id="toc" class="toc-container" aria-label="Main navigation">
    <ul>
      <?php
      $tocCurrentPath = rtrim(preg_replace('~\.php$~', '', parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/'), '/') ?: '/';
      if ($tocCurrentPath === '/index') $tocCurrentPath = '/';
      foreach ([
        ['/', 'Home', 'home'],
        ['/lofi', 'Lofi hip hop', 'cassette'],
        ['/playlists', 'Playlists', 'view_list'],
        ['/bands', 'Bands', 'band'],
        ['/releases', 'Releases', 'lp'],
        ['/remixes', 'Remixes', 'customize'],
        ['/music_videos', 'Music videos', 'youtube'],
        ['/polarized', '(Polarized)', 'soundcloud'],
        ['/movie_extra', 'Movie extra', 'film'],
        ['/events', 'Events', 'calendar'],
        ['/updates', 'Updates', 'github'],
      ] as [$tocUrl, $tocLabel, $tocIcon]): ?>
      <li><a href="<?php echo $tocUrl; ?>"<?php if ($tocCurrentPath === $tocUrl): ?> aria-current="page"<?php endif; ?>><svg class="icons" aria-hidden="true"><use href="/icons.svg#<?php echo $tocIcon; ?>"></use></svg><?php echo $tocLabel; ?></a></li>
      <?php endforeach; ?>
    </ul>

    <div class="toc-close-wrap">
      <button id="toggle-menu-close-button" class="settings-toggle" type="button" title="Close" aria-label="Close menu">
        <svg class="icons" aria-hidden="true"><use href="/icons.svg#close"></use></svg>
      </button>
    </div>
  </nav>
</div>