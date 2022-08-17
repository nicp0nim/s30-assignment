## Instructions
Application is JSON API. All requirements was ment, with few more features.
- Authentication
- Unit and feature tests
- Database seeding
- Role middleware to access Users controller
- Pagination, Filtering and Order
### Setup
To install app, simply clone repository and cd into directory. After that run commands below.
```bash
$ composer install
$ cp .env.example .env
$ ./vendor/bin/sail up -d
$ ./vendor/bin/sail key:generate
$ ./vendor/bin/sail artisan migrate
```
### Database seeder
If you want to seed database with dummy data run as below.
```
$ ./vendor/bin/sail db:seed
```
### Unit and feature tests
To run application automated tests run command. Tests will check if authentication works good and also if user could check users list without role id 1.
```
$ ./vendor/bin/sail artisan test
```
## API Routes
### Login user with givencredentials
In login route you need to pass login credentials as below (email with valid password). If user is logged in successfully in response you will get access token which is needed in all routes below.
```bash
curl --request POST \
  --url http://127.0.0.1/api/auth/login \
  --header 'Content-Type: application/json' \
  --data '{
	"email": "test@example.com",
	"password": "Secret!password0"
}'
```
Success response
```json
{
	"success": true,
	"message": "User login successfully.",
	"data": {
		"token": "1|sbdUqy2QW1r1r8bzVXAV4ijMiDTuptxgNVkFYFJP",
		"name": "Test User"
	}
}
```
Failure response
```json
{
	"success": false,
	"message": "Unauthorised.",
	"errors": {
		"email": "Credentials does not match."
	}
}
```
||==========================================================================||
||==========================================================================||
### Logout current user session
```bash
curl --request POST \
  --url http://127.0.0.1/api/auth/logout \
  --header 'Authorization: Bearer {{TOKEN_HERE}}'
```
Success response
```json
{
	"success": true,
	"message": "User has been logged out.",
	"data": []
}
```
||==========================================================================||
||==========================================================================||
### Get users list with pagination and search filters
Users list route provides pagination and search filters which should be given as get parameters like below in curl example. Parameters are as below:
```php
page = integer,
per_page = integer,
search = string,
sortField = ['email', 'name'],
sortOrder = ['asc','desc']
```

```bash
curl --request GET \
  --url 'http://127.0.0.1/api/users?per_page=5&search=Subscriber' \
  --header 'Authorization: Bearer {{TOKEN_HERE}}'
```
Response example
```json
{
	"success": true,
	"message": "Users retrieved successfully.",
	"data": {
		"resource": [
			{
				"id": 11,
				"name": "Moshe Hoppe",
				"email": "eloise20@example.com",
				"roles": [
					{
						"id": 4,
						"name": "Subscriber"
					}
				]
			}
		],
		"meta": {
			"current_page": 3,
			"per_page": 5,
			"total": 11,
			"last_page": 3,
			"next_page": null,
			"previous_page": "http:\/\/127.0.0.1\/api\/users?page=2"
		}
	}
}
```
||==========================================================================||
||==========================================================================||
### Create new user
User create route has validation that needs to pass. Validation rules are as below:


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
Success response
```json
{
	"success": true,
	"message": "User created successfully.",
	"data": {
		"id": 12,
		"name": "John Doe",
		"email": "johndoe@mail.com",
		"roles": [
			{
				"id": 1,
				"name": "Administrator"
			},
			{
				"id": 3,
				"name": "Editor"
			}
		]
	}
}
```
Validation error example response
```json
{
	"message": "The email has already been taken. (and 2 more errors)",
	"errors": {
		"email": [
			"The email has already been taken."
		],
		"name": [
			"The name must only contain letters."
		],
		"roles.2": [
			"The roles.2 must be an integer."
		]
	}
}
```
||==========================================================================||
||==========================================================================||
### Get specified user
```bash
curl --request GET \
  --url http://127.0.0.1/api/users/15 \
  --header 'Authorization: Bearer {{TOKEN_HERE}}'
```
Success response
```json
{
	"success": true,
	"message": "User retrieved successfully.",
	"data": {
		"id": 1,
		"name": "Test User",
		"email": "test@example.com",
		"roles": [
			{
				"id": 1,
				"name": "Administrator"
			}
		]
	}
}
```
User not found
```json
{
	"success": false,
	"message": "User not found."
}
```
||==========================================================================||
||==========================================================================||
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
Success response
```json
{
	"success": true,
	"message": "User updated successfully.",
	"data": {
		"id": 2,
		"name": "John Doess",
		"email": "johndoess@mail.com",
		"roles": [
			{
				"id": 2,
				"name": "Author"
			},
			{
				"id": 4,
				"name": "Subscriber"
			}
		]
	}
}
```
||==========================================================================||
||==========================================================================||
### Delete specified user
```bash
curl --request DELETE \
  --url http://127.0.0.1/api/users/10 \
  --header 'Authorization: Bearer {{TOKEN_HERE}}'
```
Success response
```json
{
	"success": true,
	"message": "User deleted successfully.",
	"data": []
}
```