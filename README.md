## About
This is a game inspired by Omicron Beta and TDZK. It's a largely text-based MMO where you command a space ship in a universe composed of multiple 2D grids of sectors. It will feature trading, resourcing, and combat. 

## Setup

 - Clone repository 
 - Install the following:
   
    - PHP7.2 
    - Composer 
    - Node.js + NPM 
    - vue-cli-3
    - Docker

- Run vue ui and run the serve task
- Navigate to `/server` and run `docker-compose up -d` to run the docker instances with postgreSQL and PHP/nginx
- Run `./server/scripts/ssh` to ssh into the webserver. (This script will likely only work on Windows. Examine the contents of the script to see how to do it on other operating systems. All it does is run one command, I just couldn't be bothered to type it every time)
- Once you're shelled into the webserver, run `php artisan:migrate --seed`
- Copy and adapt the environment file below to your needs. Note: If port 80 is blocked on your machine, you'll have to map port 80 of the docker instance to a different port on your machine. You'll also have to change the `network.js`file to reflect the port you have selected.
## Env
Use this environment file for local development.
```APP_NAME=Laravel  
APP_ENV=local  
APP_KEY=base64:+x5UAAuNKqoN1A99UDQS+n+eW18BcVYablg70QntCiA=  
APP_DEBUG=true  
APP_URL=http://localhost  
  
LOG_CHANNEL=stack  
  
DB_CONNECTION=pgsql  
DB_HOST=database  
DB_PORT=5432  
DB_DATABASE=game  
DB_USERNAME=laravel  
DB_PASSWORD=secret  
  
BROADCAST_DRIVER=log  
CACHE_DRIVER=file  
QUEUE_CONNECTION=sync  
SESSION_DRIVER=file  
SESSION_LIFETIME=120  
  
REDIS_HOST=127.0.0.1  
REDIS_PASSWORD=null  
REDIS_PORT=6379  
  
MAIL_DRIVER=smtp  
MAIL_HOST=smtp.mailtrap.io  
MAIL_PORT=2525  
MAIL_USERNAME=null  
MAIL_PASSWORD=null  
MAIL_ENCRYPTION=null  
  
PUSHER_APP_ID=  
PUSHER_APP_KEY=  
PUSHER_APP_SECRET=  
PUSHER_APP_CLUSTER=mt1  
  
MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"  
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"```
