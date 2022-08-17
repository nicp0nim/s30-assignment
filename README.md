## Install instructions

To install app, simply clone repository and cd into directory. After that run commands below.
```bash
$ composer install
$ ./vendor/bin/sail up
$ ./vendor/bin/sail artisan migrate
```

If you want to seed database with dummy data run as below.
```
$ ./vendor/bin/sail db:seed
```

## API Routes
### Login user with givencredentials
```bash
curl --request POST \
  --url http://127.0.0.1/api/auth/login \
  --header 'Content-Type: application/json' \
  --data '{
	"email": "{{LOGIN_HERE}}",
	"password": "{{PASSWORD_HERE}}"
}'
```
### Logout current user session
```bash
curl --request POST \
  --url http://127.0.0.1/api/auth/logout \
  --header 'Authorization: Bearer {{TOKEN_HERE}}'
```
### Get users list with pagination and search filters
```bash
curl --request GET \
  --url 'http://127.0.0.1/api/users?per_page=5&search=Subscriber' \
  --header 'Authorization: Bearer {{TOKEN_HERE}}'
```
### Create new user
```bash
curl --request POST \
  --url http://127.0.0.1/api/users \
  --header 'Authorization: Bearer {{TOKEN_HERE}}' \
  --header 'Content-Type: application/json' \
  --data '{
	"name": "John Doe",
	"email": "johndoe@mail.com",
	"password": "Secret!password0",
	"password_confirmation": "Secret!password0",
	"roles": [1,3]
}'
```
### Get specified user
```bash
curl --request GET \
  --url http://127.0.0.1/api/users/15 \
  --header 'Authorization: Bearer {{TOKEN_HERE}}'
```
### Update specified user
```bash
curl --request PUT \
  --url http://127.0.0.1/api/users/13 \
  --header 'Authorization: Bearer {{TOKEN_HERE}}' \
  --header 'Content-Type: application/json' \
  --data '{
	"name": "John Does",
	"email": "johndoes@mail.com",
	"password": "newSecret!password0",
	"password_confirmation": "newSecret!password0",
	"roles": [2,4]
}'
```
### Delete specified user
```bash
curl --request DELETE \
  --url http://127.0.0.1/api/users/10 \
  --header 'Authorization: Bearer {{TOKEN_HERE}}'
```