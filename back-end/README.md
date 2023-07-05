## Database Seeding

The Fulbrinc use Laravel's seeding mechanism to populate the database with an initial admin user. You can run the seeder with the following command:

`php artisan db:seed`
This will create an admin user with the following credentials:

* Email: admin@mail.com
* Password: admin123

Please change these credentials immediately after installation in a production environment.
