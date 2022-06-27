<?php
try{
    $pdo=new PDO("mysql:host=localhost;dbname=chat",'root','');
    // echo 'connected';
}
catch(PDOException $e){
    echo $e;
}

?>