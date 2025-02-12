<p align="center"><h2>Step by step instructions for Execution & Deployment</h2></p>

## 1. System Requirements

Before running the application, ensure you have the following installed:
- PHP 8.1+
- Laravel 10+

## 2. Clone the Project

<div class="highlight highlight-source-shell notranslate position-relative overflow-auto" dir="auto" data-snippet-clipboard-copy-content="git clone https://github.com/manon-jayakumar/bike-service.git\ncd bike-service">
    <pre>git clone https://github.com/manon-jayakumar/bike-service.git
cd bike-service</pre>
</div>

## 3. Install Dependencies

Run the following command to install PHP Dependencies:

<div class="highlight highlight-source-shell notranslate position-relative overflow-auto" dir="auto" data-snippet-clipboard-copy-content="composer install\nnpm install\nnpm run dev">
    <pre>composer install
npm install
npm run dev</pre>
</div>

## 4. Set Up Environment Variables

Rename .env.example to .env

<div class="highlight highlight-source-shell notranslate position-relative overflow-auto" dir="auto" data-snippet-clipboard-copy-content="cp .env.example .env">
    <pre>cp .env.example .env</pre>
</div>

Then update the .env file with your database and mail settings

## 5. Generate Application Key

<div class="highlight highlight-source-shell notranslate position-relative overflow-auto" dir="auto" data-snippet-clipboard-copy-content="php artisan key:generate">
    <pre>php artisan key:generate</pre>
</div>

## 6. Set Up the Database

<div class="highlight highlight-source-shell notranslate position-relative overflow-auto" dir="auto" data-snippet-clipboard-copy-content="php artisan migrate --seed\nphp artisan db:seed --class=SuperAdminSeeder">
    <pre>php artisan migrate --seed
php artisan db:seed --class=SuperAdminSeeder</pre>
</div>

## 7. Run the Application

<div class="highlight highlight-source-shell notranslate position-relative overflow-auto" dir="auto" data-snippet-clipboard-copy-content="php artisan serve">
    <pre>php artisan serve</pre>
</div>
