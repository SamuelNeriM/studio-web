<?php
/*
  PHP contact form script
  Version: 1.1
  Copyrights BootstrapMade.com
*/

/***************** Configuration *****************/

  // Substitua pelo seu endereço de e-mail de recebimento.
  $contact_email_to = "samuell.nerii@gmail.com";

  // Prefixos de título
  $subject_title = "Contat Form Message:";
  $name_title = "Name:";
  $email_title = "Email:";
  $message_title = "Message:";

  // Mensagens de erro
  $contact_error_name = "O nome é muito curto ou vazio!";
  $contact_error_email = "Por favor digite um email válido!";
  $contact_error_subject = "Assunto muito curto ou vazio!";
  $contact_error_message = "Mensagem muito curta! Por favor, insira algo.";

/********** Não edite a partir da linha abaixo ***********/

  if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die('Sorry Request must be Ajax POST');
  }

  if(isset($_POST)) {

    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST["subject"], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $message = filter_var($_POST["message"], FILTER_SANITIZE_STRING);

    if(!$contact_email_to || $contact_email_to == 'samuell.nerii@gmail.com') {
      die('O endereço de e-mail de recebimento do formulário de contato não está configurado!');
    }

    if(strlen($name)<3){
      die($contact_error_name);
    }

    if(!$email){
      die($contact_error_email);
    }

    if(strlen($subject)<3){
      die($contact_error_subject);
    }

    if(strlen($message)<3){
      die($contact_error_message);
    }

    if(!isset($contact_email_from)) {
      $contact_email_from = "contactform@" . @preg_replace('/^www\./','', $_SERVER['SERVER_NAME']);
    }

    $headers = 'From: ' . $name . ' <' . $contact_email_from . '>' . PHP_EOL;
    $headers .= 'Reply-To: ' . $email . PHP_EOL;
    $headers .= 'MIME-Version: 1.0' . PHP_EOL;
    $headers .= 'Content-Type: text/html; charset=UTF-8' . PHP_EOL;
    $headers .= 'X-Mailer: PHP/' . phpversion();

    $message_content = '<strong>' . $name_title . '</strong> ' . $name . '<br>';
    $message_content .= '<strong>' . $email_title . '</strong> ' . $email . '<br>';
    $message_content .= '<strong>' . $message_title . '</strong> ' . nl2br($message);

    $sendemail = mail($contact_email_to, $subject_title . ' ' . $subject, $message_content, $headers);

    if( $sendemail ) {
      echo 'OK';
    } else {
      echo 'Não foi possível enviar e-mail! Por favor, verifique sua configuração de email PHP.';
    }
  }
?>
