var Animaciones={
	init:function(){
		$("#img_posgrado").on('click keypress',Animaciones.showContenedorPosgrado);
		$("#img_ingenieria").on('click keypress',Animaciones.showContenedorIngenieria);
		$("#img_cancelar_posgrado").on('click keypress',Animaciones.showFormPosgrado);
		$("#img_cancelar_idiomas").on('click keypress',Animaciones.showFormIdiomas);
		$("#contendedor_d1").on('click keypress',".editar",Animaciones.showFormDatosEgresado);
		$("#cancelar").on('click keypress',Animaciones.showFormDatosEgresado);
		$("#img_cancelar_sw,#agregar_sw").on('click keypress',Animaciones.showFormSW);
		$("#div_dt_software").on('click keypress','#agregar_sw',Animaciones.showFormSW);
		$("#imgfrm_cancelar_academicos").on('click keypress',Animaciones.showContenedorAcademicos);
		$("#datos_academicos").on('click keypress','img.symbol-edit',Animaciones.showFormEdicionDatosAcademicos);
		$("#datos_academicos").on('click keypress','#agregar_carrera',Animaciones.showContenedorAcademicos);
	},
	showContenedorPosgrado:function(e){
		Animaciones.evaluarEvento(e,Animaciones.configurarImagenPosgrado,$(this))
	},
	showFormDatosEgresado:function(e){
		Animaciones.evaluarEvento(e,show,$(this));
	},
	showFormSW:function(e){
		Animaciones.evaluarEvento(e,show_SW,$(this));
	},
	showFormPosgrado:function(e){
		Animaciones.evaluarEvento(e,show_posgrado,$(this));
	},
	showFormIdiomas:function(e){
		Animaciones.evaluarEvento(e,show_idiomas,$(this));
	},
	showContenedorIngenieria:function(e){
		Animaciones.evaluarEvento(e,Animaciones.configurarImagenIngenieria,$(this));
	},
	showContenedorAcademicos:function(e){
		Animaciones.evaluarEvento(e,Animaciones.configurarContenedorAcademicos,$(this));
	},
	showFormDatosAcademicos:function(e){
		Animaciones.evaluarEvento(e,Animaciones.configurarContenedorAcademicos,this);
	},
	configurarContenedorAcademicos:function(obj){
        show_dt_academicos();
        document.getElementById('frm_dt_academico').dataset.registro=null;
        $(".editar_academico").show();
        $(".eliminar").show()
        $("#div_carrera_actualizar").hide();
        $("#titlo_carrera").hide();
	},
	showFormEdicionDatosAcademicos:function(){
        var nombre=this.dataset.carrera;
		document.getElementById("div_carrera_actualizar").innerHTML=nombre;
		$("#div_carrera_actualizar").show();
		$("#titlo_carrera").show();
		$(".editar_academico").hide();
		$(".eliminar").hide();
        $('#carrera').focus();
        show_dt_academicos();
	},
	configurarImagenPosgrado:function(obj){
		var img=$("#img_ingenieria");
		obj.css('border','1px solid #999');
		obj.attr('src','Imagenes/posgrado_activo.png');
		img.css('border','none');
		img.attr('src','Imagenes/ingenieria.png');
		$("#div_ingenieria").hide();
		$("#div_posgrado").fadeIn(1000);
		$(".eliminar").show();
	},
	configurarImagenIngenieria:function(obj){
		var img=$("#img_posgrado");
		obj.css('border','1px solid #999');
        obj.attr('src','Imagenes/ingenieria_activo.png');
        img.css('border','none');
        img.attr('src','Imagenes/posgrado.png');
        $("#div_posgrado").hide();
        $("#div_ingenieria").fadeIn(1000);
	},
	evaluarEvento:function(evento,funcion,obj){
		if (evento.originalEvent == "KeyboardEvent keypress") {
			if(evento.which===13){
	            funcion(obj);
	        }
	        return false;
	    }
		funcion(obj);
	}
}