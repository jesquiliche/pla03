<?php
	error_reporting(1);
	require_once "./components/head.php";
	require_once "./components/cabecera.php";
	require_once "./utils/utils.php";
	

	session_start();
	const CLAVE="espingorcio";
	$lstPersonas=array();
	$lstPersonas=$_SESSION["newsession"];
	$lstErrores=array();

	$mensaje="";

	$nif="";
	$nombre="";
	$direccion="";

	if(isset($_POST["nif"])) $nif=$_POST["nif"];
	if(isset($_POST["nombre"])) $nombre=$_POST["nombre"];
	if(isset($_POST["direccion"])) $direccion=$_POST["direccion"];
	
	


		
	

	
	if (isset($_POST["darAlta"])){
	
		alta($lstPersonas,$lstErrores);	
		
	}

	if (isset($_POST["baja"])){
			
		borrarTodos($lstPersonas);
	}



	/*if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}*/

	//Da de alta una nueva persona.
	function alta(&$lstPersonas,&$lstErrores) {
		
		
			$nif=$_POST["nif"];
			//El array esta vacio?
			if(!isset($lstPersonas)){
				//Cargar personas
				$lstPersonas=$_SESSION["newsession"];
				$p=	array(
					"nif"=>trim($nif),
					"nombre"=>trim($_POST["nombre"]),
					"direccion"=>trim($_POST["direccion"]));
				$lstPersonas[trim($nif)]=$p;
				
				ordenarArray($lstPersonas);
				$_SESSION["newsession"]=$lstPersonas;
				global $mensaje; 
				$mensaje="Alta efectuada";
			}
			elseif (!array_key_exists($nif,$lstPersonas)) {
			
				$p=	array(
					"nif"=>$nif,
					"nombre"=>$_POST["nombre"],
					"direccion"=>$_POST["direccion"]);
				$lstPersonas[$_POST["nif"]]=$p;
				

				$_SESSION["newsession"]=$lstPersonas;
				global $mensaje; 
				$mensaje="Alta efectuada";
			} elseif (array_key_exists($nif,$lstPersonas)) {
				global $mensaje;
				$mensaje="Persona ya existe";
			};
			ordenarArray($lstPersonas);
			$_SESSION["newsession"]=$lstPersonas;
		
	
	
}

	function ordenarArray(&$lstPersonas){
		$aux=array();
		foreach ($lstPersonas as $key => $row) {
			$aux[$key] = $row['nif'];
		}
		array_multisort($aux, SORT_ASC, $lstPersonas);
	}

	function borrarTodos(&$lstPersonas){
	
		unset($lstPersonas);
		$_SESSION["newsession"]=$lstPersonas;
		$url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
		header('Location: http://'.$url);
	}

	//inicializar variable de sesión

	//inicialización de variables

	//array para guardar las personas

	//si existe la variable de sesión substituyo el contenido del array
		
	//ALTA DE PERSONA

		//recuperar los datos sin espacios en blanco -trim()-
				
		//validar datos obligatorios

		//validar que el nif no exista en la base de datos
			
		//guardamos el nombre y dirección en minúsculas con la primera letra en mayúsculas
			
		//guardar la persona en el array
			
		//mensaje de alta efectuada
			
		//limpiar el formulario
			

	//BAJA DE TODAS LAS PERSONAS
	
		//inicializar el array
		

	//BAJA DE LA PERSONA SELECCIONADA EN LA TABLA
	
		//recuperar el nif
		
		//validar nif informado
		
		//borrar la fila del array
			
		//mensaje de baja efectuada
			

	//MODIFICACION DE LA PERSONA SELECCIONADA
	
		//recuperar los datos sin espacios en blanco -trim()-
						
		//validar datos
			
		//validar que el nif no exista en la base de datos
			
		//guardamos el nombre y dirección en minúsculas con la primera letra en mayúsculas
			
		//modificar la persona en el array
			
		//mensaje de modificación efectuada
			

	//CONSULTA DE PERSONAS

	//ordenar el array por nif
	
	//confeccionar la tabla con las personas del array
	

	//volcar el contenido del array en la variable de sesión

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
		      <input type="text" 
			  	class="form-control" 
				id="nif" 
				name='nif'
				value=<?=$nif?>>
		    </div>
			<div id="nifError" class="text-danger mt-2" role="alert"></div>
		  </div>
		  <div class="row mb-3">
		    <label for="nombre" class="col-sm-2 col-form-label">
			<i class='fa fa-user-circle fa-lg px-3'></i>
			Nombre
			</label>
		    <div class="col-sm-6">
		      <input type="text" 
			  	class="form-control" 
				id="nombre" 
				name="nombre"
				value=<?=$nombre?>>
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
			  	class="form-control" 
				id="direccion" 
				name="direccion"
				value="<?php $direccion?>">
			  
		    </div>
			<div id="dirError" class="text-danger mt-2"></div>
		  </div>
		  <label for="nombre" class="col-sm-2 col-form-label"></label>
		  <input type='hidden' name="darAlta">

		  <button type="submit" class="btn btn-success" name='alta'>Alta persona</button>
		<span><?=$mensaje?></span>
		  <span></span>
		</form><br>

		<table class="table table-hover">
			<tr>
				<th scope="col">NIF</th>
				<th scope="col">Nombre</th><
					<th scope="col">Dirección</th>
					<th scope="col">

					</th>
			</tr>
			
			<?php
			if(isset($lstPersonas)){ 
			foreach($lstPersonas as $persona){
			$nifCifrado = $persona["nif"] ^ CLAVE;
				echo "
			<tr >
		      <td class='nif' data-nif = '".$nifCifrado."'>".$persona["nif"]."</td>
			  <form method='post' name='formularioModif' id='modifPersona' action='modifPersona.php'>
		      <td><input type='text' name='nom' required
			   value='".$persona['nombre']."' 
			   class='form-control nombre'>
			   <div id='nombreError2' class='text-danger'>
			
			   </div>
			   </td>
		      <td><input type='text' name='direccion' required
			  	value='".$persona['direccion']."' class='form-control direccion'></td>
				  <div id='dirError2' class='text-danger'>
			
				  </div>
			  <td>
		      	
		      		<input type='hidden' name='nifModif' value='".$nifCifrado."'>
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
			<button type="submit" class="btn btn-danger" name='baja'id="baja" onsubmit="borrarTodos($lstPersonas)">Baja personas</button>
		</form>

		<!--FORMULARIO OCULTO PARA LA MODIFICACION-->
		<form method='post' action='#' id='formularioModi'>
			<input type='hidden' name='nifModi'>
			<input type='hidden' name='nombreModi'>
			<input type='hidden' name="direccionModi">
			<input type='hidden' name='modificar'>
		</form>
		</div>
	</main>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script type="text/javascript" src='./js/scripts.js'></script>
	<script type="text/javascript" src='./js/utils.js'></script>";
	<script type="text/javascript" src='./js/app.js'></script>";
</body>
</html>