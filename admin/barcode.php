<?php
$kode = $_GET['kode'];

header('Content-Type: image/png');

// Create image
$width = 200;
$height = 80;
$image = imagecreatetruecolor($width, $height);

// Colors
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);

// Fill background
imagefill($image, 0, 0, $white);

// Simple barcode pattern (Code 128 style)
$barcode = $kode;
$len = strlen($barcode);
$charWidth = 8;
$startX = 10;
$y = 10;
$barHeight = 50;

// Generate bars based on character ASCII values
for ($i = 0; $i < $len; $i++) {
    $char = ord($barcode[$i]);
    // Create pattern based on ASCII value
    $pattern = ($char % 2 == 0) ? '101' : '110';
    
    for ($j = 0; $j < 3; $j++) {
        $bit = substr($pattern, $j, 1);
        if ($bit == '1') {
            $x = $startX + ($i * $charWidth * 3) + ($j * $charWidth);
            imagefilledrectangle($image, $x, $y, $x + $charWidth - 1, $y + $barHeight, $black);
        }
    }
}

// Add text below barcode
$textX = $startX;
$textY = $y + $barHeight + 5;
imagestring($image, 3, $textX, $textY, $barcode, $black);

imagepng($image);
imagedestroy($image);
