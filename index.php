<?php

use HomeCalculator\App;
use HomeCalculator\Provider\AOSAHProvider;
use HomeCalculator\Provider\GenerationOfSiberiaProvider;
use HomeCalculator\Provider\GorskyProvider;
use HomeCalculator\Provider\GorvodokanalProvider;
use HomeCalculator\Provider\ModernizationFundProvider;

require_once "vendor/autoload.php";

$app = App::init([
    new AOSAHProvider('https://xn--80aa5bmv.xn--p1ai/about/tariffs/'),
    new ModernizationFundProvider('https://www.fondgkh-nso.ru/oplata_vznosov/'),
    new GenerationOfSiberiaProvider('https://gensib54.ru/'),
    new GorvodokanalProvider('https://www.gorvodokanal.com/abonents/tariffs/'),
//    new GorskyProvider(''),
]);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./client/css/main.css">
    <title><?= $app->getName() ?></title>
</head>
<body>
    <div class="app">
        <header class="header">
            <div class="container">
                <div class="row">
                    <div class="col col-12">
                        <h1 class="text-center"><?= $app->getName() ?></h1>
                    </div>
                </div>
            </div>
        </header>

        <main class="main">
            <div class="container">
                <blockquote class="label300">Тарифы всех поставщиков услуг указаны за актуальный период для адреса г.Новосибирск, ул.Березовая, д.13</blockquote>
                <h4>Организации</h4>

                <div class="row">
                    <div class="col col-12">
                        <div class="providers">

                        </div>
                    </div>
                </div>

                <ul>
                    <?php foreach ($app->getProviders() as $provider) { ?>
                        <li><h3><?= $provider->getOrganizationName() ?></h3></li>
                        <h5>Услуги</h5>
                        <ul>
                            <?php foreach ($provider->getServices() as $service) { ?>
                                <li><?= $service->getName() ?></li>
                                <li><?= $service->getTax() . ' ₽ ' ?><button class="btn" type="button" data-description="<?= $service->getUnit() ?>">?</button></li>
                            <?php } ?>
                        </ul>
                        <li><a href="<?= $provider->getUrl() ?>" target="_blank">Перейти к странице тарифов</a></li>
                    <?php } ?>
                </ul>
            </div>
        </main>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col col-12">
                        Написать разработчикам
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script defer src="./client/js/main.js"></script>
</body>
</html>
