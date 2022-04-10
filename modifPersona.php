
<?php 

require_once "./utils/utils.php";
$mensajeModif="";

session_start();

$CLAVE='espingorcio';
$nifModif=$_POST['nifModif'];
$nombre=$_POST['nom'];
$direccion=$_POST['direccion'];


$nifModif=$nifModif ^ $CLAVE;

$lstPersonas=array();
$lstErrores=array();

$lstPersonas=$_SESSION["newsession"];



if(isset($_POST['modiPersona'])) modificarDatos($nifModif,$lstErrores);

if(isset($_POST['bajaPersona'])) borrarDatos($nifModif,$lstErrores);
showErrors($lstErrores);

function modificarDatos($nif,&$lstErrores){
    $lstPersonas=$_SESSION["newsession"];
    try{
        if(!validateDNI($nif)){
            throw new Exception("Nif no valido");
        }
        if(!array_key_exists($nif, $lstPersonas)){
            throw new Exception("Nif no existe en la base de datos"); 
        }
        if(isEmpty($_POST["nom"])) {
            throw new Exception("Nombre es requerido"); 
        }
        
        if(empty($_POST["direccion"])){
            throw new Exception("Dirección es requerida"); 
        }

        $p=	array(
            "nif"=>trim($nif),
            "nombre"=>trim($_POST["nom"]),
            "direccion"=>trim($_POST["direccion"]));
        $lstPersonas[trim($nif)]=$p;
        $_SESSION["newsession"]=$lstPersonas;
        $url = $_SERVER["HTTP_HOST"]."/PLA03" ;
        header('Location: http://'.$url);
        global $mensajemodif; 
        $mensajemodif="Persona dada de baja";    

    } catch(Exception $e) {
       array_push($lstErrores,$e->getMessage());
       echo $e->getMessage();
    }
        

}

function borrarDatos($nif,&$lstErrores){
    try{
        $lstPersonas=$_SESSION["newsession"];
        if(!validateDNI($nif)){
            throw new Exception("Nif no valido");
        }
        if(!array_key_exists($nif, $lstPersonas)){
            throw new Exception("Nif no existe en la base de datos"); 
        }
        if(isEmpty($_POST["nom"])) {
            throw new Exception("Nombre es requerido"); 
        }
        
        if(empty($_POST["direccion"])){
            throw new Exception("Dirección es requerida"); 
        }


      
        $lstPersonas=$_SESSION["newsession"];
    
        unset($lstPersonas[$nif]);
        global $mensaje;
        global $mensajemodif;
        $mensajemodif="Persona dada de baja";
    
        $_SESSION["newsession"]=$lstPersonas;
    
        $url = $_SERVER["HTTP_HOST"]."/PLA03" ;
        header('Location: http://'.$url);
    }
    catch(Exception $e){
        array_push($lstErrores,$e->getMessage());
        $_SESSION["errores"] = $lstErrores;
    }
    

}

