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
			if ($extension==="png" || $extension==="jpg" || $extension==="gif" || $extension==="bmp" || $extension==="tif" || $extension==="jpeg" )
			{
				move_uploaded_file($a, strtolower($ruta.$b2));

				$salida["result"]=true;
				$salida["name_file"]=$b2;
				$salida["size"]=round(($c/1024/1240),2);
				$salida["old_name"]=$_FILES[$n]["name"];
				 require_once('class.upload.php');
			        //HACER RIZIR
			        $handle = new upload($ruta.$b2);
              $handle->image_resize           = true;
              $handle->image_ratio_crop       = true;
              $handle->image_y                = 300;
              $handle->image_x                = 300;
              $handle->file_safe_name         = false;
              $handle->file_dst_pathname        = "../../../media/img/300/m_".$nombre_imagen.".".$extension;
              $handle->file_dst_name            = "300/m_".$nombre_imagen;
              $handle->file_dst_name_body       = "300/m_".$nombre_imagen.".".$extension;
              $handle->file_dst_name_ext        = $extension;
              $handle->Process('../../../media/img/300/');
              $handle = new upload($ruta.$b2);
			        $handle->image_resize           = true;
			        $handle->image_ratio_crop       = true;
			        $handle->image_y                = 150;
			        $handle->image_x                = 150;
			        $handle->file_safe_name         = false;
			        $handle->file_dst_pathname        = "../../../media/img/150/m_".$nombre_imagen.".".$extension;
			        $handle->file_dst_name            = "150/m_".$nombre_imagen;
			        $handle->file_dst_name_body       = "150/m_".$nombre_imagen.".".$extension;
			        $handle->file_dst_name_ext        = $extension;
			        $handle->Process('../../../media/img/150/');
			        $handle = new upload($ruta.$b2);
			        $handle->image_resize           = true;
			        $handle->image_ratio_crop       = true;
			        $handle->image_y                = 50;
			        $handle->image_x                = 50;
			        $handle->file_safe_name         = false;
			        $handle->file_dst_pathname        = "../../../media/img/50/m_".$nombre_imagen.".".$extension;
			        $handle->file_dst_name            = "50/m_".$nombre_imagen;
			        $handle->file_dst_name_body       = "50/m_".$nombre_imagen.".".$extension;
			        $handle->file_dst_name_ext        = $extension;
			        $handle->Process('../../../media/img/50/');
			} else {
				$salida["result"]	=false;
				$salida["error"]	="no-format";
			}
		}
		return $salida;
	}
	$resultado = sube_archivo("archivo2","../../../media/img/");
}
?>
<html>
<head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

</head>
<body style="overflow: hidden; background:transparent">
<form id="formSubir2" name="formSubir2" enctype="multipart/form-data" action='<?php $_SERVER["PHP_SELF"]; ?>' method="post" class="form-horizontal">
        <div class="" style="width:30px;   overflow:hidden;color: #ffffff;   text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);   background-color: #CC1013;   *background-color: #CC1013;   background-image: -moz-linear-gradient(top, #CC1013, #CC1013);   background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#CC1013), to(#CC1013));   background-image: -webkit-linear-gradient(top, #CC1013, #CC1013);   background-image: -o-linear-gradient(top, #CC1013, #CC1013);   background-image: linear-gradient(to bottom, #CC1013, #CC1013);   background-repeat: repeat-x;   border-color: #CC1013 #CC1013 #CC1013;   border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);   filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f#CC1013', endColorstr='#ffCC1013', GradientType=0);   filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);border-radius: 5px;background-image: url(&quot;../../../../recursos/img//comun/upload.png&quot;);height: 30px;padding: 1px;background-size: 88%;background-repeat: no-repeat;background-position-x: 2px;background-position-y: 5px;height: 27px;">
            <input type="file" id="archivo2" name="archivo2" class="btn btn-primary btn-150">
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
			$class = isset($_GET["img"]) ? $_GET["img"] : $_GET["img"];
			$mini = isset($_GET["sizemini"]) ? $_GET["sizemini"] : $_GET["sizemini"];
			$peso = isset($resultado["peso"]) ? $resultado["peso"] : null;
			$url = isset($resultado["url"]) ? $resultado["url"] : null;
?>
		<script type="text/javascript">
			alert("Imagen Subido con Exito ");
			var id_producto = '<?php echo $class; ?>';
			var mini = '<?php echo $mini; ?>';
			console.log(id_producto);
			$("."+id_producto ,window.parent.document).val('<?php echo $fileName; ?>');
			$("#size",window.parent.document).val('<?php echo $peso ?>');
			$(".imagen_upload_"+id_producto ,window.parent.document).find("img").attr("src" ,'media/img/'+mini+'/<?php echo $fileName; ?>');
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
