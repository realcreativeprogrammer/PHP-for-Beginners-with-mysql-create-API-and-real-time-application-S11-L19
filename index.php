<?php
require __DIR__.'/vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

include './dbcon.php';

if(isset($_COOKIE['auth'])){
    try{
        $key='dasdsadsdasghfhgvvcvc';
        $decode=JWT::decode($_COOKIE['auth'],new Key($key,'HS256'));
        $decodearray=(array) $decode;

        $sql='SELECT users.username ,pictureprofile.path From users INNER JOIN pictureprofile ON users.id=pictureprofile.userid WHERE users.email=?';
        $exc=$pdo->prepare($sql);
        $exc->execute(array($decodearray['useremail']));
        $userinfo=$exc->fetch();
        setcookie('path',($userinfo['path']),time()+(86400 * 2));
        setcookie('username',($userinfo['username']),time()+(86400 * 2));

        $sql='select users.id AS userid,users.email,users.username,pictureprofile.path,messages.senderid,messages.text,messages.time From messages INNER JOIN users ON messages.senderid=users.id INNER JOIN pictureprofile ON pictureprofile.userid=users.id ORDER BY messages.id DESC LIMIT 10;';
        $exc=$pdo->prepare($sql);
        $exc->execute(array());

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
   ?>
   <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <script src="./js/bootstrap.bundle.min.js"></script>
        <link href="./css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/css.css" rel="stylesheet">

    </head>
    <body class="bg-dark text-white">
    <?php include 'nav.php';?>


    <!-- Content wrapper start -->
    <div class="container content-wrapper">

        <!-- Row start -->
        <div class="row no-gutters">

            <div class="">
                <div class="selected-user">
                    <span class="name">Global Chat</span>
                </div>
                <div class="chat-container ">
                    <ul class="chat-box chatContainerScroll" id="chatbox1">
                        <?php
                        $alldata=array();
                            while($row=$exc->fetch()){
                                $alldata[]=$row;
                            }
                            $alldata=array_reverse($alldata,true);
                            foreach($alldata as $data){
                                if($data['senderid']==$decodearray['userid']){
                                    ?>
                                    <li class="chat-left">
                                        <div class="chat-avatar">
                                            <img src="<?php echo $data['path']?>" alt="Retail Admin">
                                            <div class="chat-name"><?php echo $data['username']?></div>
                                        </div>
                                        <div class="chat-text" style="background-color:#1E90FF;color:white"><?php echo $data['text']?></div>
                                        <div class="chat-hour"><?php echo $data['time']?> <span class="fa fa-check-circle"></span></div>
                                    </li>
                                    <?php
                                }else{
                                    ?>
                                    <li class="chat-right">
                                        <div class="chat-hour"><?php echo $data['time']?> <span class="fa fa-check-circle"></span></div>
                                        <div class="chat-text" style="background-color:#696969;color:white"><?php echo $data['text']?>
                                        </div>
                                        <div class="chat-avatar">
                                            <img src="<?php echo $data['path']?>" alt="Retail Admin">
                                            <div class="chat-name"><?php echo $data['username']?></div>
                                        </div>
                                    </li> 
                                    <?php
                            }
                            }

                        ?>





                        
                    </ul>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="text" placeholder="Type your message here..." aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-outline-light" onclick="send()"  id="button-addon2">Send</button>
                        </div>

                </div>
            </div>
        </div>

    </div>
    <!-- Content wrapper end -->


        
    </body>
    <script>
        var ws=new WebSocket('ws://localhost:8080/chat')
        function send(){
            textvalue=document.getElementById('text')
            if(textvalue.value !=''){
                var username=(getCookie('username'))
                var path=(getCookie('path')).replace("%2F",'/')
                path=path.replace("%2F",'/')
                // console.log(getCookie('userinfo'))
                // console.log(textvalue.value)
                var token=getCookie('auth')
                var mydata=JSON.stringify({msg:textvalue.value,auth:token})
                ws.send(mydata)
    
                var li=document.createElement('li')
                li.classList.add('chat-left')
    
                var thirddiv=document.createElement('div')
                thirddiv.className='chat-avatar'
    
                var img=document.createElement('img')
                img.src=path
                thirddiv.appendChild(img)
    
                var namediv=document.createElement('div')
                namediv.className='chat-name'
                namediv.innerHTML=username
                thirddiv.appendChild(namediv)
    
                li.appendChild(thirddiv)
    
                var seconddiv=document.createElement('div')
                seconddiv.className='chat-text'
                seconddiv.style.cssText='background-color:#1E90FF;color:white'
                seconddiv.innerHTML=textvalue.value
    
                li.appendChild(seconddiv)
    
                var firstdiv=document.createElement('div')
                firstdiv.className='chat-hour'
                firstdiv.innerHTML=new Date().toLocaleString()
    
                var spanel=document.createElement('span')
                spanel.classList.add('fa','fa-check-circle')
                firstdiv.appendChild(spanel)
    
                li.appendChild(firstdiv)
    
                var mychatbox=document.getElementById('chatbox1')
                mychatbox.appendChild(li)
                textvalue.value='';
            }


        }
        ws.onmessage=function(e){
            var data=JSON.parse(e.data)
            // console.log(data)
            var li=document.createElement('li')
            li.classList.add('chat-right','al-auto')

            var firstdiv=document.createElement('div')
            firstdiv.className='chat-hour'
            firstdiv.innerHTML=data['time']

            var spanel=document.createElement('span')
            spanel.classList.add('fa','fa-check-circle')
            firstdiv.appendChild(spanel)

            li.appendChild(firstdiv)

            var seconddiv=document.createElement('div')
            seconddiv.className='chat-text'
            seconddiv.style.cssText='background-color:#696969;color:white'
            seconddiv.innerHTML=data['text']

            li.appendChild(seconddiv)

            var thirddiv=document.createElement('div')
            thirddiv.className='chat-avatar'

            var img=document.createElement('img')
            img.src=data['profile']
            thirddiv.appendChild(img)

            var namediv=document.createElement('div')
            namediv.className='chat-name'
            namediv.innerHTML=data['username']
            thirddiv.appendChild(namediv)

            li.appendChild(thirddiv)

            var mychatbox=document.getElementById('chatbox1')
            mychatbox.appendChild(li)





        }

        function getCookie(name){
            const value=`; ${document.cookie}`;
            const parts=value.split(`; ${name}=`);
            if(parts.length == 2 ) return parts.pop().split(";").shift();
        }
    </script>
    </html>