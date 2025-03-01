# PHP Exercises

This repository contains practice exercises for PHP using XAMPP, and SQL.

## Development Environment Setup

### Installing XAMPP
1. Download XAMPP from [Apache Friends](https://www.apachefriends.org/index.html)
2. Install with default settings, selecting Apache, MySQL, PHP, and phpMyAdmin
3. Launch XAMPP Control Panel and start Apache and MySQL
  - If you encounter port conflicts (common with ports 80, 443, or 3306):
    - Click on "Config" for the service
    - Change the port numbers (e.g., Apache from 80 to 8080)
    - Or close conflicting applications (e.g., Skype, IIS)
4. Verify installation: visit `http://localhost/` and `http://localhost/phpmyadmin/` on browser

### Project Setup
1. Clone or download this repository
2. Place files in `C:\xampp\htdocs\php-exercises\`
3. Create a database called `php-exercises` in phpMyAdmin
4. Import the SQL file from the `database` folder
5. Open the project in code editor

### Testing Your Setup
- Open your browser and navigate to `http://localhost/php-exercises/test-setup.php`
- You should see the PHP configuration information

## Repository Contents

The repository contains five exercises:

1. **User Authentication** 
   - Login system with session management

2. **CRUD Operations** 
   - Create, read, update, and delete tasks

3. **Search Functionality** 
   - Database record searching

4. **Reporting** 
   - Generate and display reports

5. **Complete Practice Exam** 
   - TodoList application combining all features

## How to Run Locally
Run each exercise locally by following these steps.
1. Go to phpMyAdmin
2. Select your database from the left sidebar
3. Click on the "SQL" tab in the top navigation
4. Open `schema.sql` file from an exercise folder in a text editor
5. Copy the entire content of the file & paste it into the SQL query box in phpMyAdmin
6. Click "Go" to execute the SQL commands
7. Open a browser and navigate to an exercise URL, e.g. for exercise 1, go to `http://localhost/php-exercises/exercise1-login`.