<?php
//requires enigma2 "jsonapi" plugin
$host = "dreambox";

$csvFile = __DIR__ . '/services.csv';
$bouquets = apiCall('enigma2.servicedata.getTVBouquets');
$collection = [];

foreach ($bouquets as $bouquetData) {
    list($bouquetKey, $bouquetTitle) = $bouquetData;

    $services = apiCall('enigma2.servicedata.getServiceList', $bouquetKey);
    foreach ($services as $serviceData) {
        list($serviceKey, $serviceTitle) = $serviceData;
        $collection[$serviceKey] = $serviceTitle;
    }
}

$resCsv = fopen($csvFile, 'w');
foreach ($collection as $serviceKey => $serviceTitle) {
    if (substr($serviceKey, 0, 5) == '1:64:') {
        continue;
    }
    fputcsv($resCsv, [$serviceTitle, $serviceKey]);
}
fclose($resCsv);

echo $csvFile . "\n";

function apiCall($method, ...$params)
{
    global $host;
    $context = stream_context_create(
        array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/json',
                'content' => json_encode(
                    [
                        'method' => $method,
                        'params' => $params,
                    ]
                )
            )
        )
    );
    $response = file_get_contents('http://' . $host . '/api/call', false, $context);
    $data = json_decode($response);
    //FIXME: error check
    return $data->result;
}
?>
