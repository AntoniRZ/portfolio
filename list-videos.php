<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
$dir = __DIR__ . DIRECTORY_SEPARATOR . 'video nilaya';
$result = ['videos' => []];
if (!is_dir($dir)) {
    echo json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}
$allowed = ['mp4', 'webm', 'ogg', 'mov', 'mkv'];
$files = scandir($dir);
foreach ($files as $file) {
    if ($file === '.' || $file === '..') {
        continue;
    }
    $path = $dir . DIRECTORY_SEPARATOR . $file;
    if (!is_file($path)) {
        continue;
    }
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed, true)) {
        continue;
    }
    $caption = pathinfo($file, PATHINFO_FILENAME);
    $caption = str_replace(['_', '-'], ' ', $caption);
    $src = 'video%20nilaya/' . rawurlencode($file);
    $result['videos'][] = ['src' => $src, 'caption' => $caption];
}
usort($result['videos'], function ($a, $b) {
    return strcmp($a['caption'], $b['caption']);
});
echo json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
