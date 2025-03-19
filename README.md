# WebShop
A functional online store with all operations (input, output, registration, and deletions).

![2024-11-23_15h41_31](https://github.com/user-attachments/assets/347dac79-14c5-45fe-9ee4-ac9272f5c277)

## Database Model
![Banco_Empresa](https://github.com/user-attachments/assets/793efae7-0281-451c-a8cb-3fc500f3345e)

## Environment Setup
This program is built using a microservices-oriented approach, so some environment configurations are necessary to use the tool.

### Required Programs
1. **PHP** must be installed on the machine and properly set in the environment variables so it can be used via the command line. It is recommended to install **XAMPP** ([link](https://www.apachefriends.org/pt_br/index.html)).
2. **Composer** needs to be installed. Composer is PHP’s package manager, but it does not come by default with PHP installation. [Download tutorial](https://getcomposer.org/download/).
3. **Node.js** must be installed, along with **NPM**, which is Node's package manager (NPM is included by default with Node). [Download link](https://nodejs.org/pt/download/package-manager).
4. **PGAdmin**: Although the user can choose any database, this project was built using **PostgreSQL**, which is recommended. PGAdmin is the interface used to manage PostgreSQL databases. [Download link](https://www.pgadmin.org/download/).

### Database Configuration
1. Open **PGAdmin** and create a new database.
2. Locate the `.env.example` file, make a copy of it, and remove the `.example` extension from the filename.
3. Open the `.env` file and set the database access credentials according to the database created in PGAdmin:
   ```
   # Example configuration
   DB_CONNECTION=pgsql
   DB_HOST=localhost
   DB_PORT=5432
   DB_DATABASE="DATABASE_NAME"
   DB_USERNAME=postgres
   DB_PASSWORD=123
   ```
4. Open **CMD** in the "server" folder and run the following command:
   ```
   php artisan migrate
   ```
   **⚠️ If you encounter the error** `"could not find driver (Connection: pgsql, SQL: select * from information_schema.tables...)"`, open the `php.ini` file (located in the PHP installation folder), search for `;extension=pdo_pgsql`, remove the semicolon (`;`), and then rerun the migration command:
   ```
   php artisan migrate
   ```
5. The project includes a file named `PopulaBanco.sql`, which contains SQL commands to populate the database.

The program was built using PostgreSQL as the DBMS, but it is possible to use other databases.

### Server-Side Configuration
1. Open **CMD** in the root folder of the project and run:
   ```
   composer update
   ```
2. After installing all dependencies, generate the application key:
   ```
   php artisan key:generate
   ```
3. Start the server by running:
   ```
   php artisan serve
   ```
4. In the `.env` file, there is a setting called `APP_URL`, which must match the server's actual running URL. If the server starts at `127.0.0.1`, try accessing it via `localhost` in the browser.

### Client-Side Configuration
1. In the "client" folder, open **CMD** and run:
   ```
   npm install
   ```
2. Inside `resources\js\Pages\Assets\`, there is a file named **`apiconfig.js`**, which centralizes all API routes. If the project runs on a different route than `http://localhost:8000/`, update the `BASE_URL` variable accordingly:
   ```
   export const BASE_URL = 'http://localhost:8000'
   ```
3. After all installations, build the project with:
   ```
   npm run build
   ```

## Tech Stack
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)]()
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)]()
[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)]()
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white)]()
[![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vue.js&logoColor=4FC08D)]()

<center>
<img align="right" src="http://ForTheBadge.com/images/badges/built-with-love.svg" alt="visitor_badge">
</center>

