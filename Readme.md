REST Addresses
==============

This is a small RESTfull web service that will allow a user to store ,update ,retrieve and delete physical addresses.

1. The application will accept data in JSON format and return data in JSON format.

2. The application is tested on a Ubuntu Linux server having PHP 5.5.9 ,mysql version 14.14

3 .Requirements : .htaccess must be enabled to rewrite the urls ,correct permissions to the error.log



Test cases.
----------

The REST webservice is deployed on a AWS server and can be accessed using
http://52.25.60.112/addressapi/v1/address/

1.Get all addresses

 method :GET URL: http://52.25.60.112/addressapi/v1/address/

Result .

    {
    "success": [
        {
            "ADDRESSID": "1",
            "LABEL": "test",
            "STREET": "test",
            "HOUSENUMBER": "test",
            "POSTALCODE": "test",
            "CITY": "test",
            "COUNTRY": "test"
        },
        {
            "ADDRESSID": "4",
            "LABEL": "test",
            "STREET": "test",
            "HOUSENUMBER": "test",
            "POSTALCODE": "test",
            "CITY": "test",
            "COUNTRY": "test"
        },
        {
            "ADDRESSID": "5",
            "LABEL": "test",
            "STREET": "test",
            "HOUSENUMBER": "test",
            "POSTALCODE": "test",
            "CITY": "test",
            "COUNTRY": "test"
        }

        ]
    }




2.Get a particular address

Method: GET   URL: http://52.25.60.112/addressapi/v1/address/1

Result.

    {
         success": [
            {
                "ADDRESSID": "1",
                "LABEL": "test",
                "STREET": "test",
                "HOUSENUMBER": "test",
                "POSTALCODE": "test",
                "CITY": "test",
                "COUNTRY": "test"
            }
            ]
    }



3.Post an address to the Web service

Method: POST  URL: http://52.25.60.112/addressapi/v1/address/

    DATA:  {"LABEL":"SIT Towers",
            "STREET": "Sheikh Mohammed Bin Zayed Road",
            "HOUSENUMBER": "2410",
            "POSTALCODE": "18234",
            "CITY": "Silicon Oasis",
            "COUNTRY": "UAE"

           }


Result.

    {
        "success": "Address ID is 35"
    }




4.Update an address on the Web service

Method: PUT   URL http://52.25.60.112/addressapi/v1/address/2

    DATA:  {"LABEL":"SIT Towers",
            "STREET": "Sheikh Mohammed Bin Zayed Road",
            "HOUSENUMBER": "2410",
            "POSTALCODE": "18234",
            "CITY": "Silicon Oasis",
            "COUNTRY": "UAE"

           }

Result.

    {
        "success": "Address ID  2 has been updated successfully "
    }



5.Delete an address on the Web service

Method: DELETE    URL  http://52.25.60.112/addressapi/v1/address/35

Result.

    {
        "success": "Address ID 35 deleted successfully "
    }



  API Architecture
  ----------------

In Brief:

1. .htaccess rewrites the URL and points it to the index page. htaccess is also responsible to pass errors to a error log file

2. Index page. It activates the auto loader , gz encoder ,disables error messages to the display and creates the RESTKernal and passes the request to it

3. RESTKernal  processes the request data and calls the correct controller depending on the endpoint .

4. AddressController : For an end point "address" the AddressController will be called (This is the naming convention used for the controllers).
 The controller methods index,store,update,delete are called based on HTTP methods GET,POST,PUT,DELETE

5. AddressModel: Model is responsible to handle all database operations. AddressModel will handle all DB operations on the ADDRESS table.


Details Description
-------------------

The details description about the API can be found here http://52.25.60.112/addressapi/docs/api/index.html


Advantages of this REST API Architecture
-----------------------------------------

1. Adding a new endpoint is very easy. Just create a controller with the endpoint name by implementing the Controller Interface (endpoint : address ,Controller : AddressController).You will get all the required methods (index,store,update,delete).Write your code in these methods.

2. All DB operations are done in the models. Therefor in future if there is requirement to change the Database .Just change the Models.Controllers and your business logic wont be effected.

3. All success messages and error messages are processed and handled by the RESTKernel. RESTKernel will put the correct header message based on the message type (200,201,400 etc).

4. If you want to return an error message .Just throw an exception with the custom error message. The RESTKernel will catch this error message and process it  correctly.
