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
