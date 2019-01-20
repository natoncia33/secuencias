function obtener_icono(icono){
	var datasrc = icono.getAttribute('data-src');
	var dataid = icono.getAttribute('data-id');
    document.getElementById("icon").value = dataid;
    document.getElementById("icon-img").src = datasrc;
    document.getElementById("cerrar_modal_avatar").click();
}
function obtener_grupo(icono){
	//var datasrc = icono.getAttribute('data-src');
	var dataid = icono.getAttribute('data-id');
	//alert(" src:"+datasrc+" id:"+dataid);
    document.getElementById("icon").value = dataid;
    //document.getElementById("icon-img").src = datasrc;
     //document.querySelector(".modal").style.display="none";
     //quitarclase("#myModal","in");
     //$('#myModal').modal('hide');
     document.getElementById("cerrar_modal_grupo").click();
     //$('#myModal').hide();
     //$('.modal-backdrop').hide();
}
function quitarclase(obj,remove) {
    var newClassName = "";
    var i;
    var modales = document.querySelector(obj);
    var classes = modales.className.split(" ");
    for(i = 0; i < classes.length; i++) {
        if(classes[i] !== remove) {
            newClassName += classes[i];
            if (classes.length!= i) newClassName += " ";
        }
    }
    document.querySelector("body").className = "";
    modales.style.display="none";
    modales.className = newClassName;
    var modales2 = document.querySelector(".modal-backdrop");
    modales2.className = "";
}
function hablar(texto){
	responsiveVoice.speak(texto, "Spanish Latin American Female", {pitch: 1,rate: 1});
}
function checkDecimals(fieldName, fieldValue)
{
decallowed = 2;
if (isNaN(fieldValue) || fieldValue == "")
{
alert("No es un number.try valida de nuevo.");
fieldName.select();
fieldName.focus();
}
else
{
if (fieldValue.indexOf('.') == -1) fieldValue += ".";
dectext = fieldValue.substring(fieldValue.indexOf('.')+1, fieldValue.length);
if (dectext.length > decallowed)
{
alert ("Introduzca un numero con un maximo de " + decallowed + "decimales. vuelve a intentarlo.");
fieldName.select();
fieldName.focus();
}
else
{
alert ("Numero validado con exito.");
}
}
}
function ctck()
{
var sds = document.getElementById("dum");
if(sds == null){alert("Esta utilizando un paquete gratuito. No esta autorizado para retirar la etiqueta");}
var sdss = document.getElementById("dumdiv");
if(sdss == null){alert("Esta utilizando un paquete gratuito. No esta autorizado para retirar la etiqueta");}
}
/*document.onLoad="ctck()";*/

function confirmeliminar(page,params,tit) {
	if (confirm("¿Esta ud seguro que quiere eliminar el registro "+tit+"?")){ 
			  var body = document.body;
			  form=document.createElement('form'); 
			  form.method = 'POST'; 
			  form.action = page;
			  form.name = 'jsform';
			  for (index in params)
			  {
					var input = document.createElement('input');
					input.type='hidden';
					input.name=index;
					input.id=index;
					input.value=params[index];
					form.appendChild(input);
			  }	  		  			  
			  body.appendChild(form);
			  form.submit();
		};
	}
//fin confirmar eliminar
/* Buscar */
function nuevoAjax(){
var xmlhttp=false;
try {

htmlhttp=new activeXObject("Msxml2.XMLHTTP");
}
catch (e) {

 try {htmlhttp=new activeXObject("Microsoft.XMLHTTP");
}
catch (e) {

xhtmlhttp=false;
}
}
if (!xmlhttp && typeof XMLHttpRequest!='undefineded'){
xmlhttp=new XMLHttpRequest();
}
return xmlhttp;
}
function buscar(nombre=""){
if (nombre == ""){
	nombre = document.getElementById('buscar').value;
}
//alert("esta recibiendo datos"+funcion+" "+nombre);
ajax=nuevoAjax();
ajax.open("POST","?buscar",true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		document.getElementById('txtsugerencias').innerHTML = ajax.responseText;
		}
	}
ajax.send("datos="+nombre);
}
/* Buscar */
function cargar_secuencias(id_secuencia=""){
if (id_secuencia == ""){
	id_secuencia = document.getElementById('secuencia').value;
}
//if (id_secuencia=="Nueva")
//alert('Nueva');
//var s = "Crear Nueva Secuencia";
//alert("esta recibiendo datos"+funcion+" "+nombre);
ajax=nuevoAjax();
ajax.open("POST","?cargar_secuencias",true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		document.getElementById('txt_secuencias').innerHTML = ajax.responseText;
		}
	}
ajax.send("secuencia="+id_secuencia);
}
function nuevo_reto(id_secuencia=""){
if (id_secuencia == ""){
	id_secuencia = document.getElementById('secuencia').value;
}
//alert("esta recibiendo datos"+funcion+" "+nombre);
ajax=nuevoAjax();
ajax.open("POST","?nuevo_reto",true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		document.getElementById('area_reto').innerHTML = ajax.responseText;
		}
	}
ajax.send("secuencia="+id_secuencia);
}
function listado_secuencias(pre=''){
ajax=nuevoAjax();
ajax.open("GET","?listado_secuencias="+pre,true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		var respuesta = ajax.responseText;
		document.getElementById('listado_secuencias').innerHTML = respuesta;
		}
	}
ajax.send();
}
function puntos(usuario,operador="+",cantidad="1"){
var parametros = "usuario="+usuario+"&operador="+operador+"&cantidad="+cantidad;
//alert(parametros);
ajax=nuevoAjax();
ajax.open("POST","?puntos",true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		respuesta_puntos = ajax.responseText;
			console.log(respuesta_puntos);
			if (respuesta_puntos=="1"){
				console.log("Puntos Acumulados");
			}else{
				console.log("Puntos NO Acumulados");
			}
		}
	}
//alert(parametros);
ajax.send(parametros);
}

function insignia_a_usuario(insignia,usuario){
var parametros = "insignia="+insignia+"&usuario="+usuario;
//alert(parametros);
ajax=nuevoAjax();
ajax.open("POST","?insignia_a_usuario",true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		respuesta_puntos = ajax.responseText;
			console.log(respuesta_puntos);
			if (respuesta_puntos=="1"){
				console.log("Ganaste una Insignia");
			}else{
				console.log("Insignia no guardada");
			}
		}
	}
//alert(parametros);
ajax.send(parametros);
}
function cambiar_estado_reto(id,estado){
if (id != ""){
//alert("esta recibiendo datos"+funcion+" "+nombre);
ajax=nuevoAjax();
ajax.open("POST","?cambiar_estado_reto",true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			cargar_secuencias();
			//alert(estado);
		}
	}
ajax.send("id="+id+"&estado="+estado);
}
}
function modificar_reto(cod,dif,estado,nombre){
if (cod != ""){
//alert("esta recibiendo datos"+funcion+" "+nombre);
ajax=nuevoAjax();
ajax.open("POST","?modificar_reto",true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		document.getElementById('area_reto').innerHTML = ajax.responseText;
		}
	}
ajax.send("cod="+cod+"&dif="+dif+"&estado="+estado+"&nombre="+nombre);
}
}
function eliminar_elemento_de_reto(id_elemento_reto){
if (id_elemento_reto != ""){
ajax=nuevoAjax();
ajax.open("POST","?eliminar_elemento_de_reto",true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		var respuesta = ajax.responseText;
    		if (respuesta=="1"){
    		document.getElementById('txt_alerta').innerHTML = '<div class="alert alert-success"><strong>Eliminado!</strong></div>';
    		cargar_secuencias();
    		}else{
    		document.getElementById('txt_alerta').innerHTML = '<div class="alert alert-warning"><strong>Hubo un error al eliminar!</strong></div>';
    		}
    	setTimeout(function(){ document.getElementById('txt_alerta').innerHTML = ''; }, 3000);
    	
		}
	}
ajax.send("id_elemento_reto="+id_elemento_reto);
}
}
function alert_bootstrap(mensaje,tipo='success'){
	document.getElementById('txt_alerta').innerHTML = '<div class="alert alert-'+tipo+'"><strong>'+mensaje+'</strong></div>';
	setTimeout(function(){ document.getElementById('txt_alerta').innerHTML = '';}, 3000);
}
function guardar_secuencia(nombre_secuencia){
if (nombre_secuencia != ""){
document.getElementById('nombre_secuencia').value = '';
document.getElementById('secuencia').value = '';
nuevo_reto();
ajax=nuevoAjax();
ajax.open("POST","?guardar_secuencia",true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		var respuesta = ajax.responseText;
		console.log(respuesta);
    		if (respuesta=="1"){
    		document.getElementById('txt_alerta').innerHTML = '<div class="alert alert-success"><strong>Secuencia Creada!</strong></div>';
    		}else if (respuesta=="2"){
    		document.getElementById('txt_alerta').innerHTML = '<div class="alert alert-warning"><strong>Este nombre "'+nombre_secuencia+'" ya existe!</strong></div>';
    		}else if (respuesta=="0"){
    		document.getElementById('txt_alerta').innerHTML = '<div class="alert alert-warning"><strong>Hubo un error al Guardar!</strong></div>';
    		}
	    		setTimeout(function(){
	    		document.getElementById('txt_alerta').innerHTML = '';
		    	}, 3000);
		    	if (respuesta=="1"){
		    	setTimeout(function(){
		    		listado_secuencias(nombre_secuencia);
		    	}, 3000);
		    	}
		}
	}
var parametros ="nombre_secuencia="+nombre_secuencia;
var asignacion_docente = document.getElementById('asignacion_docente');
if (asignacion_docente)
if (asignacion_docente.value!="")
parametros += "&asignacion_docente="+asignacion_docente.value;
ajax.send(parametros);
}
}
function desactivar(id,seg=3){
	document.getElementById('btn_crear').setAttribute("disabled",true);
	setTimeout(function(){
		document.getElementById('btn_crear').removeAttribute("disabled");
	}, parseInt(seg)*1000);
	
}
function guardar_reto(){
var hijos = document.getElementById('elementos').childElementCount;
//alert(hijos);
if (hijos>1 && hijos<=4){
document.getElementById('btn_crear').setAttribute("disabled",true);
var id_secuencia = document.getElementById('secuencia').value;
var id_reto = document.getElementById('id_reto').value;
var reto = document.getElementById('reto').value;//nombre
var estados = document.getElementById('estado');
 if (estados.checked == true)
var estado = estados.value;
else
var estado = "Borrador";
    
var dificultad = document.getElementById('dificultad').value;
var correcta="";
var correctas = document.getElementsByName('correcta');
var i;
for (i=0;i<correctas.length;i++){
    if (correctas[i].checked == true)
    correcta = correctas[i].value;
}
if (correcta!=""){
var palabra = "";
var palabras = document.querySelectorAll('.lienzo_palabra');
var i;
for (i=0;i<palabras.length;i++){
    if (i>0)  palabra += ",";
    palabra += palabras[i].value;
}
var vocal="";
var vocales = document.querySelectorAll('.lienzo_vocal');
var i;
for(i=0;i<vocales.length;i++){
    if (i>0) vocal+=",";
    if (vocales[i].value!=="undefined")
    vocal+=vocales[i].value;
}
var silaba="";
var silabas = document.querySelectorAll('.lienzo_silaba-hidden');
var i;
for(i=0;i<silabas.length;i++){
    if (i>0) silaba+=",";
    if (silabas[i].value!=="undefined")
    silaba+=silabas[i].value;
}
var figura="";
var figuras = document.querySelectorAll('.lienzo_figura');
var i;
for(i=0;i<figuras.length;i++){
    if (i>0) figura+=",";
    if (figuras[i].value!=="undefined")
    figura+=figuras[i].value;
}
var parametros = "secuencia="+id_secuencia+"&id_reto="+id_reto+"&reto="+reto+"&estado="+estado+"&dificultad="+dificultad+"&correcta="+correcta;
if (palabra) parametros += "&palabra="+palabra;
if (vocal) parametros += "&vocal="+vocal;
if (silaba) parametros += "&silaba="+silaba;
if (figura) parametros += "&figura="+figura;
//console.log("esta recibiendo datos"+parametros);
ajax=nuevoAjax();
ajax.open("POST","?guardar_reto",true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		 //console.log(ajax.responseText);
		 cargar_secuencias();
		 setTimeout(function(){ 
		 	nuevo_reto();
		 	document.getElementById('btn_crear').removeAttribute("disabled");
		 }, 2000);
		 
		}
	}
ajax.send(parametros);
}else{
	alert("Debe elegir una clave");
}
}else{
	alert("Debe utilizar entre 2 y 4 elementos para crear un reto");
}
}
/*cookies*/
function leercookie(cname) {
<!--
	var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
-->
}
function grabarcookie(id,valor){
<!--
document.cookie=id+"="+valor;
-->
}
function eliminarcookie(key) {
<!--
document.cookie = key + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
-->
}
function grabarcookieinput(id){
	<!--
var valor = document.getElementById(id).value;
document.cookie=id+"="+valor;
//alert(document.cookie);
//window.open('index.php','_parent');
-->
}
function leercookieinput(id){
	<!--
	var valor=getCookie(id);
    if (valor!="") {
		document.getElementById(id).value = valor;
    }
	-->
}
function existecookie(id){
	var actual=leercookie(id);
	if (actual=="null") return false;
	else if (actual=="") return false;
	else return true;
}
function limpiar(id){
	<!--
var valor = document.getElementById(id);
valor.value="";
-->
}
/*fin cookies*/
function agregar_elemento(tipo, id='',valor='',id_reto = '',clave=''){
    //document.getElementById("id_reto").value = id_reto;
    var n =  document.getElementById("num_elemento").value;
    var tipo2 = tipo;
    if (valor!=''){
		texto2 = valor;
    }else{
    if (tipo=="silaba"){
    	tipo += "-hidden";
    	var texto2 =  document.getElementById(tipo2).value;
    }else if (tipo=="vocal"){
 	var combo = document.getElementById(tipo2);
 	var texto2 =  combo.options[combo.selectedIndex].text;
	}else if (tipo=="figura"){
	 var texto2 =  document.getElementById(tipo2).value;
	}else{
	 var texto2 =  document.getElementById(tipo2).value;
	}
}
    //texto.options[combo.selectedIndex].text;
    var texto;
	if (id!=''){
		texto = id;
	}else{
    	texto =  document.getElementById(tipo).value;
	}
	var hijos = document.getElementById('elementos').childElementCount;
    if (hijos<4){
        if (texto!="" && texto2 != ""){
            if (validaunico(texto)){
            //grabarcookie("n",n);
            var textof = '<label class="areaselementos" id="areaelemento'+n+'" for="radio'+n+'">';
            textof += '<span class="elemento"><input class="lienzo_'+tipo+'" type="hidden" name="'+tipo2+'['+n+']" id="'+texto+'" value="'+texto2+'">';
            textof += '<input required id="radio'+n+'" ';
            if (tipo=="figura")
            	textof += 'type="hidden"';
            else
            	textof += 'type="radio"';
            textof += ' name="correcta" value="'+texto2+'"';
        	if (clave=="Clave") textof +=' checked ';	
        	textof +='><span class="fig ajustar">';
            if (tipo=="figura"){
				ruta_figura = document.getElementById(tipo).getAttribute('data-url');
            	textof += '<span><img src="'+ruta_figura+'" width="120"></span>';
            }else{
            	textof += '<span>'+texto2+'</span>';
            }
            textof += '<a type="button" style="text-decoration:none;" class="btn_elim" onclick="eliminar_opcion(\'areaelemento'+n+'\')">X</a></span></span></label>';
            var area = document.getElementById("elementos")
            var div = htmlToElement(textof);
            area.appendChild(div);
            document.getElementById("num_elemento").value++;
            }else{
                alert('No se permten elementos repetidos');
            }
        }else{
            alert('Debe elegir una opción');
        }
    }else{
        alert('Unicamente se permiten agregar 4 elementos');
    }
}

function validaunico(texto) {
var text = document.getElementById(texto);
if (text){
return false;
}else{
return true;	
}
}
function inArray(elemento, arreglo) {
    var length = arreglo.length;
    for(var i = 0; i < length; i++) {
        if(arreglo[i] == elemento) return true;
    }
    return false;
}
function notinArray(elemento, arreglo) {
    var length = arreglo.length;
    for(var i = 0; i < length; i++) {
        if(arreglo[i] == elemento) return false;
    }
    return true;
}
function htmlToElement(html) {
	var template = document.createElement("template");
	template.innerHTML = html;
	return template.content.firstChild;
}
function eliminar_opcion(id){
        var nodo = document.getElementById(id);
        nodo.parentNode.removeChild(nodo);
}
function validar(){
var silaba = document.getElementById('silaba');
if (silaba.value !="" ){
var silabah  = document.getElementById('silaba-hidden');
if (silaba.value === silabah.value){
	alert('Silaba no válida');
		silaba.value = "";
		silabah.value = "";
		return false;
	}else{
		return true;  // allow form submission
	}
}
}
function selclave(){

}
function validarclave(){
	return true;
}
function nueva_secuencia(){
    		swal({   title: "Crear Nueva Secuencia",
							text: "Por favor ingrese los detalles de su cuestionario",
							type: "input",
							showCancelButton: true,
                            confirmButtonText: "Registrar",
                            cancelButtonText: "Cancelar",
							closeOnConfirm: false},

								function(inputValue)
								{
									SweetAlertMultiInputReset(); // make sure you call this
									if (inputValue!=false)
									{
										
										swal({   title: "JSON",
										text: inputValue,
										type:"success",
										closeOnConfirm: true,
										},function(){SweetAlertMultiInputFix()}); // fix used if you want to display another box immediately
										if (inputValue!=false)
										{
											var checkResults = JSON.parse(inputValue);
											//alert(checkResults);
											console.log(checkResults);
											//do stuff
											alert2('Enviando','info')
											
										}
									}
								}
							);
							
			//set up the fields: labels
			var tooltipsArray = ["Nombre","Categoría Cuestionario"];
			//set up the fields: defaults
			var defaultsArray = ["",""];
			SweetAlertMultiInput(tooltipsArray,defaultsArray);

    }
function valida_existe_grupo(nombre){
    valida_existe('grupo','nombre',nombre);
}
function valida_existe_avatar(nombre){
    valida_existe('avatar','nombre_avatar',nombre);
}
function valida_existe_email(correo){
    valida_existe('usuarios','email',correo);
}
function valida_existe_nuip(nuip){
    valida_existe('usuarios','nuip',nuip);
}
function valida_existe_nombre_secuencia(nombre){
    valida_existe('secuencia','nombre_secuencia',nombre);
}
function valida_existe(tabla,campo,valor){
//alert (tabla+campo+valor);
ajax=nuevoAjax();
var url = "?valida_existe";
ajax.open("POST",url,true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			var respuesta = ajax.responseText;
			//console.log(respuesta);
			var destino = document.getElementById("txt"+campo);
			if(respuesta=="1"){
			//console.log("Ya esta registrado");
			document.getElementById("submit").setAttribute("disabled","true");
				if (destino) destino.innerHTML = "<input type='text' title='Ya esta registrado' style='width: 0px;height: 0px;background-color: transparent;border-width: 0px;' required><b>Ya esta registrado</b>";
			}else if(respuesta=="0"){
			//console.log("Disponible");
			//document.getElementById("txt"+campo).innerHTML = "";
			document.getElementById("submit").removeAttribute("disabled");
			if (destino) destino.innerHTML = "<b>Disponible</b>";
			}
		
		}
	}
var parametros = "tabla="+tabla+"&campo="+campo+"&valor="+valor;
//alert (parametros);
ajax.send(parametros);
}
function valida_asignacion_secuencia(){
var valor =document.getElementById('id_secuencia').value;
var valor2=document.getElementById('id_estudiante').value;
valida_existe_par('secuencia_estudiante','id_secuencia',valor,'id_estudiante',valor2);
}
function valida_elemento_juego(){
var valor =document.getElementById('tipo').value;
var valor2=document.getElementById('nombre_elemento').value;
valida_existe_par('elementos_juego','tipo',valor,'nombre_elemento',valor2);
}
function valida_insignia(){
var valor =document.getElementById('nombre_insignia').value;
var valor2=document.getElementById('aciertos').value;
valida_existe_par('insignia','nombre_insignia',valor,'aciertos',valor2);
}
function estudiantes_no_matriculados(){
	var destino = 'span_estudiante'
	var estudiante = $("#"+destino).attr("pre");
	var id_anio = $("#anio").val();
ajax=nuevoAjax();
var url = "?estudiantes_no_matriculados";
ajax.open("POST",url,true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			var respuesta = ajax.responseText;
			if(respuesta){
			document.getElementById(destino).innerHTML = respuesta;
			valida_matricula();
			}
		
		}
	}
var parametros = "id_anio="+id_anio+"&estudiante="+estudiante;
//alert (parametros);
ajax.send(parametros);
}
function valida_matricula(){
var valor  = document.getElementById('anio').value;
var valor2 = document.getElementById('estudiante').value;
console.log(valor+valor2);
valida_existe_par('matricula','anio',valor,'estudiante',valor2);
}
function valida_existe_par(tabla,campo,valor,campo2,valor2){
//alert (tabla+campo+valor+campo2+valor2);
if (valor.length>0 && valor2.length>0){
ajax=nuevoAjax();
var url = "?valida_existe_par";
ajax.open("POST",url,true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			var respuesta = ajax.responseText;
			//console.log("txt"+valor+valor2);
			//console.log(respuesta);
			var destino = document.getElementById("txt"+campo+campo2);
			if(respuesta=="1"){
			//console.log("Ya esta registrado");
			document.getElementById("submit").setAttribute("disabled","true");
			if (destino) destino.innerHTML = "<input type='text' title='Ya esta registrado' style='width: 0px;height: 0px;background-color: transparent;border-width: 0px;' required><b>Ya esta registrado</b>";
			}else if(respuesta=="0"){
			//console.log("Disponible");
			//document.getElementById("txt"+campo).innerHTML = "";
			document.getElementById("submit").removeAttribute("disabled");
			if (destino) destino.innerHTML = "<b>Disponible</b>";
			}
		
		}
	}
var parametros = "tabla="+tabla+"&campo="+campo+"&valor="+valor+"&campo2="+campo2+"&valor2="+valor2;
//alert (parametros);
ajax.send(parametros);
}else{
	document.getElementById("txt"+campo+campo2).innerHTML = "";
}
}

function valida_asignacion(){
var valor =document.getElementById('grupo').value;
var valor2=document.getElementById('docente').value;
var valor3=document.getElementById('anio').value;
//console.log(valor+valor2+valor3 );
if (valor !="" && valor2 !="" && valor3 !="")
valida_existe_trio('asignacion','grupo',valor,'docente',valor2,'anio',valor3);
}
function valida_existe_trio(tabla,campo,valor,campo2,valor2,campo3,valor3){
//alert (tabla+campo+valor);
if (valor.length>0 && valor2.length>0 && valor3.length>0){
ajax=nuevoAjax();
var url = "?valida_existe_trio";
ajax.open("POST",url,true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			var respuesta = ajax.responseText;
			//console.log("txt"+valor+valor2);
			//console.log(respuesta);
			var destino = document.getElementById("txt"+campo+campo2+campo3);
				if(respuesta=="1"){
			//console.log("Ya esta registrado");
			document.getElementById("submit").setAttribute("disabled","true");
			if (destino) destino.innerHTML = "<input type='text' title='Ya esta registrado' style='width: 0px;height: 0px;background-color: transparent;border-width: 0px;' required><b>Ya esta registrado</b>";
			}else if(respuesta=="0"){
			//console.log("Disponible");
			//document.getElementById("txt"+campo).innerHTML = "";
			document.getElementById("submit").removeAttribute("disabled");
			if (destino) destino.innerHTML = "<b>Disponible</b>";
			}
		
		}
	}
var parametros = "tabla="+tabla+"&campo="+campo+"&valor="+valor+"&campo2="+campo2+"&valor2="+valor2+"&valor3="+valor3+"&campo3="+campo3;
//alert (parametros);
ajax.send(parametros);
}else{
	document.getElementById("txt"+campo+campo2).innerHTML = "";
}
}
function soloNumeros(e){
	//uso en input  onKeyPress="return soloNumeros(event)"
	var key = window.Event ? e.which : e.keyCode
	//alert (key);
	return (key >= 48 && key <= 57)
	//return ((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key==190)  || (key==110) || (key==8)  || (key==9) || (key==38) || (key==40) || (key==46));
}
function validar_elemento_juego(valor=""){
var tipo = document.getElementById('tipo');
var txt_valida_silaba = document.getElementById('txt_valida_silaba');
var archivo = document.getElementById('archivo');
var area_adjunto = document.getElementById('area_adjunto');
if (tipo){
if (tipo.value=="Silaba"){
archivo.removeAttribute("required");
area_adjunto.style.display="none";
if (valor.length==1){
txt_valida_silaba.innerHTML = "Advertencia, Puede que "+valor+" no sea una Sílaba";
}else if (valor.length>2){
txt_valida_silaba.innerHTML = "Advertencia, Puede que "+valor+" no sea una Sílaba";
}else{
txt_valida_silaba.innerHTML = "";
}
}else if (tipo.value=="Figura"){
txt_valida_silaba.innerHTML = "";
var pre = $("#submit").val();
if (pre=="Nuevo")
archivo.setAttribute("required","required");
else
archivo.removeAttribute("required");
var chk_cambiar_imagen = document.getElementById('chk_cambiar_imagen');
if (chk_cambiar_imagen) chk_cambiar_imagen.checked=true;
area_adjunto.style.display="block";
}else{
archivo.removeAttribute("required");
area_adjunto.style.display="none";
txt_valida_silaba.innerHTML = "";
}
}
}
function mostrarImagen(input) {
//Objetivo: Vista previa de la imágen antes de subirla
//Parametro: el objeto input
//require un objeto con la id "img_"+input.id
//ejemplo: en un <input type="file" onchange="mostrarImagen(this);">
 if (input.files && input.files[0]) {
  var reader = new FileReader();
  reader.onload = function (e) {
  	//alert(input.id);
   $('#img_'+input.id).attr('src', e.target.result);
  }
  reader.readAsDataURL(input.files[0]);
 }
}
function sugerir_nombre_adjunto(){
var nombre_elemento = document.getElementById('nombre_elemento');
var archivo = document.getElementById('archivo');
var archivo_value = archivo.value.replace("C:\\fakepath\\","");
var res = archivo_value.split(".");
nombre_elemento.value = res[0];
}
function sugerir_nombre_insignia(){
var nombre_elemento = document.getElementById('nombre_insignia');
var archivo = document.getElementById('foto_insignia');
var archivo_value = archivo.value.replace("C:\\fakepath\\","");
var res = archivo_value.split(".");
nombre_elemento.value = res[0];
}
function sugerir_nombre_avatar(){
var nombre_elemento = document.getElementById('nombre_avatar');
var archivo = document.getElementById('img_avatar');
var archivo_value = archivo.value.replace("C:\\fakepath\\","");
var res = archivo_value.split(".");
nombre_elemento.value = res[0];
}
function valida_adjunto_img(input){
    var archivo=input.value;
    var extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
    var nomarchivo = (archivo.substring(archivo.lastIndexOf("\\")+1));
    //extensiones
    if (extension == ".png" || extension == ".jpg"){
			if(checkSize(input)){
			
			}else{
			input.value= "";
			}
    }else{
    alert("Error, Solamente se permiten archivos PNG o JPG");
    input.value= "";
    }
}
function checkSize(input){
    var max_img_size_input = document.getElementById("MAX_FILE_SIZE");
    if(max_img_size_input){
    var max_img_size = max_img_size_input.value;
    // check for browser support (may need to be modified)
    console.log(input.files[0].size);
    if(input.files && input.files.length == 1)
    {           
        if (input.files[0].size > max_img_size) 
        {
            alert("El archivo deberia ser menor a " + (max_img_size/1024/1024) + "MB");
            input.value= "";
            return false;
        }
    }

    return true;
    }else{
    	alert("Error, el formulario no contiene un campo MAX_FILE_SIZE que indique el tamaño máximo del adjunto");
    return false
    }
}
function Graficar(titulo,cualitativa,cuantitativa,contenedor,tipo_grafica,ancho,alto,datos) {
var objeto = [[cualitativa,cuantitativa]];
for (id in datos.elementos){objeto[objeto.length]=[datos.elementos[id].cualitativo, parseInt(datos.elementos[id].cuantitativo)];}
var data = google.visualization.arrayToDataTable(objeto);//Cerramos la creación de la variable datodocument.write();s
eval('new google.visualization.'+tipo_grafica+'(document.getElementById("'+contenedor+'")).       draw(          data,{title:"'+titulo+'",width: "'+ancho+'",height:"'+alto+'",});');
}
function alert2(mensaje='',t='success',avatar=false){
	//alert(mensaje);
	/*
	* t='error'
	* t='success'
	* t='warning'
	* t='info'
	<a onclick="alert2('No se','info')">Prueba</a>
	<a onclick="alert2('No se','name_image')">Prueba</a>
	*/
if (t=='error' || t=='success' || t=='warning'  || t=='info'){
	swal(
    mensaje,
    '',
    t
  )
}else{
	if (avatar==false){
	var myImage = new Image();
	myImage.src = '../img/png/'+t+'.png';
	swal({
            title: mensaje,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> Aceptar',
            text: "<img height='90' src='"+ myImage.src +"'/>",
            html: "<img height='90' src='"+ myImage.src +"'/>"
        });
	}else{
		/*
	* t='acierto' (2|3)*53 px 
	* t='fallo' 0px
	*/
	var x = 0;
	if (t=='acierto'){
		x = (Math.floor((Math.random() * 5) + 1)*100)*-1;
	}else if (t=='fallo'){
		x = -600;
	}
	//console.log(x);
		var myImage = new Image();
		var image = leercookie('img_avatar');
		//alert(image);
		myImage.src = '../img/Avatars/'+image+'';
		swal({
		title: mensaje,
		confirmButtonText: '<i class="fa fa-thumbs-up"></i> Aceptar',
		text: "<div style=\"background: url('"+ myImage.src +"');background-size:700px 193px; height: 193px;width: 100px;background-position: "+x+"px 0px; background-repeat: no-repeat;display:inline-block;margin-bottom:-8px;\" ></div>",
		html: "<div style=\"background: url('"+ myImage.src +"');background-size:700px 193px; height: 193px;width: 100px;background-position: "+x+"px 0px; background-repeat: no-repeat;display:inline-block;margin-bottom:-8px;\" ></div>"
		});
	}
}
}
function mostrar_ficha(detonado,detonante=''){
    var grupo="fichas";
       var obj_detonado = document.querySelector("#"+detonado);
       var sel_grupos = document.querySelectorAll("."+grupo);
        for (i=0; i<sel_grupos.length; i++){
            if (sel_grupos[i]==obj_detonado){
                $("#"+detonado).toggle(100);
            }else{
                //$("#"+sel_grupos[i].id).hide(100);
                document.getElementById(sel_grupos[i].id).style.display="none";
                console.log(''+i+": "+sel_grupos[i].id);
            }
        }
    $(".toogle").removeClass("toogle_active");
    $("#"+detonante).addClass("toogle_active");
}
function buscar_iconos(nombre="",destino=''){
if (nombre == ""){
	nombre = document.getElementById('buscar_iconos').value;
}
//alert("esta recibiendo datos"+funcion+" "+nombre);
ajax=nuevoAjax();
ajax.open("POST","?buscar_iconos",true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		var resultado_span = document.getElementById('txtresultadosicono'+destino);
		if (resultado_span) resultado_span.innerHTML = ajax.responseText;
		}
	}
ajax.send("datos="+nombre+"&destino="+destino);
}
function cuadre(destino){
    var icono_seleccionado = document.getElementById('icono_seleccionado'+destino);
    document.getElementById('figura').value = icono_seleccionado.value;
    var destino_url = icono_seleccionado.getAttribute('data-url');
    document.getElementById('figura').setAttribute('data-url',destino_url);
}
$(document).ready(function() {
$("#btn_crear").click(function() {
desactivar('btn_crear');
});
});
$(document).ready(function() {
    $('.form_ajax').submit(function(event) {
        event.stopPropagation();
        event.preventDefault();
        var resp_1 = $(this).attr('resp_1');
        var resp_0 = $(this).attr('resp_0');
        var callback_1 = $(this).attr('callback_1');
        var callback_0 = $(this).attr('callback_0');
        var callback = $(this).attr('callback');
        
        var type = "post";
        var url = $(this).prop("action");
        /* Cuando mandamos sólo texto (sin archivos)
             configuramos estos valores */
        var contentType = 'application/x-www-form-urlencoded';
        var processData = true;

        /* Para que PHP reciba todos los archivos hay que definir
             el <input> con corchetes, de modo que aquí tenemos que
             indicarlo igual */
        if ((this['adjunto'] && this['adjunto'].files.length) || (this['archivo'] && this['archivo'].files.length)) {
            var data = new FormData(this);
            /* En este caso sí que hay que cambiar estos parámetros,
                 en particular contentType=false provoca una cabecera HTTP
                 'multipart/form-data; boundary=----...' */
            contentType = false;
            processData = false;
        } else {
            var data = $(this).serialize();
        }
        $.ajax({
            url: url,
            data: data,
            type: type,
            contentType: contentType,
            processData: processData
        }).done(function(data) {
        	console.log(data);
            if (data=="1"){
            alert(resp_1);
            eval(callback_1);
            }else if (data=="0"){
            alert(resp_0,'danger');
            eval(callback_0);
            }else{
             alert(data,'warning');   
            }
            setTimeout(function(){
                eval(callback);
            },2000);
        });
    });
});
function sonidos_juego(tipo='acierto'){
	var x = (Math.floor((Math.random() * 3) + 1));
	var y = (Math.floor((Math.random() * 11) + 1));
	if (tipo=='acierto')
	eval ('var audio = new Audio(\'../audio/arpa'+x+'.wav\');audio.play();');
	if (tipo=='bien'){
		try {
			/* code */
	eval ('var audio = new Audio(\'../audio/bien'+y+'.mp3\');audio.play();');
		} catch (e) {
	hablar('Muy bien!');
		}
	}
	
}