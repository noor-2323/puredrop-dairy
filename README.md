# PureDrop Dairy Sales CRM

A Laravel 10-based Customer Relationship Management (CRM) application for managing dairy business leads and contacts.

## Live Application

https://puredrop-dairy.onrender.com

## GitHub Repository

https://github.com/noor-2323/puredrop-dairy

## Technologies Used

- Laravel 10
- PHP 8.3
- MySQL (Aiven)
- HTML5 and CSS3
- Docker
- Render
- Git and GitHub

## Features

- Responsive landing page
- Contact form with server-side validation
- Leads and contacts database tables
- Lead factory and sample-data seeder
- REST API for lead management
- API token authentication
- Lead search by name or email
- Pagination (5 records per page)
- Production database migrations

## Local Installation

### Requirements

- PHP 8.3 or compatible version
- Composer
- MySQL
- Git

### Setup Instructions

1. Clone the repository:

   ```bash
   git clone https://github.com/noor-2323/puredrop-dairy.git
   ```

2. Enter the project folder:

   ```bash
   cd puredrop-dairy
   ```

3. Install dependencies:

   ```bash
   composer install
   ```

4. Create the environment file:

   ```bash
   copy .env.example .env
   ```

5. Create a MySQL database named `puredrop_dairy` and configure the database credentials in `.env`.

6. Generate the application key:

   ```bash
   php artisan key:generate
   ```

7. Run database migrations and seed sample leads:

   ```bash
   php artisan migrate --seed
   ```

8. Start the development server:

   ```bash
   php artisan serve
   ```

9. Open http://127.0.0.1:8000 in your browser.

## Database Structure

The application includes:

- **Leads:** Stores name, email, phone, source, status, and timestamps.
- **Contacts:** Stores contact information and a foreign key relationship to leads.

The LeadFactory and LeadSeeder generate 10 sample leads for local development.

## Production Deployment

The application is deployed on Render using Docker and an Aiven MySQL database.

### Deployment Steps

1. Push the project to GitHub.
2. Create a Render Web Service and connect the repository.
3. Select Docker as the deployment environment.
4. Configure the production environment variables.
5. Deploy the application.

### Environment Variables

Configure these in the Render dashboard:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY`
- `APP_URL`
- `API_TOKEN`
- `DB_CONNECTION=mysql`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `MYSQL_ATTR_SSL_CA=/var/www/html/docker/certs/ca.pem`

Use your own database credentials and secret values. Never publish passwords or API tokens in GitHub or this README.
### Production Database Migrations and Seeding

The Docker startup command automatically runs:

```bash
php artisan migrate --force --seed
```

This performs the following operations before starting the Laravel server:

1. Applies pending migrations to the production database.
2. Runs `DatabaseSeeder`, which calls `LeadSeeder`.
3. Creates 10 sample leads using fixed email addresses.
4. Uses `firstOrCreate()` to prevent duplicate sample leads on subsequent deployments or container restarts.


Production database migrations and seeding are handled automatically during container startup.


## REST API Documentation

All lead-management endpoints require API token authentication.

### Authentication Header

```http
Accept: application/json
X-API-Token: YOUR_API_TOKEN
```

Replace `YOUR_API_TOKEN` with the secret configured in the Render environment variables.

### API Endpoints

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/leads` | Retrieve paginated leads |
| POST | `/api/leads` | Create a new lead |
| PUT | `/api/leads/{id}` | Update a lead |
| DELETE | `/api/leads/{id}` | Delete a lead |

### Retrieve Leads

```bash
curl -H "Accept: application/json" -H "X-API-Token: YOUR_API_TOKEN" https://puredrop-dairy.onrender.com/api/leads
```

### Search Leads

```text
GET /api/leads?search=john
```

Searches leads by name or email.

### Pagination

```text
GET /api/leads?page=2
```

The API returns five records per page.

### Create a Lead

Send a POST request to `/api/leads` with JSON data:

```json
{
  "name": "John Smith",
  "email": "john@example.com",
  "phone": "03001234567",
  "source": "Website",
  "status": "new"
}
```

### Update a Lead

Send a PUT request to `/api/leads/{id}` with the updated JSON fields.

### Delete a Lead

Send a DELETE request to `/api/leads/{id}`.

Include the authentication headers with all API requests.

### API Response

The GET endpoint returns paginated JSON containing:

- `data`: Lead records
- `current_page`: Current page number
- `per_page`: Records per page
- `total`: Total number of leads
- `last_page`: Last available page

Requests without a valid API token are rejected.

## Accessibility

- Keyboard navigation support
- Visible focus indicators
- Clear form labels and validation feedback
- Responsive layouts for desktop and mobile devices

## Purpose

This project demonstrates Laravel development, database design, REST API development, authentication, Docker configuration, and cloud deployment.
