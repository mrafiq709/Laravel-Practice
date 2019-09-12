# Laravel-Command
Simple Laravel Command [including databse cretaion]

create project
----------------
    composer create-project --prefer-dist laravel/laravel project_name

for creating database and table class
----------------------------------------
    php artisan make:migration create_tasks_table --create=tasks

for creating table and database in localhost database:
-------------------------------------------------------
    [Note: Create Table in Database Server -> PhpMyadmin. And add database name in .env File:DB_DATABASE=DB_NAME]
    php artisan migrate

for creating model class
-------------------------
    php artisan make:model model_name
