Installation Instructions | Assuming Laravel 7.x and MYSQL are pre-installed in your machine.

1. Open terminal and git clone the project in any folder of your computer
	https://github.com/xeevan/DemoProject.git
2. Create a database named 'laravel_demo' in your MYSQL database
3. Navigate to recently cloned project directory from terminal and migrate the migrations 		with following command in your terminal:
	php artisan migrate
4. Run following command to create a default admin account 'admin@admin.com' and password 		'12345678'. Use these credentials to login as admin.
	php artisan db:seed
5. Now run the project with following command:
	php artisan serve
