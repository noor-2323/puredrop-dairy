# PureDrop Dairy

A responsive landing page for PureDrop Dairy, developed as a Laravel 10 project.

## Features

- Responsive navigation header
- Hero section with a call-to-action button
- About PureDrop Dairy section
- Contact form with name, email, and message fields
- Server-side validation using Laravel
- Success message after successful form submission
- Responsive design for desktop and mobile screens

## Technologies Used

- Laravel 10
- PHP
- HTML5
- CSS3

## Project Structure

- `resources/views/home.blade.php` — Landing page layout
- `public/css/app.css` — Custom styling and responsive design
- `routes/web.php` — Home page and contact form routes

## Requirements

- PHP
- Composer

## Installation

1. Clone or download the repository.
2. Open a terminal in the project directory.
3. Install dependencies:

   ```bash
   composer install
   ```

4. Create your environment file:

   ```bash
   copy .env.example .env
   ```

5. Generate the application key:

   ```bash
   php artisan key:generate
   ```

6. Start the Laravel development server:

   ```bash
   php artisan serve
   ```

7. Open `http://127.0.0.1:8000` in your browser.

## Contact Form

The contact form accepts a name, email address, and message. Laravel validates the submitted information and displays a confirmation message after successful submission.

## Purpose

This project demonstrates a responsive business landing page built with Laravel and custom CSS.
## Accessibility

- Keyboard users can navigate links, buttons, and form fields with visible focus indicators.
- Form fields should have clear labels and validation feedback.
- Responsive styling helps users access the page on different screen sizes.