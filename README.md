
# My TodoList

It's a Simple Todo App. In which I tried to Follow MVCS design Pattern and SOLID Principle.


## Requirements

Make sure you have the following software installed on your machine:

`PHP (>= 8.1)`

`Composer`

`MySQL`
## Installation

To get started with the project, follow these steps:

Clone the project

```bash
git clone https://github.com/Nasif19/TodoList.git
```

Go to the project directory

```bash
cd TodoList
```

Install dependencies

```bash
composer install

nmp install
  
npm run dev
```


## Environment Configuration

Copy the .env.example file to create a new .env file:

```bash
cp .env.example .env
```
Generate the application key:

```bash
php artisan key:generate
```

Open the .env file and configure the database connection settings according to your MySQL setup:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```
## Database Migration
Run the following command to create the necessary database tables:
```bash
php artisan migrate
```
## Serve the Application

You can use Laravel's built-in server to run the application locally. Run the following command:

```bash
php artisan serve
```
The application will be available at http://localhost:8000.
## How To Use This App

From Welcome Page, Go to Register Form and create an account.

Than You will be eligible to Manage your todos and the tasks.

you can create multiple todo and tasks.
For edit just click on the text and change as you wish.
