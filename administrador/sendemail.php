<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'models/dbmatricula.php';
require 'libreria/PHPMailer/Exception.php';
require 'libreria/PHPMailer/PHPMailer.php';
require 'libreria/PHPMailer/SMTP.php';
require 'models/conexion.php';

    $mail = new PHPMailer(true);
    
    try {
        // Configurar el servidor de correo
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tu correo';
        $mail->Password = 'tu contraseña';
        $mail->SMTPSecure = 'tls'; // Puedes cambiarlo a 'ssl' si es necesario
        $mail->Port = 587;
    
        // Configurar el correo
        $mail->setFrom('tu correo', 'tu nombre');
        $mail->addAddress('correo a donde quiere mandar');
        $mail->Subject = 'Confirmación de matrícula';
        $mail->Body = 'lo que quieras decir';
    
        // Enviar el correo
        $mail->send();
        $mensaje = 'Mensaje enviado correctamente';
        echo "<script>alert('$mensaje');window.location.href='../email.php';</script>";
    } catch (Exception $e) {
        $mensaje = 'No se ha podido enviar el mensaje. Error: ' . $mail->ErrorInfo;
        echo "<script>alert('$mensaje');window.location.href='../email.php';</script>";
    }
?>
