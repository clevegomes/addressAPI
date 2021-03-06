<?php
/**
 * Created by PhpStorm.
 * User: Cleve
 */

namespace Http\Controllers;


use Models\AddressModel;
/**
 * This is the Controller that will manage all request made for address endpoint
 * Class AddressModel
 * @package Models
 */
class AddressController implements BaseController {

    /**
     * Method responsible to List all or 1 item from the storage system
     * @param $request  ,id of the item to be fetched from the DB ,if not set every thing will be sent back
     * @return mixed  ,array containing the selected item
     */
    function index($request)
    {

	    $addressid = NULL;

	    if(isset($request["args"][0]))
	    {

		    if(!is_numeric($request["args"][0]))
		        throw new \Exception("Invalid Address ID");
		    $addressid = $request["args"][0];
	    }





	    $addressObj = new AddressModel();
	    $listOfAddress = $addressObj->getAllAddress($addressid);




	    if($listOfAddress == false)
		    throw new \Exception("Address not found");

	    return $listOfAddress;

    }

    /**
     * Method is responsible to store the posted item details to the storage system.
     * @param $request ,array of item data to be stored
     * @return mixed ,  status
     */
    function store($request)
    {

	    $args = [];
	    //Validation
	    if(isset($request["LABEL"]) && isset($request['STREET']) && isset($request["HOUSENUMBER"]) &&
		    isset($request["POSTALCODE"]) && isset($request["CITY"]) && isset($request["COUNTRY"]))
	    {
		    $args["LABEL"] = $request["LABEL"];
		    $args["STREET"] = $request["STREET"];
		    $args["HOUSENUMBER"] = $request["HOUSENUMBER"];
		    $args["POSTALCODE"] = $request["POSTALCODE"];
		    $args["CITY"] = $request["CITY"];
		    $args["COUNTRY"] = $request["COUNTRY"];

	    }
	    else
	    {
		    throw new \Exception("Invalid Post Parameters");
	    }


	    $addressObj = new AddressModel();
	    $status = $addressObj->storeAddress($args);
	    if($status == false)
	        throw new \Exception("Internal Error");
        return "Address ID is ".$status;

    }

    /**
     * Method responsible to update a given item data to the storage system
     * @param $request ,array of item data  with the item id to be updated
     * @return mixed , status
     */
    function update($request)
    {

	    if(!isset($request["args"][0]) || !is_numeric($request["args"][0]))
	    {
		    throw new \Exception("Invalid Address ID");
	    }
	    $args["ADDRESSID"] = $request["args"][0];




            if(isset($request["LABEL"]))
		    $args["LABEL"] = $request["LABEL"];

            if(isset($request['STREET']))
		    $args["STREET"] = $request["STREET"];

            if(isset($request['HOUSENUMBER']))
		    $args["HOUSENUMBER"] = $request["HOUSENUMBER"];


            if(isset($request['POSTALCODE']))
		    $args["POSTALCODE"] = $request["POSTALCODE"];

            if(isset($request['CITY']))
		    $args["CITY"] = $request["CITY"];

             if(isset($request['COUNTRY']))
		    $args["COUNTRY"] = $request["COUNTRY"];



	    $addressObj = new AddressModel();
	    $status = $addressObj->updateAddress($args);

	    if($status == false)
		    throw new \Exception("Could not update");


	    return "Address ID  ".$args["ADDRESSID"]." has been updated successfully ";

    }

    /**
     *  Method responsible to delete  item from the storage system
     * @param $request ,item id that is to be deleted
     * @return mixed , status
     */
    function  destroy($request)
    {
	    $addressid = NULL;

	    if(isset($request["args"][0]))
	    {

		    if(!is_numeric($request["args"][0]))
			    throw new \Exception("Invalid Address ID");
		    $addressid = $request["args"][0];


            /**
             * Checking if the address is not deleted
             */
            $this->index($request);


		    $addressObj = new AddressModel();
		   if(!$addressObj->destroyAddress($addressid))
			   throw new \Exception("Address Could not be deleted");


		    return "Address ID ".$addressid." deleted successfully ";
	    }
    }
}