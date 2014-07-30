/*  ====================   Login Admin  ====================   */
function validarCliente(){
	var error="";
	var form=document.login;
	
	if(form.user.value=="" || form.pass.value==""){
		error+="\n -Proporcionar Datos";
	}
	if(error==""){
			form.conn.value="now";
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