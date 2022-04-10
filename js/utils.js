/* Función para validar el Email
    Params:
        valor: Contiene el NIF a verificar.
        divError: Etiqueta en que la se mostrara el error en el html

*/
function validateEmail(valor, divError) {

    if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(valor)) {
        divError.innerHTML = "";
        return true;
    } else {
        divError.innerHTML = " * Email incorrecto";
        return false;
    }
}

/* Función en la que se valida el DNI
  Params:
    dni: contiene el valor del DNI a validar
    divError: Etiqueta en que la se mostrara el error en el html

*/

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

        divError.innerHTML = " * Dni erroneo, formato no válido"
        return false;
    }
}

function validateName(nombre,divError){
    var expresion=/^[a-zA-ZÀ-ÿ\s]{1,40}$/ // Letras y espacios, pueden llevar acentos.
    if(expresion.test(nombre)){
        divError.innerHTML="";
        return true;
    }
    else{
        divError.innerHTML = "<i class='fa fa-times-circle px-2' style='color: red' ></i> El nombre suele puede contener letras y espacios";  
    }
}