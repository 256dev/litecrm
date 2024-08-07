# LiteCRM

## Система управления заказами для сервисного центра.

Система написана на PHP с использованием фреймворка Laravel 6

Зависимости для сборки:
* PHP 7.4 или 8.0
* Composer
* Nodejs 14 или 16

Зависимости для работы проекта
* Web server(либо хостинг)
* PHP 7.4 или 8.0
* MySQL 5.6 или выше
* созданная база данных и пользователь, имеющий к ней доступ

---

🚀 Систему можно развернуть на ПК и она будет доступна только на нем, либо на сервере или хостинге, тогда она будет доступна с любого устройства, на котором установлен браузер.

Для того, чтобы развернуть систему, вам необходимо скачать архив или склонировать репозиторий командой, которая указана ниже

    $ git clone https://github.com/256dev/litecrm.git

Перейти в папку с проектом

    $ cd ./litecrm

Из образца файла настроек **.env.example** создайте копию с именем **.env**. Eсли вы используете Linux или MacOS это можнор сделать выполнив команду в командой строке

    $ cp .env.example .env

Далее необходимо указать базовые параметры для работы системы в файле **.env**
* APP_NAME - имя системы, которое будет указываться в шапке
* APP_ENV - prod для работы и local для тестирования
* APP_DEBUG - false - для работы и true - для тестирования
* APP_URL - адрес по которому будет доступна система в браузере
* REDIRECT_HTTPS - true, если используется шифрованное соединение (https)
* SERVER_TYPE - nginx, если он используется в качестве прокси сервера, либо apache, если любой другой
* DATE_TIMEZONE - часовой пояс в таком формате 'Europe/Minsk'

#### Запуск нативно на сервере
Выполнить команду, которая скачает необходимые php зависимости

    $ composer install

Выполните команду для создания ключа шифрования сессий и кук(ключ будет автоматически добавлен в **.env** )

    $ php artisan key:generate

Далее заполняем данные базы данных в файле **.env** полученные при ее создании или выданные хостером:
* DB_HOST - 127.0.0.1 или localhost в зависимости от того, что было указано при создании пользователя в MySQL
* DB_DATABASE - имя базы данных
* DB_USERNAME - имя пользователя, который имеет доступ к базе данных
* DB_PASSWORD - пароль пользователя базы данных

Чтобы развернуть базу данных и заполнить ее базовой информацией необходимо выполнить команду

    $ php artisan migrate --seed

Далее необходимо выполнить команду для скачивания зависимостей для сборки Frontend

    $ npm install

И после выполнить его сборку

    $ npm run prod

#### Запуск с помощью Docker Compose
В файле **.env** изменяем (на основе этих данных будет автоматически созданна база данных в докере):
* DB_HOST=mysql
* DB_DATABASE - имя базы данных
* DB_USERNAME - имя пользователя
* DB_PASSWORD - пароль пользователя базы данных
* DOCKER_DB_ROOT_PASSWORD - пароль пользователя root базы данных

Выполнить следующие команды:

* Сборка образа при первом запуске и старт сервисов LiteCRM и MySQL:

       $ docker compose up -d

* Развертывание базы данных и заполнение ее базовой информацией:

       $ docker compose exec litecrm php artisan migrate --seed

* Создания ключа шифрования сессий и кук(ключ будет автоматически добавлен в **.env** )

  Для Linux:

        $  sed -i "s|^APP_KEY=.*|APP_KEY=$(docker exec litecrm php artisan key:generate --show)|" .env

  Для MacOS:

        $ sed -i '' "s|^APP_KEY=.*|APP_KEY=$(docker exec litecrm php artisan key:generate --show)|" .env

* Остановка запущенных контейнеров:

        $ docker compose down

* Запуск сервисов LiteCRM, MySQL:

        $ docker compose up -d

Система будет доступна по адресу указаному вами в настройках.
* Имя пользователя - **administrator@litecrm.online**
* Пароль - **789456123**

После авторизации в разделе сотрудники необходимо изменить данные на свои.
В общих настройках необходимо указать информацию о вашем сервисе которая будет отображатся в актах.

Так же вы можете обратиться с вопросами по развертывания, настройке и эксплуатации системы в наш [телеграм канал](https://t.me/litecrm_chat)
Так же вы можете написать нам на почту <info@litecrm.online>


## Change Notes:
v1.3
* Добавленна возможность запуска через Docker Compose
* Исправленна ошибка неверной цены материалов

v1.2
* Добавлена сборка релизных архивов готовых к работе на хостинге

v1.1
* Исправленны ошибки

v1.0
* первая версия системы

## License

Copyright © 2020 - 2024 256Dev.com.
This project is MIT licensed.
