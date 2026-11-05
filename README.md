# peko.net

Artist website for **MC Peko** (aka DJ Peko aka Ole Peko Sørensen).

## Overview

This site is a simple, fast, no-nonsense homepage with links to:

- **Lofi hip hop** releases  
- **Bands** (Howlin' of the Wolf, Silentlab, Bronson Comet Lighter)  
- **Remixes**  
- **Music videos**  
- **(Polarized)** polar ambient remixes  
- **Movie extra** appearances
- **Events**
- **Releases**

Everything is kept intentionally minimal and text-based.

## Tech

- HTML, CSS, PHP (no frameworks)
- Plain JavaScript (`index.js`) for small interactive bits
- SVG icons (`icons.svg`)
- Deployed by uploading files to the web host via FTP

## Structure (short)

- `/img` – logos and background image  
- `/film` – text files for movie extra credits  
- `/film_photos` – stills  
- `/events` – supplied event text files
- `/events_photos` – event photos
- `/releases` – text files for releases metadata  
- `/releases_lofi` – text files for lofi releases metadata  
- `index.php` – main page  
- `<section>.php` – pages for the main TOC entries, rendered by `section-page.php`
- `/data/<section>.json` – structured records displayed on each section page
- `entry-data.php` – shared data validation and metadata formatting
- `style.css` – global styles  
- `head.php`, `toc.php`, `footer.php` – shared layout includes

## Notes

This repo mirrors the live site. Changes are developed locally, then committed and pushed here, and finally uploaded to the server.

Dark mode changes the interface without inverting the background photo.
The header home link displays MC Peko as text; the site favicon is retained.
Desktop section headers align with the side panels and their first icon rows.
Section page headers repeat their icon on both sides to center the title.
Lofi hip hop uses the shared cassette icon; Playlists uses the view-list icon
in both navigation and page headings.
Close the page heading before rendering entries or controls. Keep a 16px gap
below the heading on every section page so the first entry never appears part of it.
Section pages go straight from their heading to entries or controls, without
introductory description sections.
The homepage keeps the personal introduction and shows the next upcoming event;
full content is on the corresponding section pages.
The homepage also displays the linked Fuzz Pop logo and artist label credit,
matching Silentlab's label feature.

On phones, section artwork fills the page width while record text retains
its padding. Desktop entries keep their side-by-side layout.

The footer displays the MC Peko copyright notice above the production credit,
without a document update date.
Social icons are ordered Spotify, Facebook, Instagram and GitHub.

Section entries use a required stable `id` and `title`, with optional plain-text `description`
and HTTP(S) `url`. An optional `image` points to a local image under `/img`
or `/film_photos`, `/events_photos` or `/bands_photos`; `poster_url` optionally
links that image to an HTTP(S) destination.
Work titles (songs, releases, videos and films) and album metadata
are displayed in straight double quotation marks. Event names, artist names and page/group
headings remain unquoted. Quotation marks are presentation, not stored title data.
Each section has a JSON file under `data`, with `schema_version: 1` and an
ordered `entries` list. Playlists lists the supplied Lofi Hip Hop and Fredrikstad
Spotify playlists by DJ Peko, with responsive embedded Spotify players and no
duplicate headings or links. Player URLs are derived from validated Spotify playlist URLs.
Players use Spotify's neutral dark theme instead of artwork-derived colors.
Spotify controls the embedded fonts and internal styling; site styles apply to
the surrounding headings and links.
Entire playlist players counteract Light mode inversion to preserve their artwork,
because images inside Spotify's cross-origin frames cannot be styled separately.
Polarized has nine
individual remixes with their original SoundCloud covers in `/img/polarized`.
The project heading is `(Polarized)`, and its remixes are displayed newest first
by publication date.
Music videos has locally saved YouTube stills in `/img/music-videos`, including
Silentlab's "Lonesome Town" and "Hey, Hey Goodbye".
The Silentlab remixes and The Sky's Gone Out's "The Funeral" remix use their
Spotify front covers in `/img/remixes`.
Bands uses photos from `/bands_photos`, displayed at 16:9. Silentlab uses a
full-body crop of the original seaside photograph, with space around both band
members. The original photograph and poster are preserved.
Entries may include a `links` list of nonempty `label` values and HTTP(S) `url`
values. Band names are plain headings. Bands provides website links for all four bands and verified Facebook
and Spotify links for Silentlab and Howlin' of the Wolf.
Band links include small Website, Facebook, Spotify and SoundCloud icons.
Arctica / Antarctica uses a PNG converted from the supplied Nikon RAW photo.
Use PNG for new bitmap assets.
Cover artwork retains its original colors in both interface modes.
Entry text appears to the right of its image or placeholder on desktop.
On screens narrower than 800px, images and placeholders fill the content width above the text.
Lofi entries contain the seven singles verified on Spotify, with direct song
links and local front covers. Other unreleased records remain in
`releases_lofi` but are not displayed. Movie extra uses available images from
`film_photos`, with a film-icon placeholder for entries without a still.
Døde Menn Går På Ski uses the photo from the supplied Facebook premiere post.
Both Beforeigners seasons use captures from the supplied Facebook posts.
Season One uses the supplied full landscape still rather than the earlier portrait crop.
Season Two uses the individually selected photo (Facebook photo ID 10158394776411347).
Movie extra is displayed newest first by participation year, retaining record
order within the same year.
Events contains supplied event information, photos and individual event links.
Events are grouped under Upcoming and Previous headers using today's date in
Europe/Oslo. Today's events remain upcoming; each group retains newest-first order.
Event dates are labeled Date. Simple concert and DJ descriptions appear as
Event metadata, using Concert and DJ set respectively. Every event starts with
an Event metadata row; longer descriptions retain their text in that row.
Missing event posters use a portrait A4 (210:297) calendar-icon placeholder.
Film placeholders retain their 16:9 proportions. Event links are applied
directly to matching artist, event and venue text, including venue names within
locations, rather than repeated in a separate link list. Explicit metadata links
take precedence over these record-specific links and the shared website map.
The homepage shows the next upcoming event with the same entry card as the Events
page, with identical markup and responsive styles: side by side on larger screens,
and an edge-to-edge poster above padded text below 800px.
Event photos use a centered 4:3 crop matching the video stills, with the original
files preserved.
When an event has a `poster_url`, its poster links directly to that event.
The upcoming 25-11-2026 event uses a local portrait A4 PNG crop of the supplied
poster, retaining its heading and date. The original JPEG remains unchanged.
The TOC still opens the local Events page. Invalid entry data produces
an HTTP 500 response and a server log message.
Releases omit duplicate Artist website links because artist names already link
to their profiles. Release service links show an icon, service label, linked URL
and external-link indicator.

## Record metadata

Optional `metadata` objects contain named, typed fields, not HTML or combined
description strings. The shared definitions in `entry-data.php` control
validation, display labels and ordering. Unknown fields fail validation rather
than disappearing from the page.

- `artists`, `written_by`, `remixed_by`, `produced_by`, `performed_by`,
  `video_by`, `directed_by`, `filmed_by`, `edited_by`, `mixed_by` and
  `mastered_by`: nonempty lists of names.
- `release_date`, `published_date`, `album_release_date` and `event_date`:
  ISO `YYYY-MM-DD`, or `YYYY` when only the year is known. Do not invent a day
  or month. Complete dates are displayed as `DD-MM-YYYY` throughout the site;
  event dates also include the weekday; year-only dates remain `YYYY`.
  `participation_year`, displayed as Date, is a four-digit year from the film notes,
  not the film or series release date.
- `duration_ms`: positive integer milliseconds, displayed as `m:ss` or
  `h:mm:ss`. Fractions of a second are retained in JSON but not displayed.
- `bpm`, `track_count` and `copies`: positive integers; `key`: plain text.
- `label`, `catalogue_number`, `album`, `album_catalogue_number`, `studio`,
  `format`, `role`, `character`, `production_company`, `casting`, `broadcaster`,
  `venue`, `city`, `event_name`, `location`, `edition`, `manufacturer` and
  `original_copyright`: nonempty plain text.

Optional `sources` lists contain `label`, `url` and a nonempty `fields` list
identifying the metadata supported by that source. These are internal provenance
records and are not displayed on the website. External sources must use HTTP(S); local
sources must point to existing text files in the archival notes folders.
The JSON files and referenced archival notes are runtime content and must be deployed.

Optional `metadata_links` objects map existing text metadata fields to HTTP(S)
URLs. Production company names link to their websites with a 16x16 external-link
icon. Metadata labels use normal weight.
Every metadata label has a 16x16 icon from the shared SVG sprite, using
`--white`. Icon choices are defined alongside labels and types in
`entryMetadataFields()` and apply to every section.

`data/metadata-websites.json` maps names to their known official websites or
official profiles when no standalone website is verified. All matching text
metadata and individual names in credit lists link automatically, including
artists, remixers, broadcasters, casting, labels and studios. Explicit
`metadata_links` take precedence. Unmapped names remain plain text; add verified
destinations to the shared map to link every occurrence without duplicating URLs.
Links to the site's own homepage are rendered as `/` without an external-link
icon, including MC Peko credits and archived event links. Stored source URLs
remain unchanged.

Current dates and durations come from Spotify track metadata, YouTube video
metadata and SoundCloud track metadata. YouTube and SoundCloud dates are
publication dates, not claimed original song release dates. Spotify's current
track duration supersedes the old approximate duration in the lofi notes.
Historical label credits remain factual metadata, not site branding.
Album catalogue numbers are explicitly labelled as album details, not assigned
to individual videos. The local original-edition notes for "Tell Me How It Feels"
have a different date from the current Spotify edition; its catalogue number
has not been assigned to that Spotify track without edition verification.

Omit unknown fields instead of adding empty strings, zero durations, placeholder
credits or speculative values. Verified writer credits currently include
Sebastian Komor and Andy LaPlegua for the original "Out There" recording.
Adding a record does not require a PHP edit unless a new metadata field type
or section is needed. Preserve IDs when updating titles or metadata.

## Archived events and releases

The Events page retains the current event and includes 37 archived performances.
The Releases page contains 26 release editions. Both use the shared section
renderer, metadata icons and links, with newest dates first. The navigation and
homepage link to both pages.
Releases has a Physical/Digital/All radio filter, defaulting to All. Editions
marked `digital` are digital; the imported vinyl and CD editions are physical.
Filtering preserves the record order and does not change saved site settings.
Hornorkesteret's `Jehovas vinter` uses a PNG export of the supplied local front
cover and credits from the album production notes. Its 2019 release year is
confirmed by the band's discography; no exact release day is assumed. The local
vinyl timings total 40:22 across seven tracks. Original production files are untouched.

Records were imported from `E:\PEKO.NET\peko.net\live_info` and `disco_info`,
with six additional dated events from `live_static.php`. Matching PNG posters
and covers are stored locally under `events_photos` and `img/releases`.
Archived posters retain their full proportions instead of being cropped.
The original archive remains untouched. Separate vinyl editions retain separate
records, catalogue numbers and artwork.

The import excludes Flamenco Peko and the requested Heartships & Shipwrecks,
Songs From The Loosing End (including v2.0), The Oowee Beat (including variants),
Smart MC, Songs For Tina (including Edits), Freefall and A Little Bit Of Me.
The 7 March 2015 entry also references Flamenco Peko and is excluded.
The static birthday-party date of 13 April 2014 conflicts with the dynamic
13 January 2014 record and was not imported as a second event.
Uncertain or undated static entries and unassociated posters were not turned
into speculative event records.

Unknown durations, catalogue numbers, manufacturers and pressing counts are
omitted rather than displaying archival placeholders such as `00:00`, `?`,
`none` or `0`. Year-only release dates retain year precision. Labels and link
destinations explicitly corrected by the site owner take precedence over the
old archive. Raw HTML in archival notes is converted to text and safe HTTP(S)
links; no old PHP page is copied into the runtime site.

## License

Code in this repository is licensed under the MIT License (see `LICENSE`). 

All content, including images, photos, logos, data, audio, video and text, in this repository is copyright © Ole Peko Sørensen. All rights reserved. It may not be reused, copied, or redistributed without explicit permission.
