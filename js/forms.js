function formhash(form, NIP) {
    // Crea una entrada de elemento nuevo, esta será nuestro campo de contraseña con hash.
    //var p = document.createElement("input");
// 
//    // Agrega el elemento nuevo a nuestro formulario.
//    form.appendChild(p);
//    p.name = "p";
//    p.type = "hidden";
//    p.value = hex_sha512(NIP.value);
// 
//    // Se asegura de que la contraseña en texto simple no se envíe.
//    NIP.value = "";
// 
//    // Finalmente envía el formulario.
    form.submit();
}// JavaScript Document
function navegador(){
	var navegador = navigator.userAgent;
 	 if (navigator.userAgent.indexOf('MSIE') !=-1) {
    alert('Estás usando Internet Explorer para una mejor experiencia de uso cambia de navegador');
  	} 
	}