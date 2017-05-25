var Toggle={
	init:function(){
		$('.toggle').click(Toggle.toggle);
		$('.toggle').click(Toggle.classCss);
	},
	toggle:function(){
		var show=this.dataset.show;
		var hide=this.dataset.hide;
		Toggle.hideShow(show,hide);
	},
	hideShow:function(show,hide){
		var show=document.getElementById(show);
	    var hide=document.getElementById(hide);
	    if (show != null && hide != null) {
	        hide.style.display='none';
	        show.style.display='block';
	    }
	},
	classCss:function(){
		var imgs=this.parentNode.getElementsByTagName('img');
		Toggle.removeClass(this,imgs);
		var img_children=this.getElementsByTagName('img');
		img_children[0].classList.add('img-title-active');
	},
	removeClass:function(obj,elements){
		var length=elements.length - 1;
		for (var i = 0; i <= length; i++) {
			elements[i].classList.remove('img-title-active');
		}
	},
	addClass:function(obj){

	}
}