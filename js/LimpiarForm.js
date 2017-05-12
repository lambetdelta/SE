var LimpiarForm={
	init:function(){
		$('img.limpiar_form').on('click keypress',LimpiarForm.limpiar);
	},
	limpiar:function(e){
		var target=this.dataset.target; 
		evaluarEvento(e,limpiaForm,$("#"+target))
	}
}