<?php
    include 'dbconnect.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['contactReply'])) {
        $contact_Id = $_POST['contact_Id'];
        $message = $_POST['message'];
        $user_id = $_POST['user_id'];
        
        $sql = "INSERT INTO `contactreply` (`contact_id`, `user_id`, `message`, `createdate`) VALUES ('$contact_Id', '$user_id', '$message', current_timestamp())";   
        $result = mysqli_query($conn, $sql);
        if($result) {
            echo "<script>alert('success');
                    window.location=document.referrer;
                </script>";
        }
        else {
            echo "<script>alert('failed');
                    window.location=document.referrer;
                </script>";
        }
    }
}
?>