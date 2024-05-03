# PHP-MVC-STABLE-VERSION

This is a simple PHP MVC framework using PDO for database interaction.

## Project Structure

- `app/` - Contains the core files, controllers, models, and views.

    - `Controllers/` - Contains the controller files. Each controller corresponds to a specific route.

    - `Core/` - Contains the core files of the application.

        - `App.php` - Handles the application logic, including loading controllers and methods based on the URL.
        - `Config.php` - Contains the application configuration, including database credentials.
        - `Controller.php` - Base controller class.
        - `Database.php` - Handles database connection and operations.
        - `Functions.php` - Contains utility functions used across the application.
        - `init.php` - Initializes the application by loading the necessary files and starting the application.
        - `Model.php` - Base model class.

    - `Models/` - Contains the model files. Each model corresponds to a specific database table.

    - `Views/` - Contains the view files. Each view corresponds to a specific page or component on the website.

- `public/` - Contains the public-facing files, including the entry point of the application (`index.php`), assets, and scripts.

- `README.md` - This file, which contains documentation about the project.

- `PHP-PDO.code-workspace` - The Visual Studio Code workspace file for this project.

- `.gitignore` - Specifies which files and directories to ignore in Git version control.

## Running the Project

To run the project, navigate to the `public/` directory and start a PHP server:


`php -S localhost:8000 or by using XAMPP`

## Downloading Dependencies

After cloning the project from GitHub, you will need to download the necessary dependencies. This project uses npm for package management.

1. Open a terminal in the projdct public directory.
2. Run the following command to install the project's dependencies:
`npm install`
