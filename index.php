<?php
require __DIR__ . '/vendor/autoload.php';

use Source\Support\Email;

$email = new Email();

$email->add(
    "Enviando email com PHPMailer",
    "<p>Envio de e-mails com autenticação SMTP utilizando o componente PHPMailer</p>",
    "João Paulo",
    "joaopaulo@gmail.com"
)->send();


if($email->error()){
   echo $email->error()->getMessage();
   die();
}

echo "Email enviado com sucesso!";
