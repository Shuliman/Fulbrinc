# Fulbrinc

Fulbrinc is a web application that allows you to easily manage your bookmarks. 

**[Attention] backend is ahead of frontend, use postman or other API test applications to get full functionality!**
Postman collection for interaction with API's: [![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/25079131-e590e6fd-fb7c-404b-9d23-46d4672e3b48?action=collection%2Ffork&source=rip_markdown&collection-url=entityId%3D25079131-e590e6fd-fb7c-404b-9d23-46d4672e3b48%26entityType%3Dcollection%26workspaceId%3D8d39c6dc-d36a-40ea-99a7-87500b63b806)

## Install Guide 
git clone https://github.com/Shuliman/Fulbrinc.git

### Back-end:
1. install php and composer
2. run `composer update`
3. create `.env` file using `.env.example`
4. configure your DB (create `laravel` and `laravel_test` DB's)
5. install DB drivers
6. make migrations:`php artisan migrate`
7. **[Attention]After ever migration re-install passport!**:`php artisan passport:install`	
8. generate the keys:
`php artisan passport:keys`
`php artisan passport:client --personal`
### Front-End:
1. run `npm i`
2. `npm serve`
3. Change const API_URL
