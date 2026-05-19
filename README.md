# Blog

Небольшой блог: PHP 8.1, MySQL, Smarty. Без фреймворков.

## Стек

- PHP 8.1+
- MySQL
- Smarty

## Запуск через Docker

```bash
docker compose up -d --build
docker compose exec web php database/seed.php
```

Сайт: http://localhost:8080/?route=home

Остановка: `docker compose down` (данные MySQL в volume `mysql_data`).

Переменные для контейнера `web` заданы в `docker-compose.yml`. Для локального `.env` вне Docker используйте `DB_HOST=127.0.0.1`.

## Локально (без Docker)

```bash
composer install
cp .env.example .env
# настроить .env и создать БД/пользователя MySQL
mysql -u blog -p blog < database/schema.sql
php database/seed.php
cd public && php -S localhost:8080
```

## Использование ИИ

Да, в работе использовал **Cursor** (встроенный ИИ-ассистент).

**Для чего:**
- набросать идеи по структуре папок и таблицам БД — потом сверил с ТЗ и поправил сам;
- подсказки по синтаксису (PDO, Smarty, SQL), если что-то забыл;
- черновик текста для README и `.gitignore`.

**Сам делал:**
- логику страниц, запросы к MySQL, шаблоны, роутинг, сидер, Docker и стили — пишу и проверяю сам;
- перед коммитом просматриваю diff и могу объяснить любой участок кода.

Если появятся новые случаи (например, отладка конкретного запроса) — допишу сюда кратко.