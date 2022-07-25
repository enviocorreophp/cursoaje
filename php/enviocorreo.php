<?php
//Importamos la configuracion de nuestro sitio
require_once './config.php';
//Importamos todo lo necesario para que funcione la libreria de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './PHPMailer/Exception.php';
require './PHPMailer/PHPMailer.php';
require './PHPMailer/SMTP.php';

//Ya podemos hacer uso de la libreria

function enviarCorreo($user,$email,$verificacion){
    //Esta funcion envia un correo al usuario $user con correo $email
    //en el que se le saluda y ademas se le da un enlace para verificacion
    // del correo electronico
    //si todo es correcto devulve true y si falla algo devuelve false

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;      //DEBUG_OFF para que no muestre nada                //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'envios.correos.php@gmail.com';                     //SMTP username
        $mail->Password   = 'jauntzwakiitsbyk';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        //Desde donde sale el correo
        $mail->setFrom('noresponder@jcnsystem.com', 'Docencia');
        //Configuramos la cuenta a la que se va a enviar el correo
        $mail->addAddress($email, $user);     //Add a recipient
        //$mail->addAddress('ellen@example.com');               //Name is optional
        //Cuando en el cliente de correo se le da a responder enviara la respuesta a este correo
        $mail->addReplyTo('noresponder@jcnsystem.com', 'Docencia');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        //Asunto
        $mail->Subject = 'Bienvenido a www.miSitio.com';
        //Cuerpo con HTML
        $mail->Body    = "
        <div style='background-color: blue'>
            <h1 style='color:white; text-align:center'>Bienvenido a www-miSitio.com</h1>
        </div>
        <div>
            <p>Gracias $user por registrarte en nuestra super plataforma en la vamos a 
            ponerte publicidad hasta que te canses</p>
            <p>Para poder completar el resgistro en nuestra pagina debes de activar
            tu enta y para ellos pincha en el siguiente enlace</p>
            <p style='text-align:center'><a href='".SITE."php/validar.php?u=$verificacion'>Activación de Cuenta</a></p>

        </div>
        <div style='background-color: blue'>
        <p style='color:white; text-align:center'>miSitio.com &copy; 2022</p>
        </div>
        
        ";
        //Cuerpo sin HTML
        $mail->AltBody = 'Texto pero para el caso de que no funcione HTML en el cliente de correo';

        $mail->send();
        //echo 'Message has been sent';
        return true;
    } catch (Exception $e) {
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }

}
?>