# RestAPI - Based on Laravel
Laravel 5.8 Restful API boiler plate with auth, crud and json responses.

### Install application.

1. Clone repository <br>
`git clone git@github.com:nicp0nim/rest-api.git`<br>
`cd rest-api`<br>
2. Fill database credentials <br>
`cp .env.example .env`<br>
`vim .env`<br>
3. Install needed packages <br>
`composer install`<br>
4. Migrate, install passport and seed database with fake data <br>
`php artisan migrate:fresh --seed`<br>
`php artisan passport:install`<br>
