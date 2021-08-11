<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'dbconnect.php';
    $username = $_POST["loginusername"];
    $password = $_POST["loginpassword"];    
    $sql = "Select * from users where username='$username'"; 
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1){
        $row=mysqli_fetch_assoc($result);
        $user_id = $row['id'];
        if (password_verify($password, $row['password'])){ 
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_id;
            if($user_id==1){
                header("Location: /OnlinePizzaDelivery/src/controller/admin/index.php?loginsuccess=true");      
            }else{
                header("Location: /OnlinePizzaDelivery/src/controller/users/index.php?loginsuccess=true");
            }
        }else{
            header("Location: /OnlinePizzaDelivery/src/controller/users/index.php?loginsuccess=false");
        }
    } 
    else{
        header("Location: /OnlinePizzaDelivery/src/controller/users/index.php?loginsuccess=false");
    }
}    
?>