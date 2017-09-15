<?php
$csvFile = __DIR__ . '/services.csv';
$origDir = __DIR__ . '/white/';
$piconDir = __DIR__ . '/picon/';

$resCsv = fopen($csvFile, 'r');
while (($data = fgetcsv($resCsv, 1000)) !== false) {
    list($serviceTitle, $serviceKey) = $data;

    $origFile = $origDir . $serviceTitle . '.svg';
    if (!file_exists($origFile)) {
        echo 'File missing for: ' . $serviceTitle . "\n";
        continue;
    }

    $piconFile = $piconDir
        . str_replace(':', '_', rtrim($serviceKey, ':'))
        . '.png';
    if (file_exists($piconFile)) {
        continue;
    }
    exec(
        'convert -resize 100x60 -background none'
        . ' ' . escapeshellarg($origFile)
        . ' ' . escapeshellarg($piconFile)
    );
    echo 'png created: ' . $serviceTitle . "\n";
}
fclose($resCsv);

?>
