<?php
include "config.php";
// include "../_db_connection.php";
// echo "connection success";

if(isset($_POST["submit"])){
    // echo "mysqli num";
    $name=mysqli_real_escape_string($conn, $_POST['name']);
    $email=mysqli_real_escape_string($conn, $_POST['email']);
    $password=mysqli_real_escape_string($conn, md5($_POST['password']));

    $cpassword=mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    // $file=mysqli_real_escape_string($conn, $_POST['file']);

    $filename = $_FILES["imagename"]["name"];
    $filesize = $_FILES["imagename"]["size"];  
    $tempname = $_FILES["imagename"]["tmp_name"];
    $folder = "upload_img/". $filename;

    $select =mysqli_query($conn, "SELECT * from `user-form` where email='$email' AND password='$password'") or die ('select Query failed');
    
    if(mysqli_num_rows($select)>0){
        $message[] ='user already exist ';
    }
    else 
    {
        if($password !== $cpassword){
            $message[]='confirm password not matched!';
        }
        elseif($filesize> 2000000){
            $message[]='Image size mis too large!';
        }
        else{
            $insert = mysqli_query($conn, "INSERT INTO `user-form`(`name`, `email`, `password`, `image`) VALUES ('$name','$email','$password','$folder')" )or die("insert Query failed");
            if($insert){
                move_uploaded_file($tempname,$folder);
                // $message[]='registered Succesfully! '.' <a href="login.php"> Login</a>';
                $message[]='registered Succesfully! ';
                header('location:login.php');
            }
        }
    }
    
}
    ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="form-container">

        <form action="registration.php" method="post" enctype="multipart/form-data">
            <h1>Register now</h1>
            <?php
                if(isset($message)){
                    foreach ($message as $message){
                        echo '<div class="message">'. $message .'</div>';
                    }
                }
            ?>
            <input type="text" name="name" placeholder="Enter username" class="box" required>
            <input type="email" name="email" placeholder="Enter email" class="box" required>
            <input type="password" name="password" placeholder="Enter password" class="box" required>
            <input type="password" name="cpassword" placeholder="conform password" class="box" required>
            <input type="file" name="imagename" accept="image/jpg, image/jpeg, image/png" class="box">
            <input type="submit" name="submit" value="Register now" class="btn">
            <p>already have an account? <a href="login.php">Login now</a> </p>
        </form>
    </div>



</body>

</html>