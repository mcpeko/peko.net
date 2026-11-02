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
      <svg class="icons">
        <use href="/icons.svg#spotify" />
      </svg>
    </div>
    <h1>Lofi hip hop</h1>
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
    <a href="https://open.spotify.com/artist/5p4HgZHdHOOWlE9q7aJ9ZM">Here they are on Spotify</a>, and you can find them on other outlets as well. Instrumental, around two minutes and 70 BPM kinda stuff with sufficient crackle, shuffle and microtonality.
  </div>

  <div class="top-line">
    <div class="images">
      <svg class="icons">
        <use href="/icons.svg#spotify" />
      </svg>
    </div>
    <h1>Bands</h1>
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
    I played bass in <a href="https://open.spotify.com/artist/74JX7v2IC9YPFTBmhuRV1X">Howlin' of the Wolf</a>, and drums and various instruments in <a href="https://open.spotify.com/artist/4trI2gf2BoSN6vTc8XrPYe">Silentlab</a>. And I'm in a vinyl only rehabilly band called <a href="http://bronson.no">Bronson Comet Lighter</a>, that you'll have to search around in the real world to get a hold of. <a href="https://arcticaantarctica.com">Arctica / Antarctica</a> was a polar ambient band that did some lovely concerts.
  </div>

  <div class="top-line">
    <div class="images">
      <svg class="icons">
        <use href="/icons.svg#spotify" />
      </svg>
    </div>
    <h1>Remixes</h1>
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
    I've done <a href="/remixes.php">remixes</a> of two of the Silentlab songs, and one by The Sky's Gone Out.
  </div>

  <div class="top-line">
    <div class="images">
      <svg class="icons">
        <use href="/icons.svg#youtube" />
      </svg>
    </div>
    <h1>Music videos</h1>
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
    Sometimes we make <a href="/music-videos.php">music videos</a>. Pop corn and turn on the YouTube with MC Peko, Bronson Comet Lighter, The Sky's Gone Out and Silentlab.
  </div>

  <div class="top-line">
    <div class="images">
      <svg class="icons">
        <use href="/icons.svg#soundcloud" />
      </svg>
    </div>
    <h1>(Polarized)</h1>
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
    Enjoy some ice cold, SoundCloud only, <a href="https://soundcloud.com/mc-peko/sets/polarized">polar ambient remixes</a> of some tracks from some friends of mine.
  </div>

  <div class="top-line">
    <div class="images">
      <svg class="icons">
        <use href="/icons.svg#film" />
      </svg>
    </div>
    <h1>Movie extra</h1>
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
    I do some <a href="/movie-extra.php">movie extra</a> (statist) stuff from time to time. At your service, hit me up.
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
    Concerts, DJ sets and other performances. <a href="/events.php">Upcoming and Previous dates</a>.
  </div>

  <div class="top-line">
    <div class="images">
      <svg class="icons" aria-hidden="true"><use href="/icons.svg#lp"></use></svg>
    </div>
    <h1>Releases</h1>
    <div class="images">
      <svg class="icons show-pointer" role="button" tabindex="0" aria-label="Expand/collapse" onclick="toggleDiv('releasesContainer')">
        <title>Expand/collapse</title>
        <use href="/icons.svg#triangle_down"></use>
      </svg>
    </div>
  </div>

  <div class="padded center-on-medium-screen colored" id="releasesContainer">
    <a href="/releases.php">Records and other releases</a> I have been involved with, including different editions. Newest releases are listed first.
  </div>

  <?php require($_SERVER['DOCUMENT_ROOT'] . "/footer.php"); ?>

</body>

</html>