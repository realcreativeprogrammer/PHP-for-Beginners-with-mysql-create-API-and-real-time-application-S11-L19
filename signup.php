<?php
require __DIR__.'/vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


if(isset($_COOKIE['auth'])){
    try{
        $key='dasdsadsdasghfhgvvcvc';
        $decode=JWT::decode($_COOKIE['auth'],new Key($key,'HS256'));
        ?>
             <script>
        document.location="index.php"
    </script>

        <?php
    }
    catch(Exception $e){
        ?>
        <script>
        document.location="logout.php"
        </script>

   <?php
    }
}
include './dbcon.php';
$emailerror=false;
$usernamevalue='';
$emailvalue='';
$passwordvalue='';
if(isset($_POST['submit'])){
// echo'ssssssssssssssssssssss';
$emailerror=false;
$email=htmlentities($_POST['email']);
$username=htmlentities($_POST['username']);
$password=htmlentities($_POST['password']);
$passwordvalue=$password;
$usernamevalue=$username;
$emailvalue=$email;
$password=hash('sha256',$password);

$sql='SELECT `id`, `email`, `password`, `username` FROM `users` WHERE email=?';
$exc=$pdo->prepare($sql);
$exc->execute(array($email));
if($exc->rowCount()==0){
    $sql='INSERT INTO `users`( `email`, `password`, `username`) VALUES (?,?,?)';
    $exc=$pdo->prepare($sql);
    $exc->execute(array($email,$password,$username));
    $userid=$pdo->lastInsertId();
    // echo $userid;
    $sql='INSERT INTO `pictureprofile`(`userid`) VALUES (?)';
    $exc=$pdo->prepare($sql);
    $exc->execute(array($userid));
    ?>
    <script>
        document.location="login.php"
    </script>
    <?php


}else{
    $emailerror=true;
}



}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/css.css" rel="stylesheet">
</head>
<body class="bg-dark">
   <div class="d-flex justify-content-center align-content-center">
       <form method='post' class="bg-light mt-5 p-5 rounded-3" style="width: 400px;">
            <h3 class="mb-5 text-center">
                Signup
            </h3>
            <div class="form-floating mb-4">
                <input type="email" id="email" name='email'  value="<?php echo $emailvalue ?>" class="form-control <?php if($emailerror) echo 'is-invalid' ?>" placeholder="email">
                <label for="username">Email</label>
                <div id="email" class="invalid-feedback">
                    that email is already registered
                </div>
            </div>
            <div class="form-floating mb-4">
                <input type="text" id="username" name="username" value="<?php echo $usernamevalue ?>" class="form-control" placeholder="username">
                <label for="username">Username</label>
            </div>
            <div class="form-floating mb-4">
                <input type="text" id="password" name="password" value="<?php echo $passwordvalue ?>" class="form-control" placeholder="password">
                <label for="password">Password</label>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="checkbox">
                <label for="checkbox">I agree to the terms and conditions and privacy policy</label>
            </div>
            <input Type="submit" name="submit" value='Signup' class="btn btn-primary btn-lg col-12">
            <hr class="my-4">
            <a href="./login.php" class="btn btn-outline-primary btn-lg col-12">Login</a>
        </form>

   </div>
</body>
</html>