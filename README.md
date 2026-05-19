# Blog

Тестовое задание: простой блог на **PHP 8.1+**, **MySQL** и **Smarty** без фреймворков.

## Возможности

- главная — категории со статьями, 3 последних поста в каждой, ссылка «Все статьи»;
- страница категории — описание, список, сортировка по дате и просмотрам, пагинация;
- страница статьи — полный текст, категории, счётчик просмотров, 3 похожие статьи;
- сидер для заполнения БД демо-данными;
- Docker-окружение;
- стили на SCSS.

## Стек

- PHP 8.1+
- MySQL 8
- Smarty 4
- Composer
- SCSS (опционально для пересборки CSS)

## Структура

```
public/           — точка входа (DocumentRoot)
src/              — контроллеры, репозитории, Router, View
templates/        — шаблоны Smarty
config/           — app, database, smarty
database/         — schema.sql, seed.php
assets/scss/      — исходники стилей
```

## Требования

- PHP 8.1+ с расширениями `pdo_mysql`
- Composer
- MySQL 8 (локально или в Docker)
- для SCSS: Node.js и `npm` (не обязательно, CSS уже собран)

## Запуск через Docker

```bash
docker compose up -d --build
docker compose exec web php database/seed.php
```

Сайт: **http://localhost:8080/?route=home**

Полезные команды:

```bash
docker compose exec web php database/check_connection.php
docker compose down
```

Переменные БД для контейнера `web` заданы в `docker-compose.yml`. Пример для `.env` в Docker: `.env.docker.example`.

## Локальный запуск

```bash
composer install
cp .env.example .env
```

В `.env` укажите доступ к MySQL (пример):

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog
DB_USERNAME=blog
DB_PASSWORD=ваш_пароль
```

Создайте БД и пользователя (в `mysql` под root):

```sql
CREATE DATABASE IF NOT EXISTS blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'blog'@'localhost' IDENTIFIED BY 'ваш_пароль';
GRANT ALL PRIVILEGES ON blog.* TO 'blog'@'localhost';
FLUSH PRIVILEGES;
```

Схема и демо-данные:

```bash
mysql -u blog -p blog < database/schema.sql
php database/seed.php
php database/check_connection.php
```

Веб-сервер (встроенный PHP):

```bash
cd public
php -S localhost:8080
```

DocumentRoot для Apache/Nginx: каталог **`public/`**.

## Маршруты

| Страница | URL |
|----------|-----|
| Главная | `?route=home` |
| Категория | `?route=category&id=1` |
| Статья | `?route=article&id=1` |
| Сортировка | `&sort=date` или `&sort=views` |
| Пагинация | `&page=2` (10 статей на страницу) |

Пример: `?route=category&id=1&sort=views&page=2`

## Стили (SCSS)

Готовый файл: `public/css/style.css`.

Пересборка:

```bash
npm install
npm run scss
```

## Использование ИИ

Да, использовал **Cursor** (ИИ-ассистент в редакторе).

**Для чего:**
- обсуждение структуры проекта и схемы БД (черновик, дальше правил под ТЗ);
- подсказки по PDO, Smarty, SQL;
- черновики README, `.gitignore`, Docker-конфига;
- помощь с разбивкой задачи на коммиты.

**Самостоятельно / с разбором каждого файла:**
- PHP-код: роутинг, репозитории, контроллеры, сидер;
- SQL-запросы, пагинация, похожие статьи, счётчик просмотров;
- шаблоны Smarty и правки SCSS под свой вкус;
- настройка локального MySQL и проверка в браузере.

Перед сдачой прохожу по diff и могу объяснить логику любой части решения.
