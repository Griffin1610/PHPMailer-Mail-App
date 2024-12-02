# PHPMailer-Mail-App
A PHP-based web application that allows users to send emails securely using PHPMailer. It includes a login system with user authentication and stores user data in a MySQL database. After logging in, users can compose and send emails through a simple interface. Built for efficient and secure email management.

Installation and Setup

  PHPMailer installation
  
    1. Install Composer on system
    
      - composer require phpmailer/phpmailer (terminal command)
      - Vendor foldor and autoload.php file are now created.
      
    2. Modify php.ini file
    
       - Modify the'[Mail Function]' in php.ini file, by changing the username and password to your google email and password.

  User-Registration.php setup
  
    -user must have access to database to run program. This must be imported in PHPMyAdmin through the XAMMP local host server. ensure you are logged       in as the root user. Denoted by a comment on Line 5 of User-Registration.php.

  User-Dashboard.php setup
  
    - change username and password value in user-dashboard.php (Line 64-65). The username must be your email and the password must be a user created       16 digit app password key from google.
    
  download zip file and database file to run program
    
