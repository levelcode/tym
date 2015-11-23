<?php 
	function generarContenidoHTML($titulo, $nombre_destino, $contenido) {
	  $email_html = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Ecopetrol Email</title>
</head>

<body style="background-color: #083b1a; font-size: 9px;">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th bgcolor="#083b1a" scope="row"><table width="650" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <th colspan="2" align="left" bgcolor="#FFFFFF" scope="row"><h1 style="font-size:20px;color:#063"><img src="back_2.jpg" width="650" height="150"></h1></th>
      </tr>
      <tr>
        <th colspan="2" align="left" bgcolor="#FFFFFF" scope="row"><h2 style="font-size:18px;color:#083b1a">'.$titulo.'</h2></th>
      </tr>
      <tr>
        <th colspan="2" align="left" bgcolor="#FFFFFF" scope="row">'.$contenido.'</th>
      </tr>
      <tr align="left"> 
        <th width="325" bgcolor="#FFFFFF" scope="row"><img src="logo.png" style="max-width: 200px;margin-top: 42px; display: inline-block;float: left;"> </th>
        <th width="315" bgcolor="#FFFFFF" scope="row"><b>Nombre:  </b> '.$desde.'<br>
                    <b>Email: </b> '.$desdeEmail.' <br>
                    <b>Fecha de envio :</b>'.date("c").'<br>
          Si encuentra este email en spam NO es correo malicioso por favor sáquelo de esta bandeja.</th>
      </tr>
    </table></th>
  </tr>
</table>
</body>
</html>';
	          return $email_html;
	}
	require_once('../lib/class.phpmailer.php');
	  $to = "michaelrojasbeltran@gmail.com";
	  $toName = "Michael Rojas";
	  $sujeto = "Prueba email ".date("c");
	  $contenido = 'En un lugar de la Mancha, de cuyo nombre no quiero acordarme, no ha mucho tiempo que vivía un hidalgo de los de lanza en astillero, adarga antigua, rocín flaco y galgo corredor. Una olla de algo más vaca que carnero, salpicón las más noches, duelos y quebrantos los sábados, lantejas los viernes, algún palomino de añadidura los domingos, consumían las tres partes de su hacienda. El resto della concluían sayo de velarte, calzas de velludo para las fiestas, con sus pantuflos de lo mesmo, y los días de entresemana se honraba con su vellorí de lo más fino. Tenía en su casa una ama que pasaba de los cuarenta, y una sobrina que no llegaba a los veinte, y un mozo de campo y plaza, que así ensillaba el rocín como tomaba la podadera. Frisaba la edad de nuestro hidalgo con los cincuenta años; era de complexión recia, seco de carnes, enjuto de rostro, gran madrugador y amigo de la caza. Quieren decir que tenía el sobrenombre de Quijada, o Quesada, que en esto hay alguna diferencia en los autores que deste caso escriben; aunque, por conjeturas verosímiles, se deja entender que se llamaba Quejana. Pero esto importa poco a nuestro cuento; basta que en la narración dél no se salga un punto de la verdad. 

Es, pues, de saber que este sobredicho hidalgo, los ratos que estaba ocioso, que eran los más del año, se daba a leer libros de caballerías, con tanta afición y gusto, que olvidó casi de todo punto el ejercicio de la caza, y aun la administración de su hacienda. Y llegó a tanto su curiosidad y desatino en esto, que vendió muchas hanegas de tierra de sembradura para comprar libros de caballerías en que leer, y así, llevó a su casa todos cuantos pudo haber dellos; y de todos, ningunos le parecían tan bien como los que compuso el famoso Feliciano de Silva, porque la claridad de su prosa y aquellas entricadas razones suyas le parecían de perlas, y más cuando llegaba a leer aquellos requiebros y cartas de desafíos, donde en muchas partes hallaba escrito: La razón de la sinrazón que a mi razón se hace, de tal manera mi razón enflaquece, que con razón me quejo de la vuestra fermosura. Y también cuando leía: ...los altos cielos que de vuestra divinidad divinamente con las estrellas os fortifican, y os hacen merecedora del merecimiento que merece la vuestra grandeza. ';
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
	    $mailTO->AddReplyTo('pmapde@gapmac.com', 'PMA PDE Sistema');
	    $mailTO->AddAddress($to, $toName);
	    $mailTO->SetFrom('pmapde@gapmac.com', 'PMA PDE Sistema');
	    $mailTO->Subject = $sujeto;
	    $mailTO->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically

	  //  $mailTO = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

	    $mailTO->MsgHTML(generarContenidoHTML("Notificaciones Actividades ".date("Y-m-d"), $toName ,$contenido));
	   // $mailTO->AddAttachment('../img_email/back.jpg'); // attachment
	    //$mailTO->AddAttachment('img_email/logo.png'); // attachment
	    
	    $mailTO->Send();
	    
	    echo date("Y-m-d H:i:s")." EMAIL ENVIANDO CON EXITO ".$toName." y ".$to."\n \t <br>";
	  } catch (phpmailerException $e) {
	    echo $e->errorMessage(); //Pretty error messages from PHPMailer
	  } catch (Exception $e) {
	    echo date("Y-m-d H:i:s")."ERROR: ".$e->getMessage(); //Boring error messages from anything else!
	  } 
?>