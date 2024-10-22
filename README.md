# API RESTFUL BLOG 📓

## 📖 Overview
The **API RESTFUL BLOG** is a backend project built with Laravel, designed to manage users, articles, categories, and comments efficiently. This API follows RESTful principles, providing endpoints to perform standard CRUD operations while ensuring secure authentication with JWT (JSON Web Tokens).

## 🛠️ Key Features
- **User Authentication 🔒**: Uses JWT to securely authenticate and authorize users.
- **Article Management ✍️**: Allows users to create, read, update, and delete articles.
- **Category Association 📂**: Articles are organized into categories, which can be managed through their own endpoints.
- **Comment Management 💬**: Users can add, update, and delete comments on articles.
- **Secure Data Handling 🚀**: Implements thorough validation to ensure the integrity of the data.

## 🧰 Technology Stack
- **Laravel 11.24**: PHP framework providing a robust and elegant foundation for web applications.
- **JWT**: Secure authentication using JSON Web Tokens for API access.
- **MySQL**: Database system for storing and managing users, articles, categories, and comments.

## 🗂️ Models and Relationships
- **User 👤**: Represents the registered users. Users can create multiple articles and post comments.
- **Article ✍️**: Represents individual blog posts. Articles are associated with a specific user and category, and can have multiple comments.
- **Category 📚**: Represents the different types of articles.
- **Comment 💬**: Represents user comments on articles, allowing interaction and feedback.

## 🔍 Core Endpoints
- **User Endpoints**: Register, login, and access user details.
- **Article Endpoints**: CRUD operations for creating, reading, updating, and deleting articles.
- **Category Endpoints**: Manage the categories that organize articles.
- **Comment Endpoints**: CRUD operations to manage comments on articles.

## 🚀 Purpose
The **API RESTFUL BLOG** is designed to offer a secure and structured way for developers to build blogging platforms or content management systems. The goal is to provide a clean and organized API backend that adheres to modern development standards.

This project can be easily expanded to include features like tags, advanced user roles, and other related functionalities. It serves as a strong foundation for any content-driven application.

# Installation Guide
To run this Laravel project locally, follow the steps below:

## 📦 Step 1: Clone the Repository
Clone the project repository to your local machine:

    **git clone https://github.com/YoCere/API-RESTFUL-BLOG.git**

    **cd API-RESTFUL-BLOG**

## 🔧 Step 2: Install Dependencies
Make sure you have Composer installed. Then, run the following command to install Laravel dependencies:
composer install

## 📄 Step 3: Create Your .env File
Copy the **.env.example** file to create a new **.env** file:
cp .env.example .env

## ⚙️ Step 4: Configure Your Environment
Open the newly created .env file and set your database credentials and other environment settings. For example:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password

## 🔑 Step 5: Generate the Application Key
Run this command to generate a unique key for your Laravel application:

    php artisan key:generate

## 🗂 Step 6: Run the Migrations
Create your database and run the following command to set up the necessary tables:
    
    php artisan migrate

## 🛠 Step 7: Publish JWT Configurations
Publish the JWT configuration file by running the following command (👀this is very important):

    php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"

## 🔐 Step 8: Generate JWT Secret Key
Generate the JWT secret key that will be used to sign the tokens:
    
    php artisan jwt:secret

## 🚀 Step 9: Start the Development Server
Run the following command to start the local development server:

    php artisan serve
    
## 🌐 Step 10: Access the Project
Open your browser and go to 
    
    http://localhost:8000
to see the project up and running! 🎉
## 👥 Project Contributors
- **Jose Alfredo Cerezo Rios**
- **Veronica Vargas Pavia**

## 🙏 Acknowledgments
We would like to extend our gratitude to **Engineer Elías Cassal Baldiviezo**, who helped us resolve a critical issue during the development of this project. His guidance and support were invaluable.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
