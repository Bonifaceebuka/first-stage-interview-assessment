## Fullstack development Assessment
This application is built with the following technologies:
1. PHP(8.2.18) and Apache/2.4.48
2. Laravel Framework(11.9.2)
3. MYSQL(5.0.12)
4. Composer version 2.6.5 2023-10-06 10:11:5
5. Openserver 6.0.0(8.2.18)

### This is how you can install this application
1. Clone this Repository(Repo) with the following command `git clone https://github.com/Bonifaceebuka/first-stage-interview-assessment.git`
2. Move to the DIR of the Repo `cd first-stage-interview-assessment`
3. Install composer with `composer install`
4. Save .env.example file as .env or run this command: `cp .env.example .env`
5.	Open the .env file and set the Database configurations as follows:<br>
	DB_CONNECTION=mysql<br>
	DB_HOST=127.0.0.1<br>
	DB_PORT=3306<br>
	DB_DATABASE=YOUR_DATABASE_NAME<br>
	DB_USERNAME=YOUR_SERVER_USERNAME<br>
	DB_PASSWORD=YOUR_DATABASE_PASSWORD (Leave it empty if you have none)<br>
6. Generate new Key with this command: `php artisan key:generate`
7. Import the database tables with this command: `php artisan migrate`.
10. Start the application with `php artisan serve`
	Visit localhost:8000/ to see the front-end of the application

## NOTE
1. The base URL for all the request is localhost:8000/api