<?php

use HomeCalculator\App;
use HomeCalculator\Provider\AOSAHProvider;

require_once "vendor/autoload.php";

$app = App::init([
    new AOSAHProvider('https://xn--80aa5bmv.xn--p1ai/about/tariffs/')
]);
$providers = $app->getProviders();


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $app->getName() ?></title>
</head>
<body>
    <h1><?= $app->getName() ?></h1>
    <ul>
        <?php foreach ($providers as $provider) { ?>
            <li><?= $provider->getName() ?></li>
        <?php } ?>
    </ul>
</body>
</html>
