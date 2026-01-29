Описание проекта

Здравствуйте! Я выполнил задание.
Чтобы запустить проект, выполните следующие команды:

# Установить зависимости
composer install

# Создать файл окружения
cp .env.example .env

# Сгенерировать ключ приложения
php artisan key:generate

# Выполнить миграции и посеять данные
php artisan migrate --seed

# Запустить сервер разработки
php artisan serve

# Реализованная логика
-LeadController

-CallController (Поскольку этот контроллер содержит много логики, я перенёс часть её в класс CallService)

-ManagerController

# Также я написал тесты для некоторых случаев.
-php artisan test

# Дополнительно
Я добавил некоторую логику в файл bootstrap/app.php

