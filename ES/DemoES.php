<?php
     header("Content-Type: text/html; charset=ISO-8859-1\r\n");
    //header("Content-type: text/html;charset=\"utf-8\"");
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
          //  $header .= "Content-Type: text/plain";
            $header .="Content-Type: text/html; charset=ISO-8859-1\r\n";
            
          /*  $mensaje .= "You received an email from: " . $name . ". \r\n";
            $mensaje .= "The e-mail is: " . $mail . ", \r\n";
            $mensaje .= "and the contact telephone number is: " . $phone . ". \r\n";
            $mensaje .= "Message: " . $mensajeC . ". \r\n";*/


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
                <p style='font-size: 15px; color: #00005b;padding-left:50px;'> You received an email from: " . $name ." . \r\n;</p>
                <p style='font-size: 15px; color: #00005b;padding-left:50px;'> The e-mail is: " . $mail . ", \r\n  </p>
                <p style='font-size: 15px; color: #00005b;padding-left:50px;'> and the contact telephone number is: " . $phone . ". \r\n \r\n </p>
                <p style='font-size: 15px; color: #00005b;padding-left:50px;'> Message: " . $mensajeC . " \r\n </p>
                 </body>
            </html>";

            
            $mensaje .= "Sent in : " . date('F j,Y', time());

            $para = 'descalsmaria@hotmail.com';
            $asunto = 'Solicito mi demo de Arval';

            
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
            
				 window.location='indexES.html';
				               
    </script>";
?>