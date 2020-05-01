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
		public $status = array('codigo_status'=>null, 'descricao_status'=>'');

		
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
		header('Location:index.php');//evita acesso direto ao arquivo processa_envio.php
		alert('Verifique a existência de campos vazios');

	}
	

	$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = false;// exibir log passo a passo de envio de emailSMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'development89test@gmail.com';                     // SMTP username
    $mail->Password   = 'deve2020';                               // SMTP password
    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('development89test@gamil.com', 'Wanderson Teixeira');
    $mail->addAddress($msg->__get('para'));     // Add a recipient
   // $mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information'); e-mail padrão para resposta
    //$mail->addCC('cc@example.com');  destinatarios em copia
    //$mail->addBCC('bcc@example.com');

    // Attachments -- adicionar anexos
  //  $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $msg->__get('assunto');
    $mail->Body    = $msg->__get('mensagem');
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; -- para emails que não suportão html

    $mail->send();
    $msg ->status['codigo_status'] = 1;
    $msg ->status['descricao_status'] = '<h3 style="color:green;">Email enviado!</h3>';
   
} catch (Exception $e) {
	 $msg ->status['codigo_status'] = 2;
	 $temp = $e->errorMessage();
    $msg ->status['descricao_status'] = '<h3 style="color:red;">Não foi  possivel enviar este e-mail! Por favor tente novamente mais tarde!</h3><br>Detalhes do erro:<br>'.$temp;
        
    
}


?>

<<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8" />
    	<title>App Mail Send</title>

    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>

	<div class="container">
		<div class="py-3 text-center">
				<img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
				<h2>Send Mail</h2>
				<p class="lead">Seu app de envio de e-mails particular!</p>
			</div>

			<div class="row">
				<div class="col-md-12">

					<? if($msg->status['codigo_status']==1){?>

						<div class="container">
							<h1 class="display-4 text-success">Sucesso!</h1>
							<p><?=$msg->status['descricao_status']?></p>
							<a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>

						</div>


					<?}?>
					<? if($msg->status['codigo_status']==2){?>
						<div class="container">
							<h1 class="display-4 text-danger">Ops!</h1>
							<p><?=$msg->status['descricao_status']?></p>
							<a href="index.php" class="btn btn-danger btn-lg mt-5 text-white">Voltar</a>

						</div>


					<?}?>
				</div>				
			</div>
		
	</div>
</body>
</html>