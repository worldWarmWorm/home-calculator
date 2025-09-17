<?php

use HomeCalculator\App;
use HomeCalculator\Driver\Service;
use HomeCalculator\Provider\AOSAHProvider;

require_once "vendor/autoload.php";

$app = App::init([
    new AOSAHProvider('https://xn--80aa5bmv.xn--p1ai/about/tariffs/'),
]);
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
    <blockquote>Тарифы всех поставщиков услуг указаны за актуальный период для адреса г.Новосибирск, ул.Березовая, д.13</blockquote>
    <h2>Организации</h2>
    <ul>
        <?php foreach ($app->getProviders() as $provider) { ?>
            <li><h3><?= $provider->getOrganizationName() ?></h3></li>
            <h4>Услуги</h4>
            <ul>
                <?php
                /** @var Service $service */
                foreach ($provider->getServices() as $service) { ?>
                    <li><?= $service->getName() ?></li>
                    <li><?= $service->getTax() . ' ₽ ' . $service->getUnit() ?></li>
                <?php } ?>
            </ul>
            <li><a href="<?= $provider->getUrl() ?>" target="_blank">Перейти к странице тарифов</a></li>
            <hr>
        <?php } ?>
    </ul>
</body>
</html>
