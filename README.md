# Mini Helpdesk API

This repository contains the backend for a simple help‑desk ticketing system built with Laravel 11.

## 🚀 Getting Started

### Requirements

- PHP 8.1+
- Composer
- MySQL (or compatible database)
- [Laravel Sail](https://laravel.com/docs/sail) / local server environment

### Installation

```bash
git clone <repo-url> mini-helpdesk-api
cd mini-helpdesk-api
composer install
cp .env.example .env      # configure DB credentials etc.
php artisan key:generate
php artisan migrate
php artisan db:seed        # loads sample users/tickets/comments
```

Run the application:

```bash
php artisan serve           # default http://127.0.0.1:8000
```

### Authentication

The API uses **Laravel Sanctum** for token authentication. Register/login to obtain a bearer token, then include it in the `Authorization` header for protected routes:

```
Authorization: Bearer {token}
```


## 📦 Available Endpoints
All routes are prefixed with `/api` and protected routes require a valid token.

### Authentication

| Method | URI                 | Description                | Body params                              |
|--------|---------------------|----------------------------|-------------------------------------------|
| POST   | `/auth/register`    | Create new user            | `name`, `email`, `password`, `password_confirmation` |
| POST   | `/auth/login`       | Obtain auth token          | `email`, `password`                       |
| POST   | `/auth/logout`      | Revoke current token       | – (auth required)                         |

### Tickets

| Method | URI                              | Description                         | Body params / query                         |
|--------|----------------------------------|-------------------------------------|---------------------------------------------|
| POST   | `/tickets`                       | Create ticket                       | `title` **(required)**, `description`, `priority` (`low|normal|high`) |
| GET    | `/tickets`                       | List tickets                        | optional `?archive=true` for archived ones  |
| GET    | `/tickets/{ticket}`              | Get single ticket                   | –                                           |
| PATCH  | `/tickets/{ticket}`              | Update ticket or archive action     | any of `title`, `description`, `status` (`open,in_progress,resolved,closed`), `priority`, `assignee_id`, **`action: "archive"`** to archive |

> Archived tickets are simply tickets with `is_archived = true`. The `?archive` query parameter filters the list.

### Comments

| Method | URI                                      | Description                         | Body params                               |
|--------|------------------------------------------|-------------------------------------|--------------------------------------------|
| POST   | `/tickets/{ticket}/comments`             | Add comment to ticket               | `body` **(required)**                      |
| GET    | `/tickets/{ticket}/comments`             | List comments for ticket            | paginated                                  |
| GET    | `/comments`                              | List comments created by current user | paginated                                 |
| GET    | `/comments/{comment}`                    | Show one of user's comments         | –                                          |
| PATCH  | `/comments/{comment}`                    | Edit own comment                    | `body` **(required)**                      |
| DELETE | `/comments/{comment}`                    | Delete own comment                  | –                                          |

> Authorization: users can only view/modify comments they created; ticket comments listing is open to ticket owner only.


## 🛠 Architectural Notes

- **Domain‑Driven Design**: Repositories and services live under `app/Domain`.
- **Exception handling**: Custom renderers in `bootstrap/app.php` convert domain or auth errors to JSON.
- **Status transitions**: Business logic for ticket statuses resides in `TicketStatusTransitionFactory`.


## 🧪 Testing

```bash
./vendor/bin/phpunit
```

There are feature tests covering authentication, ticket endpoints, and error responses.


---

For further development or deployment details, consult the in‑code comments and Laravel documentation.
