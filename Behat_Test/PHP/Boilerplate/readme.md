# Requirements
To run this project you will need a computer with PHP and composer installed.

# Install
To install the project, you just have to run `composer install` to get all the dependencies

# Running the tests
After installing the dependencies you can run the tests with this command `./vendor/bin/behat`.
The result should look like this :
![behat.png](behat.png)

# Command Line CLI and DataBase
Before using the command line CLI you gonna need to import the database. The SQL File : `Behat_Test\PHP\Boilerplate\Behat_Test.sql`
For configure the connection in the DataBase you need to fill the correct variable inside `Behat_Test\PHP\Boilerplate\src\db_connection.php`

After this you can run the following command :
```shell
php Application.php ./fleet_create <FleetId>
php Application.php ./fleet_register_vehicle <FleetId> <PlateNumber>
php Application.php ./fleet_park_vehicle <FleetId> <PlateNumber> <latitude> <longitude>
php Application.php ./fleet_localize_vehicle <FleetId> <PlateNumber>
```