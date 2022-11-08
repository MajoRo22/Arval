<?php
	// echo print_r( $_POST ); die;
	
	try 
	{
		//throw new Exception('Exception message');
	
		header("Content-type: text/html;charset=\"utf-8\"");
		//$error = ""; $mensajeExito = "";

		if( $_POST ) 
		{
			//
			// Email
			if( $_POST['Email'] && filter_var( $_POST["Email"], FILTER_VALIDATE_EMAIL) === false ) 
			{			
				//$error .= "E-mail no válido.<br>";  
				$responseArrayFailEmailInvalid 
				= 
				array
				( 
					"responseSuccess" => false
					, "responseMessage" => "E-mail no válido." 
				);
				$responseJsonFailEmailInvalid = json_encode( $responseArrayFailEmailInvalid );					
				echo $responseJsonFailEmailInvalid;
				die();			
			}			
			//
			// Recaptchav3
			
			//
			// Recaptchav3 Validate Captcha Token
			if( !isset( $_POST[ 'token' ] ) )
			{
				$captchaResponseStringArrayFailToken = array( "responseSuccess" => false, "responseMessage" => "Error captcha post" );
				$captchaResponseStringJsonFailToken = json_encode( $captchaResponseStringArrayFailToken );
				echo $captchaResponseStringJsonFailToken;
				die();
			}
			//
			// cambiar clave secreta
			define( 'CAPTCHASECRETKEY', '6LegspciAAAAAJ0H9pfAsHwOHv83sa-Y1OWZuRgh' );
			//
			// Recaptchav3 Get Post
			$captchaToken = $_POST[ 'token' ];
			$action = $_POST[ 'action' ];
			/*
			echo "token<br/>";
			print_r( $token );
			echo "<br/>";
			echo "action<br/>";
			print_r( $action );
			echo "<br/>";
			//*/
			//
			// Recaptchav3 Call Google
			$captchaCurl = curl_init();
			curl_setopt( $captchaCurl, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
			curl_setopt( $captchaCurl, CURLOPT_POST, 1 );
			curl_setopt( $captchaCurl, CURLOPT_POSTFIELDS, http_build_query( array( 'secret' => CAPTCHASECRETKEY, 'response' => $captchaToken ) ) );
			curl_setopt( $captchaCurl, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $captchaCurl, CURLOPT_SSL_VERIFYPEER, false );
			
			//https://stackoverflow.com/questions/15135834/php-curl-curlopt-ssl-verifypeer-ignored
			curl_setopt( $captchaCurl, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt( $captchaCurl, CURLOPT_SSL_VERIFYPEER, false );	
			
			$captchaResponseString = curl_exec( $captchaCurl );

			curl_close( $captchaCurl );
			//
			// Recaptchav3 Dump captchaResponseString
			//print_r( $captchaResponseString ); die();
			/*
			echo "1<br/>";
			echo "captchaResponseString=" . "\"" . $captchaResponseString . "\"";
			echo "<br/>";	
			print_r( $captchaResponseString );
			echo "2<br/>";	
			//*/
			//
			// Recaptchav3 get JSON
			$captchaResponseJson = json_decode( $captchaResponseString, true );
			//print_r( $captchaResponseJson );
			//
			// Recaptchav3 Validate
			$captchaResponseJsonSuccess = 0;
			if( isset( $captchaResponseJson[ 'success' ] ) )
			{
				$captchaResponseJsonSuccess = $captchaResponseJson[ 'success' ];
			}
			
			$captchaResponseJsonScore = 0.00;
			if( isset( $captchaResponseJson[ 'score' ] ) )
			{
				$captchaResponseJsonScore = $captchaResponseJson[ 'score' ];
			}
			//$captchaResponseJsonScore = 0.10;
			//$captchaResponseJsonSuccess = 0;
			
			$captchaResponseJsonHostName = "";
			if( isset( $captchaResponseJson[ 'hostname' ] ) )
			{
				$captchaResponseJsonHostName = $captchaResponseJson[ 'hostname' ];
			}
			
			$captchaResponseJsonAction = "";
			if( isset( $captchaResponseJson[ 'action' ] ) )
			{
				$captchaResponseJsonAction = $captchaResponseJson[ 'action' ];
			}				
				
			// print_r( $captchaResponseJson );
			//echo "captchaResponseJsonSuccess=" . $captchaResponseJsonSuccess . "<br/>";
			//echo "captchaResponseJsonScore=" . $captchaResponseJsonScore . "<br/>";
			///*
			if( $captchaResponseJsonSuccess == 0 || $captchaResponseJsonScore < 0.50 )
			{					
				$captchaResponseStringArrayFail 
				= 
				array
				( 
					"responseSuccess" => false
					, "responseMessage" => "captcha no válido" 
					, "captchaResponseJsonSuccess" => $captchaResponseJsonSuccess 
					, "captchaResponseJsonScore" => $captchaResponseJsonScore 		
					, "captchaResponseJsonHostName" => $captchaResponseJsonHostName 
					, "captchaResponseJsonAction" => $captchaResponseJsonAction 						
				);
				$captchaResponseStringJsonFail = json_encode( $captchaResponseStringArrayFail);
				echo $captchaResponseStringJsonFail;
				die();
			}
			// Recaptchav3

			 
			$language = $_POST[ 'language' ];
									
            $name = $_POST['Name'];
            $mail = $_POST['Email'];
            $phone = $_POST['Phone'];
            $mensajeC = $_POST['MensajeC'];
						
            //$header = 'From: ' . $name . " \r\n";
			$header = 'From: ' . "formularios@arval.tech". " \r\n";
            $header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
            $header .= "Mime-Version: 1.0 \r\n";
            // $header .= "Content-Type: text/plain";
           $header .= "Content-type: text/html; charset: utf8\r\n";
            
            
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
                <p style='font-size: 15px; color: #00005b;padding-left:50px;'> Recibiste un email de: " . $name ." . \r\n;</p>
                <p style='font-size: 15px; color: #00005b;padding-left:50px;'> El email es: " . $mail . ", \r\n  </p>
                <p style='font-size: 15px; color: #00005b;padding-left:50px;'> El numero de telefono es: " . $phone . ". \r\n \r\n </p>
                <p style='font-size: 15px; color: #00005b;padding-left:50px;'> Mensaje: " . $mensajeC . " \r\n </p>
                 </body>
            </html>";

            
            $mensaje .= "Enviado en: " . date('F j,Y', time());
            $para = 'info@pentass.com';
            $asunto ='Este mensaje fue enviado por Arval.';		
			
			//if(0)		
			if( mail( $para, $asunto, utf8_decode( $mensaje ), $header, '-f formularios@arval.tech'  ) ) 
			{
				//$mensajeExito = '<div class="alert alert-success" role="alert"><p><strong>Mensaje enviado con éxito :)</strong></p></div>';   
				$responseArraySuccess 
				= 
				array
				( 
					"responseSuccess" => true
					, "responseMessage" => "Mensaje enviado con éxito! :)" 
					, "captchaResponseJsonSuccess" => $captchaResponseJsonSuccess 
					, "captchaResponseJsonScore" => $captchaResponseJsonScore	
					, "captchaResponseJsonHostName" => $captchaResponseJsonHostName 
					, "captchaResponseJsonAction" => $captchaResponseJsonAction 					
				);
				$responseJsonSuccess = json_encode( $responseArraySuccess );
				echo $responseJsonSuccess;
				die();				
			} 
			
			//$error = '<div class="alert alert-danger" role="alert"><p><strong>Mensaje sin enviar :(</strong></p></div>';  
			$responseArrayFail 
			= 
			array
			( 
				"responseSuccess" => false
				, "responseMessage" => "Mensaje sin enviar :(" 
				, "captchaResponseJsonSuccess" => $captchaResponseJsonSuccess 
				, "captchaResponseJsonScore" => $captchaResponseJsonScore	
				, "captchaResponseJsonHostName" => $captchaResponseJsonHostName 
				, "captchaResponseJsonAction" => $captchaResponseJsonAction 				
			);
			$responseJsonFail = json_encode( $responseArrayFail );
			echo $responseJsonFail;
			die();			
		}
	} 
	catch( Exception $e ) 
	{
		$message = "Excepción capturada=".$e->getMessage();
		$responseArrayFail = array( "responseSuccess" => false, "responseMessage" => $message );
		$responseJsonFail = json_encode( $responseArrayFail );
		echo $responseJsonFail;
		die();		
	}
?>



