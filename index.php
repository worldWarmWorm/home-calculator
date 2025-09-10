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
    <blockquote>Тарифы всех поставщиков услуг указаны за актуальный период для адреса г.Новосибирск, ул.Березовая, д.13</blockquote>
    <ul>
        <?php foreach ($providers as $provider) { ?>
            <li>Организация: <?= $provider->getName() ?></li>
            <li>Тариф: <?= $provider->getTax() ?> <?= $provider->getMeasure() ?></li>
            <?php if (null !== $provider->getFixedTaxExplain()) { ?>
                <li>Сумма платежа фиксированная: <?= $provider->getFixedTaxExplain() ?></li>
            <?php } ?>
            <li><a href="<?= $provider->getUrl() ?>" target="_blank">Перейти к странице тарифов</a></li>
            <hr>
        <?php } ?>
    </ul>
</body>
</html>
