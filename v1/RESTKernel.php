<?php
/**
 * User: Cleve
 */


/**
 * Class RESTKernel : Responsible to handle all HTTP REST house keeping operations
 */
class RESTKernel {




    /**
    either GET, POST, PUT or DELETE
     */
    protected $method = '';
    /**
     * The Model requested in the URI.
     */
    protected $endpoint = '';
    /**
     * An optional additional descriptor about the endpoint
     */
    protected $verb = '';
    /**
     * Any additional URI components after the endpoint and verb
     */
    protected $args = Array();
    /**
     * Stores the input of the PUT request
     */
    protected $file = NULL;
    /**
     * Constructor: __construct
     */
    public function __construct($request) {

        /*
         *    CORS for cross-origin HTTP request
         */
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        $this->args = explode('/', rtrim($request, '/'));
        //Fetching the first value from the request which is the endpoint
        $this->endpoint = array_shift($this->args);
        if (array_key_exists(0, $this->args) && !is_numeric($this->args[0])) {
            $this->verb = array_shift($this->args);
        }
        $this->method = $_SERVER['REQUEST_METHOD'];
        // Fetching the delete and put method from the  HTTP_X_HTTP_METHOD
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }
        switch($this->method) {
            case 'DELETE':  // delete
            case 'POST':    // Create or Add
                $this->request = $this->cleanup($_POST);
                break;
            case 'GET': // read
                $this->request = $this->cleanup($_GET);
                break;
            case 'PUT': //replace update
                $this->request = $this->cleanup($_GET);
                $this->file = file_get_contents("php://input");
                break;
            default:
                $this->response('Invalid Method', 405);
                break;
        }
    }
    /**
     * Processing the API  . Its also responsible to catch all the exceptions and produce a correct error message
     * @return string  . Success or Error message
     *
     */
    public function processAPI() {



	    try
	    {



		    /**
		     * For this particular API we are not supporting verbs .But it can be implemented
		     * Verb : is the first string that comes after the Endpoint , Like activate or list etc
		     */
		 if($this->verb != "")
		 {
			 throw new Exception("Invalid Address ID");
		 }


            /**
             * Adding args that we processed from the url into the request array
             */
            $_REQUEST["args"] =   $this->args;

            /**
             * This section handles the GET method operations that is List all   or one  item from our storage system.
             * In this case its address
             */
            if($this->method == 'GET')
        {

            /**
             *  Forming the class name with the name space so that it can be called in the auto load.
             * This class is formed based on the endpoint .ie if address is the endpoint will be
             * \Http\Controllers\AddressController
             */
            $controllerClassName = "\\Http\\Controllers\\".ucfirst($this->endpoint)."Controller";

            /**
             * If class not found throw an exception so that the exception catcher can catch it and create a nice error message
             */
            if (!class_exists($controllerClassName))
	            throw new Exception("No EndPoint");

            /**
             * Creating the controller object
             */
            $controllerObj = new $controllerClassName;
	            $return = $controllerObj->index($_REQUEST);

            /**
             * return array is sent to the response function to create and sent the HTTP success message
             */
            return $this->response(["success"=>$return]);

        }
            /*
             * This section handles the operations to add something to our storage system
             */
        else if($this->method == 'POST' && !isset($this->args[0]))
        {


            /*
             * This is same as what was done for the get but a different method is called.to handle post
             */
            $controllerClassName = "\\Http\\Controllers\\".ucfirst($this->endpoint)."Controller";
            if (class_exists($controllerClassName)) {



                $controllerObj = new $controllerClassName;
	            $return = $controllerObj->store($_REQUEST);
	            return $this->response(["success"=>$return]);
            }
        }
        /*
         * This section handles all the update operations .
         */
        else if($this->method == 'PUT' && isset($this->args[0]))
        {

            /**
             * This is same as what was done for the get .But a different method is called
             */
            $controllerClassName = "\\Http\\Controllers\\".ucfirst($this->endpoint)."Controller";

	        if (class_exists($controllerClassName)) {



		        $controllerObj = new $controllerClassName;
		        $return =$controllerObj->update($_REQUEST);
		        return $this->response(["success"=>$return]);
	        }
        }
        /**
         * This section handles  all the delete operations .
         */
        else if($this->method == 'DELETE' && isset($this->args[0]))
        {
	        $controllerClassName = "\\Http\\Controllers\\".ucfirst($this->endpoint)."Controller";

	        if (class_exists($controllerClassName)) {



		        $controllerObj = new $controllerClassName;
		        $return = $controllerObj->destroy($_REQUEST);
		        return $this->response(["success"=>$return]);
	        }
        }

	    }
        catch(Exception $e)
        {

            /**
             * Any errors thrown in the application will be caught here. The response method is called to form the correct error
             * message
             */
            return $this->response(["Error"=> $e->getMessage()], 404);
        }


        /**
         * This is if none of the above conditions were found the application will return back with a HTTP error message
         */
        return $this->response(["Error"=> "No Endpoint:".$this->endpoint], 404);







    }
    /*
     *  Building the Response message
     */
    private function response($data, $status = 200) {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));

        /**
         * encoding data with pretty print so it will be easy to read and understand in the browser
         */
        return json_encode($data,JSON_PRETTY_PRINT);
    }
    /*
     * Cleaning the data Post or get data . Stripping all HTML and PHP tags
     *
     */
    private function cleanup($data) {
        $clean_input = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->cleanup($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }
    /**
     * HTTP status code to HTTP code description
     * @param $code
     * @return mixed
     */
    private function _requestStatus($code) {
        $status = array(
            200 => 'OK',
            400 => 'Invalid Data',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code])?$status[$code]:$status[500];
    }











} 