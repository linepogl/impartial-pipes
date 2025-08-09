<?php

declare(strict_types=1);

$attr = simplexml_load_file($argv[1])->attributes();
$c = intval($attr['lines-covered']);
$t = intval($attr['lines-valid']);
echo 'Code coverage: ' . $c . '/' . $t . ' (' . round($c / $t * 100, 5) . '%)' . PHP_EOL;
if ($c !== $t) exit(1);
