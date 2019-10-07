<?php
require_once "conf.php";

$id = isset($_GET['ID'])? $_GET['ID'] : null;

if (!empty($id)) {
	try {
		$con = new PDO('mysql:host=localhost;dbname='.DB_NAME, DB_USER, DB_PASS);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Delete
		$stmt = $con->prepare('DELETE from city WHERE id=:id');
		$rows = $stmt->execute(array(
				':id' => $_GET['ID']
			));
		
		if( $rows == 1 )
			echo "<h3>Eliminado correctamente.</h3>";
		else
			echo "<h3>Error al eliminar.</h3>";

		
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Listado práctica DI 1.1</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/list.css">
</head>
<body>	
	<h1>Práctica DI 1.1</h1>
	
	<nav>
		<form action="form.php" method="POST">
			<!--<input type="hidden" name="ID" value="1" />-->
			<input type="submit" name="Nueva" value="nueva" />
		</form>
	</nav>

	<?php require "list.php";?>
</body>
</html>