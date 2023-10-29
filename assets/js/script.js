document.getElementById("btn__iniciar-sesion_vendedor").addEventListener("click", vendedor);
document.getElementById("btn__iniciar-sesion_admin").addEventListener("click", admin);
window.addEventListener("resize", anchoPagina);

var contenedor_login = document.querySelector(".contenedor__login")
var formulario_login_admin = document.querySelector(".formulario__login-admin")
var formulario_login_vendedor = document.querySelector(".formulario__login-vendedor")
var caja_trasera_admin = document.querySelector(".caja__trasera-admin")
var caja_trasera_vendedor = document.querySelector(".caja__trasera-vendedor")
var usuarioAdminInput = document.querySelector(".formulario__login-admin input[type='text']")
var contrasenaAdminInput = document.querySelector(".formulario__login-admin input[type='password']");
var usuarioVendedorInput = document.querySelector(".formulario__login-vendedor input[type='text']")
var contrasenaVendedorInput = document.querySelector(".formulario__login-vendedor input[type='password']");


formulario_login_admin.style.display = "block";

function anchoPagina(){
    if(window.innerWidth > 850){
        caja_trasera_admin.style.display = "block";
        caja_trasera_vendedor.style.display = "block";
        if(formulario_login_admin.style.display == "block"){
            contenedor_login.style.left = "10px";
        }
        else{
            contenedor_login.style.left = "410px";
        }
    }
    else{
        if(formulario_login_admin.style.display == "block"){
            caja_trasera_vendedor.style.display = "block";
            caja_trasera_vendedor.style.opacity = "1";
            caja_trasera_admin.style.display = "none";
            formulario_login_admin.style.display = "block";
            formulario_login_vendedor.style.display = "none";
            contenedor_login.style.left = "0px";
        }
        else{
            caja_trasera_vendedor.style.display = "none";
            caja_trasera_vendedor.style.opacity = "0";
            caja_trasera_admin.style.display = "block";
            formulario_login_admin.style.display = "none";
            formulario_login_vendedor.style.display = "block";
            contenedor_login.style.left = "0px";
        }
        
    }
}

anchoPagina();

function admin(){
    usuarioVendedorInput.value = "";
    contrasenaVendedorInput.value = "";
    if(window.innerWidth > 850){
        formulario_login_vendedor.style.display = "none";
        contenedor_login.style.left = "10px";
        formulario_login_admin.style.display = "block";
        caja_trasera_vendedor.style.opacity = "1";
        caja_trasera_admin.style.opacity = "0";
    }
    else{
        formulario_login_vendedor.style.display = "none";
        contenedor_login.style.left = "0px";
        formulario_login_admin.style.display = "block";
        caja_trasera_vendedor.style.display = "block";
        caja_trasera_admin.style.display = "none";
        caja_trasera_vendedor.style.opacity = "1";
    }
    
}

function vendedor(){
    usuarioAdminInput.value = "";
    contrasenaAdminInput.value = "";
    if(window.innerWidth > 850){
        formulario_login_vendedor.style.display = "block";
        contenedor_login.style.left = "410px";
        formulario_login_admin.style.display = "none";
        caja_trasera_vendedor.style.opacity = "0";
        caja_trasera_admin.style.opacity = "1";
    }
    else{
        formulario_login_vendedor.style.display = "block";
        contenedor_login.style.left = "0px";
        formulario_login_admin.style.display = "none";
        caja_trasera_vendedor.style.display = "none";
        caja_trasera_admin.style.display = "block";
        caja_trasera_admin.style.opacity = "1";
    }
    
}