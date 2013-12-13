<?php
/**
 * Database abstraction class, make very easy to work with databases.
 * Created : 2009 - March - 05 
 * @author Gombos Lorand (glorand@gmail.com)
 * @name simpleSQL - PDO
 * @version 1.1
 * http://www.phpclasses.org/package/5206-PHP-Execute-database-queries-from-parameters-using-PDO.html
 */


/**
 * Database specific class - mySQL
 *
 */
class DB {
    /**
     * Host name.
     * @see connect()
     * @var string 
     */
    private static $hostname    =    DB_HOST;
    /**
     * Socket
     * @see connect()
     * @var string
     */
    private static $socket    =    DB_SOCKET;
    /**
     * Database username.
     * @see connect()
     * @var string
     */
    private static $username    =    DB_LOGIN;
    /**
     * User password for database.
     * @var string
     */
    private static $password    =    DB_PASSWD;
    /**
     * Database name.
     * @see connect()
     * @var string
     */
    private $dbname                =    DB_DATABASE; 
    /**
     * Represented the DD class instance. 
     * Help to implement the Singleton design pattern.
     * @var boolean|object DB 
     */
    private static $instance = FALSE;
    /**
     * PDO fetch mode.
     * This variable use we to setting the PDO fetching mode.
     * @var string
     */
    public $fetch_mode = PDO::FETCH_OBJ;
    /**
     * Last query, used by this class.
     * @var string
     */
    private $last_query        = NULL;
    /**
     * After we execute the last query, we obtain a PDO statement.
     * @var PDO::Statement 
     */
    private $last_statement = NULL;
    /**
     * Contain the last result.
     * @var array|object
     */
    private $last_result    = NULL;
    /**
     * Row count, returned by last query.
     * @var integer
     */
    private $row_count        = NULL;
    /**
     * Affected row, returned by last query (DML Queryes).
     * @var integer
     */
    private $affected_row    = NULL;
    
    /**
     * Constructor.
     * Implements the Singleton design pattern.
     * 
     * @return object DB
     * @access public
     * @uses connect() connect to database.
     */
    public function __construct() {
        if (!self::$instance){
            self::connect();
        }
        return self::$instance;        
    }
    
    /**
     * Connect to the database and set the error mode to Exception.
     * 
     * @return void
     * @access private
     */
    private function connect(){
        if(self::$socket)
        {
            $dns = 'mysql:unix_socket='.self::$socket.';dbname='.$this->dbname;
        }
        else {
            $dns = 'mysql:host='.self::$hostname.';dbname='.$this->dbname;
        }
	try {
	        self::$instance = new PDO($dns, self::$username, self::$password);
	        self::$instance->exec("SET CHARACTER SET utf8");
	} catch (PDOException $e) {
		echo 'Erreur de connexion à la BDD :'.$e->getMessage().'<br />';
	}
    }
    
    /**
     * Select a database.
     * 
     * @param string $dbname
     * @return void
     * @access public
     */
    public function selectDB($dbname){
        $this->dbname = $dbname;
        $this->connect();
    }
    
    /**
     * Execute a query. 
     * This function can be used from external. 
     * The function separate the simple queryes and the INSERT, UPADTE, DELETE queries.
     * Do not use this function without escape the data with function DB::escape
     * 
     * @param string $query
     * @return result/affected row depending on query type.
     * @access public
     */
    public function query($query = NULL){
        $this->flush(); 
        $query = trim($query);
        $this->last_query = $query;
        // Query was an insert, delete, update, replace
        if ( preg_match("/^(insert|delete|update|replace|drop|create)\\s+/i",$query) ){
            $this->affected_row = self::$instance->exec($query);
            if ( $this->catch_error() ) return false;
            else return $this->affected_row;
        }
        else {
            //Query was an simple query.
            $stmt = self::$instance->query($query);
            if ( $this->catch_error() ) return false;
            else {
                $stmt->setFetchMode($this->fetch_mode);
                $this->last_statement = $stmt;
                $this->last_result = $this->last_statement->fetchAll();
                return $this->last_result;
            }
        }
    }
    
    /**
     * Execute a query.
     * This function can be used from DB class methods.
     * 
     * @param string $query
     * @return bool
     * @access private
     */
    private function internalQuery($query = NULL){
        $this->flush();
        $query = trim($query);
        $this->last_query = $query;
        
        $stmt = self::$instance->query($query);
        if ( $this->catch_error() ) return false;
        $stmt->setFetchMode($this->fetch_mode);
        $this->last_statement = $stmt;
        return TRUE;
    }

    /**
     * Execute a query (INSERT, UPDATE, DELETE).
     * This function can be used from DB class methids.
     * 
     * @param string $query
     * @return int
     * @access private
     */
    private function execute($query = NULL){
        $this->flush();
        $query = trim($query);
        $this->last_query = $query;
        $this->affected_row = self::$instance->exec($query);
        if ($this->catch_error()) return false;
        return $this->affected_row;
    }    
    
    /**
     * Return a result set.
     *
     * @param string $query
     * @return result set
     * @access public.
     */
    public function getResults($query = NULL){
        $this->internalQuery($query);
        $result = $this->last_statement->fetchAll();
        $this->last_result = $result;
        return $result;
    }
    
    /**
     * Get one row from the DB.
     *
     * @param string $query
     * @return reulst set
     * @access public
     */
    public function getRow($query = NULL){
        $this->internalQuery($query);
        $result = $this->last_statement->fetch();
        $this->last_result = $result;
        return $result;        
    }
    
    /**
     * Helper function, walk the array, and modify the values.
     *
     * @param pointer $item
     * @return void
     * @access private 
     */
    private static function prepareDbValues(&$item){
        $item = self::$instance->quote(self::escape($item));
    }

    /**
     * Insert a value into a table.
     *
     * @param string $table
     * @param array $data
     * @return integer 
     * @access public
     */
    public function insert($table = NULL, $data = NULL){
        array_walk($data,'DB::prepareDbValues');
        
        $query = "INSERT INTO `".$table."` 
                 (`".implode('`, `', array_keys($data))."`) 
                 VALUES ( ".implode(', ', $data).")";
        return $this->execute($query);
    }
    
    /**
     * Update a value(s) in a table
     * Ex: 
     * $table = 'tableName';
     * $data = array('text'=> 'value', 'date'=> '2009-12-01');
     * $where = array('id=12','AND name="John"'); OR $where = 'id = 12';
     *
     * @param string $table
     * @param array $data
     * @param array/string $where
     * @return void
     * @access public
     */
    public function update($table = NULL, $data = NULL, $where = NULL){
        array_walk($data,'DB::prepareDbValues');
        foreach ($data as $key => $val){
            $valstr[]= '`'.$key.'` = '.$val;
        }

        $query = "UPDATE `".$table."` SET ".implode(', ', $valstr);
        if (is_array($where)){
            $query.= " WHERE ".implode(" ",$where);
        }
        else {
            $query.= " WHERE ".$where;
        }
        
        return $this->execute($query);
    }
    
    /**
     * Delete a record from a table.
     * Ex.
     * $table = 'tableName';
     * $where = array('id = 12','AND name = "John"'); OR $where = 'id = 12';
     *
     * @param string $table
     * @param array/string $where
     * @return void
     * @access public
     */
    public function delete($table = NULL, $where = NULL){
        $query = "DELETE FROM `".$table."` WHERE ";
        if (is_array($where)){
            $query.= implode(" ",$where);
        }
        else{
            $query.= $where;
        }
        
        return $this->execute($query);
    }
    
    /**
     * Return  a result set.
     * Similar to {@link getResults()}, but in this case not need to write a query.
     * The generated query is based on $where associative Array and $table.
     * 
     * Ex.
     * <code>
     * $where = array();
     * $where['username'] = 'testUsername';
     * $where['id'] = '1';
     * $result =  $c->buildQuery('user',$where);
     * print_r($result);
     * </code>
     * 
     * @param string $table
     * @param array $where
     * @return array - result set
     * @access public
     */
    public function buildQuery($table,$where){
        array_walk($where,'DB::prepareDbValues');
        $query = "SELECT * FROM `{$table}` WHERE ";
        $valstr = array();
        foreach ($where as $key => $value){
            $valstr[] = "`{$key}` = {$value}";
        }
        $query.= implode(" AND ",$valstr);
        
        $this->internalQuery($query);
        $result = $this->last_statement->fetchAll();
        $this->last_result = $result;
        return $result;
    }
    
    /**
     * Return the last insert id.
     *
     * @return integer
     * @access public
     */
    public function getLastInsertId(){
        return self::$instance->lastInsertId();
    }
    
    /**
     * Return the last executed query.
     *
     * @return string
     * @access public
     */
    public function getLastQuesry(){
        return $this->last_query;
    }
    
    /**
     * Returns the number of rows affected by the last SQL statement.
     *
     * @return int
     * @access public
     */
    public function getRowCount(){
        if (!is_null($this->last_statement)){
            return $this->last_statement->rowCount();
        }
        else {
            return 0;
        }
    }
    
    /**
     * Set the PDO fetch mode.
     *
     * @param string $fetch_mode
     * @return void
     * @access public
     */
    public function setFetchMode($fetch_mode){
        $this->fetch_mode = $fetch_mode;
    }
    
    /**
     * Set to NULL all cached data.
     * 
     * @return void
     * @access private
     */
    private function flush(){
        $this->last_query        = NULL;
        $this->last_statement     = NULL;
        $this->last_result        = NULL;
        $this->row_count        = NULL;
        $this->affected_row        = NULL;
    }
    
    /**
    *  Format a mySQL string correctly for safe mySQL insert
    *  (no mater if magic quotes are on or not)
    *
    * @param string $str
    * @return string
    * @access public
    */
    public static function escape($str){
        return mysql_escape_string(stripslashes($str));
    }
    
    /**
     * Print the error if exist.
     * 
     * @return vois
     * @access private
     */
    private function catch_error()
        {
            $err_array = self::$instance->errorInfo();
            // Note: Ignoring error - bind or column index out of range
            if ( isset($err_array[1]) && $err_array[1] != 25)
            {
                try {
                    throw new Exception();
                }
                catch (Exception  $e){
                    print "<div style='background-color:#D8D8D8; color:#000000; padding:10px;
                    border:2px red solid;>";
                    print "<p style='font-size:25px; color:#7F0000'>DATABASE ERROR</p>";
                    print "<p style='font-size:20px; color:#7F0000'>Query:<br />
                    <span style='font-size:15px; color:#000000;'>{$this->getLastQuesry()}</span></p>";
                    print "<p style='font-size:20px; color:#7F0000'>Message:<br />
                    <span style='font-size:15px; color:#000000;'>{$err_array[2]}</span></p>";
                    print "</div>";
                    die();
                }
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
    /**
     * Prepares as prepared Statement
     * @param string $statement
     * @param array $driver_options [optional]
     * @return PDOStatement
     */
    public function prepare($stmt,$driver_options = array() )
    {
        return self::$instance->prepare($stmt,$driver_options);
    }
}
?>
