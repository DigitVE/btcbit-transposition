<?php

require __DIR__ . '/vendor/autoload.php';

if (count($argv) < 2) {
    exit('Specify the number of semitones as the argument (\'php index.php -3 < test1.json\' for example)' . PHP_EOL);
}

if (!filter_var($argv[1], FILTER_VALIDATE_INT)) {
    exit('Please provide the correct integer for the last argument' . PHP_EOL);
}

$json = stream_get_contents(STDIN);

if (!$json) {
    exit('Can\'t open json' . PHP_EOL);
}

$arrayToTransposite = json_decode($json, true);
$semitonesToTranspone = (int) $argv[1];

try {
    $transposited = (new \App\TranspositionService())->transpose($arrayToTransposite, $semitonesToTranspone);
} catch (\App\Exceptions\TranspositionOutOfRangeException $e) {
    exit($e->getMessage() . PHP_EOL);
}

echo json_encode($transposited) . PHP_EOL;
exit();
