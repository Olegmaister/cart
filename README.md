# Сайт интернет магазина - "prof1group.ua"


В /common/config/params-local.php надо прописать:
return [
    'cookieDomain' => '.dev.p1gtac.com',
    'homeUrl' => 'https://dev.p1gtac.com',
];


В /common/config/main-local.php
return [
    'aliases' => [
        '@host'=> 'http://dev.p1gtac.com',
    ],
];

<div>
    <b>Раскоментировать или установить расширение intl</b>:
    <ul>
        <li>Для работы - Inflector::slug нужно поставить расширение intl</li>
        <li>extension = intl</li>
    </ul>
</div>

<div>
    <b>Консольные команды</b>:
    <ul>
        <li>composer install</li>
        <li>php init</li>
        <li>yii migrate</li>
    </ul>
</div>

<div>
    <b>Консольные команды (RBAC)</b>:
    <ul>
        <li>php yii rbac</li>
    </ul>
</div>




