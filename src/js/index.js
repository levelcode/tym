// variable para el sitio 
st.index = {};

st.index.buscador = {
	// props

	// metds
	ini: function(){
		this.eventos();
	},

	analizar: function(){
		if($('#p').val() == ''){
			st.ventanaInfo.abrir('Por favor seleccione una marca');
		}else if($('#p1').val() == ''){
			st.ventanaInfo.abrir('Por favor seleccione un modelo');
		}else if($('#p2').val() == ''){
			st.ventanaInfo.abrir('Por favor seleccione un año');
		}else{
			if(!st.menuAccesorios.abierto){
				st.menuAccesorios.abrir();
			}
			$('#catalogo-accesorios .catalogo .indicador').css('top', '14px');
			st.catalogoAccesorios.abrir();
		}
	},

	eventos: function(){
		var t = this;

		$('#boton-busqueda-vehiculo').on('click', function(e){
			e.preventDefault();
			t.analizar();
		});
	}
}

st.index.buscador.ini();