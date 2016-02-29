<?php
/**
 * Created by PhpStorm.
 * User: Cleve
 */

namespace Http\Controllers;

/**
 * Interface BaseController . Any controller created must implement this interface
 * @package Http\Controllers
 */
interface BaseController {

    /**
     * Method responsible to List all or 1 item from the storage system
     * @param $request  ,id of the item to be fetched from the DB ,if not set every thing will be sent back
     * @return mixed  ,array containing the selected item
     */
    function index($request);

    /**
     * Method is responsible to store the posted item details to the storage system.
     * @param $request ,array of item data to be stored
     * @return mixed ,  status
     */
    function store($request);

    /**
     * Method responsible to update a given item data to the storage system
     * @param $request ,array of item data  with the item id to be updated
     * @return mixed , status
     */
    function update($request);


    /**
     *  Method responsible to delete  item from the storage system
     * @param $request ,item id that is to be deleted
     * @return mixed , status
     */
    function  destroy($request);

} 