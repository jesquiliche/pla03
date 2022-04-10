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
