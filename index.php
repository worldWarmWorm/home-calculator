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
        <div class="row">
            <div class="col col-3">
                <aside class="aside">
                    <div class="logo">
                        <i class="fa fa-calculator" aria-hidden="true"></i>
                        <span><?= $app->getName() ?></span>
                    </div>
                    <nav class="nav">
                        <ul class="tab-switcher">
                            <li class="item active">Калькулятор</li>
                            <li class="item">Добавить поставщика услуг</li>
                            <li class="item">Сообщить о неактуальности тарифа</li>
                        </ul>
                    </nav>
                </aside>
            </div>
            <div class="col col-9">
                <main class="calculator">
                    <div class="tab-wrapper">
                        <div class="row tab-content">
                            <div class="col col-7">
                                <form action="#" class="inputs">
                                    <blockquote>Тарифы поставщиков услуг взяты с их официальных публичных сайтов</blockquote>
                                    <h3>Заполните поля для расчета</h3>
                                    <ul class="providers">
                                        <?php foreach ($app->getProviders() as $providerKey => $provider) { ?>
                                        <li class="provider provider-<?= $providerKey ?>">
                                                <h4 class="organization">
                                                    <span class="name"><?= $provider->getOrganizationName() ?></span>
                                                    <span class="number"><?= $providerKey + 1 ?></span>
                                                </h4>
                                                <ul class="services">
                                                    <?php foreach ($provider->getServices() as $serviceKey => $service) { ?>
                                                    <li class="service service-<?= $serviceKey ?>">
                                                            <label class="label">
                                                                <?= $service->getName() ?> (₽/<?= $service->getUnit() ?>)
                                                                <input name="<?= $service->getKey() ?>" type="text" readonly value="<?= $service->getTax() ?>">
                                                            </label>
                                                            <?php foreach ($service->getMultipliers() as $multiplierKey => $multiplier) { ?>
                                                                <label for="<?= $service->getKey() ?>-<?= $multiplierKey ?>" class="label">
                                                                    <?= $multiplier->getLabel() ?> (<?= $multiplier->getMeasure() ?>)
                                                                    <input
                                                                            id="<?= $service->getKey() ?>-<?= $multiplierKey ?>"
                                                                            name="<?= $multiplier->getName() ?>"
                                                                            type="number"
                                                                            value=""
                                                                            placeholder="Ввод..."
                                                                            required
                                                                            oninvalid="this.setCustomValidity('Пропустили обязательное поле для ввода')"
                                                                            oninput="this.setCustomValidity('')"
                                                                            min="<?= $multiplier->getMeasure() === 'чел' ? '1.0' : '0.1' ?>"
                                                                            max="1000"
                                                                            step="<?= $multiplier->getMeasure() === 'чел' ? '1.0' : '0.1' ?>"
                                                                    >
                                                                </label>
                                                            <?php } ?>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                                <a href="<?= $provider->getUrl() ?>" target="_blank">
                                                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                                    На страницу тарифов
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <div class="buttons">
                                        <button id="btn-calc" type="submit" class="btn btn-calc">Посчитать</button>
                                        <button type="reset" class="btn btn-clear">Очистить</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col col-5">
                                <div class="summary">
                                    <h3>Итого: <span id="result"></span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="row tab-content hide">
                            <div class="col col-12">
                                add provider
                            </div>
                        </div>
                        <div class="row tab-content hide">
                            <div class="col col-12">
                                incorrect taxes
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <script type="module" src="./client/js/main.js"></script>
</body>
</html>
