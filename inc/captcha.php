<?php
session_start();

$length_of_string = 5;

// random alphanum for captcha
$captcha = substr(bin2hex(random_bytes($length_of_string)), 0, $length_of_string);

// The captcha will be stored
// for the session
$_SESSION["captcha"] = $captcha;

$iw = 50; //x
$ih = 30; //y

// 50x30 standard captcha image
$im = imagecreatetruecolor($iw, $ih);

// random fg color
$fg = imagecolorallocate($im, rand(0, 70), rand(0, 70), rand(0, 70));

// random fbg color
$bg = imagecolorallocate($im, rand(185, 255), rand(185, 255), rand(185, 255));

// random line color
$ln = imagecolorallocate($im, rand(0, 70), rand(0, 70), rand(0, 70));

// image color fill
imagefill($im, 0, 0, $bg);

// Print the captcha text in the image
// with random position & size
$x = rand(0, 5);
$y = rand(0, 5);

imagestring($im, 5, $x, $y, $captcha, $fg);

// strike through
imageline($im, 0, $y + 8, $iw, $y + 8, $fg); // x1, y1, x2, y2

// cross
$t = rand(0, 1) ? 0 : $ih;
imageline($im, 0, $t, $iw, $ih - $t, $ln); // x1, y1, x2, y2

// VERY IMPORTANT: Prevent any Browser Cache!!
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

// The PHP-file will be rendered as image
header('Content-type: image/png');

// Finally output the captcha as
// PNG image the browser
imagepng($im);

// Free memory
imagedestroy($im);