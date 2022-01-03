<?php


namespace Source\Support;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use stdClass;

/**
 * Class Email
 * @package Source\Support
 */
class Email
{
    /** @var PHPMailer */
    private $mail;

    /** @var stdClass */
    private $data;

    /** @var Exception */
    private $error;

    /**
     * Email constructor.
     */
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->data = new stdClass();

        $this->mail->isSMTP();
        $this->mail->isHTML();
        $this->mail->setLanguage("br");

        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = "tls";
        $this->mail->CharSet = "utf-8";

        $this->mail->Host = MAIL["host"];
        $this->mail->Port = MAIL["port"];
        $this->mail->Username = MAIL["user"];
        $this->mail->Password = MAIL["passwd"];
    }

    /**
     * @param string $subject
     * @param string $body
     * @param string $recipient_name
     * @param string $recipient_email
     * @return $this
     */
    public function add(string $subject, string $body, string $recipient_name, string $recipient_email): Email
    {
        $this->data->subject = $subject;
        $this->data->body = $body;
        $this->data->recipient_name = $recipient_name;
        $this->data->recipient_email = $recipient_email;
        return $this;
    }

    /**
     * @param string $ccEmail
     * @param string $ccName
     * @return $this
     */
    public function addCC(string $ccEmail, string $ccName): Email
    {
        $this->data->cc[$ccName] = $ccEmail;
        return $this;
    }
    
    /**
     * addBCC
     *
     * @param  mixed $bccEmail
     * @param  mixed $bccName
     * @return Email
     */
    public function addBCC(string $bccEmail, string $bccName): Email
    {
        $this->data->bcc[$bccName] = $bccEmail;
        return $this;
    }

    /**
     * @param string $filePath
     * @param string $fileName
     * @return $this
     */
    public function attach(string $filePath, string $fileName): Email
    {
        $this->data->attach[$fileName] = $filePath;
        return $this;
    }

    /**
     * @param string $from_name
     * @param string $from_email
     * @return bool
     */
    public function send(string $from_name = MAIL["from_name"], string $from_email = MAIL["from_email"]): bool
    {
        try {
            $this->mail->Subject = $this->data->subject;
            $this->mail->msgHTML($this->data->body);
            $this->mail->addAddress($this->data->recipient_email, $this->data->recipient_name);
            $this->mail->setFrom($from_email, $from_name);

            if(!empty($this->data->cc)){
                foreach($this->data->cc as $name => $address){
                    $this->mail->addCC($address, $name);
                }
            }

            if(!empty($this->data->bcc)){
                foreach($this->data->bcc as $name => $address){
                    $this->mail->addBCC($address, $name);
                }
            }

            if(!empty($this->data->attach)){
                foreach ($this->data->attach as $name => $path){
                    $this->mail->addAttachment($path, $name);
                }
            }

            $this->mail->send();
            return true;

        }catch (Exception $exception){
            $this->error = $exception;
            return false;
        }
    }

    /**
     * @return Exception|null
     */
    public function error(): ?Exception
    {
        return $this->error;
    }

}