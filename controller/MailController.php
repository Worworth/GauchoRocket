<?php
use PHPMailer\PHPMailer\PHPMailer;

class MailController
{
  private $mail;

  public function __construct()
  {
  }

  public function enviarMail($destinatario, $user, $validar)
  {
    $url = "http://localhost:8080/login/activarLogin/?codigo=".urlencode($validar);
    //Crear una instancia de PHPMailer
    $mail = new PHPMailer();
    //Definir que vamos a usar SMTP
    $mail->IsSMTP();
    //Esto es para activar el modo depuración. En entorno de pruebas lo mejor es 2, en producción siempre 0
    // 0 = off (producción)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug  = 0;
    //Ahora definimos gmail como servidor que aloja nuestro SMTP
    $mail->Host       = 'smtp.gmail.com';
    //El puerto será el 587 ya que usamos encriptación TLS
    $mail->Port       = 587;
    //Definmos la seguridad como TLS
    $mail->SMTPSecure = 'tls';
    //Tenemos que usar gmail autenticados, así que esto a TRUE
    $mail->SMTPAuth   = true;
    //Definimos la cuenta que vamos a usar. Dirección completa de la misma
    $mail->Username   = "gauchorocketviajes@gmail.com";
    //Introducimos nuestra contraseña de gmail
    $mail->Password   = "asdfg123456.";
    //Definimos el remitente (dirección y, opcionalmente, nombre)
    $mail->SetFrom('gauchorocketviajes@gmail.com', 'GauchoRocket');
    //Y, ahora sí, definimos el destinatario (dirección y, opcionalmente, nombre)
    $mail->AddAddress($destinatario, $user);
    //Definimos el tema del email
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Codigo Activacion: Gaucho Rocket SA';
    //Para enviar un correo formateado en HTML lo cargamos con la siguiente función. Si no, puedes meterle directamente una cadena de texto.
    //$mail->MsgHTML(file_get_contents('correomaquetado.html'), dirname(ruta_al_archivo));
    //Y por si nos bloquean el contenido HTML (algunos correos lo hacen por seguridad) una versión alternativa en texto plano (también será válida para lectores de pantalla)
    //$mail->Body =
    $cuerpo = '<html>
    </head>
    <title>Validacion de cuenta</title>
    </head>
    <body>
    <p>Hola que tal, nos da gusto que nos elijas para viajar al espacio. Sin duda no te arrepentiras.</p>
    <p>Ya casi acompletas tu registro, solo falta validar tu cuenta. <br>
    Para ello solo sigue el siguiente enlace: <a href="'.$url.'">Validar cuenta</a></p>
    <br>
    <p> En caso de no funcionar el link, ingrese el siguiente codigo para poder verificar su cuenta:<b>'.$validar.'</b> </p>
    </body>
    </html>';
    $mail->Body = $cuerpo;
    if(!$mail->Send()) {
    echo "Error: " . $mail->ErrorInfo;
    } else {
    echo "Enviado!";
    }
    //Enviamos el correo
  }

  public function enviarTurnoMedico($destinatario, $nombre_paciente, $lugar, $fecha, $nivelVuelo)
  {
    //Crear una instancia de PHPMailer
    $mail = new PHPMailer();
    //Definir que vamos a usar SMTP
    $mail->IsSMTP();
    //Esto es para activar el modo depuración. En entorno de pruebas lo mejor es 2, en producción siempre 0
    // 0 = off (producción)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug  = 0;
    //Ahora definimos gmail como servidor que aloja nuestro SMTP
    $mail->Host       = 'smtp.gmail.com';
    //El puerto será el 587 ya que usamos encriptación TLS
    $mail->Port       = 587;
    //Definmos la seguridad como TLS
    $mail->SMTPSecure = 'tls';
    //Tenemos que usar gmail autenticados, así que esto a TRUE
    $mail->SMTPAuth   = true;
    //Definimos la cuenta que vamos a usar. Dirección completa de la misma
    $mail->Username   = "gauchorocketviajes@gmail.com";
    //Introducimos nuestra contraseña de gmail
    $mail->Password   = "asdfg123456.";
    //Definimos el remitente (dirección y, opcionalmente, nombre)
    $mail->SetFrom('gauchorocketviajes@gmail.com', 'GauchoRocket');
    //Y, ahora sí, definimos el destinatario (dirección y, opcionalmente, nombre)
    $mail->AddAddress($destinatario, $nombre_paciente);
    //Definimos el tema del email
    $mail->isHTML(true);// Set email format to HTML
    $mail->Subject = 'Sus datos de Turno medico';
    //Para enviar un correo formateado en HTML lo cargamos con la siguiente función. Si no, puedes meterle directamente una cadena de texto.
    //$mail->MsgHTML(file_get_contents('correomaquetado.html'), dirname(ruta_al_archivo));
    //Y por si nos bloquean el contenido HTML (algunos correos lo hacen por seguridad) una versión alternativa en texto plano (también será válida para lectores de pantalla)
    $mail->Body = "Estimado/a $nombre_paciente, <br> usted tiene turno para el $fecha en el centro de $lugar. El resultado de su chequeo medico ha dado $nivelVuelo";
    if (!$mail->Send()) {
      echo "Error: " . $mail->ErrorInfo;
    } else {
      echo "Enviado!";
    }
  }
}
