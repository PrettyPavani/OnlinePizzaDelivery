<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'dbconnect.php';
    $username = $_POST["username"];
    $password = $_POST["password"]; 
    
    $sql = "Select * from users where username='$username'"; 
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1){
        $row=mysqli_fetch_assoc($result);
        $userType = $row['userType'];
        if($userType == 1) {
            $user_id = $row['id'];
            if (password_verify($password, $row['password'])){ 
                session_start();
                $_SESSION['adminloggedin'] = true;
                $_SESSION['adminusername'] = $username;
                $_SESSION['adminuser_id'] = $user_id;
                header("Location: /OnlinePizzaDelivery/src/controller/admin/index.php?loginsuccess=true");
                exit();
            } 
            else{
                header("Location: /OnlinePizzaDelivery/src/controller/admin/login.php?loginsuccess=false");
            }
        }
        else {
            header("Location: /OnlinePizzaDelivery/src/controller/admin/login.php?loginsuccess=false");
        }
    } 
    else{
        header("location: /OnlinePizzaDelivery/src/controller/admin/login.php?loginsuccess=false");
    }
}    
?>