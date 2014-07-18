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

/////////////////////////////////////////////////////////////////////////Administracion usuarios Polanco ////////////////////////////////////////

//Funcion para actualizar informacion de empleados
function updateEmple(){
	var error="";
	var form=document.formUpdateEmpl;

	if(form.nombre.value=="" || form.apellido.value=="" || form.user.value=="" || form.pass.value=="" || form.idDepto.value=="" || form.idNivel.value=="" || form.apellido.value=="idEmpresa"){
		error+="\n -Proporcionar Datos Del Empleado";
	}

	if(error==""){		
		form.updateEM.value="updateEM";
		form.submit();
	}else{
		alert(error);
	}
}

//Funcion para agregar a un empleado
function addConfEmpleado(){
	var error="";
	var form=document.formNuevoEmpleado;

	if(form.nombre.value=="" || form.apellido.value=="" || form.user.value=="" || form.pass.value=="" || form.idDepto.value=="" || form.idNivel.value==""){
		error+="\n -Proporcionar Datos Empleado";
	}

	if(error==""){		
		form.nuevaEM.value="ADD";
		form.submit();
	}else{
		alert(error);
	}
}

//Valida datos del update departamento
function updateDepar(){
var error="";
var form=document.formUpdateDepartamento;

if(form.nombre.value==""){
		error+="\n -Proporcionar Datos Del Departamento";
	}

	if(error==""){		
		form.updateDE.value="updateDE";
		form.submit();
	}else{
		alert(error);
	}

}	


//Valida datos del insert departamento
function addConfDepartamento(){
	var error="";
	var form=document.formNuevoDepartamento;

	if(form.nombre.value==""){
		error+="\n -Proporcionar Datos Del Departamento";
	}

	if(error==""){		
		form.nuevaDepto.value="ADD";
		form.submit();
	}else{
		alert(error);
	}
}


//Valida datos del update Nivel
function updateNive(){
var error="";
var form=document.formUpdateNiveles;

if(form.nombre.value==""){
		error+="\n -Proporcionar Datos Del Nivel";
	}

	if(error==""){		
		form.updateNI.value="updateNI";
		form.submit();
	}else{
		alert(error);
	}

}


//Valida datos del Insert Niveles
function addConfNiveles(){
	var error="";
	var form=document.formNuevoNiveles;

	if(form.nombre.value==""){
		error+="\n -Proporcionar Datos Del Nivel";
	}

	if(error==""){		
		form.nuevaNive.value="ADD";
		form.submit();
	}else{
		alert(error);
	}
}

/////////////////////////////////////////////////////////////////////////Administracion usuarios Polanco ////////////////////////////////////////	