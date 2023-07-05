# Fulbrinc

Fulbrinc is a web application that allows you to easily manage your bookmarks. 

**[Attention] backend is ahead of frontend, use postman or other API test applications to get full functionality!**


## Install Guide 
git clone https://github.com/Shuliman/Fulbrinc.git

### Back-end:
1. `install php,composer`
2. run `composer update`
3. create `.env` file using `.env.example`
4. configure your DB
5. install DB drivers
6. make migrations:`php artisan migrate`
**[Attention]After ever migration re-install passport!**:
`php artisan passport:install`
	
generate keys:
`php artisan passport:keys`
`php artisan passport:client --personal`
### Front-End:
1. run `npm i`
2. `npm serve`
3. Change const API_URL
