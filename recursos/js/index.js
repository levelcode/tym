st.index={},st.index.buscador={ini:function(){this.eventos()},analizar:function(){""==$("#p").val()?st.ventanaInfo.abrir("Por favor seleccione una marca"):""==$("#p1").val()?st.ventanaInfo.abrir("Por favor seleccione un modelo"):""==$("#p2").val()?st.ventanaInfo.abrir("Por favor seleccione un año"):(st.menuAccesorios.abierto||st.menuAccesorios.abrir(),st.catalogoAccesorios.abrir())},eventos:function(){var a=this;$("#boton-busqueda-vehiculo").on("click",function(b){b.preventDefault(),a.analizar()})}},st.index.buscador.ini();