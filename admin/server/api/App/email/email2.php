<?php 
require '/AppBD/app/public_html/assets/server/conexion.php';
use App\DB as Database;  
//FUNCIONES PARAR GENERAR NUEVA TAREA
function update_email_send($id_pdt){  
   $conexion = Database\conectar();
   $sql="UPDATE ecp_documento_actividad_pdt SET email_send = 1 WHERE id_pdt = :id_pdt";
   $queryList = $conexion->prepare($sql);
   $queryList->bindParam("id_pdt", $id_pdt  , \PDO::PARAM_STR);
   $queryList->execute();
}
function complete_pdt($actividad, $frecuencia, $repetir, $doc, $elaboro,$time){

    if ($frecuencia == "D" && $repetir == "1") {
      //pdt_complete_task($id); //Cerar tarea actual
        $next_time = $time+(60*60*24);
        $fecha_next = date('Y-m-d', $next_time);
      pdt_new_task($actividad, $doc, $fecha_next, $elaboro); //Crear nueva tarea
      $salida["info"] = true;
      echo date("Y-m-d H:i:s")." CREADA ACTIVIDAD DIARIA ".$fecha_next."\n \t <br>";
    }
    if ($frecuencia == "S" && $repetir == "1") {
      //pdt_complete_task($id); //Cerar tarea actual
        $next_time = $time+(60*60*24*7);
        $fecha_next = date('Y-m-d', $next_time);
      pdt_new_task($actividad, $doc, $fecha_next, $elaboro); //Crear nueva tarea
      $salida["info"] = true;
      echo date("Y-m-d H:i:s")." CREADA ACTIVIDAD SEMANAL ".$fecha_next."\n \t <br>";
    }
    if ($frecuencia == "M" && $repetir == "1") {
      //pdt_complete_task($id); //Cerar tarea actual
        $next_time = $time+(60*60*24*30);
        $fecha_next = date('Y-m-d', $next_time);
      pdt_new_task($actividad, $doc, $fecha_next, $elaboro); //Crear nueva tarea
      $salida["info"] = true;
      echo date("Y-m-d H:i:s")." CREADA ACTIVIDAD MENSUAL ".$fecha_next."\n \t <br>";
    }
    if ($frecuencia == "A" && $repetir == "1") {
      //pdt_complete_task($id); //Cerar tarea actual
        $next_time = $time+(60*60*24*365);
        $fecha_next = date('Y-m-d', $next_time);
      pdt_new_task($actividad, $doc, $fecha_next, $elaboro); //Crear nueva tarea
      $salida["info"] = true;
      echo date("Y-m-d H:i:s")." CREADA ACTIVIDAD ANUAL ".$fecha_next."\n \t <br>";
    }
    return json_encode($salida);
    //return 1;
  }

function pdt_new_task($id, $id_doc, $fecha_next, $elaboro){
    $conexion = Database\conectar();
    $sql="INSERT INTO ecp_documento_actividad_pdt (id_actividad, id_documento_version, fecha_programacion, id_elaboro) VALUES (:id_actividad, :id_documento_version, :fecha_programacion, :id_elaboro)";
    $queryList = $conexion->prepare($sql);
    $queryList->bindParam("id_actividad", $id  , \PDO::PARAM_STR);
    $queryList->bindParam("id_documento_version", $id_doc, \PDO::PARAM_STR);
    $queryList->bindParam("fecha_programacion", $fecha_next  , \PDO::PARAM_STR);
    $queryList->bindParam("id_elaboro", $elaboro  , \PDO::PARAM_STR);
    $queryList->execute();
  }
//GENERADOR DE HTML
function generarContenidoHTML($titulo, $nombre_destino, $contenido) {
  $email_html = '        <html>
          <head>
            <meta charset="UTF-8" />
            <title></title>
          </head>
          <style type="text/css">
            body {
              margin: 0;
              padding: 0;
              font-family: Tahoma,Arial, Verdana, sans-serif;
              color: #595959;
              font-size: 16px;
              background-color: #7ea828;
            }
            .ecp_logo{
              float: right;
            }
            .conteiner{
              width: 550px;
              margin: 10px auto;
              padding: 15px;
              background-image: url("img_email/back.jpg");
              background-color: #FFF;
              background-repeat: no-repeat;
              height: auto;
              background-position: 78px 0;
              min-height: 530px;
              border: 2px solid #f7d800;
              border-radius: 10px;

            }
            h1 {
              display: inline-block;
              color: #00254C;
              margin:15px 0 0 0;
              padding: 0;
              width: 100%;
              font-size: 22px;
              font-weight: 300;
            }
            h2{
              padding: 0;
              font-size: 18px;
              font-weight: 300;
              color: #00254C
            }
            .footer{
              width: 550px;
              color: #000;
              bottom: 0;

            }
            .container_texto{
              min-height: 300px;
              max-width: 380px;
            }
            .text-left {
              display: inline-block;
              width: 262px;
              font-size: 12px;
              border-left: 3px #F7D800 solid;
              margin-left: 9px;
              padding-left: 16px;
              color: #727272;
            }

          </style>
          <body>
            <br><br>
            <table width="100%" border="0" cellspacing="0" cellpadding="20"  bgcolor="#7ea828" color="#595959">
              <table align="center" width="600px;" bgcolor="#FFF" border="0" cellpadding="7px" cellspacing="0px" background="img_email/back.jpg" style="background-repeat: no-repeat;border: 2px solid #f7d800;
              border-radius: 10px;"> 
                <tr>
                  <td><h1>Sistema Gestión PMA PDE <br> '.$titulo.'</h1><h2>Hola '.$nombre_destino.'</h2></td>
                </tr>
                <tr>
                  <td><div style="width: 400px;font-size: 15px;color: #000;font-weight: 100;text-align: left;">'.$contenido.'</div> </td>
                </tr>
                <tr>
                  <td >

                    <img src="img_email/logo.png" style="max-width: 200px;margin-top: 42px; display: inline-block;float: left;"> 
                     <br>
                     <div class="text-left" style="display: inline-block;width: 262px;font-size: 12px;border-left: 3px #F7D800 solid;margin-left: 9px;padding-left: 16px;color: #727272;">
                   <b>Nombre: </b> Gestion PMA PDE<br>
                    <b>Email: </b> <a href="mailto:soporte@progracol.com">Mesa de ayuda</a><br>
                    <b>Fecha de envio :</b>'.date("c").'<br>
                    Si encuentra este email en spam NO es correo malicioso por favor sáquelo de esta bandeja. 
                  </div>

                  </td>
                  
                </tr>
              </table>
               <table align="center" width="600px;" bgcolor="#7ea828" color="#595959" border="0" cellpadding="7px" cellspacing="0px">
                <tr style="color:#FFF; font-size: 11px;text-align: justify">
                  <td>

                    <p>Este mensaje y sus anexos está dirigido para ser usado por su(s) destinatario(s) exclusivamente y puede contener información confidencial y/o reservada protegida legalmente. Si usted no es el destinatario, se le notifica que cualquier distribución o reproducción del mismo, o de cualquiera de sus anexos, está estrictamente prohibida. Si usted ha recibido este mensaje por error, por favor notifíquenos inmediatamente y elimine su texto original, incluidos los anexos, o destruya cualquier reproducción del mismo. Las opiniones expresadas en este mensaje son responsabilidad exclusiva de quien las emite y no necesariamente reflejan la posición institucional de Ecopetrol S.A. ni comprometen la responsabilidad institucional por el uso que el destinatario haga de las mismas. Este mensaje ha sido verificado con software antivirus. En consecuencia, Ecopetrol S.A. no se hace responsable por la presencia en él, o en sus anexos, de algún virus que pueda generar daños en los equipos o programas del destinatario.</p>

                    <p>This e-mail, and any attachments thereto, is intended for use by the addressee(s) named herein only and may contain legally privileged and/or confidential information. If you are not the recipient of this e-mail, you are hereby notified that any distribution or copying of this e-mail, and any attachments thereto, is strictly prohibited. If you have received this e-mail in error, please notify us immediately, permanently delete the original including attachments, and destroy any copy or printout thereof. The opinions contained in this message are the sole responsibility of the individual person who gives them and do not either necessarily reflect the institutional policy of Ecopetrol S.A. on the subject, or involve corporate responsibility for any use of them by the addressee(s). This message has been checked with antivirus software; therefore, Ecopetrol S.A. is not liable for the presence of any virus in the message or in its attachments that causes or may cause damage to the recipients equipment or software.</p>

                  </td>
                </tr>
              </table>
            </table>
          </body>
          </html>';
          return $email_html;
}
function sendEmailOneDestini($to, $toName, $contenido, $sujeto){  
  require_once('/AppBD/app/public_html/assets/server/lib/class.phpmailer.php');
      //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
  $mailTO = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
  $mailTO->IsSMTP(); // telling the class to use SMTP
  //$mailTO->Host       = "mail.yourdomain.com"; // SMTP server
  $mailTO->SMTPDebug  = false;                 // enables SMTP debug information (for testing)
  $mailTO->SMTPAuth   = true;                  // enable SMTP authentication
  $mailTO->SMTPSecure = "tls";                 // sets the prefix to the servier
  $mailTO->Host       = "mail.gapmac.com";      // sets GMAIL as the SMTP server
  $mailTO->Port       = 25;                   // set the SMTP port for the GMAIL server
  $mailTO->Username   = "pmapde@gapmac.com" ;  // GMAIL username
  $mailTO->Password   = "!8}W04BTw_4N";            // GMAIL password
  $mailTO->AddBCC('pmapde@gapmac.com',"APP");
  $mailTO->CharSet = 'UTF-8';
  try {
    $mailTO->AddReplyTo('pmapde@gapmac.com', 'Plataforma de Gestión Ambiental en PMA y PDE');
    $mailTO->AddAddress($to, $toName);
    $mailTO->SetFrom('pmapde@gapmac.com', 'Plataforma de Gestión Ambiental en PMA y PDE');
    $mailTO->Subject = $sujeto;
    $mailTO->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically

  //  $mailTO = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

    $mailTO->MsgHTML(generarContenidoHTML("Fecha ".date("Y-m-d"), $toName ,$contenido));
    //$mailTO->AddAttachment('/AppBD/app/public_html/assets/server/img_email/back.jpg'); // attachment
    //$mailTO->AddAttachment('/AppBD/app/public_html/assets/server/img_email/logo.png'); // attachment
    
    $mailTO->Send();
    
    echo date("Y-m-d H:i:s")." EMAIL ENVIANDO CON EXITO ".$toName." y ".$to."\n \t <br>";
  } catch (phpmailerException $e) {
    echo $e->errorMessage(); //Pretty error messages from PHPMailer
  } catch (Exception $e) {
    echo date("Y-m-d H:i:s")."ERROR: ".$e->getMessage(); //Boring error messages from anything else!
  } 
}

$dia_de_la_semana = date("w");
//$dia_de_la_semana = "1";
if($dia_de_la_semana =="1"){

  $time_hoy = mktime(0,0,0, date("m"), date("d"), date("Y"));
  $fecha_domingo = $time_hoy - (60*60*24);
  $fecha_domingo = date("Y-m-d", $fecha_domingo);
  echo date("Y-m-d H:i:s")." INICO ANALISIS PARA DOMINGO(".$fecha_domingo.")\n \t <br>";
  evaluar_actividades($fecha_domingo); //DOMINGO
  $fecha_lunes = date("Y-m-d", $time_hoy);
  echo date("Y-m-d H:i:s")." INICO ANALISIS PARA LUNES(".$fecha_lunes.")\n \t <br>";
  evaluar_actividades($fecha_lunes); //LUNES
} else {
  $fecha = date("Y-m-d");
  echo date("Y-m-d H:i:s")." INICO ANALISIS PARA HOY(".$fecha.")\n \t <br>";
  evaluar_actividades($fecha);
}
function evaluar_actividades($fecha){
  $ftoday_exp = explode("-", $fecha);
  $time_fecha_today = mktime(0,0,0, $ftoday_exp[1], $ftoday_exp[2], $ftoday_exp[0]);
      //PARAMETRO 
      $SQL = "SELECT * FROM ecp_documento_actividad_pdt, ecp_user, ecp_documento_actividad WHERE
      ecp_documento_actividad.id_actividad = ecp_documento_actividad_pdt.id_actividad AND
      ecp_documento_actividad.id_elaboro = ecp_user.id_user AND fecha_programacion = :fecha ";
      $conexion = Database\conectar();
      $row = Database\query($SQL, array("fecha" => $fecha), $conexion);
      //EVALUAR SI ES LUNES Y HACER LA PREGUNTA DESDE PARA EL DOMIGO
      $actividades = array();

      //EVALUYACIPN
      if(count($row) > 0){
        echo date("Y-m-d H:i:s")." PARA HOY EXISTEN ACTIVIDADES\n \t <br>";
        //echo print_r($row);
        foreach ($row as $key => $value) {
          //REVISAR LA FRECUENCIA
          if($value["email_send"] == "0"){
          if($value["frecuencia"] != "NA"){

            echo date("Y-m-d H:i:s")." CREAR EL OTRO EVENTO ".$value["id_elaboro"]." : ".$value["frecuencia"]."\n \t <br>";
            //SI LA FRECUENCI CIA ES INFINITA CONTINUE
            if($value["hasta"] == "0"){
              echo date("Y-m-d H:i:s")." CREADA ACTIVIDAD  DEPEDIENDO DE HASTA INFINITO (".$value["hasta"].") ".$fecha_next."\n \t <br>";
              complete_pdt($value["id_actividad"], $value["frecuencia"], $value["repetir"], $value["id_documento_version"], $value["id_user"], $time_fecha_today);
            //SI LA SECUENCIA TIENE UN HASTA EVALUE SI CREAAMOS OTRO O NO ?
            } else {
              $fh = explode("-", $value["fecha_hasta"]);
              $time_hasta = mktime(0,0,0, $fh[1], $fh[2], $fh[0]);
              if(time() < $time_hasta){
                echo date("Y-m-d H:i:s")." CREADA ACTIVIDAD  DEPEDIENDO DE HASTA(".$value["hasta"].") VALIDO \n \t <br>";
                complete_pdt($value["id_actividad"], $value["frecuencia"], $value["repetir"], $value["id_documento_version"], $value["id_user"], $time_fecha_today);
              } else {
                //YA SUPERA EL HASTA YA PARA
                echo date("Y-m-d H:i:s")." NO SE CREA SUPERA FECHA HASTA (".$value["fecha_hasta"].") \n \t <br>";
              }
            }
          }
            $actividades["user_".$value["id_user"]]["NOMBRE"] = $value["nombre"]." ".$value["apellido"];
            $actividades["user_".$value["id_user"]]["EMAIL"] = $value["email"];
            $actividades["user_".$value["id_user"]]["ACTIVIDAD"][$key] = $value["tarea"];
            update_email_send($value["id_pdt"]);
          } else {
                echo date("Y-m-d H:i:s")." NO SE ENVIA PDT POR QUE YA FUE ENVIADO (".$value["fecha_programacion"].") \n \t <br>";
          }
          
        }
        if(count($actividades) > 0 ){
          foreach ($actividades as $key => $value) {
              //echo print_r($actividades);
              $nombre = $value["NOMBRE"];
              $mail = $value["EMAIL"];
              echo date("Y-m-d H:i:s")." PREPARANDO CORREO PARA ".$nombre." y ".$mail."\n \t <br>";
              //echo print_r($value["ACTIVIDAD"]);
              $acts = "";
              foreach ($value["ACTIVIDAD"] as $key => $act) {
                  $acts .= "<li>".$act."</li>";
              }
              $contenido_final = '<p>Esta(s) son las actividades para hoy:</p><ul>'.$acts.'</ul>';
              //echo generarContenidoHTML("Fecha ".date("Y-m-d"), $nombre ,$contenido_final);
              $sujeto = "Actividades plataforma PMA PDE para el ".$fecha;
              sendEmailOneDestini($mail, $nombre, $contenido_final, $sujeto);
              
              // ENVIAR EMAIL
              echo date("Y-m-d H:i:s")." -------------- NEXT ------------ \n \t <br> ";
          }
          } else {
            echo date("Y-m-d H:i:s")." NO EXISTE NINGUAN ACTIVIDAD PARA HOY\n \t <br>";
          }
        }
}
  



    
?>