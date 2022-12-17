<?php
include "config.php";

session_start();
$user_id=$_SESSION['user_id'];
$user_id = $_SESSION['user_id'];
if(!isset($user_id)){
    header("location:login.php");
};
if(isset($_GET['logout'])){
    unset($user_id);
    session_destroy();
    header("location:login.php");
}


if(isset($_POST["update_profile"])){
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
    
    mysqli_query($conn , "UPDATE `user-form` SET name = '$update_name', email = '$update_email' WHERE id = $user_id ") or die ("query failed");
    
    $upass=$_POST['upass'];
    $npass=$_POST['npass'];
    $cpass=$_POST['cpass'];
    
    
    if(!empty($upass) || !empty($npass) || !empty($cpass)){
        
        $oldpass= $_POST['old_password'];
        $upass=mysqli_real_escape_string($conn, md5($_POST['upass']));

        if($upass != $oldpass){
            $message[]="Old Password not match";          
        }
        elseif(!empty($npass) || !empty($cpass)){
            $npass=mysqli_real_escape_string($conn, md5($_POST['npass']));
            $cpass=mysqli_real_escape_string($conn, md5($_POST['cpass']));
            if( $npass == $oldpass && $cpass==$oldpass){
                $message[]='you have entered last password please enter new one!';
            }
            elseif( $npass != $cpass){
                $message[]='confirm password not matched!';
            }
            else{
                $message[]='your password updated!';
                mysqli_query($conn , "UPDATE `user-form` SET password = '$npass' WHERE id = $user_id ") or die ("query failed");
            }
        }
        else{
            $message[] = "please Enter your new password";
        }
    }
    $filename = $_FILES["update_imagename"]["name"];
    $filesize = $_FILES["update_imagename"]["size"];  
    $tempname = $_FILES["update_imagename"]["tmp_name"];
    $folder = "upload_img/". $filename;

    if(!empty($filename)){
        if($filesize > 20000){
           $insert = mysqli_query($conn , "UPDATE `user-form` SET image = '$folder' WHERE id = $user_id ") or die ("query failed");
            if($insert){
                move_uploaded_file($tempname,$folder);
                // $message[]='registered Succesfully! '.' <a href="login.php"> Login</a>';
                $message[]='registered Succesfully! ';
                // header('location:login.php');
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


    <form action="update_profiles.php" method="post" enctype="multipart/form-data">
            <?php
            if($fetch['image'] == ''){
                echo '<img src="images/large_7.jpg">';
            }
            else{
                echo '<img src="'.$fetch['image'].'">';                
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
                    
                    <span>email:</span>
                    <input type="email" name="update_email" value="<?php echo  $fetch['email'];?>" class="box">
                    
                    <span>Image</span>
                    <input type="file" name="update_imagename" accept="image/jpg, image/jpeg, image/png" class="box">
                </div>
                <div class="inputBox">
                    <input type="hidden" name="old_password" value="<?php echo  $fetch['password']; ?>" class="box">
                    <span>old:</span>
                    
                    <input type="password" name="upass"  class="box">
                    
                    
                    <span>new:</span>
                    <input type="password" name="npass"  class="box">
                    
                    <span>con</span>
                    <input type="password" name="cpass"  class="box">
                </div>
            </div>
            <input type="submit" name="update_profile" id="" value="Update Profile" class="btn">
            <a href="home.php" class="delete-btn">Go Back </a>
    </form>
</div>