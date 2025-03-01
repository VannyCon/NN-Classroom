<?php 
ob_start();
session_start();
class config {
    public $pdo; // Declare $pdo as a class property

    // Corrected function to return base URL
    public function base_url(){
        require_once('config.php');
        return URL;
    }
    public function getfile(){
        require_once('config.php');
        return FILEPATH;
    }

    public function __construct(){
        require_once('config.php'); // Include config.php for DB constants
        $dsn = "mysql:host=".H.";dbname=".DB; // Corrected concatenation
        $username = U;
        $password = P;
        try {
            // Initialize PDO with correct parameters
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    static function clean($key, $type) {
        if ($type == "post") {
            // Sanitize input from POST
            $data = filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES);
        } 
        else if ($type == "get") {
            // Sanitize input from GET
            $data = filter_input(INPUT_GET, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES);
        } 
        else {
            return ""; // Return empty string for invalid type
        }
    
        return $data !== false ? trim($data) : ""; // Ensure it doesn't return false
    }
    
    function logout(){
        session_start();
        // Unset all session variables
        $_SESSION = array();
        // Destroy the session
        session_destroy();
        header("Location: index.php");
        return true;
    }
}



?>
