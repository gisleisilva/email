# Envio de e-mails com PHPMailer
Seguindo as boas práticas em orientação a objetos, abstrai o comportamento do componente em uma classe com métodos simplificados.

## Recursos
- Provavelmente o código mais popular do mundo para enviar e-mail de PHP!
- Envie e-mails com vários endereços Para, CC, BCC e para resposta
- Adicionar anexos, incluindo inline
- Valida endereços de e-mail automaticamente

## Instalação

```sh
composer install
```


## Configurações básicas
Edite o arquivo `source/Config.php` e adicione suas configurações de SMTP
```php
<?php
define("MAIL", [
    "host" => "myhost",
    "port" => "myport",
    "user" => "myuser",
    "passwd" => "mypassword",
    "from_name" => "myuser",
    "from_email" => "myemail"
]);
?>
```

## Exemplo Simples
```php
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
?>
```

## Exemplo com cópia

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Source\Support\Email;

$email = new Email();

$email->add(
    "Enviando email com PHPMailer",
    "<p>Envio de e-mails com autenticação SMTP utilizando o componente PHPMailer</p>",
    "João Paulo",
    "joaopaulo@gmail.com"
)
->addCC("copycc@email.com", "NameCopyCC")
->addBCC("copybcc@email.com", "NameCopyBCC")
->send();


if($email->error()){
   echo $email->error()->getMessage();
   die();
}

echo "Email enviado com sucesso!";
?>
```

## Exemplo com anexo

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Source\Support\Email;

$email = new Email();

$email->add(
    "Enviando email com PHPMailer",
    "<p>Envio de e-mails com autenticação SMTP utilizando o componente PHPMailer</p>",
    "João Paulo",
    "joaopaulo@gmail.com"
)
->attach(
    'path/file'
    'Name for file',
)->send();


if($email->error()){
   echo $email->error()->getMessage();
   die();
}

echo "Email enviado com sucesso!";
?>
```
