$('#image-gallery').lightSlider({
    gallery:true,
    item:1,
    thumbItem:9,
    slideMargin: 0,
    speed:800,
    pause: 7000,
    auto:true,
    loop:true,
    onSliderLoad: function() {
        $('#image-gallery').removeClass('cS-hidden');
    }  
});


/* objeto para esta página */
st.galerias = {};


/* ver galeria */
st.galerias.fotos = {
    // props
    dur: 600,

    // metds
    ini: function(){
        this.eventos();
    },

    verFotos: function(){
        $('#galeria').slideUp(this.dur);
        $('#fotos').slideDown(this.dur);
    },

    eventos: function(){
        var t = this;
        $('#galeria .galeria').on('click', function(){
            t.verFotos();
        });
    }
}
st.galerias.fotos.ini();