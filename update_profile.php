<!-- |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->
<!-- |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->
<!-- |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->
<!-- |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->
<!-- ||||||||| ************ ||| ******** |||| .***. || ************ ||||||||||||||||||| -->
<!-- |||||||||||||| * ||||||||| * |||||||||| * || *|||||||| * ||||||||||||||||||||||||| -->
<!-- |||||||||||||| * ||||||||| * ||||||||||| * ||||||||||| * ||||||||||||||||||||||||| -->
<!-- |||||||||||||| * ||||||||| * ** |||||||||| * ||||||||| * ||||||||||||||||||||||||| -->
<!-- |||||||||||||| * ||||||||| * ||||||||| * || * |||||||| * ||||||||||||||||||||||||| -->
<!-- |||||||||||||| * ||||||||| ******** |||| ***' |||||||| * ||||||||||||||||||||||||| -->
<!-- |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->
<!-- |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->
















<?php

include "config.php";
session_start();
$user_id=$_SESSION['user_id'];
$update_password="";
$new_password="";
$conform_password="";
if(isset($_POST["update_profile"])){
   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
   
   mysqli_query($conn , "UPDATE `user-form` SET name = '$update_name', email = '$update_email' WHERE id = $user_id ") or die ("query failed");
   
   $old_password = mysqli_real_escape_string($conn, $_POST['old_password']);
   $update_password = mysqli_real_escape_string($conn, md5($_POST['update_password']));
   $new_password = mysqli_real_escape_string($conn, md5($_POST['new_password']));
   $conform_password = mysqli_real_escape_string($conn, md5($_POST['conform_password']));
   
   echo $update_password;
   echo $new_password;
   echo $conform_password;

   if(!empty($new_new_password)){
    if($update_password != $old_password){
        $message[]="Old Password not match";          
    }
    elseif( $new_password != $conform_password){
        $message[]='confirm password not matched!';
    }
    else{
        $message[]='password matched!';
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
    <title>Update frofile</title>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="update-profile">
        <?php
            $select =mysqli_query($conn, "SELECT * from `user-form` WHERE id = '$user_id' ");
            if(mysqli_num_rows($select)){
                $fetch = mysqli_fetch_assoc($select);
            }           
            ?>
        <!-- <form action="" method="post" enctype="multipart/form-data"> -->
        <form action="update_profile.php" method="post" enctype="multipart/form-data">
            <?php
            if($fetch['image'] == ''){
                echo '<img src="images/large_7.jpg">';
            }
            else{
                echo '<img src="images/large_7.jpg">';                
                //<!-- echo '<img src="'.$fetch['image'].'">'; -->   
            }  
            if(isset($message)){
                foreach ($message as $message){
                    echo '<div class="message">'. $message .'</div>';
                }
            }
        
            ?>
            <div class="flex">
                <div class="inputBox">
                    <span>username:</span>
                    
                    <input type="text" name="update_name" value="<?php echo  $fetch['name'];?>" class="box">
                    <!-- <input type="text" name="update_name" value="<php echo $fetch['name']; ?>" class="box"> -->
                    
                    <span>email:</span>
                    <input type="email" name="update_email" value="<?php echo  $fetch['email'];?>" class="box">
                    
                    <span>Image</span>
                    <input type="file" name="update_file" accept="image/jpg, image/jpeg, image/png" class="box">
                </div>
                <div class="inputBox">
                    <input type="hidden" name="old_password" value="<?php echo  $fetch['password']; ?>" class="box">

                    <span>Old Password</span>
                    <input type="password" name="update_password" placeholder="Enter your old password" class="box">

                    <span>new Password</span>
                    <input type="password" name="new_new_password" placeholder="Enter your new password" class="box">
                    
                    <span>Conform Password</span>
                    <input type="password" name="conform_password" placeholder="Conform new password" class="box">

                </div>
            </div>
            <input type="submit" name="update_profile" id="" value="Update Profile" class="btn">
            <a href="home.php" class="delete-btn">Go Back </a>

        </form>

    </div>



</body>

</html>