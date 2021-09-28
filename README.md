# open-api-sdk-php

## О проекте

Данная библиотека предназначена для работы с Open API.

## Требования

* PHP 7.4 и выше
* PHP extension cURL
* Extension Predis

## Установка

```
composer require business-ru/open-api-sdk-php
```

Документация: https://app.swaggerhub.com/apis/Business.Ru/check.business.ru/1.2.2

## Принцип работы

Сохраняем данные 'account' , 'app_id' , 'secret_key' в Json файл.

```json
{
	"account_url": "https://check-dev.class365.ru/open-api/v1/",
	"app_id": "app_id",
	"secret_key": "secret_key"
}
```

### Необходимо получить Json данные.

```php
<?php

    /**
     * Наименование аккаунта
     * @var string
     */
    protected string $account;

    /**
     * ID приложения (интеграции)
     * @var mixed
     */
    protected $appID;

    /**
     * Секретный ключ приложения
     * @var string
     */
    protected string $secretKey;

    /**
     * Установка параметров для работы с API
     * @return void
     * @throws Exception
     */
    protected function setConfig(): void
    {
        #Получаем данные внутри файла
        $cfg = json_decode(file_get_contents('openApi.json'));
        #Наименование аккаунта
        $this->account = $cfg['account'];
        #ID Приложения
        $this->appID = $cfg['app_id'];
        #Секретный ключ
        $this->secretKey = $cfg['secret_key'];
    }
```

### Создаем Адаптер для работы с Open Api

```php
<?php

use Open\Api\OpenClient;

    /**
     * Инициализируем класс Open Api
     * @var OpenClient
     */
    private OpenClient $openClient;

    /**
     * Получаем данные в виде массива
     * @var mixed
     */
    protected $response;

    public function __construct()
    {
        $this->setConfig();
        $this->openClient = new OpenClient($this->account_url, $this->appID, $this->secretKey);
    }
```

### Примеры использования

#### Информация о состоянии системы

```php
<?php

    /**
     * Метод выполняет запрос на получение информации о состоянии системы.
     * @return array
     */
    public function openApiStateSystem(): array
    {
        #Отправляем запрос
        $this->response = $this->openClient->getStateSystem();
        #Возвращаем ответ
        return $this->response;
    }
```

#### Открытие смены

```php
<?php

    /**
     * Метод отправляет запрос на открытие смены на ККТ.
     * @param string $commandName - Кастомное наименование для запроса OpenShift
     * @return array<string, mixed>
     */
    public function openApiOpenShift(string $commandName = "name"): array
    {
        #Отправляем запрос
        $this->response = $this->openClient->openShift($commandName);
        #Возвращаем ответ
        return $this->response;
    }
```

#### Закрытие смены

```php
<?php

    /**
     * Метод отправляет запрос на закрытие смены на ККТ.
     * @param string $commandName - Кастомное наименование для запроса CloseShift
     * @return array<string, mixed>
     */
    public function openApiCloseShift(string $commandName = "name"): array
    {
        #Отправляем запрос
        $this->response = $this->openClient->closeShift($commandName);
        #Возвращаем ответ
        return $this->response;
    }
```

#### Печать чека прихода

```php
<?php

    /**
     * Метод выполняет запрос на печать чека прихода на ККТ.
     * @param array $command - Сгенерированный command
     * @return int - Возвращает command_id
     */
    public function openApiPrintCheck(array $command): int
    {
        #Отправляем запрос
        $this->response = $this->openClient->printCheck($command);
        $response = $this->response;
        #Если запрос не прошел, выбрасываем исключение
        if (isset($response["message"], $response["result"])) {
            throw new Exception($response["message"], (int)$response["result"]);
        }
        #Получаем command_id
        $commandID = $response["command_id"];
        return $commandID;
    }
```

#### Печать чека возврата прихода

```php
<?php

    /**
     * Метод выполняет запрос на печать чека возврата прихода на ККТ.
     * @param array<array> $command - Массив параметров чека.
     * @return int - Возвращает command_id
     */
    public function openApiPrintPurchaseReturn(array $command): int
    {
        #Отправляем запрос
        $this->response = $this->openClient->printPurchaseReturn($command);
        $response = $this->response;
        #Если запрос не прошел, выбрасываем исключение
        if (isset($response["message"], $response["result"])) {
            throw new Exception($response["message"], (int)$response["result"]);
        }
        #Получаем command_id
        $commandID = $response["command_id"];
        return $commandID;
    }
```

#### Вернёт информацию о команде ФР

```php
<?php

    /**
     * Метод OpenApi, получение данных "fn_number, fiscal_document_number, receipt_datetime"
     * @param string $commandID - command_id.
     * @return array<array>
     */
    public function openApiDataCommandID(string $commandID): array
    {
        #Отправляем запрос для получения data по command_id до тех пор, пока не фискализируется запрос
        $this->response = $this->openClient->dataCommandID($commandID);
        #Получаем данные по command_id
        $dataCommandID = $this->response;
        if ($dataCommandID["fn_number"]
            && $dataCommandID["fiscal_document_number"]
            && $dataCommandID["receipt_datetime"]) {
            #Возвращаем данные в виде массива
            return $dataCommandID;
        }
        #Если время скрипта доходит до 14400 секунд, выдаем ошибку
        if ((time() - $timeNow) >= 14400) {
            throw new Exception('Данные не получены за 14400 секунд. Время для подключения истекло');
        }
    }
```
