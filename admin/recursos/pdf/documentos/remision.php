<?php

session_start();
//error_reporting(0);
//FILES
require_once('tcpdf_include.php');
require_once('../../../server/api/App/Db.php');

$con = App\DB\conectar();
$date_time = date( 'Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
$info = json_decode($_COOKIE["remPdf"]);
$vehicleInfo = ( isset($_COOKIE["vehicleInfo"]) ) ? json_decode($_COOKIE["vehicleInfo"]) : NULL;

if (isset($info->generalInfo->nrem)) {

  $nrem = $info->generalInfo->nrem;
  $type_of_pdf_output = 'F';

}else {
  $nrem = "No asignado";  
  $type_of_pdf_output = 'I';
}

if( isset($vehicleInfo) ) {
  $diference = $vehicleInfo->weightFull - $vehicleInfo->weightEmpty; 
  $vw = '('.$vehicleInfo->weightFull.'-'.$vehicleInfo->weightEmpty.')='.$diference .' '.$vehicleInfo->unit->unit;
}

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
  .table-remission {
    margin-top: 10px;
  }

</style>
HTML;

$html = <<<HTML
$estilo

<table border="" cellpadding="5px" class="txt_center fs7">
  <thead>
    <tr>
      <th><img width="130"></th>
      <th class="txt_center fs9">
        <b>Cliente:</b> $client_name<br>
        <b>Fecha/Hora:</b> $date_time<br>
        <b>Dirección:</b> $address_line1<br>
      </th>
    </tr>
  </thead>
</table>
<br><br>
<table cellpadding="5px" class="table-remission">
  <tr class="txt_right">
    <td ></td>
    <td ></td>
    <td ></td>
    <td border="">$nrem</td>
  </tr>
</table>
<br><br>
<table border="" cellpadding="5px" >
  <thead>
    <tr class="txt_left">
      <th><b>Responsable: </b>$person_in_charge</th>
      <th><b>Vehiculo de placa:</b> $plate</th>
      <th><b>Pesos vehiculo:</b> $vw</th>
    </tr>
  </thead>
</table>
<br><br>
<table border="" cellpadding="5px">
  <thead>
    <tr class="txt_center">
      <th><b>Tipo</b></th>
      <th><b>Cantidad</b></th>
      <th><b>Unidad</b></th>
      <th><b>Embalaje</b></th>
    </tr>
  </thead>
  <tbody>
    $wastesTable
  </tbody>
</table>
HTML;



// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


//echo $html;
// reset pointer to the last page
//$pdf->lastPage();
// ---------------------------------------------------------
//Close and output PDF document // I = VISUALIZAR Y F = FARCHIVO
if ( $type_of_pdf_output == 'F' ) {
  $time_stamp_to_use = $_SERVER['REQUEST_TIME'];
  $type_of_pdf_output = 'I'  ;

  $pdf->Output('../../../media/pdf/remision_' . $nrem . '.pdf', $type_of_pdf_output);

  $type_of_pdf_output = 'F'  ;
  $pdf->Output('../../../media/pdf/remision_' . $nrem . $time_stamp_to_use .'.pdf', $type_of_pdf_output);
  //$pdf->Output('../../../recursos/pdf/documentos/data/remision_' . $nrem . $time_stamp_to_use .'.pdf', $type_of_pdf_output);
    
  $file_to_send_data = array(
    'timestamp' => $time_stamp_to_use, 
    'remission_number' => $nrem 
  );

  $_SESSION['file_to_send_data'] = $file_to_send_data;
  
}else {
  $pdf->Output('../../../media/pdf/remision_' . $nrem . '.pdf', $type_of_pdf_output);
}

//echo '{"file_name": "remision_' . $nrem . '.pdf"}';
//============================================================+
// END OF FILE
//============================================================+