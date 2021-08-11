<?php
    include 'dbconnect.php';
    session_start();
    $user_id = $_SESSION['user_id'];    
    if(isset($_POST["updateProfilePic"])){
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $newfilename = "person-".$user_id.".jpg";
            $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/OnlinePizzaDelivery/src/controller/users/assets/img/';
            $uploadfile = $uploaddir . $newfilename;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
                echo "<script>alert('success');
                        window.location=document.referrer;
                    </script>";
            }else {
                echo "<script>alert('image upload failed, please try again.');
                        window.location=document.referrer;
                    </script>";
            }
        }else{
            echo '<script>alert("Please select an image file to upload.");
                window.history.back(1);
            </script>';
        }
    }
    if(isset($_POST["updateProfileDetail"])){
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $password =$_POST["password"];
        $passSql = "SELECT * FROM users WHERE id='$user_id'"; 
        $passResult = mysqli_query($conn, $passSql);
        $passRow=mysqli_fetch_assoc($passResult);
        if (password_verify($password, $passRow['password'])){ 
            $sql = "UPDATE `users` SET `firstName` = '$firstName', `lastName` = '$lastName', `email` = '$email', `phone` = '$phone' WHERE `id` ='$user_id'";   
            $result = mysqli_query($conn, $sql);
            if($result){
                echo '<script>alert("Update successfully.");
                        window.history.back(1);
                    </script>';
            }else{
                echo '<script>alert("Update failed, please try again.");
                        window.history.back(1);
                    </script>';
            } 
        }else {
            echo '<script>alert("Password is incorrect.");
                        window.history.back(1);
                    </script>';
        }
    }  
    if(isset($_POST["removeProfilePic"])){
        $filename = $_SERVER['DOCUMENT_ROOT']."/OnlinePizzaDelivery/src/controller/users/assets/img/person-".$user_id.".jpg";
        if (file_exists($filename)) {
            unlink($filename);
            echo "<script>alert('Removed');
                window.location=document.referrer;
            </script>";
        }else {
            echo "<script>alert('no photo available.');
                window.location=document.referrer;
            </script>";
        }
    }
    
?>