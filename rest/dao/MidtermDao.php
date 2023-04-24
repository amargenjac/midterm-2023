<?php

class MidtermDao {

    private $conn;

    /**
    * constructor of dao class
    */
    public function __construct(){
        try {

        /** TODO
        * List parameters such as servername, username, password, schema. Make sure to use appropriate port
        */
        $servername = "db-mysql-nyc1-51552-do-user-3246313-0.b.db.ondigitalocean.com";
        $username = "doadmin";
        $password = "AVNS_sQwKZryHF62wtg6XNoi";
        $schema = "midterm-2023";
        $port = "25060";
        // set the PDO error mode to exception
        //echo "Connected successfully";



        /*options array neccessary to enable ssl mode - do not change*/
        $options = array(
        	PDO::MYSQL_ATTR_SSL_CA => 'https://drive.google.com/file/d/1g3sZDXiWK8HcPuRhS0nNeoUlOVSWdMAg/view?usp=share_link',
        	PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,

        );
        /** TODO
        * Create new connection
        * Use $options array as last parameter to new PDO call after the password
        */
        $this->conn = new PDO("mysql:host=$servername; port=$port; dbname=$schema", $username, $password, $options);

        // set the PDO error mode to exception
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          echo "Connected successfully";
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
    }

    /** TODO
    * Implement DAO method used to get cap table
    */
    public function cap_table(){
      $stmt = $this->conn->prepare("SELECT * FROM cap_table");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** TODO
    * Implement DAO method used to get summary
    */
    
    /* "SELECT COUNT(investor_id) AS 'total_investors', SUM(diluted_shares) AS 'total_shares' FROM cap_table" */
    public function summary(){
      $stmt = $this->conn->prepare("SELECT COUNT(DISTINCT(investor_id)) AS 'total_investors', SUM(diluted_shares) AS 'total_shares'
      FROM cap_table c
      JOIN investors i ON c.investor_id = i.id
      ");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** TODO
    * Implement DAO method to return list of investors with their total shares amount
    */
    public function investors(){
      /* 
    SELECT company, first_name, last_name,SUM(c.diluted_shares)
    FROM investors i 
    JOIN cap_table c ON i.id = c.investor_id
    GROUP BY(i.id)*/
    $stmt = $this->conn->prepare("SELECT company, first_name, last_name,SUM(c.diluted_shares) FROM investors i JOIN cap_table c ON i.id = c.investor_id GROUP BY(i.id)");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
