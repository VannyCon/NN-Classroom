<?php 
    // Redirect to login if not logged in
    // if (isset($_SESSION['username'])) {
    //     header("Location: view/pages/Dashboard/index.php");
    //     exit();
    // }
    require('../../../services/LoginAccessService.php');
    // Instantiate the class to get nursery owners
    $access = new LoginAccess();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'adminlogin') {
        // Retrieve form input
        $username = $access->clean('username', 'post');
        $password = $access->clean('password', 'post');

        if (!empty($username) && !empty($password)) { 
            $status = $access->adminlogin($username,$password);
            if($status == true){
                header("Location: dashboard.php");
                exit();
            }else{
                header("Location: index.php?error=1");
            }
           
        } else {
            $error = "Please fill in both fields.";
        }
    }else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'instructorlogin') {
        // Retrieve form input
        $username = $access->clean('username', 'post');
        $password = $access->clean('password', 'post');
    
        if (!empty($username) && !empty($password)) { 
            $result = $access->instructorlogin($username, $password);
    
            if ($result['success']) {
                if ($result['status'] == 2) {
                    header("Location: dashboard.php");
                    exit();
                } else if ($result['status'] == 1) {
                    header("Location: rejected.php");
                    exit();
                } else if ($result['status'] == 0) {
                    header("Location: pending.php");
                    exit();
                }
            } else {
                header("Location: index.php?error=1");
                exit();
            }
        } else {
            header("Location: index.php?error=Please fill in both fields.");
            exit();
        }
    }else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'studentlogin') {
        // Retrieve form input
        $username = $access->clean('username', 'post');
        $password = $access->clean('password', 'post');

        if (!empty($username) && !empty($password)) { 
            $status = $access->studentlogin($username,$password);
            if($status == true){
                header("Location: dashboard.php");
                exit();
            }else{
                header("Location: index.php?error=1");
            }
           
        } else {
            $error = "Please fill in both fields.";
        }
    }

    

?>