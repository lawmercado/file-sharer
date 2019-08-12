# file-sharer
A simple web based system to share files between users.



## Dependencies

- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- bower
- composer



## Instalation and setup

### Instalation

After cloning or downloading this repository, run the installer script.

```shell
cd file-sharer
./install.sh
```

And create an '.env' file inside the same dir. Your .env file should be similar to the following:

```shell
APP_NAME=Lumen
APP_ENV=local
APP_KEY=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9
APP_DEBUG=true
APP_URL=http://localhost
APP_TIMEZONE=UTC

LOG_CHANNEL=stack
LOG_SLACK_WEBHOOK_URL=

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fs
DB_USERNAME=fs
DB_PASSWORD=fs123

CACHE_DRIVER=file
QUEUE_CONNECTION=sync

JWT_SECRET=JhbGciOiJIUzI1N0eXAiOiJKV1QiLC
```



### Database setup

Create a dedicated and user for the application as you wish. After this, put the information regarding the database login in the '.env' file created above.



### General setup

Now we need to create the tables and populate the application for an example use. To do this,

```shell
cd file-sharer
php artisan migrate
php artisan db:seed
```



## Serving the application

```shell
php -S localhost:8000 -t public
```

