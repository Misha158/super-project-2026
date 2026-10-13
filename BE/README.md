# Super Project API

Laravel 13 REST API for the learning project. The Vue frontend lives in `/FE` and is not part of this app.

## Requirements

- PHP 8.3–8.5. This project was set up with PHP 8.4.
- Extensions: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML, Intl, Zip, `pdo_pgsql`, and `pgsql`.
- Composer 2.
- Docker, for the local PostgreSQL container.

`pdo_pgsql` and `pgsql` are included with the Windows PHP build used here, but they must be enabled in `php.ini`:

```ini
extension=pdo_pgsql
extension=pgsql
```

Confirm with `php -m`.

## Install

From the repository root:

```sh
cd BE
composer install
copy .env.example .env
php artisan key:generate
```

`.env.example` contains local placeholders only. `.env` is gitignored.

## Database

Docker Compose starts PostgreSQL 17 and stores data in the named volume `super_project_postgres`.

| Setting | Local value |
| --- | --- |
| Host | `127.0.0.1` |
| Port | `5433` |
| Database | `super_project` |
| User | `super_project` |
| Password | `secret` |

`secret` is a local development placeholder. Change it in `.env` before using this project anywhere else, then recreate the database volume if PostgreSQL has already been initialized.

```sh
docker compose up -d
php artisan migrate
php artisan db:seed
```

Check the connection:

```sh
php artisan db:show
```

The container health check uses `pg_isready`. `docker compose ps` should show the service as healthy.

Tests do not use this database. PHPUnit forces an in-memory SQLite database, so `php artisan test` does not migrate or wipe PostgreSQL.

## Run the API

```sh
php artisan serve
```

The API is at `http://localhost:8000`.

Point the frontend at this API with:

```
VITE_API_BASE_URL=http://localhost:8000/api/v1
```

Copy `FE/.env.example` to `FE/.env` and set that value. The health check is outside the version prefix: `http://localhost:8000/api/health`.

CORS allows `http://localhost:5173` by default. Add more origins as a comma-separated list in `CORS_ALLOWED_ORIGINS`. The API does not use credentialed CORS with a wildcard origin.

`APP_DEBUG=true` is for local development. Set it to `false` in production so error responses do not include stack traces.

Authentication is not enabled. API routes are public so a guard can be added later without changing the resource shape.

## Checks

```sh
composer validate
php artisan about
php artisan route:list
composer test
composer format
```

`composer format` runs Laravel Pint. Use `vendor/bin/pint --test` to check formatting without writing files.

## Endpoints

`GET /api/health`

```sh
curl http://localhost:8000/api/health
```

```json
{"status":"ok"}
```

Task statuses are `pending`, `in_progress`, and `completed`.

`GET /api/v1/tasks` returns a paginated list.

```sh
curl http://localhost:8000/api/v1/tasks
```

`POST /api/v1/tasks` creates a task and returns `201`.

```sh
curl -X POST http://localhost:8000/api/v1/tasks -H "Accept: application/json" -H "Content-Type: application/json" -d "{\"title\":\"Write tests\",\"description\":\"Cover the task API\",\"status\":\"pending\"}"
```

`GET /api/v1/tasks/{task}` returns one task, or `404` when it does not exist.

`PUT /api/v1/tasks/{task}` replaces `title` and `status`. `description` is optional and nullable.

`PATCH /api/v1/tasks/{task}` updates any subset of those fields.

```sh
curl -X PATCH http://localhost:8000/api/v1/tasks/1 -H "Accept: application/json" -H "Content-Type: application/json" -d "{\"status\":\"completed\"}"
```

`DELETE /api/v1/tasks/{task}` returns `204`.

Missing or invalid fields return `422` with Laravel's `message` and `errors` JSON.

## Troubleshooting

- `could not find driver`: enable `pdo_pgsql` and `pgsql`, then open a new terminal.
- `connection refused` on port 5433: start Docker and run `docker compose up -d` from `BE`. Wait until `docker compose ps` shows the database as healthy.
- Port 5432 is already used by another local Postgres container, so this project publishes PostgreSQL on host port `5433`. Inside the container the database still listens on `5432`.
- Password authentication failed after changing `.env`: the volume keeps the first password. Update the role inside Postgres, or remove the volume with `docker compose down -v` and start again. That deletes local data.
- Empty `APP_KEY`: run `php artisan key:generate`.
- Browser requests blocked: set `CORS_ALLOWED_ORIGINS` to the exact frontend origin, including the port.
