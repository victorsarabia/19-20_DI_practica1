<?php
require_once "conf.php";

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit();

// Recoge la ciudad de BD si se pasa su identificador
$id = null;
$name = null;
$countryCode = null;
$district = null;
$population = null;

if (isset($_GET['ID']) && !empty($_GET['ID'])) {
	try {
		$con = new PDO('mysql:host=localhost;dbname='.DB_NAME, DB_USER, DB_PASS);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $con->prepare('SELECT * FROM city where id=:id');
		$stmt->execute(array(':id' => $_GET['ID']));

		if ( $datos = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			$id = $datos["ID"];
			$name = $datos["Name"];
			$countryCode = $datos["CountryCode"];
			$district = $datos["District"];
			$population = $datos["Population"];
		}

		} catch(PDOException $e) {
		  echo 'Error: ' . $e->getMessage();
		}

}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Formulario Ciudades</title>
	<link rel="stylesheet" type="text/css" href="css/form.css">
</head>
<body>
<h1>Práctica DI 1.1</h1>
<nav>
	<form action="index.php" method="POST">
		<input type="submit" name="list" value="Listado" />
	</form>
</nav>
<form method="POST" action="insert_update_form.php">
	<fieldset>
		<legend>Ciudad</legend>
		ID: <input name='ID' type='text' tabindex='1' readonly value="<?php echo $id ?>" />
		Nombre: <input name='Name' type='text' tabindex='2' value="<?php echo $name ?>" />
  		Cód. País: <input name='CountryCode' type='text' tabindex='3' value="<?php echo $countryCode ?>" />
  		Distrito: <input name='District' type='text' tabindex='4' value="<?php echo $district ?>" >
  		Población: <input name='Population' type='text' tabindex='5' value="<?php echo $population ?>" />

  		<input type="submit" name="guardar" value="Guardar" />
  		<input type="button" name="cancelar" value="Cancelar" />
	</fieldset>
	
</form>
</body>
</html>
