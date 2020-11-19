# Test

### Docker

1. RUN: `docker-compose up -d`

1. Frontend: http://localhost:8002/customers

1. Backend: http://localhost:8001/api/customers

1. Backend UnitTest: `docker exec -it norwex_backend_1  ./vendor/bin/phpunit --filter=CustomerOrderControllerTest
`

---

### Backend

##### Manual Setup

1. PHP 7.4.3. 

1. SQLite 

1. Please see [Laravel 8.x Requirements](https://laravel.com/docs/8.x#server-requirements)

1. Run `composer install` (Maybe you need to upgrade your composer to 2.0)

1. Copy `.env.example` and Paste as `.env`.

1. Create a `backend/database/norwex.sqlite` file for SQLite.

1. Run `php artisan key:generate`

1. Run `php artisan migrate`

1. Run `php artisan db:seed`

1. Run `php artisan serve --port=8001`

##### Feature

| Endpoint        | Method           |
| ------------- |:-------------:|
| /api/customers      | GET |

```json
{
    "data": [
        ...
        {
            "customer_name": "Gerda Fay",
            "total_order_count": "173",
            "display_color": "green"
        },
        {
            "customer_name": "Hubert Gutkowski",
            "total_order_count": "187",
            "display_color": "red"
        },
        {
            "customer_name": "Jonas Zulauf",
            "total_order_count": "161",
            "display_color": "orange"
        },
        ...
    ]
}
```

##### Test

1. Run `./vendor/bin/phpunit --filter=CustomerOrderControllerTest
`

### Frontend

##### Setup

1. Vue 3.0 + vue-router + axios + bootstrap

1. Please see [Vue's latest setup](https://v3.vuejs.org/guide/installation.html#npm)

1. Run `npm run serve` (default devServer Port is 8002)

1. `http://localhost:8002/customers`