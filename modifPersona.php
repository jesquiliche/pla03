
<?php 


session_start();

$CLAVE='espingorcio';
$nifModif=$_POST['nifModif'];

$nifModif=$nifModif ^ $CLAVE;
echo $nifModif;
$lstPersonas=array();
if(isset($_POST['modiPersona'])) modificarDatos($nifModif);
if(isset($_POST['bajaPersona'])) borrarDatos($nifModif);

function modificarDatos($nif){
    $lstPersonas=$_SESSION["newsession"];
    $p=	array(
        "nif"=>trim($nif),
        "nombre"=>trim($_POST["nombre"]),
        "direccion"=>trim($_POST["direccion"]));
    $lstPersonas[trim($nif)]=$p;
    $_SESSION["newsession"]=$lstPersonas;
    $url = $_SERVER["HTTP_HOST"]."/PLA03" ;
	header('Location: http://'.$url);
        

}

function borrarDatos($nif){
    $lstPersonas=$_SESSION["newsession"];
    array_splice_assoc($lstPersonas,$nif , 1);

    $_SESSION["newsession"]=$lstPersonas;
    $_SESSION["newsession"]=$lstPersonas;
    $url = $_SERVER["HTTP_HOST"]."/PLA03" ;
	header('Location: http://'.$url);
        

}

/**
 * array_splice_assoc
 * Splice an associative array
 * Removes the elements designated by offset & length and replaces them
 * with the elements of replacement array
 * @param $input array
 * @param $key string
 * @param $length int
 * @param $replacement array
 */
function array_splice_assoc($input, $key, $length, $replacement=array()) {
    // Find the index to insert/replace at
    $index = array_search($key, array_keys($input));
    
    // How do we handle the key not existing in the array?
    // Up to you. In my case I'm going to return the original array
    // But you might want to return false, throw an error etc
    
    if($index === false) {
      return $input;
    }
}
?>
