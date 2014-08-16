/*  ====================   Login Admin  ====================   */
function validarCliente(){
	var error="";
	var form=document.login;
	var url = document.URL;	
	
	if(form.user.value=="" || form.pass.value==""){
		error+="\n -Proporcionar Datos";
	}
	if(error==""){
			form.conn.value="now";
			form.uD.value =url;
			form.submit();
	}
}

/*  ====================   Validacion para agregar un cliente  ====================   */
function addConfCliente(){
	var error="";
	var form=document.formNuevoCliente;

	if(form.nombre.value=="" || form.apellido.value=="" || form.titulo.value=="" || form.user.value=="" || form.pass.value==""){
		error+="\n -Proporcionar Datos Del Cliente";
	}

	if(error==""){		
		form.nuevaCli.value="ADD";
		form.submit();
	}else{
		alert(error);
	}
}

/*  ====================   Validacion para agregar un cliente  ====================   */
function updCliente(){
	var error="";
	var form=document.formUpdCliente;

	if(form.nombre.value=="" || form.apellido.value=="" || form.titulo.value=="" || form.user.value==""){
		error+="\n -Proporcionar Datos Del Cliente";
	}

	if(error==""){		
		form.updCli.value="UPD";
		form.submit();
	}else{
		alert(error);
	}
}


/*  ====================   Validacion para agregar un direccion  ====================   */
function addDirEnvio(){
	var form=document.formNuevoEnvio;
	form.nuevoEnvio.value="ADD";
	form.submit();
}

/*  ====================   Validacion para agregar un direccion  ====================   */
function updDirEnvio(){
	var form=document.formEnvio;
	form.upd.value="UPD";
	form.submit();
}
/*  ====================   Validacion para agregar un direccion  ====================   */
function addNewRFC(){
	var form=document.formNuevoRFC;
	form.nuevo.value="ADD";
	form.submit();
}

/*  ====================   Validacion para agregar un direccion  ====================   */
function updRFC(){
	var form=document.formRFC;
	form.upd.value="UPD";
	form.submit();
}