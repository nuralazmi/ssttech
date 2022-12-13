
## Run


- git clone https://github.com/nuralazmi/ssttech.git
- cp .env.example .env
  - settings check (nano or vim or editor)
    - DB_CONNECTION=mysql 
    - DB_HOST=db 
    - DB_PORT=3306 
    - DB_DATABASE=ssttech 
    - DB_USERNAME=ssttech_user 
    - DB_PASSWORD=ssttech_password 
    - CACHE_DRIVER=file 
    - QUEUE_CONNECTION=redis 
    - REDIS_HOST=redis
- docker-compose build app
- docker-compose up -d
- docker exec -it ssttech-app bash
- composer install
- php artisan key:generate
- php artisan migrate
- php artisan db:seed
- php artisan test
- php artisan serve

NOTE : You have to run "php artisan horizon" in new terminal(docker exec -it ssttech-app bash). I couldn't identify supervisor. I'm sorry. 

## Check List

- [✓] OOP
- [✓] PHP 8.1
- [✓] Laravel 9+
- [✓] Git
- [-] Postgres - (I used MYSQL)
- [✓] Eloquent ORM
- [✓] Migration & Seeders
- [✓] Test
- [✓] Auth with token
- [✓] SOA orianted design
- [✓] Queue (Horizon)
- [✓] Cache - File
- [no] Api Docs (But there is postman collection in this repo)

## Login Info

http://127.0.0.1:8000/api
username : nuralazmi
password : 123456
debug    : true  (optional)

