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




Post an address to the Web service

3. Method: POST  URL: http://52.25.60.112/addressapi/v1/address/

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




Update an address on the Web service

4. Method: PUT   URL http://52.25.60.112/addressapi/v1/address/2

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





Delete an address on the Web service

5. Method DELETE    URL  http://52.25.60.112/addressapi/v1/address/35

Result.
{
    "success": "Address ID 35 deleted successfully "
}