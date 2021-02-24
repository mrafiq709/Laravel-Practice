##### Install tailwindcss
https://tailwindcss.com/docs/guides/laravel

If there is problem during ***npm install && npm run dev*** then run below code OR try different version installation
```
npm uninstall autoprefixer postcss tailwindcss
npm install tailwindcss@npm:@tailwindcss/postcss7-compat @tailwindcss/postcss7-compat postcss@^7 autoprefixer@^9
npm install && npm run dev
```
Blade Component
-----------------
https://laravel.com/docs/8.x/blade#components
```
php artisan make:component ComponentName

```
##### Refernces
https://laravel.com/docs/8.x/mix#tailwindcss
https://tailwindcss.com/docs/guides/laravel
