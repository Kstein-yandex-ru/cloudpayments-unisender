# Интеграция CloudPayments и Unisender на PHP
Отправляет письма через Unisender после транзакций и событий в Cloudpayments:
1. Разовая оплата
2. Ошибка при разовой оплате
3. При первом регулярном платеже (оформлении подписки)
4. При отписке от регулярных платежей
5. При ошибке списания регулярного платежа (очередная попытка через 1 день)
6. При отписке от регулярных платежей из-за трёх ошибок списания
   

## Настройка
Заменить константы в файле config.php на свои.

Для получения ключа и идентификатора пользователя:
1. Зарегистрироваться в Unisender Go: [https://go1.unisender.ru/ru/user/registration/](https://go1.unisender.ru/ru/user/registration/)
2. Создать необходимые шаблоны писем и указать их идентификаторы в файле config.php

В CloudPayments в разделе «Сайты → Выбрать сайт → Настройки» указать в соответствии с названиями файлов ссылки для уведомлений:
1. Pay
2. Fail
3. Confirm
4. Recurrent

Pay — для выполненных одностадийных платежей.
Confirm — для выполненных двухстадийных платежей.

Pay желательно указывать в любом случае, иначе могут не работать остальные уведомления из-за особенностей CloudPayments.

## Отладка неисправностей
Если отправка не работает, можно включить отображение ошибок, раскомментировав эти строки:
```
   // $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
   // if ( $status != 201 ) {
   //     die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
   // }
```
