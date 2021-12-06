<?php

class LoginController
{
  private $loginModel;
  private $printer;
  private $mail;

  public function __construct($mail, $loginModel, $logger, $printer)
  {
    $this->loginModel = $loginModel;
    $this->log = $logger;
    $this->mail = $mail;
    $this->printer = $printer;
  }

  public function show()
  {
   
    echo $this->printer->render("view/validarView.html");
  }

  function procesarLogin()
  {
    if (!empty($_POST["usuario"]) && !empty($_POST["password"])) {

      $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);
      $validar = password_hash('rasmuslerdorf', PASSWORD_DEFAULT);
      $email = $_POST["email"];
      $tipoRol = 2;
      $this->loginModel->insertarLogin($_POST["email"], $_POST["usuario"], $pass, $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $tipoRol);
      $this->loginModel->insertarLoginSesion($email, $validar);
      $this->mail->enviarMail($email, $_POST["usuario"], $validar);
      echo $this->printer->render("view/loginView2.html");

    } else {
      echo "usuario no registrado";
    }
  }

  public function activarLogin()
  {
    $valor = $_GET["codigo"];
    $this->loginModel->borrar($valor);
    header("location:/login");
    exit;
  }
}
