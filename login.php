<?php
require __DIR__.'/vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

include './dbcon.php';

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

$loginerror=false;
$emailvalue='';
$passwordvalue='';
if(isset($_POST['submit'])){
    $email=htmlentities($_POST['email']);
    $password=htmlentities($_POST['password']);
    $emailvalue=$email;
    $passwordvalue=$password;

    $sql='SELECT `id`, `email`, `password`, `username` FROM `users` WHERE email=? AND password=?';
    $exc=$pdo->prepare($sql);
    $password=hash('sha256',$password);
    $exc->execute(array($email,$password));
    if($exc->rowCount()==1){
        $userinfo=$exc->fetch();
        $key='dasdsadsdasghfhgvvcvc';
        $payload=[
            'userid'=>$userinfo['id'],
            'useremail'=>$userinfo['email']
        ];
        $token=JWT::encode($payload,$key,"HS256");
        setcookie('auth',$token,time()+(86400 * 2));
        ?>
     <script>
        document.location="index.php"
    </script>
        <?php
        // header("LOcation : index.php");

    }else{
        $loginerror=true;
 
    }


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/css.css" rel="stylesheet">
</head>
<body class="bg-dark">
   <div class="d-flex justify-content-center align-content-center" >
       <form method="post" class="bg-light mt-5 p-5 rounded-3" style="width: 400px;">
            <h3 class="mb-5 text-center">
                Login
            </h3>
            <div class="form-floating mb-4">
                <input type="text" id="email" name="email" value="<?php echo $emailvalue; ?>"  class="form-control <?php if($loginerror) echo 'is-invalid'; ?>" placeholder="email">
                <label for="email">Email</label>
                <div class="invalid-feedback">
                    Wrong Credentials invalid email or password
                </div>
            </div>
            <div class="form-floating mb-4">
                <input type="text" id="password" name="password" value="<?php echo $passwordvalue; ?>" class="form-control <?php if($loginerror) echo 'is-invalid'; ?>" placeholder="password">
                <label for="password">Password</label>
                <div class="invalid-feedback">
                    Wrong Credentials invalid email or password
                </div>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="checkbox">
                <label for="checkbox">Remember me</label>
            </div>
            <input type="submit" name="submit" value="Login" href="./index.html" class="btn btn-primary btn-lg col-12">
            <hr class="my-4">
            <a href="./signup.php" class="btn btn-outline-primary btn-lg col-12">Signup</a>
        </form>

   </div>
</body>
</html>