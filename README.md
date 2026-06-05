docker compose up -d --build
# Установка пакетов
docker compose exec backend composer install --no-security-blocking

# Генерация ключа
docker compose exec backend php artisan key:generate
