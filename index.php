<!DOCTYPE html>
<html>

<head>
  <?php require($_SERVER['DOCUMENT_ROOT'] . "/head.php"); ?>
</head>

<body>

  <?php require($_SERVER['DOCUMENT_ROOT'] . "/toc.php"); ?>

  <div class="top-line">
    <div class="images">
      <svg class="icons">
        <use href="/icons.svg#spotify" />
      </svg>
    </div>
    <h1>LOFI HIP HOP</h1>
    <div class="images">
      <svg class="icons show-pointer"
        role="button"
        tabindex="0"
        aria-label="Expand/collapse"
        onclick="toggleDiv('lofiContainer')">
        <title>Expand/collapse</title>
        <use href="/icons.svg#triangle_down"></use>
      </svg>
    </div>
  </div>

  <div class="padded center-on-medium-screen colored" id="lofiContainer">
    Hi. I'm MC Peko or DJ Peko or Ole Peko Sørensen. Most of the time I make lofi beats on my phone. <a href="https://open.spotify.com/artist/5p4HgZHdHOOWlE9q7aJ9ZM">Here they are on Spotify</a>, and you can find them on other outlets as well. Instrumental, around two minutes and 70 BPM kinda stuff with sufficient crackle, shuffle and microtonality.
  </div>

  <div class="top-line">
    <div class="images">
      <svg class="icons">
        <use href="/icons.svg#spotify" />
      </svg>
    </div>
    <h1>BANDS</h1>
    <div class="images">
      <svg class="icons show-pointer"
        role="button"
        tabindex="0"
        aria-label="Expand/collapse"
        onclick="toggleDiv('bandsContainer')">
        <title>Expand/collapse</title>
        <use href="/icons.svg#triangle_down"></use>
      </svg>
    </div>
  </div>

  <div class="padded center-on-medium-screen colored" id="bandsContainer">
    You can also hear me play with some bands, like
    <a href="https://open.spotify.com/artist/74JX7v2IC9YPFTBmhuRV1X">Howlin' of the Wolf</a> and
    <a href="https://open.spotify.com/artist/4trI2gf2BoSN6vTc8XrPYe">Silentlab</a>. And I'm in a vinyl only band called Bronson Comet Lighter, that you'll have to search around in the real world to get a hold of.
  </div>

  <div class="top-line">
    <div class="images">
      <svg class="icons">
        <use href="/icons.svg#spotify" />
      </svg>
    </div>
    <h1>REMIXES</h1>
    <div class="images">
      <svg class="icons show-pointer"
        role="button"
        tabindex="0"
        aria-label="Expand/collapse"
        onclick="toggleDiv('remixContainer')">
        <title>Expand/collapse</title>
        <use href="/icons.svg#triangle_down"></use>
      </svg>
    </div>
  </div>

  <div class="padded center-on-medium-screen colored" id="remixContainer">
    I've also remixed two of the Silentlab songs. Check out <a href="https://open.spotify.com/track/2iPBP9A5fDyafzmVYonqg7">"The Day We Spent In Spain"</a> and <a href="https://open.spotify.com/track/6SyvIpkZu3kuentgMhdHJG">"Lonesome Town"</a>.
  </div>

  <div class="top-line">
    <div class="images">
      <svg class="icons">
        <use href="/icons.svg#youtube" />
      </svg>
    </div>
    <h1>MUSIC VIDEOS</h1>
    <div class="images">
      <svg class="icons show-pointer"
        role="button"
        tabindex="0"
        aria-label="Expand/collapse"
        onclick="toggleDiv('videosContainer')">
        <title>Expand/collapse</title>
        <use href="/icons.svg#triangle_down"></use>
      </svg>
    </div>
  </div>

  <div class="padded center-on-medium-screen colored" id="videosContainer">
    Sometimes we make music videos. Pop corn and turn on the YouTube with
    <a href="https://youtu.be/_nwNNsyEdfs?si=N2TnSbQTOdqXc2U1">The Sky's Gone Out - "She's Dead"</a>
    and
    <a href="https://youtu.be/9iHKasawsUw?si=159GTUez4TTz1wYt">Bronson Comet Lighter - "Vladivar"</a>.
  </div>

  <div class="top-line">
    <div class="images">
      <svg class="icons">
        <use href="/icons.svg#soundcloud" />
      </svg>
    </div>
    <h1>(POLARIZED)</h1>
    <div class="images">
      <svg class="icons show-pointer"
        role="button"
        tabindex="0"
        aria-label="Expand/collapse"
        onclick="toggleDiv('polarizedContainer')">
        <title>Expand/collapse</title>
        <use href="/icons.svg#triangle_down"></use>
      </svg>
    </div>

  </div>

  <div class="padded center-on-medium-screen colored" id="polarizedContainer">
    Enjoy some ice cold, SoundCloud only, <a href="https://soundcloud.com/mc-peko/sets/polarized">polar ambient remixes</a> of some tracks from some friends of mine. Rama Project, Prunk Möbel, Icon Of Coil, The Quantum Field Trip and more...
  </div>

  <div class="top-line">
    <div class="images">
      <svg class="icons">
        <use href="/icons.svg#film" />
      </svg>
    </div>
    <h1>MOVIE EXTRA</h1>
    <div class="images">
      <svg class="icons show-pointer"
        role="button"
        tabindex="0"
        aria-label="Expand/collapse"
        onclick="toggleDiv('filmContainer')">
        <title>Expand/collapse</title>
        <use href="/icons.svg#triangle_down"></use>
      </svg>
    </div>
  </div>

  <div class="padded center-on-medium-screen colored" id="filmContainer">
    I've been an extra (background actor) in
    "Anno 1700 Season Three" (reality series <a href="https://nrk.no">NRK</a>),
    "Beforeigners Season One" and "Beforeigners Season Two" (series <a href="https://hbomax.com">HBO Nordic</a>),
    "Døde Menn Går På Ski" (movie <a href="https://skylinestudios.no">Skyline Studios</a>),
    "Golden Gate" (short movie <a href="https://mediev.no">Østfold Medieverksted</a>),
    "Makta Season One" (series <a href="https://nrk.no">NRK</a>) and
    "Now Clap!" aka "Applaus!" (short movie <a href="https://filmskolen.no">Den Norske Filmskolen</a>).
  </div>

  <?php require($_SERVER['DOCUMENT_ROOT'] . "/footer.php"); ?>

</body>

</html>