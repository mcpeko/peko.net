<?php
$pageTitle = isset($pageTitle) ? $pageTitle : 'MC Peko';
$canonicalUrl = isset($canonicalUrl) ? $canonicalUrl : 'https://peko.net';
$ogImageSize = getimagesize(__DIR__ . '/img/peko_photo_small.png');
?>
<title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
<meta charset="utf-8">
<script src="/resize_table.js?v=<?php echo filemtime(__DIR__ . '/resize_table.js'); ?>" defer></script>
<link rel="icon" href="/favicon.svg?v=<?php echo filemtime(__DIR__ . '/favicon.svg'); ?>" type="image/svg+xml">
<link rel="stylesheet" type="text/css" href="style.css?v=<?php echo filemtime(__DIR__ . '/style.css'); ?>">
<link rel="canonical" href="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta property="og:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:image" content="https://peko.net/img/peko_photo_small.png">
<meta property="og:image:type" content="image/png">
<?php if ($ogImageSize !== false): ?>
<meta property="og:image:width" content="<?php echo $ogImageSize[0]; ?>">
<meta property="og:image:height" content="<?php echo $ogImageSize[1]; ?>">
<?php endif; ?>
<meta property="og:description" content="Official website for the artist MC Peko.">

<meta name="keywords" content="Peko, MC Peko, DJ Peko, Ole Peko Sørensen">
<meta name="description" content="This is the official website for the artist MC Peko.">  
