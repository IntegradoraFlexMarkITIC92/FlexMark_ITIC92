// script.js para la validacion

/*  ====================   Login Admin  ====================   */
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


/*  ====================   Validacion Empresas  ====================   */

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

/*  ====================   Validacion para agregar una empresa de facturacion ====================   */
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


/*  ====================   Validacion para actualizar una empresa de facturacion ====================   */
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

/*  ====================   Validacion para agregar una configuracion  ====================   */
function addConf(){
	var error="";
	var form=document.formNuevaConf;

	if(form.titlee.value=="" || form.iva.value==""){
		error+="\n -Proporcionar Datos";
	}

	if(error==""){		
		form.nuevaCG.value="ADD";
		form.submit();
	}else{
		alert(error);
	}
}

/*  ====================   Validacion para actualizar una configuracion  ====================   */
function updateConG(){
	var error="";
	var form=document.formUpdCG;

	if(form.titlee.value=="" || form.iva.value==""){
		error+="\n -Proporcionar Datos";
	}

	if(error==""){		
		form.updateCG.value="update";
		form.submit();
	}else{
		alert(error);
	}
}	


/*  ====================   Validacion para agregar una categoria  ====================   */
function addCategoria(){
	var error="";
	var form=document.formNuevaCat;

	if(form.nombre.value=="" || form.nivelCategoria.value=="" || form.catPadre.value==""){
		error+="\n -Proporcionar Datos";
	}

	if(error==""){		
		form.nuevaCat.value="ADD";
		form.submit();
	}else{
		alert(error);
	}
}

/*  ====================   Validacion para actualizar una categoria  ====================   */

function updCategoria(){
	var error="";
	var form=document.formUpdCat;

	if(form.nombre.value=="" || form.nivelCategoria.value=="" || form.catPadre.value==""){
		error+="\n -Proporcionar Datos";
	}

	if(error==""){		
		form.updCat.value="update";
		form.submit();
	}else{
		alert(error);
	}
}

/*  ====================   Validacion para agregar un  producto  ====================   */
function addPro(){
	var error="";
	var form=document.formNuevoPro;

	if(form.descripcionCorta.value=="" || form.descripcion.value=="" || form.precio.value=="" || form.existencia.value=="" || form.rangoMM.value=="" || form.precioMM.value=="" || form.rangoMayoreo.value=="" || form.precioMayoreo.value==""){
		error+="\n -Proporcionar Datos";
	}

	if(error==""){		
		form.nuevoProd.value="ADD";
		form.submit();
	}else{
		alert(error);
	}
}

/*  ====================   Validacion para actualizar un  producto  ====================   */
function updPro(){
	var error="";
	var form=document.formNuevoPro;

	if(form.descripcionCorta.value=="" || form.descripcion.value=="" || form.precio.value=="" || form.existencia.value=="" || form.rangoMM.value=="" || form.precioMM.value=="" || form.rangoMayoreo.value=="" || form.precioMayoreo.value==""){
		error+="\n -Proporcionar Datos";
	}

	if(error==""){		
		form.updProd.value="upd";
		form.submit();
	}else{
		alert(error);
	}
}

/*  ====================   Validacion para agregar una promocion  ====================   */
function addPromo(){
	var error="";
	var form=document.formNuevoPromo;

	if(form.descCorta.value=="" || form.descripcion.value=="" || form.inicio.value=="" || form.fin.value=="" || form.producto.value==""){
		error+="\n -Proporcionar Datos";
	}

	if(error==""){		
		form.nuevaPromo.value="ADD";
		form.submit();
	}else{
		alert(error);
	}
}

/*  ====================   Validacion para actualizar una  promocion  ====================   */
function updPromocion(){
	var error="";
	var form=document.formNuevoPromo;

	if(form.descCorta.value=="" || form.descripcion.value=="" || form.inicio.value=="" || form.fin.value==""){
		error+="\n -Proporcionar Datos";
	}

	if(error==""){		
		form.updPromo.value="upd";
		form.submit();
	}else{
		alert(error);
	}
}

///////////////////////////////////////Administracion usuarios Polanco ////////////////////////////////////////

/*  ====================   Validacion para agregar un empleado  ====================   */
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


/*  ====================   Validacion para actualizar un empleado  ====================   */
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

/*  ====================   Validacion para agregar un departamento  ====================   */
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


/*  ====================   Validacion para actualizar un departamento  ====================   */
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


/*  ====================   Validacion para agregar un nivel  ====================   */
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

/*  ====================   Validacion para actualizar un nivel  ====================   */
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

/*  ====================   Validacion para actualizar un Cliente  ====================   */
function updateCliente(){
	var error="";
	var form=document.formUpdateClie;

	if(form.nombre.value=="" || form.apellido.value=="" || form.titulo.value=="" || form.user.value=="" || form.pass.value==""){
		error+="\n -Proporcionar Datos Del Cliente";
	}

	if(error==""){		
		form.updateCli.value="updateCli";
		form.submit();
	}else{
		alert(error);
	}
}