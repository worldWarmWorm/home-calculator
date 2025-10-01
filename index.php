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
//    new ModernizationFundProvider('https://www.fondgkh-nso.ru/oplata_vznosov/'),
//    new GenerationOfSiberiaProvider('https://gensib54.ru/'),
//    new GorvodokanalProvider('https://www.gorvodokanal.com/abonents/tariffs/'),
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
        <div class="back-layout container">
            <div class="row">
                <div class="col col-3">
                    <aside class="aside">
                        <div class="logo">
                            <img src="" alt="calc-logo.png">
                            <span><?= $app->getName() ?></span>
                        </div>
                        <nav class="nav">
                            <ul>
                                <li>Пункт 1</li>
                                <li>Пункт 2</li>
                                <li>Пункт 3</li>
                            </ul>
                        </nav>
                    </aside>
                </div>
                <div class="col col-9">
                    <main class="calculator">
                        <div class="row">
                            <div class="col col-8">
                                <div class="inputs">
                                    <blockquote class="label300">Тарифы всех поставщиков услуг указаны за актуальный период для адреса г.Новосибирск, ул.Березовая, д.13</blockquote>
                                    <h4>Организации</h4>

                                    <ul class="providers">
                                        <?php foreach ($app->getProviders() as $providerKey => $provider) { ?>
                                            <li class="provider provider-<?= $providerKey ?>">
                                                <h3><?= $provider->getOrganizationName() ?></h3>
                                                <h5>Услуги</h5>
                                                <ul class="services">
                                                    <?php foreach ($provider->getServices() as $serviceKey => $service) { ?>
                                                        <li class="service service-<?= $serviceKey ?>">
                                                            <p><?= $service->getName() ?></p>
                                                            <p><?= $service->getTax() . ' ₽ ' ?><button class="btn" type="button" data-description="<?= $service->getUnit() ?>">?</button></p>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                                <a href="<?= $provider->getUrl() ?>" target="_blank">Перейти к странице тарифов</a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col col-4">
                                <div class="summary">
                                    summary
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>

    <script defer src="./client/js/main.js"></script>
</body>
</html>
