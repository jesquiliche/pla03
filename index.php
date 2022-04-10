<?php
error_reporting(1);
require_once "./components/head.php";
require_once "./components/cabecera.php";
require_once "./utils/utils.php";


session_start();
const CLAVE = "espingorcio";
if(isset($_SESION["errores"])){
	$lstErrores=$_SESION["errores"];
	
} else{ 
	$lstErrores=array();
}

$lstPersonas = array();
$lstPersonas = $_SESSION["newsession"];
//$lstErrores = $_SESSION["errores"];
$lstErrores=array();

$mensaje="";


$nif = "";
$nombre = "";
$direccion = "";
$includeJs=true;

if (isset($_POST["nif"])) $nif = $_POST["nif"];
if (isset($_POST["nombre"])) $nombre = $_POST["nombre"];
if (isset($_POST["direccion"])) $direccion = $_POST["direccion"];


if (isset($_POST["darAlta"])) {

	alta($lstPersonas, $lstErrores);
}

if (isset($_POST["baja"])) {

	borrarTodos($lstPersonas,$lstErrores);
}


//Da de alta una nueva persona.
function alta(&$lstPersonas, &$lstErrores)
{

	try {
		$nif = trim($_POST["nif"]);
		$nombre = trim($_POST["nombre"]);
		$direccion = trim($_POST["direccion"]);

		//Validación de campos
		if (!validateDNI($nif)) {
			throw new Exception("Nif incorrecto");
		}
		if (isEmpty($nombre)) {
			throw new Exception("Nombre requerido");
		}
		if (isEmpty($direccion)) {
			throw new Exception("Dirección requerido");
		}

		//El array esta vacio?
		if (!isset($lstPersonas)) {
			//Cargar personas
			$lstPersonas = $_SESSION["newsession"];
			//Dar de alta persona
			$p = array(
				"nif" => $nif,
				"nombre" => $nombre,
				"direccion" => $direccion
			);
			$lstPersonas[trim($nif)] = $p;

			reseteaControles();
			$mensaje = "Alta efectuada";
		// si no existe la clave procede con el alta
		} elseif (!array_key_exists($nif, $lstPersonas)) {
			$p =	array(
				"nif" => $nif,
				"nombre" => $_POST["nombre"],
				"direccion" => $_POST["direccion"]
			);
			$lstPersonas[$_POST["nif"]] = $p;
			//Guardar datos
			$_SESSION["newsession"] = $lstPersonas;
			global $mensaje;
			reseteaControles();			
			$mensaje = "Alta efectuada";

			//Existe el nif ya en la lista
		} elseif (array_key_exists($nif, $lstPersonas)) {
			global $mensaje;
			$mensaje = "Persona ya existe";
		};
		ordenarArray($lstPersonas);
		$_SESSION["newsession"] = $lstPersonas;
	} catch (Exception $e) {
		array_push($lstErrores, $e->getMessage());
		$_SESSION["errores"] = $lstErrores;
	}
}

function ordenarArray(&$lstPersonas)
{
	$aux = array();
	foreach ($lstPersonas as $key => $row) {
		$aux[$key] = $row['nif'];
	}
	array_multisort($aux, SORT_ASC, $lstPersonas);
}

//Borra todas las persons de la lista
function borrarTodos(&$lstPersonas, &$lstErrores)
{
	try {
		unset($lstPersonas);
		$_SESSION["newsession"] = $lstPersonas;
		//Volver a cargar el index, para volver a cargar los datos
		$url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
		header('Location: http://' . $url);
	} catch (Exception $e) {
		array_push($lstErrores, $e->getMessage());
		$_SESSION["errores"] = $lstErrores;
	}
}

//Limpia los controles del formulario
function reseteaControles()
{
	global $nombre;
	global $nif;
	global $direccion;
	$nombre="";
	$nif="";
	$nombre="";
	$direccion="";
}


?>

<main>
	<div class="card col-lg-10 py-3 mt-3 mx-auto bg-light">
		<h1 class='mx-auto'><b>PLA03: MANTENIMIENTO PERSONAS</b></h1>
		<br>
		<form method='post' action='#' id="formulario">
			<div class="row mb-3">
				<label for="nif" class="col-sm-2 col-form-label ">
					<i class='fa fa-id-card fa-lg px-3'></i>
					Nif
				</label>
				<div class="col-lg-3">
					<input type="text" class="form-control" id="nif" name='nif' value=<?= $nif ?>>
				</div>
				<div id="nifError" class="text-danger mt-2"></div>
			</div>
			<div class="row mb-3">
				<label for="nombre" class="col-sm-2 col-form-label">
					<i class='fa fa-user-circle fa-lg px-3'></i>
					Nombre
				</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="nombre" name="nombre" value=<?="'".$nombre."'" ?>>
				</div>
				<div id="nombreError" class="text-danger mt-2"></div>
			</div>
			<div class="row mb-3">
				<label for="direccion" class="col-sm-2 col-form-label">
					<i class='fa fa-user-circle fa-lg px-3'></i>
					Dirección
				</label>
				
				<div class="col-sm-6">
					<input type="text" 
					class="form-control" id="direccion" 
					name="direccion" class="text-danger" value=<?php echo "'".$direccion."'" ?>>

				</div>
				<div id="dirError" class="text-danger mt-2"></div>
			</div>
			<label for="nombre" class="col-sm-2 col-form-label"></label>
			<input type='hidden' name="darAlta">

			<button type="submit" class="btn btn-success" name='alta'>Alta persona</button>
			<span><?= $mensaje ?></span>
			<span></span>
			<?php showErrors($lstErrores); ?>
		</form><br>
		

		<table class="table table-hover">
			<tr>
				<th scope="col">NIF</th>
				<th scope="col">Nombre</th>
				<th scope="col">Dirección</th>
				<th scope="col">

				</th>
			</tr>

			<?php
			// Comprobamos que la lista no este vacia
			if (isset($lstPersonas)) {
				//Montar lista
				foreach ($lstPersonas as $persona) {
					$nifCifrado = $persona["nif"] ^ CLAVE;
					echo "
			<tr >
				<td class='nif' data-nif = '" . $nifCifrado . "'>" . $persona["nif"] . "</td>
				<form method='post' name='formularioModif' id='modifPersona' action='modifPersona.php'>
				<td valign='middle' ><input type='text' id='nom' name='nom' required
				value='" . $persona['nombre'] . "' 
				class='form-control nombre'>
				<div id='nombreError2' class='text-danger'>
				
				</div>
				</td>
					<td><input type='text' name='direccion' id='direccion' required
						value='" . $persona['direccion'] . "' class='form-control direccion'></td>
						<div id='dirError2' class='text-danger'>
						</div>
					<td>
		      	
		      		<input type='hidden' name='nifModif' value='" . $nifCifrado . "'>
		     		<button type='submit' class='btn btn-danger' name='bajaPersona' id='bajaPersona'>Baja</button>
					<button type='submit' class='btn btn-warning modificar' name='modiPersona'>Modificar</button>
		      	</form>
			  </td>
			</tr>";
			}
		}
		?>
		</table>

		<form method='post' action='#' id='formularioBaja'>
			<input type='hidden' id='baja' name='baja'></input>
			<button type="submit" class="btn btn-danger" name='baja' id="baja" onsubmit="borrarTodos($lstPersonas,$lstErrores)">Baja personas</button>
		</form>

		<!--FORMULARIO OCULTO PARA LA MODIFICACION-->
		<form method='post' action='#' id='formularioModi'>
			<input type='hidden' name='nifModi'>
			<input type='hidden' name='nombreModi'>
			<input type='hidden' name="direccionModi">
			<input type='hidden' name='modificar'>
		</form>
		<?php
		
	
		?>
	</div>
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<!--<script type="text/javascript" src='./js/scripts.js'></script>-->
<?php
if($includeJs){
	echo "<script type='text/javascript' src='./js/utils.js'></script>
	<script type='text/javascript' src='./js/app.js'></script>";
}
?>
</body>

</html>