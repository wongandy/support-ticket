
# Support Ticket

A web app for creating support tickets.

## Screenshots
![admin_dashboard](https://user-images.githubusercontent.com/3273498/206614132-9891127b-070d-4905-a79a-de4fb25d18e9.png)
![create_ticket](https://user-images.githubusercontent.com/3273498/206614141-4c5d156a-cdae-4eae-98e4-111737e803ac.png)

## Features

- Login/register user functionality
- Users can create support tickets
- Admins can assign tickets to agents
- Agents work on tickets assigned to them

## Tech Stack

**Front-end framework:** TailwindCSS

**Back-end framework:** Laravel
![DB__transaction](https://user-images.githubusercontent.com/3273498/206613371-97f54e4f-9732-44ee-9c30-c0b6277b917b.jpg)

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
