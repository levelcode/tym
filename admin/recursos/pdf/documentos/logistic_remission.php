<?php

session_start();
//error_reporting(0);
date_default_timezone_set("America/Bogota");
//FILES
require_once('tcpdf_include.php');
require_once('../../../server/api/App/Db.php');

$con = App\DB\conectar();
$date_time = date( 'Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);

$info = json_decode($_COOKIE["remPdf"]);

$nrem =  (isset($info->generalInfo->nrem)) ? $info->generalInfo->nrem : '';
$nrec = $info->generalInfo->nrec;
$client_name = $info->clientData->cliName;
$address_line1 = $info->clientData->address_line1;
$city = $info->clientData->city;
$NIT = $info->clientData->cliIdentification;
$person_in_charge = $info->clientData->personInCharge;

if ( isset($info->driver) ) {

  $transport_company = $info->driver->transport_company;
  $collector_address =  $info->driver->main_address;
  $collector_mobile = $info->driver->mobile_phone;
  $driver_name = $info->driver->name .' '. $info->driver->last_name;
  $plate = $info->driver->plate;

}else {
  $transport_company = $_SESSION['transport_company'];
  $collector_address =  $_SESSION['main_address'];
  $collector_mobile = $_SESSION['mobile_phone'];
  $driver_name = $_SESSION['name'].' '.$_SESSION['last_name'];
  $plate = $_SESSION['plate'];
}

$wastesTable = '';

foreach ($info->wastes as $value) {

  $wastesTable .= '<tr class="txt_center">'. 
                    '<td>' . $value->type . '</td>'. 
                    '<td>' . $value->quantity . '</td>'.
                    '<td></td>'.
                    '<td>' . $value->unit . '</td>'.
                    '<td>' . $value->packing . '</td>'.
                  '</tr>';
    
}
//$info = App\DB\query("SELECT * FROM ormi_hogar, ormi_contrato_separacion, ormi_proyecto, ormi_hogar_promesa WHERE ormi_hogar_promesa.id_hogar = ormi_hogar.id_casa AND ormi_hogar.id_proyecto = ormi_proyecto.id_proyecto AND ormi_hogar.contrato_separacion = ormi_contrato_separacion.id_contrato AND ormi_hogar_promesa.id_contrato_promesa = :id", array("id" => $id), $con);
//$datos = $info[0];


class MyPDF extends TCPDF {

  public function footer() {
    $this->SetTextColor(160, 160, 160);
    $this->MultiCell(80, 0, "OFICINA BOGOTÁ\nCarrera 13 # 60 86 oficina 403\nPBX: 7498808", 0, 'C', false, 1, 10, 312, true, 0, false, true, 0, 'M', false);
    $this->MultiCell(80, 0, "SALA DE VETAS\nCalle 15 sur No. 12 - 40\nSoacha Compartir", 0, 'C', false, 1, 56, 312, true, 0, false, true, 0, 'M', false);

    $this->MultiCell(80, 0, "TELÉFONOS\n721 1690\n318 354 2070 - 321 437 3358", 0, 'C', false, 1, 100, 312, true, 0, false, true, 0, 'M', false);

    $this->Image('img/img001.png', 184, 314, 20, 6, 'PNG', '', 'L', false, 300, '', false, false, 0, false, false, false, false, array());
  }

}

$size = array(214, 278);
//$size = 'A4';
$pdf = new MyPDF('P', PDF_UNIT, $size, true, 'UTF-8', false);

//Fuentes
//$f = $pdf->addTTFfont('../../fuentes/OpenSans-Regular-webfont.ttf','','');
// set document information
$pdf->SetCreator('prograCOL');
$pdf->SetAuthor('Andrés Beltrán');
$pdf->SetTitle('Remisión');
$pdf->SetSubject('Remisión');

//Header y footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->setFooterData(array(180, 180, 180), array(255, 255, 255));
//$pdf->setFooterFont(Array($f, '', 7));
// set default monospaced font
//$pdf->SetDefaultMonospacedFont($f);
//Línea
$pdf->setLineStyle(array(), true);


//Page size
//$pdf->setPageFormat(array(320, 217), 'p');
// set margins
$pdf->SetMargins(13, 10, 10);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(40);

// set auto page breaks
$pdf->SetAutoPageBreak(true, 20);

// set image scale factor
$pdf->setImageScale(1);
$pdf->setCellPaddings(1, 1.4, 1.4, 1);

// ---------------------------------------------------------
// set font
//$pdf->SetFont($f, '', 9);
// add a page
$pdf->AddPage();



#################################################
################### variables ###################
#################################################
//Logo
$logo = 'img/logo.png';

//$numero_formato = str_pad();
//$numero = numtoletras(1234567890);



$var = 'Texto aquí';
//CONSULTARS Y VARIABLES
// define some HTML content with style

$estilo = <<<HTML
<style>
  table{
    font-size: 9px;
  }
  .cuadro_logo{

  }
  .pLogo{
      text-align:center;
      line-height:19px;
  }
  .img_logo{
    width:150px;
    position: absolute;
    left: 10px;

  }
  .title_td{
    background-color: #337AB7;
    line-height:10px;
    padding:5px;
    color: #FFF;
    font-size: 10px;
    font-weight : bold;
  }
  h3{
    font-size: 18px;
    line-height: 50px;
    text-align: center;
  }
  .top_formar {
    text-align: center;
    margin: 20px;

  }
  .especial{
    font-weight:bold;
  /* Tabla */
  .tabla{
    border-collapse: collapse;

  }
  .tabla tr td{
    border-bottom: 1px solid #000000;
    vertical-align: middle;
    box-sizing:border-box;
  }

  /* alineaciones */
  .txt_center{
    text-align: center;
  }
  .txt_left{
    text-align: left;
  }
  .txt_right{
    text-align: right;
  }

  /* tamaños de fuente */
  .fs7{
    font-size: 7px;
  }
  .fs8{
    font-size: 8px;
  }
  .fs9{
    font-size: 9px;
  }
  .fs10{
    font-size: 10px;
  }
  .fs11{
    font-size: 11px;
  }
  .fs12{
    font-size: 12px;
  }
  .fs13{
    font-size: 13px;
  }
  .fs14{
    font-size: 14px;
  }

  /* Varios */
  .bg_grey{
    background-color: #eeeeee;
  }
  .bold{
    color: #ff0000;
  }

  /* Altos de linea */
  .lheight40{
    line-height: 40px;
  }

  /* Altos */
  .height40{
    height: 40px;
  }

  /* Bordes */
  .no_border_left{
    border-left-color: #ff0000;
  }
  .no_border_right{
    border-right-color: #ff0000;
  }
  .no_border_both{
    border-left-color: #ff0000;
    border-right-color: #ff0000;
  }

</style>
HTML;

$html = <<<HTML
$estilo

<table border="0.5" cellpadding="5px" class="txt_center fs7">
  <thead>
    <tr>
      <th><img width="130" src="{$logo}"></th>
      <th class="txt_center fs7">
        Planta ORCO S.A<br>
         Mamonal Km 10 Zona Franca<br>
        La Candelaria Cra. 56N<sup>o</sup> 5-33<br>
        Cel: 3126013797 - Tel: 6685209<br>
        Cartagena - Bolivar
      </th>
    </tr>
  </thead>
</table>
<br><br>
<table cellpadding="5px" >
  <tr>
    <td ><b>Fecha/Hora:</b></td>
    <td class="fs8" border="0.5">$date_time</td>
    <td ><b>No. Remisión</b></td>
    <td border="0.5">$nrem</td>
    <td ><b>No. Recolección</b></td>
    <td border="0.5">$nrec</td>
  </tr>
</table>
<br><br>
<table border="0.5" cellpadding="5px" >
  <thead>
    <tr class="txt_center">
      <th><b>Datos del Cliente</b></th>
      <th><b>Datos del Recolector</b></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><b>Cliente:</b> $client_name<br><b>Dirección:</b> $address_line1<br><b>Ciudad:</b> $city<br><b>Nit:</b> $NIT<br><b>Responsable de la entrega: </b>$person_in_charge</td>
      <td><b>Transportadora:</b> $transport_company<br><b>Dirección:</b> $collector_address<br><b>Nit:</b> 999999999-2<br><b>Teléfono:</b>$collector_mobile<br><b>Conductor:</b> $driver_name<br><b>Placa:</b> $plate</td>
    </tr>
  </tbody>
</table>
<br><br>
<table border="0.5" cellpadding="5px">
  <thead>
    <tr class="txt_center">
      <th><b>Tipo de Residuo</b></th>
      <th><b>Cantidad</b></th>
      <th><b>Verificada</b></th>
      <th><b>Unidad</b></th>
      <th><b>Embalaje</b></th>
    </tr>
  </thead>
  <tbody >
    $wastesTable
  </tbody>
</table>
<br><br><br>
<table>
  <tr>
    <td><b>Firma Entregado</b><br><br>__________________________________<br>C.C.</td>
    <td><b>Firma Recibido</b><br><br>___________________________________<br>C.C.</td>
  </tr>
</table>
<br><br>
<span class="fs7">Datos de Ingreso</span>
HTML;



// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


//echo $html;
// reset pointer to the last page
//$pdf->lastPage();
// ---------------------------------------------------------
//Close and output PDF document // I = VISUALIZAR Y F = FARCHIVO
$pdf->Output('../../../media/pdf/remision_' . $nrem . '.pdf', 'I');
echo '{"file_name": "remision_' . $nrem . '.pdf"}';
//============================================================+
// END OF FILE
//============================================================+
