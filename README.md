# Incident Api

## Used Tools:
- Slim version : 3.1
- ORM version and details : Eloquent version 5.1.16
- Unit Test version  : 7
- JWT version : 5.0
- guzzle version  : 6.0


## What is Slim : 
- Slim is a PHP micro framework that helps you quickly write simple yet powerful web applications and APIs.


## Installation Process:
1. Clone the whole project to your local system.
2. Open the cmd inside the root folder and run the bellow command.
    $ composer update
3. Create the database in your local system from the given basic_sql.
4. Change the DB settings inside the api/config/settings.php file.

## Functionality:
- I am using Jwt for the validation process of the apis. If we will hit the apis with no token then it will show token missmatch error. So to run the api we need to generate the jwt token first, with the credentials (email => admin@gmail.com, password => password).

## Process: 
1. Create the jwt token with the credentials. Need to pass the  token in header for other apis to work.
2. Bellow are the three end points that are there in the project along with the unit tests:
	- http://localhost/api/incident/categories (GET) {It will fetch all the categories of the incident}
	- http://localhost/api/incident (GET) {It will fetch all the incidents}
	- http://localhost/api/incident (POST) {It will save an incident to the application}
	- For unit testing need to run 'vendor/bin/phpunit' in the command inside app.
	
## Folder Structure:
1. Inside app folder there are three folders:
	- Helpers: It contains a helper.php file. It contains the common methods which are accessable throug out the Modules.
	- Middlewares: It contains a ValidateJWTToken.php which is responsible for generating the jwt token.
	- Modules: It contain Modules. Here I am having a single module so there is a single folder named Incident. Inside Incidents Module Controller, Models and Routes folders along with one index.php file are there.
		- index.php file initialize the module into the application.
		- Routes folder contain route.php file where the routes are stated.
		- Models folder contains the model files.
		- Controller folder contain the Controller files.
2. Inside config folder there are six files:
	- database.php file contain the database details. We can change the database details here.
	- settings.php We can change the jwt validation here from true to false to disable jwt.
3. Inside Tests Folder I am performing few unit tests.
	- Inside IncidentTest.php file I am writing 3 tests where 10 assertions are there and one failure is there along with 9 success.
	
## Tree Structure:

