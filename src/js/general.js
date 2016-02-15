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



/* ventanaInfo */
st.ventanaInfo = {
    /* Porps */
    tempo: 400,
	efecto: 'drop',
	easing: 'easeInOutQuart',
	timeout: null,
	duracionVentana: 10000,
	direction: 'right',

    /* Methods */
    ini: function(){
        this.ponerEventos();
    },

    abrir: function(txt){
    	var t = this;

        if(typeof txt == 'string'){
        	t.abierto = true;
            $('#ventana-info .contenido').html(txt);

            $('#ventana-info').show({
				effect: t.efecto,
				duration: t.tempo,
				easing: t.easing,
				direction: t.direction
			});

			clearTimeout(t.timeout);

            t.timeout = setTimeout(function(){
            	t.cerrar();
            }, t.duracionVentana);
            
        }else{
            console.error('Debe pasarse un string a la función');
        }
    },

    cerrar: function(){
    	var t = this;
    	clearTimeout(this.timeout);
        $('#ventana-info').hide({
			effect: this.efecto,
			duration: this.tempo,
			easing: this.easing,
			direction: this.direction
		});
		
    }, 

    ponerEventos: function(){
        var t = this;

        $('#ventana-info .cerrar').click(function(){
            t.cerrar();
        });

        $('[data-ventana-info]').on('click', function(e){
        	e.preventDefault();
        	clearTimeout(t.timeout);
        	t.abrir($(this).attr('data-ventana-info'));
        });

        $('#ventana-info').on('mouseenter', function(){
        	clearTimeout(t.timeout);
        })

        $(document).on('keypress', function(e){
        	if(e.keyCode == 27){
        		t.cerrar();
        	}
        });
    }
}

st.ventanaInfo.ini();






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

		$('#cabecero .menu').show({
			duration: t.dur,
			effect: t.efe,
			direction: t.dir,
			easing: t.eas,
			complete: function(){
				t.abierto = true;
			}
		});
		$('#alternador-menu').css({
			'background-image': 'url(recursos/img/alternador-menu-cerrar.png)',
			'background-color': 'transparent',
		});
	},

	cerrar: function(){
		var t = this;
		$('#cabecero .menu').hide({
			duration: t.dur,
			effect: t.efe,
			direction: t.dir,
			easing: t.eas,
			complete: function(){
				t.abierto = false;
			}
		});
		$('#alternador-menu').css({
			'background-image': 'url(recursos/img/alternador-menu.png)',
			'background-color': 'rgba(0, 0, 0, 0.4)'
		});
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
		var t = this,
			bp = 768;
		$('#alternador-menu-accesorios').on('click', function(){
			t.analizar();
		});

		$(window).on({
			load: function(){
				if($(this).width() < bp){
					t.cerrar();
				}
			},
			resize: function(){
				if($(this).width() < bp){
					if(!t.abierto) return;
					t.cerrar();
				}else{
					if(t.abierto) return;
					t.abrir();
				}
			}
		});
	}
}
st.menuAccesorios.ini();






// menu accesorios
st.btnCarroCompra = {
	// props
	btnGrande: true,

	// metds
	ini: function(){
		this.eventos();
	},


	grande: function(){
		var t = this;
		$('#btn-carro-compras').css({
			right: '-8px',
			'font-size': '12px'
		});
		t.btnGrande = true;
		console.log('grande');
	},

	pequeno: function(){
		var t = this;
		$('#btn-carro-compras').css({
			right: '-136px',
			'font-size': '18px'
		});
		t.btnGrande = false;
		console.log('pequeño');
	},

	eventos: function(){
		var t = this,
			bp = 768;

		$(window).on({
			load: function(){
				if($(this).width() < bp){
					t.pequeno();
				}
			},
			resize: function(){
				if($(this).width() < bp){
					if(!t.btnGrande) return;
					t.pequeno();
				}else{
					if(t.btnGrande) return;
					t.grande();
				}
			}
		});
	}
}
st.btnCarroCompra.ini();





/* catálogo de accesorios */
st.catalogoAccesorios = {
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

		$('#cabecero .menu-accesorios ul li a.activo').removeClass('activo');
		elm.addClass('activo');
		$('#catalogo-accesorios .catalogo .indicador').css('top', elm.offset().top - 76);
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
		//$('#catalogo-accesorios').fadeIn(t.dur);
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
		//$('#catalogo-accesorios').fadeOut(t.dur);
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
		$('#cabecero .menu-accesorios ul li a').on('click', function(e){
			e.preventDefault();
			t.analizar($(this));
		});

		$('#catalogo-accesorios .catalogo > .cerrar').on('click', function(){
			t.cerrar();
		});
	}
}
st.catalogoAccesorios.ini();




/* detalles de produto */
st.producto = {
	// props
	abierto: false,
	dur: 800,
	efe: 'slide',
	dir: 'left',
	eas: 'easeOutCirc',
	slider: false,

	// metds
	ini: function(){
		this.eventos();
	},

	abrir: function(){
		var t = this;

		$('#detalle-producto').fadeIn({
			duration: t.dur,
			complete: function(){
			}
		});
		if(!t.slider){
			console.log('entró');
			$("#slider-productos-compatibles").lightSlider({
				loop:true,
				keyPress:true,
				item: 5,
				autowidth: false,
				responsive: [
					{
						breakpoint: 1200,
						settings: {
							item: 4,
							slideMove: 1,
							slideMargin: 4
						}
					},
					{
						breakpoint: 992,
						settings: {
							item: 3,
							slideMove: 1,
							slideMargin: 2
						}
					},
					{
						breakpoint: 768,
						settings: {
							item: 2,
							slideMove: 1,
							slideMargin: 2
						}
					}
				]
			});
			t.slider = true;
		}

		t.abierto = true;
	},

	cerrar: function(){
		var t = this;
		$('#detalle-producto').fadeOut(t.dur);
		t.abierto = false;
	},

	eventos: function(){
		var t = this;
		$(document).on('click', '#catalogo-accesorios .catalogo .contenido .producto', function(e){
			e.preventDefault();
			t.abrir();
		});

		$('#detalle-producto .container .cerrar').on('click', function(){
			t.cerrar();
		});
	}
}
st.producto.ini();






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




st.registroIngreo = {
	// props

	// metds
	ini: function(){
		this.eventos();
	},

	fInscripcion: function(){
		$('#formulario-ingreso').slideUp(500);
		$('#formulario-registro').slideDown(500);
	},

	fRegistro: function(){
		$('#formulario-ingreso').slideDown(500);
		$('#formulario-registro').slideUp(500);
	},


	eventos: function(){
		var t = this;
		$('#registro-tym').on('click', function(e){
			e.preventDefault();
			t.fInscripcion();
		});

		$('#btn-atras-ingreso').on('click', function(){
			t.fRegistro();
		});
	}
}
st.registroIngreo.ini();




/* inicializar slider de productos compatibles en catalogo-productos/detalle */
/*$("#slide-productos-compatibles").lightSlider({
	loop:true,
	keyPress:true
});*/