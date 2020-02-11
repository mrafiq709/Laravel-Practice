# Laravel-Command
Simple Laravel Command [including databse cretaion]

create project
----------------
    composer create-project --prefer-dist laravel/laravel project_name
    
If mbstring or ext dom or xml missing:
--------------------------------------
    Sudo apt-get update
    sudo apt-get install php-mbstring
    sudo apt install php-xml

for creating database and table class
----------------------------------------
    php artisan make:migration create_tasks_table --create=tasks

for creating table and database in localhost database:
-------------------------------------------------------
Create Database in PhpMyadmin Local server. And add that database name in .env File:DB_DATABASE=DB_NAME

    php artisan migrate

for creating model class
-------------------------
    php artisan make:model model_name
    
error: Your requirements could not be resolved to an installable set of packages.
----------------------------------------------------------------------------------
<a href="https://imgur.com/8DeuJHW"><img src="https://i.imgur.com/8DeuJHW.png" title="source: imgur.com" /></a><br/><br/>

    composer update --ignore-platform-reqs
