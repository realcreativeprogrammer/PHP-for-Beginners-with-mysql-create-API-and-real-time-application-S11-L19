<?php
require __DIR__.'/vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

include './dbcon.php';

if(isset($_COOKIE['auth'])){
    try{
        $key='dasdsadsdasghfhgvvcvc';
        $decode=JWT::decode($_COOKIE['auth'],new Key($key,'HS256'));
        $userinfo=(array) $decode;

    }
    catch(Exception $e){
        ?>
        <script>
        document.location="logout.php"
        </script>

   <?php
    }
}else{
    ?>
    <script>
    document.location="logout.php"
    </script>

<?php  
}


$sql='SELECT users.id as userid ,users.email,users.username,users.password,pictureprofile.path From users INNER JOIN pictureprofile ON users.id=pictureprofile.userid WHERE users.email=?';
$exc=$pdo->prepare($sql);
$exc->execute(array($userinfo['useremail']));
$userdata='';
if($exc->rowCount()==1){
$userdata=$exc->fetch();
}else{
    ?>
    <script>
    document.location="logout.php"
    </script>

<?php     
}
// print_r($userdata);
$usernameerror=false;
$usernamesuccess=false;
$passworderror=false;
$passwordsuccess=false;
$imagesuccess=false;
if(isset($_POST['save'])){
    $usernameerror=false;
    $usernamesuccess=false;
    $passworderror=false;
    $passwordsuccess=false;
    $imagesuccess=false;

    //update username
    $username=htmlentities($_POST['username']);
    if($username != $userdata['username']){
        if($username!=''){
            $sql='UPDATE `users` SET `username`=? WHERE email=?';
            $exc=$pdo->prepare($sql);
            $exc->execute(array($username,$userinfo['useremail']));
            $sql='SELECT users.id as userid ,users.email,users.username,users.password,pictureprofile.path From users INNER JOIN pictureprofile ON users.id=pictureprofile.userid WHERE users.email=?';
            $exc=$pdo->prepare($sql);
            $exc->execute(array($userinfo['useremail']));
            if($exc->rowCount()==1){
                $userdata=$exc->fetch();
                }else{
                    ?>
                    <script>
                    document.location="logout.php"
                    </script>
                
                <?php     
                }
            $usernamesuccess=true;
    
        }else{
            $usernameerror=true;
     
        }
    }

    //update username

    //update password
    $newpassword=htmlentities($_POST['newpassword']);
    $oldpassword=htmlentities($_POST['oldpassword']);

    if($newpassword !='' && $oldpassword!=''){
        $oldpassword=hash('sha256',$oldpassword);

        if($oldpassword ==$userdata['password']){
            $newpassword=hash('sha256',$newpassword);

            $sql='UPDATE `users` SET `password`=? WHERE email=?';
            $exc=$pdo->prepare($sql);
            $exc->execute(array($newpassword,$userinfo['useremail']));
            $passwordsuccess=true;
            $sql='SELECT users.id as userid ,users.email,users.username,users.password,pictureprofile.path From users INNER JOIN pictureprofile ON users.id=pictureprofile.userid WHERE users.email=?';
            $exc=$pdo->prepare($sql);
            $exc->execute(array($userinfo['useremail']));
            if($exc->rowCount()==1){
                $userdata=$exc->fetch();
                }else{
                    ?>
                    <script>
                    document.location="logout.php"
                    </script>
                
                <?php     
                }
    
        }else{
            $passworderror=true;
     
        }
    }
    //update password

    //update pic frofile
    if(isset($_FILES['image']) && $_FILES['image']['error'] != UPLOAD_ERR_NO_FILE){
        $realfilename=$_FILES['image']['name'];
        $filename=$userinfo['userid'].'_'.$userdata['username'];
        $filetype=pathinfo($realfilename,PATHINFO_EXTENSION);
        if($filetype == 'png' || $filetype == 'jpg'){
            if($userdata['path']!='./images/default.png'){
                unlink($userdata['path']);
            }
            if(move_uploaded_file($_FILES['image']['tmp_name'],'images/'.$filename.'.'.$filetype)){
                $sql='UPDATE `pictureprofile` SET `path`=? WHERE  userid=?';
                $exc=$pdo->prepare($sql);
                $exc->execute(array('images/'.$filename.'.'.$filetype,$userdata['userid']));
                $imagesuccess=true;

            }
        }
    }
    //update pic profile
}
   ?>
   <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit</title>
        <script src="./js/bootstrap.bundle.min.js"></script>
        <link href="./css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/css.css" rel="stylesheet">

    </head>
    <body class="bg-dark">
    <?php include 'nav.php';?>


    <div class="d-flex justify-content-center align-content-center" >
       <form method='post' enctype='multipart/form-data' class="bg-light mt-5 p-5 rounded-3" style="width: 400px;">
            <h3 class="mb-5 text-center text.black">
                Edit Profile
            </h3>
            <center>
                <img class="img-fluid rounded-circle mb-5" src='<?php echo $userdata['path'] ?>' width="200" height="200">
            </center>
            <div class="mb-3">
                <label for="formFile" class="form-label">Choose New Picture Profile </label>
                <input class="form-control <?php if($imagesuccess){ echo 'is-valid';}?>" name='image' type="file" id="picture" accept="image/*">
                <div class="valid-feedback">
                    Successfully updated
                </div>
            </div>
            <div class="form-floating mb-4">
                <input type="text" name='username' id="username" value='<?php echo $userdata['username']; ?>' class="form-control <?php if($usernameerror){ echo 'is-invalid';} if($usernamesuccess){ echo 'is-valid';} ?>" placeholder="username">
                <label for="username">Username</label>
                <div class="valid-feedback">
                    Successfully updated
                </div>
                <div class="invalid-feedback">
                    Sorry usename not be null
                </div>
            </div>

            <div class="form-floating mb-4">
                <input type="password" name='oldpassword' id="oldpassword" class="form-control <?php if($passworderror){ echo 'is-invalid';} if($passwordsuccess){ echo 'is-valid';} ?>" placeholder="oldpassword">
                <label for="oldpassword">Old Password</label>
                <div class="valid-feedback">
                    Successfully updated
                </div>
                <div id="oldpassword" class="invalid-feedback">
                    Your old passwordis incorrect.
                </div>
            </div>
            <div class="form-floating mb-4">
                <input type="password" name='newpassword' id="newpassword" class="form-control <?php if($passworderror){ echo 'is-invalid';} if($passwordsuccess){ echo 'is-valid';} ?>" placeholder="newpassword">
                <label for="newpassword">New Password</label>
                <div class="valid-feedback">
                    Successfully updated
                </div>
                <div id="newpassword" class="invalid-feedback">
                    Your old passwordis incorrect.
                </div>
            </div>
            <hr class="my-4">

            <input type='submit' value='Save' name='save' class="btn btn-primary btn-lg col-12">
        </form>

   </div>
        
    </body>
    </html>