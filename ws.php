<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

include './dbcon.php';

    require __DIR__ . '/vendor/autoload.php';


class MyChat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        try{
            include './dbcon.php';

            $obj=json_decode($msg);
            $key='dasdsadsdasghfhgvvcvc';
            $decode=JWT::decode($obj->auth,new Key($key,'HS256'));
            $decode=(array) $decode;
            $sql='SELECT users.id as userid ,users.email,users.username,users.password,pictureprofile.path From users INNER JOIN pictureprofile ON users.id=pictureprofile.userid WHERE users.email=?';
            $exc=$pdo->prepare($sql);
            $exc->execute(array($decode['useremail']));
            $userinfo=$exc->fetch();
            $text=htmlentities($obj->msg);

            $sql='INSERT INTO `messages`(`senderid`, `text`) VALUES (?,?)';
            $exc=$pdo->prepare($sql);
            $exc->execute(array($userinfo['userid'],$text));
            
            $now=date('Y-m-d h:i:s');
            $info=array("username"=>$userinfo['username'],"userid"=>$userinfo['userid'],"time"=>$now,"profile"=>$userinfo['path'],"text"=>$text);

            foreach ($this->clients as $client) {
                if ($from != $client) {
                    $client->send(json_encode($info));
                }
            }

        }
        catch(Exception $error){
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}

    // Run the server application through the WebSocket protocol on port 8080
    $app = new Ratchet\App('localhost', 8080);
    $app->route('/chat', new MyChat, array('*'));
    $app->route('/echo', new Ratchet\Server\EchoServer, array('*'));
    $app->run();

    ?>