<?php
/**
 * Created by PhpStorm.
 * User: Developer1
 */

namespace Models;


/**
 * This is the abstract class that all Models must extend. It has all the methods required for a model to work .
 * In future if i need any methods to
 * help me with pulling data from other tables based on relation ship or so on I will put them here.
 * Class BaseModel
 * @package Models
 */
abstract class BaseModel {


	protected $conection;
	public function __construct()
	{

        /**
         *  Getting the datable configuration details
         */
        $configobj = new \Config();
		$this->connectDatabase($configobj);
	}

    /**
     * Connecting to the db
     * @param \Config $configobj
     * @throws \Exception
     */
    protected function connectDatabase(\Config $configobj)
	{


		$this->conection = new \mysqli( $configobj->DB_HOST,$configobj->DB_USERNAME,$configobj->DB_PASSWORD);
		if (mysqli_connect_errno()) {
			throw new \Exception("Error in Connection");
		}

		$this->conection->select_db($configobj->DB_DATABASE);

	}


    /**
     * Closing the connection
     */
    protected function closeConnection()
	{
		$this->conection->close();
	}


}