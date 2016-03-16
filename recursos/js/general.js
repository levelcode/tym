function initMap(){map=new google.maps.Map(document.getElementById("mapa"),{center:{lat:4.676541,lng:-74.141177},zoom:12})}$('[data-toggle="tooltip"]').tooltip(),$("[data-ir]").on("click",function(a){a.preventDefault();var b=$("#"+$(this).attr("data-ir")).offset().top-64;$("html, body").animate({scrollTop:b},1e3)});var map;initMap();var st={};st.ventanaInfo={tempo:400,efecto:"drop",easing:"easeInOutQuart",timeout:null,duracionVentana:1e4,direction:"right",ini:function(){this.ponerEventos()},abrir:function(a){var b=this;"string"==typeof a?(b.abierto=!0,$("#ventana-info .contenido").html(a),$("#ventana-info").show({effect:b.efecto,duration:b.tempo,easing:b.easing,direction:b.direction}),clearTimeout(b.timeout),b.timeout=setTimeout(function(){b.cerrar()},b.duracionVentana)):console.error("Debe pasarse un string a la función")},cerrar:function(){clearTimeout(this.timeout),$("#ventana-info").hide({effect:this.efecto,duration:this.tempo,easing:this.easing,direction:this.direction})},ponerEventos:function(){var a=this;$("#ventana-info .cerrar").click(function(){a.cerrar()}),$("[data-ventana-info]").on("click",function(b){b.preventDefault(),clearTimeout(a.timeout),a.abrir($(this).attr("data-ventana-info"))}),$("#ventana-info").on("mouseenter",function(){clearTimeout(a.timeout)}),$(document).on("keypress",function(b){27==b.keyCode&&a.cerrar()})}},st.ventanaInfo.ini(),st.menu={abierto:!1,dur:300,efe:"drop",dir:"up",eas:"easeOutCirc",ini:function(){this.eventos()},analizar:function(){this.abierto?this.cerrar():this.abrir()},abrir:function(){var a=this;$("#cabecero .menu").show({duration:a.dur,effect:a.efe,direction:a.dir,easing:a.eas,complete:function(){a.abierto=!0}}),$("#alternador-menu").css({"background-image":"url(recursos/img/alternador-menu-cerrar.png)","background-color":"transparent"})},cerrar:function(){var a=this;$("#cabecero .menu").hide({duration:a.dur,effect:a.efe,direction:a.dir,easing:a.eas,complete:function(){a.abierto=!1}}),$("#alternador-menu").css({"background-image":"url(recursos/img/alternador-menu.png)","background-color":"rgba(0, 0, 0, 0.4)"})},eventos:function(){var a=this;$("#alternador-menu").on("click",function(){a.analizar()})}},st.menu.ini(),st.menuAccesorios={abierto:!0,dur:300,efe:"slide",dir:"left",eas:"easeOutCirc",ini:function(){this.eventos()},analizar:function(){this.abierto?this.cerrar():this.abrir()},abrir:function(){var a=this;$("#cabecero .menu-accesorios").show({duration:a.dur,effect:a.efe,direction:a.dir,easing:a.eas,complete:function(){a.abierto=!0}}),$("#alternador-menu-accesorios").css("background-image","url(recursos/img/bg-menu-accesorios-l.png)")},cerrar:function(){var a=this;$("#cabecero .menu-accesorios").hide({duration:a.dur,effect:a.efe,direction:a.dir,easing:a.eas,complete:function(){a.abierto=!1}}),$("#alternador-menu-accesorios").css("background-image","url(recursos/img/bg-menu-accesorios-r.png)"),st.catalogoAccesorios.cerrar()},eventos:function(){var a=this,b=768;$("#alternador-menu-accesorios").on("click",function(){a.analizar()}),$(window).on({load:function(){$(this).width()<b&&a.cerrar()},resize:function(){if($(this).width()<b){if(!a.abierto)return;a.cerrar()}else{if(a.abierto)return;a.abrir()}}})}},st.menuAccesorios.ini(),st.btnCarroCompra={btnGrande:!0,ini:function(){this.eventos()},grande:function(){var a=this;$("#btn-carro-compras").css({right:"-8px","font-size":"12px"}),a.btnGrande=!0,console.log("grande")},pequeno:function(){var a=this;$("#btn-carro-compras").css({right:"-136px","font-size":"18px"}),a.btnGrande=!1,console.log("pequeño")},eventos:function(){var a=this,b=768;$(window).on({load:function(){$(this).width()<b&&a.pequeno()},resize:function(){if($(this).width()<b){if(!a.btnGrande)return;a.pequeno()}else{if(a.btnGrande)return;a.grande()}}})}},st.btnCarroCompra.ini(),st.catalogoAccesorios={abierto:!1,dur:800,efe:"fold",dir:"left",eas:"linear",ini:function(){this.eventos()},analizar:function(a){return a.hasClass("activo")?(a.removeClass("activo"),void this.cerrar()):($("#accesorio-tipo").html('<div class="text-center"> <br> <p class="txt-11">Cargando accesorios...</p> <br> <img src="recursos/img/preloader-productos.gif" alt=""> </div>'),$("#cabecero .menu-accesorios ul li a.activo").removeClass("activo"),a.addClass("activo"),$("#catalogo-accesorios .catalogo .indicador").css("top",a.offset().top-76),$.ajax({url:"recursos/php/html/inc/"+a.attr("data-nombre")+".php",type:"get",dataType:"html",complete:function(a){console.log(a),setTimeout(function(){$("#accesorio-tipo").html(a.responseText)},1200)}}),void this.abrir())},abrir:function(){var a=this;$("#catalogo-accesorios").show({effect:a.efe,duration:a.dur,direction:a.dir,easing:a.eas}),a.abierto=!0},cerrar:function(){var a=this;$("#catalogo-accesorios").hide({effect:a.efe,duration:a.dur,direction:a.dir,easing:a.eas}),$("#cabecero .menu-accesorios ul li a.activo").removeClass("activo"),a.abierto=!1},eventos:function(){var a=this;$("#cabecero .menu-accesorios ul li a").on("click",function(b){b.preventDefault(),a.analizar($(this))}),$("#catalogo-accesorios .catalogo > .cerrar").on("click",function(){a.cerrar()})}},st.catalogoAccesorios.ini(),st.producto={abierto:!1,dur:800,efe:"slide",dir:"left",eas:"easeOutCirc",slider:!1,ini:function(){this.eventos()},abrir:function(){var a=this;$("#detalle-producto").fadeIn({duration:a.dur,complete:function(){}}),a.slider||(console.log("entró"),$("#slider-productos-compatibles").lightSlider({loop:!0,keyPress:!0,item:5,autowidth:!1,responsive:[{breakpoint:1200,settings:{item:4,slideMove:1,slideMargin:4}},{breakpoint:992,settings:{item:3,slideMove:1,slideMargin:2}},{breakpoint:768,settings:{item:2,slideMove:1,slideMargin:2}}]}),a.slider=!0),a.abierto=!0},cerrar:function(){var a=this;$("#detalle-producto").fadeOut(a.dur),a.abierto=!1},eventos:function(){var a=this;$(document).on("click","#catalogo-accesorios .catalogo .contenido .producto",function(b){b.preventDefault(),a.abrir()}),$("#detalle-producto .container .cerrar").on("click",function(){a.cerrar()})}},st.producto.ini(),st.botonArriba={botonUp:!1,effect:"drop",direction:"down",duration:200,ini:function(){this.ponerEventos(),this.mostrarBotonUp($(window).scrollTop())},desplazarArriba:function(){$("html, body").animate({scrollTop:0},1e3)},mostrarBotonUp:function(a){if(a>100){if(this.botonUp)return;$("#boton-arriba").show({effect:this.effect,duration:this.duration,direction:this.direction}),this.botonUp=!0}else{if(!this.botonUp)return;$("#boton-arriba").hide({effect:this.effect,duration:this.duration,direction:this.direction}),this.botonUp=!1}},ponerEventos:function(){var a=this;$("#boton-arriba").click(function(){a.desplazarArriba()}),$(window).on("scroll",function(){a.mostrarBotonUp($(this).scrollTop())})}},st.botonArriba.ini(),st.modal={efecto:"drop",duracion:800,direccion:"left",easing:"easeInQuint",ini:function(){this.eventos()},obtenerNombre:function(a){return a.attr("data-modal")},obtenerId:function(a){var b=a.attr("id");return b.replace(/^modal-/,"")},abrir:function(a){$("#modal-"+a).show({effect:this.efecto,duration:this.duracion,direction:"up",easing:this.easing})},cerrar:function(){$(".st-modal").hide({effect:this.efecto,duration:this.duracion,direction:"down",easing:this.easing})},eventos:function(){var a=this;$("[data-modal]").on("click",function(b){b.preventDefault(),a.abrir(a.obtenerNombre($(this)))}),$(".st-modal .contenido .cerrar").on("click",function(){a.cerrar()})}},st.modal.ini(),st.registroIngreo={ini:function(){this.eventos()},fInscripcion:function(){$("#formulario-ingreso").slideUp(500),$("#formulario-registro").slideDown(500)},fRegistro:function(){$("#formulario-ingreso").slideDown(500),$("#formulario-registro").slideUp(500)},eventos:function(){var a=this;$("#registro-tym").on("click",function(b){b.preventDefault(),a.fInscripcion()}),$("#btn-atras-ingreso").on("click",function(){a.fRegistro()})}},st.registroIngreo.ini();
/* catálogo de accesorios */
st.catalogoAccesoriosAux = {
	// props
	abierto: false,
	dur: 800,
	efe: 'fold',
	dir: 'left',
	eas: 'linear',

	// metds
	ini: function(){
		this.eventos();
	},

	analizar: function(elm){
		if(elm.hasClass('activo')){
			elm.removeClass('activo');
			this.cerrar();
			return;
		}

		$('#accesorio-tipo').html('<div class="text-center"> <br> <p class="txt-11">Cargando accesorios...</p> <br> <img src="recursos/img/preloader-productos.gif" alt=""> </div>');

		$('#catalogo-accesorios .catalogo .indicador').css('top', elm.offset().top - 76);
		elm.addClass('activo');
        console.log(elm.attr('data-nombre'));
		$.ajax({
			url: 'recursos/php/html/inc/' + elm.attr('data-nombre') + '.php',
			type: 'get',
			dataType: 'html',
			complete: function(d){
				console.log(d);
				setTimeout(function(){
					$('#accesorio-tipo').html(d.responseText);
				},1200);
			}
		});
		this.abrir();
	},

	abrir: function(){
		var t = this;
		$('#catalogo-accesorios').fadeIn(t.dur);
		$('#catalogo-accesorios').show({
			effect: t.efe,
			duration: t.dur,
			direction: t.dir,
			easing: t.eas
		})
		t.abierto = true;
	},

	cerrar: function(){
		var t = this;
		$('#catalogo-accesorios').fadeOut(t.dur);
		$('#catalogo-accesorios').hide({
			effect: t.efe,
			duration: t.dur,
			direction: t.dir,
			easing: t.eas
		})
		$('#cabecero .menu-accesorios ul li a.activo').removeClass('activo');
		t.abierto = false;

	},

	eventos: function(){
		var t = this;
		$('.te-puede-interesar .tipo a').on('click', function(e){
			e.preventDefault();
			t.analizar($('#cabecero .menu-accesorios ul li a.accesorios'));
		});
	}
}
st.catalogoAccesoriosAux.ini();
