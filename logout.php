<?php
session_start();
session_unset();
session_destroy();

// Cegah cache halaman
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

header("Location: index.php");
exit;
?>
