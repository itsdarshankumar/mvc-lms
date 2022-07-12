# LMS

This is the repository for my submission of MVC assignment

## About

MVC-LMS is a Library Management website on MVC Architecture. The web based app is built using ToroPHP, Twig and MySql.

## How to start?

- Clone the repository to your local system using `git clone -b` along with branch name and SSH Key.
- Install composer using:
    ```console
    > curl -s https://getcomposer.org/installer | php
    > sudo mv composer.phar /usr/local/bin/composer
    ```
- Install dependencies and dump-autoload:
    ```console
    > composer install
    > composer dump-autoload
    ```
- Copy `config/sample.config.php` as `config/config.php` and edit it accordingly:
    ```console
    > cp config/sample.config.php config/config.php
    # Edit the file using your mysql database credentials
    ```
- Import schema present in `schema/schema.sql` in your database using:
    ```console
    > mysql -u root -p [DB_NAME] < C:\Users\user_name\Downloads\schema.sql
    ```
- Serve the public folder at any port (say 8000):
    ```console
	> cd public
    > php -S localhost:8000
    ```

## Author

[Darshan Kumar](https://github.com/itsdarshankumar)
