# Incident Api

# Used Tools:
- Slim version : 3.1
- ORM version and details : Eloquent version 5.1.16
- Unit Test version  : 7
- JWT version : 5.0
- guzzle version  : 6.0


# What is Slim : 
- Slim is a PHP micro framework that helps you quickly write simple yet powerful web applications and APIs.


# Installation Process:
1. Clone the whole project to your local system.
2. Open the cmd inside the root folder and run the bellow command.
    $ composer update
3. Create the database in your local system from the given basic_sql.
4. Change the DB settings inside the api/config/settings.php file.

# Functionality:
- I am using Jwt for the validation process of the apis. If we will hit the apis with no token then it will show token missmatch error. So to run the api we need to generate the jwt token first, with the credentials (email => admin@gmail.com, password => password).

# Process: 
1. Create the jwt token with the credentials. Need to pass the  token in header for other apis to work.
2. Bellow are the three end points that are there in the project:
	- localhost/api/incident/categories (GET) {It will fetch all the categories of the incident}
	- localhost/api/incident (GET) {It will fetch all the incidents}
	- localhost/api/incident (POST) {It will save an incident to the application}
