<?php
// retorna false(0) si hay errror o el DNI validado y con letra si no hay error 
function validateDNI($dni)
{
    $str = trim($dni);
    $str = str_replace("-", "", $str);
    $str = str_ireplace(" ", "", $str);
    $n = substr($str, 0, strlen($str) - 1);
    $n = intval($n);
    if (!is_int($n)) {
        return false;
    }
    $l = substr($str, -1);
    if (!is_string($l)) {
        return false;
    }
    $letra = substr("TRWAGMYFPDXBNJZSQVHLCKE", $n % 23, 1);
    if (strtolower($l) == strtolower($letra)) {
        return $n . $l;
    } else {
        return false;
    }
}

//Función que valida el Email develovera True o false, dependiendo si el valor
// es correcto o no
function validateEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // echo "{$email}: A valid email"."<br>";
        return true;
    } else {
        return false;
    }
}

//Función para determinar si el valor es nulo o esta vacio.
function isEmpty($valor)
{
    if (empty(trim($valor)) || $valor == "")
        return true;
    return false;
}

//Funcion para deterninar si $value esta comprendio en un determinado rango
// de valores.
function isNumber($value, $minValue, $maxValue)
{
    $value = floatval($value);
    if ($value > $maxValue || $value < $minValue)
        echo "${value} no esta comprendido entre ${minValue} y ${maxValue}";
    else
        echo null;
}

//Muestre un Array de errores en un DIV dentro del formulario
function showErrors($errores)
{

	try {
        // Solo dibujar el Div si existen errores
		if (count($errores) > 0) {
			echo "<div class='card col-lg-10 mx-auto py-3'>";
			echo "<div class='card-title mx-auto'>";
			echo "<b><b>Errores de validación</b>";
			echo "</div>";
			for ($x = 0; $x < count($errores); $x++) {
				echo "<div>";
				echo "<i class='fa fa-times-circle px-2' style='color: red' ></i> " . $errores[$x] . "<br>";
				echo "<div>";
			}
			echo "<div>";
		}
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}