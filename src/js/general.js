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
	abierto: false,
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

		$('#cabecero .container .menu-accesorios').show({
			duration: t.dur,
			effect: t.efe,
			direction: t.dir,
			easing: t.eas,
			complete: function(){
				t.abierto = true;
			}
		});
		$('#alternador-menu-accesorios .flecha').html('<i class="fa fa-arrow-left"></i>');
		$('#alternador-menu-accesorios').css('left', '114px');
	},

	cerrar: function(){
		var t = this;
		$('#cabecero .container .menu-accesorios').hide({
			duration: t.dur,
			effect: t.efe,
			direction: t.dir,
			easing: t.eas,
			complete: function(){
				t.abierto = false;
			}
		});
		$('#alternador-menu-accesorios .flecha').html('<i class="fa fa-arrow-right"></i>');
		$('#alternador-menu-accesorios').css('left', '14px');
	},

	eventos: function(){
		var t = this;
		$('#alternador-menu-accesorios').on('click', function(){
			t.analizar();
		});
	}
}
st.menuAccesorios.ini();


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