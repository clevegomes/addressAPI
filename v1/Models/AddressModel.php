<?php
/**
 * Created by PhpStorm.
 * User: Developer1
 */

namespace Models;

/**
 * This Model is responsible to handle all storage operations for Address table.
 * Class AddressModel
 * @package Models
 */
class AddressModel extends BaseModel{

	public function __construct()
	{
		parent::__construct();

	}


    /**
     * Responsible to handle any  delete operations on address table
     * @param null $addressid
     * @return bool
     */
    public function destroyAddress($addressid = NULL)
	{

		if($this->conection->query("delete from address   where  ADDRESSID  ='$addressid'"))
		{
			return true;
		}

		return false;

	}


    /**
     * Responsible to handle any selection operation on address table
     * @param null $addressid
     * @return array|bool
     */
    public  function getAllAddress($addressid = NULL)
	{

		$sqlWhere = "";

		if($addressid != NULL)
			$sqlWhere = "  where  ADDRESSID = '".$addressid."' ";
		if($result = $this->conection->query(" select ADDRESSID,LABEL,STREET,HOUSENUMBER,POSTALCODE,CITY,COUNTRY from  address ".$sqlWhere))
		{

			$returnArry =[];
			if($result->num_rows >0)
			{
				while($row = $result->fetch_assoc())
				{
					$returnArry[] = $row;
				}
			}
		}
		else
			return false;
		
		
		
		return $returnArry;
		
	}


    /**
     * Responsible to handle any insert operations
     * @param array $args
     * @return bool|int|string
     */
    public function storeAddress($args = [])
	{

		$sql = "insert into address set
		        LABEL = '".$args['LABEL']."',
		        STREET = '".$args['STREET']."',
		        HOUSENUMBER = '".$args['HOUSENUMBER']."',
		        POSTALCODE = '".$args['POSTALCODE']."',
		        CITY = '".$args['CITY']."',
		        COUNTRY = '".$args['COUNTRY']."'
				";

print_r($sql);exit;
		if($result = $this->conection->query($sql))
		{
			 return mysqli_insert_id($this->conection);
		}

		return false;
	}

    /**
     * Responsible to handle any  update operations
     * @param array $args
     * @return bool
     */
    public function updateAddress($args = [])
	{

		$sqlupdate = " update address set  ";
		$sqlwhere = " where ADDRESSID = '".$args["ADDRESSID"]."'";
		$sqlmid = "";
		$firstFlag = true;
		foreach($args as $ky =>$val)
		{
			if($ky != "ADDRESSID")
			{
				if($firstFlag == false)
				{
					$sqlmid .= ",";
				}
				$sqlmid .=  " $ky = '".$val."'";
				$firstFlag =false;
			}
		}

		$sql = $sqlupdate.$sqlmid.$sqlwhere;

		if($result = $this->conection->query($sql))
		{
			return true;
		}

		return false;

	}






}