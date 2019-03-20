<?php 

class Application {
    private static $instance;

    public static function getInstance() {
        if(!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
	 * @var array Contains the information neeeded to connect to the database ( host, user,password,database)
	 */
    private $dbConnectionData;


    /**
	 * Stores if the Application is initialized or not
	 * 
	 * @var boolean
	 */
	private $initialized = false;

    /**
	 * Initializes the application
	 * 
	 * @param array $dbConnection data needed to connect to the database
	 */
	public function init($dbConnectionData)
	{
        if ( ! $this->initialized ) {
    	    $this->dbConnectionData = $dbConnectionData;
    		session_start();
    		$this->initialized = true;
        }
    }
    

    /**
	 * @var \mysql Database connection.
	 */
	private $conn;
	

    /**
	 *  Stops the application
	 */
	public function shutdown()
	{
	    $this->checkInitializedInstance();
	    if ($this->conn !== null) {
	        $this->conn->close();
	    }
    }
    
    /**
	 * Verifies if the Application is initialized. If not shows a message and terminates execution
	 */
	private function checkInitializedInstance()
	{
	    if (! $this->initialized ) {
	        echo "Application is not initialized";
	        exit();
	    }
    }
    
    /**
	 * Creates a database connection. Verifies if there already is one.
	 * 
	 * @return \mysqli MySQL connection
	 */
	public function connectDB()
	{
	    $this->checkInitializedInstance();
		if (! $this->conn ) {
			$dbHost = $this->dbConnectionData['host'];
			$dbUser = $this->dbConnectionData['user'];
			$dbPass = $this->dbConnectionData['pass'];
			$db = $this->dbConnectionData['bd'];
			
			$this->conn = new \mysqli($dbHost, $dbUser, $dbPass, $db);
			if ( $this->conn->connect_errno ) {
				echo "Database connection errror: (" . $this->conn->connect_errno . ") " . utf8_encode($this->conn->connect_error);
				exit();
			}
			if ( ! $this->conn->set_charset("utf8mb4")) {
				echo "Database codification error: (" . $this->conn->errno . ") " . utf8_encode($this->conn->error);
				exit();
			}
		}
		return $this->conn;
	}



    private function __contstruct() {
        //we do not want to be able to instanciate this
    }

    private function __clone() {
        parent::__clone();
    }

    private function __wakeup()
	{
        //we do not want to use unserialize
	    return parent::__wakeup();
	}


}