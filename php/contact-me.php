<?php
if($_POST) {

    $to_Email = "prokdfbsu@gmail.com, imcupofcoffe@gmail.com"; // Write your email here
   
    // Use PHP To Detect An Ajax Request
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
   
        // Exit script for the JSON data
        $output = json_encode(
        array(
            'type'=> 'Ошибка',
            'text' => 'Запрос должен исходить от Ajax'
        ));
       
        die($output);
    }
   
    // Checking if the $_POST vars well provided, Exit if there is one missing
    if(!isset($_POST["userName"]) || !isset($_POST["userEmail"]) || !isset($_POST["userSubject"]) || !isset($_POST["userMessage"])) {
        
        $output = json_encode(array('type'=>'error', 'text' => '<i class="icon ion-close-round"></i> Заполните все поля'));
        die($output);
    }
   
    // PHP validation for the fields required
    if(empty($_POST["userName"])) {
        $output = json_encode(array('type'=>'error', 'text' => '<i class="icon ion-close-round"></i> Извините, но ваше имя слишком короткое или не указано.'));
        die($output);
    }
    
    if(!filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL)) {
        $output = json_encode(array('type'=>'error', 'text' => '<i class="icon ion-close-round"></i> Введите свой настоящий e-mail.'));
        die($output);
    }

    // To avoid the spammy bots, you can change the value of the minimum characters required. Here it's <20
    if(strlen($_POST["userMessage"])<20) {
        $output = json_encode(array('type'=>'error', 'text' => '<i class="icon ion-close-round"></i> Слишком короткое сообщение, пожалуйста добавьте пару слов .'));
        die($output);
    }
   
    // Proceed with PHP email
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n";
    $headers .= 'From: My website' . "\r\n";
    $headers .= 'Reply-To: '.$_POST["userEmail"]."\r\n";
    
    'X-Mailer: PHP/' . phpversion();
    
    // Body of the Email received in your Mailbox
    $emailcontent = 'Привет! Вы получили новое сообщение от посетителя <strong>'.$_POST["userName"].'</strong><br/><br/>'. "\r\n" .
                'Его сообщение: <br/> <em>'.$_POST["userMessage"].'</em><br/><br/>'. "\r\n" .
                '<strong>Feel свободно связаться '.$_POST["userName"].' via email at : '.$_POST["userEmail"].'</strong>' . "\r\n" ;
    
    $Mailsending = @mail($to_Email, $_POST["userSubject"], $emailcontent, $headers);
   
    if(!$Mailsending) {
        
        //If mail couldn't be sent output error. Check your PHP email configuration (if it ever happens)
        $output = json_encode(array('type'=>'error', 'text' => '<i class="icon ion-close-round"></i> К сожалению! Похоже, что-то пошло не так, пожалуйста, проверьте конфигурацию PHP почты.'));
        die($output);
        
    } else {
        $output = json_encode(array('type'=>'message', 'text' => '<i class="icon ion-checkmark-round"></i> Hello '.$_POST["userName"].', Ваше сообщение было отправлено, мы свяжемся с вами как можно скорее!'));
        die($output);
    }
}
?>