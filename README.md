#Tick IT
A support ticketing example


## Symfony setup

Install composer and node.js packages.
1. Install symfony dependencies using `composer install`
2. Install node dependencies using `npm install`

Setup the database.

1. Edit the DATABASE_URL var in .env (or override DATABASE_URL in .env.local to avoid committing your changes)
   eg. `mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7`

2. Setup mailer dsn by relation the line in the .env if left to null mails will still be generated but not sent
   `MAILER_DSN=null://null`

3. Next create all the tables by running
   `php bin/console d:m:m` or `php bin/console doctrine:migrations:migrate`

4. Next create data by runnning
   `php bin/console d:f:l`

5. Build vue files run
   `npm run dev`

Default Users Are.

bob@support.com - password

sue@support.com - password

randy@support.com - password