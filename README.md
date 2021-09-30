# open-api-sdk-php

## О проекте

Данная библиотека предназначена для работы с Open API.

## Требования

* PHP 7.4 и выше
* PHP extension cURL

## Установка

```
composer require business-ru/open-api-sdk-php
```

Документация: https://app.swaggerhub.com/apis/Business.Ru/check.business.ru/1.2.2

## Принцип работы

### Создаем Адаптер для работы с Open Api

```php
<?php
# Подключаем автозагрузку
require 'vendor/autoload.php';
# Подключаем библиотеку Open Api Client
include 'vendor/business-ru/open-api-sdk-php/src/OpenClient.php';
# Создание экземпляра класса
$openApiClient = new OpenClient($this->account_url,$this->appID,$this->secret_key);
```

### Примеры использования

#### Информация о состоянии системы

```php
<?php
$openApiClient->getStateSystem();
```

#### Открытие смены

```php
<?php
$openApiClient->openShift();
```

#### Закрытие смены

```php
<?php
$openApiClient->closeShift();
```

#### Печать чека прихода

```php
<?php
$command = [
    "author" => "Тестовый кассир",
    "smsEmail54FZ" => "+79173446170",
    "c_num" => "1111222333",
    "payed_cashless" => 1000,
    "goods" => [
        [
            "count" => 2,
            "price" => 500,
            "sum" => 1000,
            "name" => "Товар 1",
            "nds_value" => 20,
            "nds_not_apply" => false,
            "payment_mode" => 1,
            "item_type" => 1
        ]
    ]
];
$openApiClient->printCheck($command);
```

#### Печать чека возврата прихода

```php
<?php
$command = [
    "author" => "Тестовый кассир",
    "smsEmail54FZ" => "+79173446170",
    "c_num" => "1111222333",
    "payed_cashless" => 1000,
    "goods" => [
        [
            "count" => 2,
            "price" => 500,
            "sum" => 1000,
            "name" => "Товар 1",
            "nds_value" => 20,
            "nds_not_apply" => false,
            "payment_mode" => 1,
            "item_type" => 1
        ]
    ]
];
$openApiClient->printPurchaseReturn($command);
```

#### Вернёт информацию о команде ФР

```php
<?php
$commandID = "command_id"
$openApiClient->dataCommandID($commandID);
```
