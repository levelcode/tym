$(function(){
  //console.log("Iniciar Login");
  $("#form_login").on("submit", do_login);
  $(document).on( "submit" , "#form_olvido_contraseña" , olvidar_pass);
  $("#form_cambio_pass").on("submit", cambio_pass);
  $("#nueva_cuenta").on("submit", nueva_cuenta)
  $(".advertencia").slideUp();

  //AJAX SETUP
  $.ajaxSetup({
    url       : "server/api/Ajax.php",
    dataType  : 'json',
    type      : "POST"
  });
});
var do_login = function(){
  //console.log("Iniciar Validacion");
  //EVALUAR EMAIL  Y PASS
  var pass = $("#form_login #pass").val(),
      user = $("#form_login #id").val();

  if(pass != '' && user != ''){

      st.ventanaInfo.abrir("Cargando...", "succes", 3000);  
      
      $.ajax({
        data : 'a=login&pass='+pass+'&id='+user,
        complete: function(response, status){
          //console.log(response, ' - ', status);
          console.log(response);
          if(status == 'success'){
              //console.log(response);
              if(response.responseJSON.accede){
                window.location = 'inicio';
                
                st.ventanaInfo.abrir("Bienvenido a Cartecrudo", "succes");  
              } else {
                 st.ventanaInfo.abrir("Datos incorrectos", "error");              
              }
          } else {
            alert(status);
          }
        }
      });
  } else {
     st.ventanaInfo.abrir("Datos incorrectos", "error");
  }
  return false;
}
var nueva_cuenta = function(){
  console.log("Crear cuenta");
  $(".cargando_plataforma_sigin").slideUp();
  $(".datos_incorrectos_sigin").slideUp();
  var pass = $("#nueva_cuenta #pass").val()
  if(pass == ""){
    console.log("Falta pass");
    $(".datos_incorrectos_sigin").slideDown();
  } else {
    //CONTINUAR
    $(".datos_incorrectos_sigin").slideUp();
    $(".cargando_plataforma_sigin").slideDown();
    $.ajax({
      data : 'a=Usuarios&'+$("#nueva_cuenta").serialize(),
      complete: function(response, status){
        console.log(response, ' - ', status);
        console.log(response);
        if(status == 'success'){
            console.log(response);
            if(Number(response.responseJSON.response) > 0){
              //window.location = 'inicio.php';
              //$(".cargando_plataforma_sigin").slideUp();
              $(".ok").slideDown();
              $("#nueva_cuenta").reset();

            } else {
              $(".cargando_plataforma_sigin").slideUp();
              $(".datos_incorrectos_sigin").slideUp();
              $("#email_duplicate").slideDown();
            }
        } else {
          //alert(status);
        }
      }
    });

  }
  //alert("Creat");
  return false;
}
var olvidar_pass = function(){
  var email = $("#email_restablecer").val();
  if(email == ""){
    $("#email_restablecer").focus().attr("placeholder", "Por favor escribe un email");
  } else {
    $.ajax({
      data : 'a=olvidar_pass&email='+email,
      complete: function(response, status){
        console.log(response, ' - ', status);
        console.log(response);
        if(status == 'success'){
          $("#email_restablecer").val("").attr("placeholder", "Email enviado con exito");
        } else {
          alert(status);
        }
      }
    });
  }
  return false;
}
var cambio_pass = function (){
  var pass = $("#form_cambio_pass #pass").val();
  var pass2 = $("#form_cambio_pass #pass2").val();
  if( (pass == pass2) && (pass != "" && pass2 != "") ){
    $(".datos_incorrectos").slideUp("fase");
    $(".consultando_datos").slideDown();
    $.ajax({
      data : 'a=cambio_pass&pass='+pass+"&pass2="+pass2+"&key="+$("#llave").val()+"&e="+$("#e").val(),
      complete: function(response, status){
        console.log(response, ' - ', status);
        console.log(response);
        if(status == 'success'){
            console.log(response);
            if(response.responseJSON.accede){
              window.location = 'inicio';
            } else {
              $(".consultando_datos").slideUp();
              $(".datos_incorrectos").slideDown();
            }
        } else {
          alert(status);
        }
      }
    });
  } else {
    $(".datos_incorrectos").slideDown("fase");
  }
  return false;
}
