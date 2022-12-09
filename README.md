
# Support Ticket

A web app for creating support tickets.

## Features

- Login/register user functionality
- Users can create support tickets
- Admins can assign tickets to agents
- Agents work on tickets assigned to them

## Screenshots
![admin_dashboard](https://user-images.githubusercontent.com/3273498/206614132-9891127b-070d-4905-a79a-de4fb25d18e9.png)
![create_ticket](https://user-images.githubusercontent.com/3273498/206616433-b899c2f3-a8f1-4a42-b0dd-3a80dd709e11.png)

## Tech Stack

**Front-end framework:** TailwindCSS

**Back-end framework:** Laravel

## Installation

First, install backend dependencies

```bash
  composer install
```
Generate an .env file and edit it with your own database details

```bash
  cp .env.example .env
```
Then generate keys

```bash
  php artisan key:generate
```
Install frontend dependencies 

```bash
  npm install && npm run dev
```

Run migration code to setup database schema with seeders

```bash
  php artisan migrate --seed
```

You can register as a regular user or login as admin to manage data with the following default credentials 

```bash
  username: admin@admin.com
  password: password
```
