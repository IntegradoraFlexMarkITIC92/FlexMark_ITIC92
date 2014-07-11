// script.js para la validacion
//Login Admin
function validar(){
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

function update(){
	var error="";
	var form=document.formEmpresaEdit;
	
	if(form.nombreEmpresa.value=="" || form.direccionEmpresa.value=="" || form.razonSocialEmpresa.value==""){
		error+="\n -Proporcionar Datos";
	}
	if(error==""){
			form.conn.value="now";
			form.submit();
	}
}

//Funcion para agregar una empresa para facturacion
function addRS(){
	var error="";
	var form=document.formNueva;

	if(form.razonSocial.value=="" || form.rfc.value=="" || form.direccion.value=="" || form.cp.value=="" || form.municipio.value=="" || form.estadosList.value==""){
		error+="\n -Proporcionar Datos";
	}

	if(error==""){		
		form.nuevaRS.value="ADD";
		form.submit();
	}else{
		alert(error);
	}
}	


//Funcion para actualizar una empresa para facturacion
function updateRSo(){
	var error="";
	var form=document.formUpdate;

	if(form.razonSocial.value=="" || form.rfc.value=="" || form.direccion.value=="" || form.cp.value=="" || form.municipio.value=="" || form.estadosList.value==""){
		error+="\n -Proporcionar Datos";
	}

	if(error==""){		
		form.updateRS.value="update";
		form.submit();
	}else{
		alert(error);
	}
}	

//Funcion para agregar una nueva configuracion
function addConf(){
	var error="";
	var form=document.formNuevaConf;

	if(form.logo.value=="" || form.titlee.value=="" || form.iva.value==""){
		error+="\n -Proporcionar Datos";
	}

	if(error==""){		
		form.nuevaCG.value="ADD";
		form.submit();
	}else{
		alert(error);
	}
}

//Funcion para actualizar una configuracion general
function updateConG(){
	var error="";
	var form=document.formUpdateConf;

	if(form.logo.value=="" || form.titlee.value=="" || form.iva.value==""){
		error+="\n -Proporcionar Datos";
	}

	if(error==""){		
		form.updateCG.value="update";
		form.submit();
	}else{
		alert(error);
	}
}	