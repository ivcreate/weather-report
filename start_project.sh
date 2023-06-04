#!/bin/bash

if [ ! -f ".env" ]; then
cp .env.example .env
fi

# Подъем и ребилд докер-композа
docker-compose up -d --build

docker exec -u 0 weather_app sudo service cron start

# Установка новых зависимостей composer, если есть
docker exec weather_app composer install

# Запуск миграций, сидов и т.д.
docker exec weather_app php artisan migrate --force
docker exec weather_app php artisan db:seed --force

docker exec -d weather_app php artisan queue:work

# Очистка кеша Laravel
docker exec weather_app php artisan cache:clear
docker exec weather_app php artisan config:clear
docker exec weather_app php artisan view:clear

#генерация документации
docker exec weather_app php artisan l5-swagger:generate

# Запуск тестов хотел их в конце написать
#docker exec weather_app php artisan test
