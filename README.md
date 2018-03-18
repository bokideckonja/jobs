# Jobs

### Installation

1. git clone https://github.com/bokideckonja/jobs.git
2. cd jobs
3. composer install
4. rename .env.example to .env and modify the following:

DB settings:
`
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
`

Mail settings(mail will be used as smtp for sending emails):
`
MAIL_DRIVER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
`

5. php artisan migrate
6. open website and register(top-right link) to create account that will be used as moderator
7. start posting jobs