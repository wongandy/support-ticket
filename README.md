
# Support Ticket

A web app for creating support tickets.

## Features

- Login/register user functionality
- Users can create support tickets
- Admins can assign tickets to agents
- Agents work on tickets assigned to them

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
