## Lumen Task REST API
Simple Lumen REST API that allows users to manage tasks.

## Setup API locally

### Requirements
- PHP veriosn 8.2 and above
- MySQL Database
- Composer Package Manager [Composer Download](https://getcomposer.org/download/)

### Clone the repo
```
git clone [https://github.com/j-muiruri/lumen-rest-api.git](https://github.com/j-muiruri/lumen-rest-api.git)
```
### Install the following PHP extensions
```
php8.2-cli php8.2-common php8.2-fpm php8.2-mysql php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml php8.2-bcmath openssl php8.2-json php8.2-tokenizer
```
### Install dependencies
```
composer install
```
### Create .env file by 
copy `.env.example` file to `.env` or run :
```
php -r file_exists('.env') || copy('.env.example', '.env');
```
### Generate application key
```
php artisan key:generate
```
### Setup database settings 
Change these values in `.env ` file by except `DB_CONNECTION` since we are using PostgreSQL

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rest_api
DB_USERNAME=username
DB_PASSWORD=password
```

## Run migrations
```
php artisan migrate
```
## Run the Application
```
php -S localhost:8000 -t public
```

## Test the API
The api can be tested using this Postman collection [Task REST API](https://api.postman.com/collections/18086763-2b71710a-851b-464a-b795-35cbabfcbeea?access_key=PMAT-01JB9HVV4CJGQA0TVY26QWC39V)

# Filter and Search
To filter the tasks by `status` or `due_date` add a parameter to the url eg. `http://127.0.0.1/task?status=completed`, the `due date` must in `YYYY-MM-DD` format  
To search, append the `search` parameter same as filtering
