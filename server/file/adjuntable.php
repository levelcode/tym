<?php
if(isset($_FILES["archivo2"]["name"])){
    //echo print_r($_FILES);
  function sube_archivo($nombre_campo,$ruta){
    $n=$nombre_campo;
    $a=$_FILES[$n]["tmp_name"];
    $b=$_FILES[$n]["name"];
    $b=explode(".",$b);
    $b=strtolower(array_pop($b));
    //echo $b;
    $today=date("YmdHis");
    $nombre_imagen = $today."_".rand(1,9999);
    $b2=strtolower($nombre_imagen.".".$b);
    $c=$_FILES[$n]["size"];
    //echo "".$a.", ".$b.", ".$c;
    if($c >= 4100032){
      $salida["result"]	=false;
      $salida["error"]	="max-size";
    } else  {
      $extension = (String)strtolower($b);
      if ($extension==="pdf" )
      {
        move_uploaded_file($a, strtolower($ruta.$b2));

        $salida["result"]=true;
        $salida["name_file"]=$b2;
        $salida["size"]=round(($c/1024/1240),2);
        $salida["old_name"]=$_FILES[$n]["name"];

      } else {
        $salida["result"]	=false;
        $salida["error"]	="no-format";
      }
    }
    return $salida;
  }
  $resultado = sube_archivo("archivo2","../../media/recursos/");
}
?>
<html>
<head>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
  <style>
  .normal{
    width: 30px;
    overflow: hidden;
    color: #FFF;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    background-color: #004586;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f#004586', endColorstr='#ffCC1013', GradientType=0);
    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
    border-radius: 5px;
    background-image: url(../../../recursos/img/upload.png);
    padding: 1px;
    background-size: 88%;
    background-repeat: no-repeat;
    background-position-x: 2px;
    background-position-y: 5px;
    height: 27px;
  }
  .loading{
    width: 30px;
    overflow: hidden;
    color: #FFF;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    background-color: #004586;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f#004586', endColorstr='#ffCC1013', GradientType=0);
    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
    border-radius: 5px;
    background-image: url(../../../recursos/img/reload.gif);
    padding: 1px;
    background-size: 88%;
    background-repeat: no-repeat;
    background-position-x: 2px;
    background-position-y: 5px;
    height: 27px;
  }
  </style>
</head>
<body style="overflow: hidden; background:transparent">
<form id="formSubir2" name="formSubir2" enctype="multipart/form-data" action='<?php $_SERVER["PHP_SELF"]; ?>' method="post" class="form-horizontal">
        <div class="normal">
            <input type="file" id="archivo2" name="archivo2" class="btn btn-primary btn-mini" style="margin-left: -120; opacity: 0.0; -moz-opacity: 0; -ms-filter: 'progid:DXImageTransform.Microsoft.Alpha(Opacity=0)';
filter: alpha(opacity=0); overflow:hidden">
        </div>

</form>
<script type="text/javascript">
$(document).on("ready", iniciarl_subeArchivodoc);

function iniciarl_subeArchivodoc() {
  //var url = getUrlVars()["input_name"];
  //alert(first);
  $("#archivo2").change(function (){
    if($("#archivo2").val()=='');
      else {
        $("div").removeClass("normal").addClass("loading");
        $("#formSubir2").submit();
      }
  })
  $("body").show('fast');
}
</script>
</html>
<?php
  if(isset($resultado["result"])){
    if($resultado["result"]){
      $fileName = isset($resultado["name_file"]) ? $resultado["name_file"] : null;
      $peso = isset($resultado["peso"]) ? $resultado["peso"] : null;
      $url = isset($resultado["url"]) ? $resultado["url"] : null;
?>
    <script type="text/javascript">
      alert("Documento Publicado con Exito ");
      $("div").removeClass("loading").addClass("normal");
      $("#link_adjuntable",window.parent.document).val('http://recusos.crm.appsyntex.com/<?php echo $fileName ?>');
    </script>
<?php
    } else {
      if($resultado["error"] === "no-format"){
?>
    <script type="text/javascript">
      alert("Tipo de archivo invalido");
    </script>
<?php
      }
      if($resultado["error"] === "max-size"){
?>
    <script type="text/javascript">
      alert("Archivo supero el tamaño maximo");
    </script>
<?php
      }
    }
  }
?>
