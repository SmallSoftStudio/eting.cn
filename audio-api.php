<?php
// audio-api.php - 动态扫描音频文件夹
header('Content-Type: application/json');

$baseDir = __DIR__ . '/audio';
$result = [];

function scanAudioDir($dir, $baseDir) {
    $items = [];
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        $fullPath = $dir . '/' . $file;
        $relativePath = str_replace($baseDir, '', $fullPath);
        
        if (is_dir($fullPath)) {
            $category = $file;
            $songs = [];
            $subFiles = scandir($fullPath);
            foreach ($subFiles as $subFile) {
                if ($subFile === '.' || $subFile === '..') continue;
                $ext = strtolower(pathinfo($subFile, PATHINFO_EXTENSION));
                if (in_array($ext, ['mp3', 'm4a', 'wav', 'ogg', 'flac'])) {
                    $displayName = pathinfo($subFile, PATHINFO_FILENAME);
                    $songs[] = [
                        'name' => $displayName,
                        'url' => '/audio' . $relativePath . '/' . $subFile
                    ];
                }
            }
            if (!empty($songs)) {
                $items[$category] = $songs;
            }
        }
    }
    return $items;
}

$result = scanAudioDir($baseDir, $baseDir);
echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>