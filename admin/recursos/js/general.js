String.prototype.capitalize=function(){return this.charAt(0).toUpperCase()+this.slice(1)},$('*[data-toggle="tooltip"]').attr("data-placement","bottom"),$('*[data-toggle="tooltip"]').tooltip(),$("header > .actualizar").on("click",function(){document.location.reload()});var st={},sv={};st.regexp={nombre:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,15}\s?(?:[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,15}\s)?(?:[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,15}\s)?(?:[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,15})?$/,texto:/.{10,1000}/,fecha:/^dd\/dd\/dddd$/,numero:/^\d+$/,email:/^[\w.%+-]{3,44}@[\w.-]{3,20}\.[\w]{2,6}$/,pass:/^.{6,32}$/,tel:/^\d{7,32}$/,edad:/^\d{1,2}$/,iniciales:/^[a-zñÑ]{2}$/i,ini:function(){this.ponerEventos()},validar:function(a){var b=$(a).attr("data-regexp");b in this?""==$(a).val()?$(a).css({borderColor:"#8cf",backgroundImage:"none"}):this[b].test($(a).val())?$(a).css({borderColor:"#0a0",backgroundImage:"url(recursos/img/icono-bien.png)"}):$(a).css({borderColor:"#c00",backgroundImage:"url(recursos/img/icono-mal.png)"}):console.error("El tipo de validacion dado no existe")},ponerEventos:function(){var a=this;$("[data-regexp]").off("input"),$("[data-regexp]").on("input",function(){a.validar(this)})}},st.regexp.ini(),st.modalNavegadores={ini:function(){this.eventos(),this.saberNavegador()},saberNavegador:function(){var a=document.cookie;a=a.split(";");var b=null;a.forEach(function(a){/no-recordar-navegador/.test(a)&&(b=a.match(/\d/)[0])}),(/OPR|opera|firefox|vivaldi|msie/i.test(navigator.userAgent)||!/google inc/i.test(navigator.vendor))&&setTimeout(function(){b||$("#navegadores").fadeIn(600)},1e3)},modalNavegadores:function(a){console.log("nav consultado"),a?(document.cookie="no-recordar-navegador=1;expires="+new Date(parseInt((new Date).getTime())+1296e6).toGMTString()+";path=/",$("#navegadores").fadeOut(400)):$("#navegadores").fadeOut(400)},eventos:function(){var a=this;$("#navegadores > .contenido .cerrar").click(function(){a.modalNavegadores(!1)}),$("#btn-no-navegador").on("click",function(){a.modalNavegadores(!0)})}},st.modalNavegadores.ini(),st.conexionInternet={tiempo:5e3,img1:new Image,img2:new Image,ini:function(){this.img1.src="recursos/img/icono-router.png",this.img1.src="recursos/img/icono-no-router.png",this.eventos(),this.enInicio()},enInicio:function(){navigator.onLine||this.noInternet()},siInternet:function(){$("#conexion-internet").css({display:"block"}),$("#conexion-internet").removeClass("no-internet"),$("#conexion-internet .contenido").html('<p><img src="recursos/img/icono-router.png" alt=""><br>Ahora estás conectado</p>'),setTimeout(function(){$("#conexion-internet").hide({duration:1e3,effect:"scale",easing:"easeOutBounce"})},this.tiempo)},noInternet:function(){$("#conexion-internet").addClass("no-internet"),$("#conexion-internet").show({duration:1e3,effect:"scale",easing:"easeOutBounce"}),$("#conexion-internet .contenido").html('<p><img src="recursos/img/icono-no-router.png" alt=""><br>Se ha perdido la conexión a internet</p>')},eventos:function(){var a=this;$(window).on("offline",function(){a.noInternet()}),$(window).on("online",function(){a.siInternet()})}},st.conexionInternet.ini(),st.menu={visible:!1,tempo:300,efecto:"puff",easing:"easeInOutQuart",ini:function(){this.eventos()},alternar:function(a){$("header .alternador").toggleClass("activo"),this.visible?($("#menu").hide({effect:this.efecto,duration:this.tempo,easing:this.easing}),$("header .alternador").html('<i class="fa fa-reorder"></i>'),$(".lupa, .actualizar, .notificaciones").css({top:"11px",opacity:1}),this.visible=!1):($("#menu").show({effect:this.efecto,duration:this.tempo,easing:this.easing}),$("header .alternador").html('<i class="fa fa-remove"></i>'),$(".lupa, .actualizar, .notificaciones").css({top:"-100px",opacity:0}),this.visible=!0)},submenu:function(a,b){return b.preventDefault(),$(a).parent().find(".opciones").hasClass("activo")?void $(a).parent().find(".opciones").slideUp(200).removeClass("activo"):($("#menu > .contenido > .main .opciones").css({display:"none"}).removeClass("activo"),void $(a).parent().find(".opciones").slideDown(200).addClass("activo"))},eventos:function(){var a=this;$("header > .alternador").click(function(){a.alternar(this)}),$("#menu > .contenido > .main > li > a").on("click",function(b){a.submenu(this,b)})}},st.menu.ini(),st.buscar={visible:!1,tempo:300,efecto:"puff",easing:"easeInOutQuart",buscado:!1,resultados:{},ini:function(){this.eventos()},alternar:function(a){$("header .lupa").toggleClass("activo"),this.visible?($("#busqueda-general").hide({effect:this.efecto,duration:this.tempo,easing:this.easing}),$("header .lupa").html('<i class="fa fa-search"></i>'),$(".alternador, .actualizar, .notificaciones").css({top:"11px",opacity:1}),this.visible=!1):($("#busqueda-general").show({effect:this.efecto,duration:this.tempo,easing:this.easing,complete:function(){$("#termino-busqueda").delay(800).focus()}}),$("header .lupa").html('<i class="fa fa-remove"></i>'),$(".alternador, .actualizar, .notificaciones").css({top:"-100px",opacity:0}),this.visible=!0)},buscarArchivos:function(a){var b=this,c=$(a).val(),d="",e="",f="";b.buscado||$.ajax({url:"recursos/php/xhr/buscador-archivos.php",error:function(a){console.log(arguments)},success:function(a){b.resultados=a,b.buscado=!0}}),$("#busqueda-general .resultados ul").html(""),$.each(b.resultados,function(a,b){"php"==b.extension||"html"==b.extension?(d='<li><a href="'+b.ruta+"/"+b.nombre+'"><i class="fa ',f=b.nombre.replace(/_|-|\./," ").capitalize(),e=""):/doc|docx|xls|xlsx/.test(b.extension)?(d='<li><a href="'+b.ruta+"/"+b.base+'"><i class="fa ',e=' &nbsp;<i class="fa fa-download text-muted"></i>',f=b.nombre):(d='<li><a href="'+b.ruta+"/"+b.base+'" target="_blank"><i class="fa ',e=' &nbsp;<i class="fa fa-external-link text-muted"></i>',f=b.nombre),new RegExp(c,"i").test(b.base)&&(d+=/jpg|png|gif/.test(b.extension)?"fa-image text-primary":"php"==b.extension||"html"==b.extension?"fa-file text-success":"pdf"==b.extension?"fa-file-pdf-o text-danger":"doc"==b.extension||"docx"==b.extension?"fa-file-word-o text-info":"xls"==b.extension||"xlsx"==b.extension?"fa-file-excel-o text-success":"fa-file-o text-warning",$("#busqueda-general .resultados ul").append(d+'"></i> &nbsp;'+f+e+"</a></li>"))}),""==c&&(console.log("vacio"),$("#busqueda-general .resultados ul").html(""))},eventos:function(){var a=this;$("header > .lupa").click(function(b){b.preventDefault(),a.alternar(this)}),$("#termino-busqueda").on("input",function(){a.buscarArchivos(this)})}},st.buscar.ini(),st.notificaciones={visible:!1,tempo:300,efecto:"puff",easing:"easeInOutQuart",ini:function(){this.eventos()},alternar:function(a){$("header .notificaciones").toggleClass("activo"),this.visible?($("#notificaciones").hide({effect:this.efecto,duration:this.tempo,easing:this.easing}),$("header .notificaciones").html('<i class="fa fa-bell"></i>'),$(".alternador, .actualizar, .lupa").css({top:"11px",opacity:1}),this.visible=!1,$("body").css({overflow:"auto"})):($("#notificaciones").show({effect:this.efecto,duration:this.tempo,easing:this.easing}),$("header .notificaciones").html('<i class="fa fa-remove"></i>'),$(".alternador, .actualizar, .lupa").css({top:"-100px",opacity:0}),this.visible=!0,$("body").css({overflow:"hidden"}))},eventos:function(){var a=this;$("header > .notificaciones").click(function(b){b.preventDefault(),a.alternar(this)})}},st.notificaciones.ini(),st.usuario={visible:!1,tempo:200,efecto:"puff",direction:"right",easing:"easeInOutQuart",ini:function(){this.eventos()},ocultar:function(){var a=this;$("#usuario").hide({effect:a.efecto,duration:a.tempo,easing:a.easing,complete:function(){$("#alternador-usuario").show({effect:"fade",duration:a.tempo,easing:a.easing,direction:a.direction})}}),a.visible=!1},mostrar:function(){var a=this;$("#alternador-usuario").hide({effect:"fade",duration:a.tempo,easing:a.easing,complete:function(){$("#usuario").show({effect:a.efecto,duration:a.tempo,easing:a.easing,direction:a.direction})}}),a.visible=!0},eventos:function(){var a=this;$("#alternador-usuario").on("click",function(b){b.preventDefault(),a.mostrar()}),$("#usuario .cerrar").on("click",function(b){b.preventDefault(),a.ocultar()})}},st.usuario.ini(),st.ventanaInfo={tempo:400,efecto:"drop",easing:"easeInOutQuart",timeout:null,duracionVentana:1e4,direction:"right",clase:"",ini:function(){this.ponerEventos()},abrir:function(a,b){b&&($("#ventana-info").removeClass(this.clase),this.clase=b,$("#ventana-info").addClass(this.clase));var c=this;"string"==typeof a?($("#ventana-info .contenido").html(a),$("#ventana-info").show({effect:c.efecto,duration:c.tempo,easing:c.easing,direction:c.direction}),this.timeout=setTimeout(function(){c.cerrar()},c.duracionVentana)):console.error("Debe pasarse un string a la función")},cerrar:function(){clearTimeout(this.timeout),$("#ventana-info").hide({effect:this.efecto,duration:this.tempo,easing:this.easing,direction:this.direction,complete:function(){$("#ventana-info").removeClass(this.clase),this.clase=""}})},ponerEventos:function(){var a=this;$("#ventana-info .cerrar").click(function(){a.cerrar()}),$("[data-ventana-info]").on("click",function(b){b.preventDefault(),clearTimeout(a.timeout),a.abrir($(this).attr("data-ventana-info"),"success")}),$(document).on("keypress",function(b){27==b.keyCode&&a.cerrar()})}},st.ventanaInfo.ini(),st.modal={effect:"puff",duration:300,puedeCerrar:!0,opciones:{archivo:"",html:"",cerrar:!0,completo:function(){}},ini:function(){this.eventos()},preModal:function(a){this.abrir({archivo:$(a).attr("data-modal")})},abrir:function(a){var b={};b.archivo="string"==typeof a.archivo?a.archivo:this.opciones.archivo,b.html="string"==typeof a.html?a.html:this.opciones.html,b.cerrar="boolean"==typeof a.cerrar?a.cerrar:this.opciones.cerrar,b.completo="function"==typeof a.completo?a.completo:this.opciones.completo,b.cerrar||(this.puedeCerrar=b.cerrar,$("#modal > .contenido > .cerrar").css({display:"none"})),$("#modal").show({effect:this.effect,duration:this.duration,complete:function(){$("body").css({overflow:"hidden"}),""!=b.archivo?($("#modal .contenido .datos").html('<div class="wrap"><img src="recursos/img/preloader-1.gif" alt=""/></div>'),$.ajax({url:"recursos/modal/"+b.archivo+".php",method:"GET",dataType:"html",error:function(){$("#modal .contenido .datos").html('<div class="wrap"><p>En el momento no podemos obtener la informacion, por favor intenta más tarde.</p></div>')},success:function(a){$("#modal .contenido .datos").html(a),b.completo()}})):""!=b.html?$("#modal .contenido .datos").html(b.html):console.error("No se pasó nada para cargar en el modal.")}})},cerrar:function(){var a=this;$("#modal").hide({effect:a.effect,duration:a.duration,complete:function(){a.puedeCerrar=!0,$("#modal > .contenido > .cerrar").css({display:"block"}),$("#modal > .contenido > .datos").html(""),$("body").css({overflow:"auto"})}})},eventos:function(){var a=this;$("[data-modal]").on("click",function(b){b.preventDefault(),a.preModal(this)}),$("#modal > .contenido > .cerrar").on("click",function(){a.cerrar()})}},st.modal.ini(),st.nota={tempo:600,efecto:"fade",easing:"easeInOutQuart",timeout:null,duracionVentana:1e4,direction:"right",clase:"",ini:function(){this.ponerEventos()},abrir:function(a){var b=this;"string"==typeof a?($("#nota .contenido").html(a),$("#nota").show({effect:b.efecto,duration:b.tempo,easing:b.easing,direction:b.direction}),this.timeout=setTimeout(function(){b.cerrar()},b.duracionVentana)):console.error("Debe pasarse un string a la función")},cerrar:function(){clearTimeout(this.timeout),$("#nota").hide({effect:this.efecto,duration:this.tempo,easing:this.easing,direction:this.direction,complete:function(){$("#ventana-info").removeClass(this.clase),this.clase=""}})},ponerEventos:function(){var a=this;$("#nota .cerrar").click(function(){a.cerrar()}),$("[data-nota]").on("click",function(b){b.preventDefault(),clearTimeout(a.timeout),a.abrir($(this).attr("data-nota"))}),$(document).on("keypress",function(b){27==b.keyCode&&a.cerrar()})}},st.nota.ini(),st.panelesOcultables={panelActual:$("li[data-panel-alternador].activo").attr("data-panel-alternador"),tiempo:500,ini:function(){this.eventos()},alternarPaneles:function(a){a!=this.panelActual&&($("li[data-panel-alternador].activo").removeClass("activo"),$('li[data-panel-alternador="'+a+'"]').addClass("activo"),$("div[data-panel-contenido].activo").slideUp(this.tiempo,function(){$(this).removeClass("activo")}),$('div[data-panel-contenido="'+a+'"]').slideDown(this.tiempo,function(){$(this).addClass("activo")}),this.panelActual=a)},eventos:function(){var a=this;$("li[data-panel-alternador]").on("click",function(){a.alternarPaneles($(this).attr("data-panel-alternador"))})}},st.panelesOcultables.ini(),st.botonArriba={botonUp:!1,effect:"drop",direction:"down",duration:200,ini:function(){this.ponerEventos(),this.mostrarBotonUp($(window).scrollTop())},desplazarArriba:function(){$("html, body").animate({scrollTop:0},1e3)},mostrarBotonUp:function(a){if(a>100){if(this.botonUp)return;$("#boton-arriba").show({effect:this.effect,duration:this.duration,direction:this.direction}),this.botonUp=!0}else{if(!this.botonUp)return;$("#boton-arriba").hide({effect:this.effect,duration:this.duration,direction:this.direction}),this.botonUp=!1}},ponerEventos:function(){var a=this;$("#boton-arriba").click(function(){a.desplazarArriba()}),$(window).on("scroll",function(){a.mostrarBotonUp($(this).scrollTop())})}},st.botonArriba.ini();