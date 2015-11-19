<?php namespace App\Email;
      /*
          NAMESPACE PARA ENVIAR EMAIL
      */
      $_SERVER["APP_NAME"] = isset($_SERVER["APP_NAME"]) ? $_SERVER["APP_NAME"] : "Syntex CRM";

      $_SERVER["EMAIL_HOST"] = isset($_SERVER["EMAIL_HOST"]) ? $_SERVER["EMAIL_HOST"] : "mail.bocetos.co";
      $_SERVER["EMAIL_USER"] = isset($_SERVER["EMAIL_USER"]) ? $_SERVER["EMAIL_USER"] : "email@bocetos.co";
      $_SERVER["EMAIL_PASS"] = isset($_SERVER["EMAIL_PASS"]) ? $_SERVER["EMAIL_PASS"] : "!8}W04BTw_4N";

      $nombre_desde = "Plataforma - ".$_SERVER["APP_NAME"];
      $host = $_SERVER["EMAIL_HOST"];
      $email = $_SERVER["EMAIL_USER"];
      $email_pass = $_SERVER["EMAIL_PASS"];

      require_once('lib/class.phpmailer.php');

      function generarContenidoHTML($nombre_destino, $contenido, $desde, $desdeEmail) {
              if($desde == "") $desde = $GLOBALS["nombre_desde"];
              if($desdeEmail == "") $desdeEmail = '<a href="mailto:soporte@progracol.com">Mesa de ayuda</a>';
              $email_html = '
              <html>
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
                </head>
                <body>
                  <div style="width:600px;font-family:arial;">
                    <div style="border-bottom:1px solid #eee;padding:14px 0;">
                      <img src="http://'.$_SERVER["HTTP_HOST"].'/server/api/App/email/logo.png" alt="">
                    </div>
                    <div style="padding:16px 0;">
                      <div>
                       '.$contenido.'
                      </div>
                      <br><br>
                      <br><br>
                      <table>
                        <tr>
                          <td style="padding:0 14px;border-right:1px solid #1d42a4;"><img src="http://bocetos.co/cartecrudo/recursos/img/no-img.png" alt="" style="border-radius:40px;"></td>
                          <td style="color:#888;font-size:13px;padding:0 14px;">
                            <strong>'.$desde.'</strong><br>
                            <span>'.$desdeEmail.'</span><br>
                            <span>Enviado '.date("c").'</span>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </body>
              </html>';
                return $email_html;
      }
      function enviar_email_prueba(){
          $mailTO = new \PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
          $mailTO->IsSMTP(); // telling the class to use SMTP
          //$mailTO->Host       = "mail.yourdomain.com"; // SMTP server
          $mailTO->SMTPDebug  = true;                 // enables SMTP debug information (for testing)
          $mailTO->SMTPAuth   = true;                  // enable SMTP authentication
          $mailTO->SMTPSecure = "tls";                 // sets the prefix to the servier
          $mailTO->Host       = $GLOBALS["host"];      // sets GMAIL as the SMTP server
          $mailTO->Port       = 25;                   // set the SMTP port for the GMAIL server
          $mailTO->Username   = $GLOBALS["email"];  // GMAIL username
          $mailTO->Password   = $GLOBALS["email_pass"];            // GMAIL password
          $mailTO->AddBCC($GLOBALS["email"], $GLOBALS["nombre_desde"]);
          $mailTO->CharSet = 'UTF-8';
        try {
          $mailTO->AddReplyTo($GLOBALS["email"], $GLOBALS["nombre_desde"]);
          $mailTO->SetFrom($GLOBALS["email"], $GLOBALS["nombre_desde"]);
          $mailTO->AddAddress("michaelrojas@progracol.com", "Michael Rojas");
          $mailTO->Subject = "Prueba de servicio de correo ". date("c");
          $mailTO->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
          $mailTO->MsgHTML("ESTA ES UNA PRUEBA BIEN ;) ");
          return $mailTO->Send();
        } catch (phpmailerException $e) {
          return $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
          return $e->getMessage(); //Boring error messages from anything else!
        }
      }
      function enviar_email_to($contenido, $para = array() , $from,  $file, $subject){

          /*
            contenido : Pequño contenido html del cuerpo del mensaje
            para: array[nombre, email]
            to: array[nombre,email]
            file: array[url_file]
            sujeto: texto con el sujeto final
          */
          $mailTO = new \PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
          $mailTO->IsSMTP(); // telling the class to use SMTP
          //CONFIGURACION GENERAL
          $mailTO->SMTPDebug  = false;                 // enables SMTP debug information (for testing)
          $mailTO->SMTPAuth   = true;                  // enable SMTP authentication
          $mailTO->SMTPSecure = "tls";                 // sets the prefix to the servier
          $mailTO->Host       = $GLOBALS["host"];      // sets GMAIL as the SMTP server
          $mailTO->Port       = 25;                   // set the SMTP port for the GMAIL server
          $mailTO->Username   = $GLOBALS["email"];  // GMAIL username
          $mailTO->Password   = $GLOBALS["email_pass"];            // GMAIL password
          $mailTO->AddBCC($GLOBALS["email"], $GLOBALS["nombre_desde"]);
          $mailTO->CharSet = 'UTF-8';
        try {
          //mailTO->SetFrom($GLOBALS["email"], $GLOBALS["nombre_desde"]); //SIEMPRE EL MISMO
          $mailTO->SetFrom($from["email"], $from["nombre"]);
          $mailTO->AddReplyTo($from["email"], $from["nombre"]);

          if(count($para) > 0){
            //AGREGAR DESTINATARIOS
            foreach ($para as $key => $value) {
              $mailTO->AddAddress($value["email"], $value["nombre"]);
            }
          } else {
            return false;
          }

          if(count($file) > 0 ){
            //ADJUNTAR ARCHIVOS
            foreach ($file as $key => $value) {
              $mailTO->AddAttachment($value["url"]);
            }
          }

          $mailTO->Subject = $subject;

          $mailTO->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically

          $mailTO->MsgHTML(generarContenidoHTML($para[0]["nombre"], $contenido, $from["nombre"] ,$from["email"]));

          return $mailTO->Send();

        } catch (phpmailerException $e) {
          return $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
          return $e->getMessage(); //Boring error messages from anything else!
        }
      }
?>
