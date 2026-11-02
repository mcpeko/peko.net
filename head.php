<?php
$pageTitle = isset($pageTitle) ? $pageTitle : 'MC Peko';
$canonicalUrl = isset($canonicalUrl) ? $canonicalUrl : 'https://peko.net';
?>
<title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
<meta charset="utf-8">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" type="text/css" href="style.css?v=<?php echo filemtime(__DIR__ . '/style.css'); ?>">
<link rel="canonical" href="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta property="og:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:image" content="https://peko.net/img/peko_photo_small.png">
<meta property="og:description" content="Official website for the artist MC Peko.">

<meta name="keywords" content="Peko, MC Peko, DJ Peko, Ole Peko Sørensen">
<meta name="description" content="This is the official website for the artist MC Peko.">