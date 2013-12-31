<h1>CheckDC Spool Data</h1>

## About Spool Data
Fetch data from hackernews api by running every 12 hours

## How to run it
1. Clone the project
2. Setup your env with the project name, app key, and db name
3. Migrate the database
4. Run php artisan schedule:run and wait every 12 hours, thereafter you'll see hackernews data in your database.
5. Enjoy the app.
