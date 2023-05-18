# fulbrinc

Fulbrinc is a web application that allows you to easily manage your bookmarks. 

## Install Guide 
git clone https://github.com/Shuliman/Fulbrinc.git

### Back-end:
	`install php,composer`

	run `composer update`

	create `.env` file using `.env.example`

	configure your DB
	
	install DB drivers

make migrations:
	`php artisan migrate`
	
generate keys:
	`php artisan passport:keys`
	`php artisan passport:client --personal`
### Front-End:
	run `npm i`
	`npm serve`
	Change const API_URL
