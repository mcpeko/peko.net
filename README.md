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
- `/releases` – text files for releases metadata  
- `/releases_lofi` – text files for lofi releases metadata  
- `index.php` – main page  
- `style.css` – global styles  
- `head.php`, `toc.php`, `footer.php` – shared layout includes

## Notes

This repo mirrors the live site. Changes are developed locally, then
committed and pushed here, and finally uploaded to the server.
