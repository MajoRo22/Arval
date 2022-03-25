<?php
    header("Content-Type: text/html; charset=ISO-8859-1\r\n");
    $error = ""; $mensajeExito = "";

    if ($_POST) {
        if ($_POST['Email'] && filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL) === false) {
            $error .= "E-mail no válido.<br>";   
        }
        if ($error != "") {
            $error = '<div class="alert alert-danger" role="alert"><p><b>Se generó un error:</b></p>' . $error . '</div>';
        } else {
            $name = $_POST['Name'];
            $mail = $_POST['Email'];
            $phone = $_POST['Phone'];
            $mensajeC = $_POST['MensajeC'];
            
            $header = 'From: ' . $mail . " \r\n";
            $header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
            $header .= "Mime-Version: 1.0 \r\n";
            $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            

            $mensaje = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <title>Document</title>
            </head>
            <body>
            <img src = «» />
           
            <div style='margin-left:20px;'>
                <p style='font-size: 15px; color: #00005b;padding-left:50px;'> Usted recibió un correo de: " . $name . ". \r\n;</p>
                <p style='font-size: 15px; color: #00005b;padding-left:50px;'> Su e-mail es: " . $mail . ", \r\n </p>
                <p style='font-size: 15px; color: #00005b;padding-left:50px;'>Su teléfono de contacto es: " . $phone . " \r\n </p>
                <p style='font-size: 15px; color: #00005b;padding-left:50px;'>El comentario del usuario: " . $mensajeC . " \r\n </p>
                 </body>
            </html>";


            
            $mensaje .= "Enviado el " . date('d/m/Y', time());

            $para = 'descalsmaria@hotmail.com';
            $asunto = 'Mensaje de Arval';

            
        if (mail($para, $asunto, utf8_decode($mensaje), $header)) {
                $mensajeExito = '<div class="alert alert-success" role="alert"><p><strong>Mensaje enviado con éxito :)</strong></p></div>';    
            } else {
                $error = '<div class="alert alert-danger" role="alert"><p><strong>Mensaje sin enviar :(</strong></p></div>';  
            } 
			
		
		}  
    }





?>


<?php 
     echo "<script>
            
     window.location='indexES.html#contact';
				               
    </script>";
?>
