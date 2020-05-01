<?php

	//importando arquivos da biblioteca PHPMailer
	require "./bibliotecas/PHPMailer/Exception.php";
	require "./bibliotecas/PHPMailer/OAuth.php";
	require "./bibliotecas/PHPMailer/PHPMailer.php";
	require "./bibliotecas/PHPMailer/POP3.php";//protocolo de recebimento de e-mail
	require "./bibliotecas/PHPMailer/SMTP.php";//protocolo de envio de e-mail


	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	class Mensagem{
		private $para=null;
		private $assunto = null;
		private $mensagem = null;

		
		public function __get($atr){
			return $this->$atr;
		}
		

		public function __set($atr, $valor){
			$this->$atr = $valor;
		}


		public function mensagemValida(){
			if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)){
				return false;
			}
			return true;
		}

	}//fim classe

	$msg = new Mensagem();

	$msg -> __set('para', $_POST['para']);
	$msg -> __set('assunto', $_POST['assunto']);
	$msg -> __set('mensagem',$_POST['mensagem']);

	//print_r($msg);

	if(!$msg->mensagemValida()){
		echo "mensagem invalida";
		die();//mata a execução deste ponto em diante
	}
	

	$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com ';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'development89test@gmail.com';                     // SMTP username
    $mail->Password   = 'deve2020';                               // SMTP password
    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('development89test@gamil.com', 'Wanderson Teixeira');
    $mail->addAddress('wandersonh89@gmail.com', 'Joe User');     // Add a recipient
   // $mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information'); e-mail padrão para resposta
    //$mail->addCC('cc@example.com');  destinatarios em copia
    //$mail->addBCC('bcc@example.com');

    // Attachments -- adicionar anexos
  //  $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'oi';//$assunto;
    $mail->Body    = 'corpo da mensagem de <strong>email</strong>';//$mensagem;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; -- para emails que não suportão html

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Não foi  possivel enviar este e-mail! Por favor tente novamente mais tarde";
    echo '<br>Detalhes do erro:<br>'.$e->errorMessage();
    
}


?>