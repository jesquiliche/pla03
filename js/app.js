

const form = document.getElementById("formulario");
const nif = document.getElementById("nif");
let nombre=document.getElementById("nombre");
console.log(nombre.value);
let nifError = document.getElementById("nifError");
let nombreError=document.getElementById("nombreError");
let nombreError2=document.getElementById("nombreError2");
let direccion=document.getElementById("direccion");
let dirError=document.getElementById("dirError");

const formBajaPersonas = document.getElementById("formularioBaja");

//Validación de formulario
form.addEventListener("submit", function (evt) {
    evt.preventDefault();
    // Comprueba si es un DNI correcto (entre 5 y 8 letras seguidas de la letra que corresponda).
    var validaDNI = validateDNI(nif.value, nifError);
    var validaNombre = validateName(nombre.value,nombreError)
    var validaAddres=validateAddres(direccion.value,dirError)
    if (validaDNI && validaNombre && validaAddres) {
        
        form.submit();

    } else {
          
        return false;
    }
});

formBajaPersonas.addEventListener("submit", function (evt) {
    evt.preventDefault();
    if (confirm("¿Esta seguro de que desea borrar todas las personas?")) {
        this.submit()
        return true;
    }
    else {
        return false;
    }

});

function validateName(nombre,divError){
    var expresion=/^[a-zA-ZÀ-ÿ-09\s]{1,40}$/ // Letras y espacios, pueden llevar acentos.
    
    if((nombre!==undefined && nombre!="" && expresion.test(nombre)) ){
        divError.innerHTML="";
        
    
        return true;
    }
    else {
    
        divError.innerHTML = "<i class='fa fa-times-circle px-2' style='color: red' ></i> El nombre suele puede contener letras y espacios";  
        return false;
    }

};

function validateAddres(direccion,divError){
    if(direccion.trim()!=="" && direccion.trim()!=null){
    
        divError.innerHTML="";
        return true;

    }
    else{
        divError.innerHTML = "<i class='fa fa-times-circle px-2' style='color: red' ></i> La dirección es requerida";  
        return false;
    }
}

function validateDNI(dni, divError) {

    var numero,
        let, letra;
    var expresion_regular_dni = /^[XYZ]?\d{5,8}[A-Z]$/;


    dni = dni.toUpperCase();

    if (expresion_regular_dni.test(dni) === true) {
        numero = dni.substr(0, dni.length - 1);
        numero = numero.replace('X', 0);
        numero = numero.replace('Y', 1);
        numero = numero.replace('Z', 2);
        let = dni.substr(dni.length - 1, 1);
        numero = numero % 23;
        letra = 'TRWAGMYFPDXBNJZSQVHLCKET';
        letra = letra.substring(numero, numero + 1);
        if (letra !=
            let) {

            divError.innerHTML = "<i class='fa fa-times-circle px-2' style='color: red' ></i> rrrrDni erroneo, la letra del NIF no se corresponde";
            return false;
        } else {
            divError.innerHTML = "";
            return true;
        }
    } else {

        divError.innerHTML = "<i class='fa fa-times-circle px-2' style='color: red' ></i> Nif Incorrecto"
        return false;
    }
}

//activar listener del boton de baja de todas las personas

//activar listener de los botones de modificación de persona
console.log("entro")
var botonsModificar = document.querySelectorAll('.modificar')
console.log(botonsModificar)

botonsModificar.forEach(function(boto) {
	console.log(boto)
	boto.onclick = traslladarDades
})

//función para trasladar los datos de la fila seleccionada al formulario oculto
function traslladarDades() {
	/*
	<tr>
      <td class='nif'>40000000A</td>
      <td><input type='text' value='O-Ren Ishii' class='nombre'></td>
      <td><input type='text' value='Graveyard avenue, 66' class='direccion'></td>
      <td>
      	<form method='post' action='#'>
      		<input type='hidden' name='nifModif' value='40000000A'>
      		<button type="submit" class="btn btn-warning" name='bajaPersona'>Baja</button>
      	</form>
      	<button type="button" class="btn btn-primary modificar" name='modiPersona'>Modificar</button>
      </td>
    </tr>
	*/

	//situarnos en la etiqueta tr que corresponda a la fila donde se encuentra el botón
	var tr = this.closest('tr') //buscar l'etiqueta tr de la fila a la que pertany el botó on l'usuari a fet click

	//recuperar los datos de la persona
	var nif = tr.querySelector('.nif').innerText // 40000000A
	 var nom = tr.querySelector('.nombre').value
     var dir = tr.querySelector('.direccion').value// O-Ren Ishii
    let nombreError=tr.querySelector("nombreErro2");    
    let dirError=tr.querySelector("dirError2");
    var validaNombre = validateName(nom,nombreError)
    if(!validaNombre) nom.value=" * nombre es requerido";
 //   var validaDireccion= validateAddres(dir,dirError)
   // let nombreError=document.getElementById("nombreError2");
	
	
	document.querySelector('[name=nifModi]').value = nif
	
	//submit del formulario
    if(validaNombre)
	    document.querySelector('#formularioModi').submit()
}
	