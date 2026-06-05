.PHONY: init up down restart composer key migrate clear

init: env up composer key migrate clear
	@echo " Сервис сокращения ссылок успешно запущен"

env:
	@if [ ! -f .env ]; then \
		cp .env.example .env; \
		echo "Файл .env создан из .env.example. Проверьте порты, если необходимо."; \
	else \
		echo "Файл .env уже существует."; \
	fi

up:
	docker compose up -d --build

down:
	docker compose down

restart:
	docker compose restart

composer:
	docker compose exec backend composer install --no-security-blocking

key:
	docker compose exec backend php artisan key:generate

migrate:
	docker compose exec backend php artisan migrate

clear:
	docker compose exec backend php artisan optimize:clear
