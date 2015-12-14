/* activar tooltips de bootstrap */
//$('[data-toogle="tooltip"]').attr('data-placement', 'bottom');
$('[data-toggle="tooltip"]').tooltip();

/* elemntos de autoscroll */
$('[data-ir]').on('click', function(e){
    e.preventDefault();
    var offset = $('#'+$(this).attr('data-ir')).offset().top - 64;
    $('html, body').animate({
        scrollTop: offset,
    }, 1000);
});

var map;
function initMap() {
  map = new google.maps.Map(document.getElementById('mapa'), {
    center: {lat: 4.676541, lng: -74.141177},
    zoom: 12
  });
}

initMap();


/* variable global para el sitio */
var st = {};

// menu
st.menu = {
	// props
	abierto: false,
	dur: 300,
	efe: 'drop',
	dir: 'up',
	eas: 'easeOutCirc',

	// metds
	ini: function(){
		this.eventos();
	},

	analizar: function(){
		if(this.abierto){
			this.cerrar();
		}else{
			this.abrir();
		}
	},

	abrir: function(){
		var t = this;

		$('#cabecero .container .menu').show({
			duration: t.dur,
			effect: t.efe,
			direction: t.dir,
			easing: t.eas,
			complete: function(){
				t.abierto = true;
			}
		});
		$('#alternador-menu').css('background-image', 'url(recursos/img/alternador-menu-cerrar.png)');
	},

	cerrar: function(){
		var t = this;
		$('#cabecero .container .menu').hide({
			duration: t.dur,
			effect: t.efe,
			direction: t.dir,
			easing: t.eas,
			complete: function(){
				t.abierto = false;
			}
		});
		$('#alternador-menu').css('background-image', 'url(recursos/img/alternador-menu.png)');
	},

	eventos: function(){
		var t = this;
		$('#alternador-menu').on('click', function(){
			t.analizar();
		});
	}
}
st.menu.ini();




// menu accesorios
st.menuAccesorios = {
	// props
	abierto: true,
	dur: 300,
	efe: 'slide',
	dir: 'left',
	eas: 'easeOutCirc',

	// metds
	ini: function(){
		this.eventos();
	},

	analizar: function(){
		if(this.abierto){
			this.cerrar();
		}else{
			this.abrir();
		}
	},

	abrir: function(){
		var t = this;

		$('#cabecero .menu-accesorios').show({
			duration: t.dur,
			effect: t.efe,
			direction: t.dir,
			easing: t.eas,
			complete: function(){
				t.abierto = true;
			}
		});
		$('#alternador-menu-accesorios').css('background-image', 'url(recursos/img/bg-menu-accesorios-l.png)');
		//$('#alternador-menu-accesorios').css('left', '114px');
	},

	cerrar: function(){
		var t = this;
		$('#cabecero .menu-accesorios').hide({
			duration: t.dur,
			effect: t.efe,
			direction: t.dir,
			easing: t.eas,
			complete: function(){
				t.abierto = false;
			}
		});
		$('#alternador-menu-accesorios').css('background-image', 'url(recursos/img/bg-menu-accesorios-r.png)');
		st.catalogoAccesorios.cerrar();
	},

	eventos: function(){
		var t = this;
		$('#alternador-menu-accesorios').on('click', function(){
			t.analizar();
		});
	}
}
st.menuAccesorios.ini();





/* catálogo de accesorios */
st.catalogoAccesorios = {
	// props
	abierto: false,
	dur: 800,
	efe: 'slide',
	dir: 'left',
	eas: 'easeOutCirc',

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

		$('#cabecero .menu-accesorios ul li a.activo').removeClass('activo');
		elm.addClass('activo');
		$('#catalogo-accesorios .catalogo .indicador').css('top', elm.offset().top - 110);
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
		t.abierto = true;
	},

	cerrar: function(){
		var t = this;
		$('#catalogo-accesorios').fadeOut(t.dur);
		$('#cabecero .menu-accesorios ul li a.activo').removeClass('activo');
		t.abierto = false;
		
	},

	eventos: function(){
		var t = this;
		$('#cabecero .menu-accesorios ul li a').on('click', function(e){
			e.preventDefault();
			t.analizar($(this));
		});
	}
}
st.catalogoAccesorios.ini();






/* botonArriba */
st.botonArriba = {
    /* props */
    botonUp: false,
    effect: 'drop',
    direction: 'down',
    duration: 200,

    /* metodos */

    ini: function(){
        this.ponerEventos();
        this.mostrarBotonUp($(window).scrollTop());
    },


    desplazarArriba: function(){
        $('html, body').animate({
            scrollTop: 0
        }, 1000);
    },

    mostrarBotonUp: function(n){
        if(n > 100){
            if(this.botonUp) return;
            $('#boton-arriba').show({
            	effect: this.effect,
            	duration: this.duration,
            	direction: this.direction
            });
            this.botonUp = true;
        }else{
            if(!this.botonUp) return;
           $('#boton-arriba').hide({
            	effect: this.effect,
            	duration: this.duration,
            	direction: this.direction
            });
            this.botonUp = false;
        }
    },


    ponerEventos: function(){
        var t = this;

        $('#boton-arriba').click(function(){
            t.desplazarArriba();
        });

        $(window).on('scroll', function(){
        	t.mostrarBotonUp($(this).scrollTop());
        })

    }
}
st.botonArriba.ini();



/* modales del sitio */
st.modal = {
	/* props */
	efecto: 'drop',
	duracion: 800,
	direccion: 'left',
	easing: 'easeInQuint',

	/* metds */
	ini: function(){
		this.eventos();
	},

	obtenerNombre: function(t){
		return t.attr('data-modal');
	},

	obtenerId: function(t){
		var id = t.attr('id');
		return id.replace(/^modal-/, '');
	},

	abrir: function(nombre){
		$('#modal-'+nombre).show({
			effect: this.efecto,
			duration: this.duracion,
			direction: 'up',
			easing: this.easing
		})
	},

	cerrar: function(){
		$('.st-modal').hide({
			effect: this.efecto,
			duration: this.duracion,
			direction: 'down',
			easing: this.easing
		})
	},

	eventos: function(){
		var t = this;
		$('[data-modal]').on('click', function(e){
			e.preventDefault();
			t.abrir(t.obtenerNombre($(this)));
		});

		$('.st-modal .contenido .cerrar').on('click', function(){
			t.cerrar();
			//console.log(t.obtenerId($(this).parent().parent()));
		});
	}
}
st.modal.ini();