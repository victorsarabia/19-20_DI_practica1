<?php
require_once "conf.php";

try {
  $con = new PDO('mysql:host=localhost;dbname='.DB_NAME, DB_USER, DB_PASS);
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $con->prepare('SELECT * FROM city');
  $stmt->execute();
?>
<script type="text/javascript">
	function eliminar(id) {
		var r = confirm("Estás seguro de eliminar la ciudad " + id);
		if (r == true) {
		  // TODO eliminar
		  console.log("Eliminar: " +id);
		  window.location="index.php?ID="+id;
		}
	}	
</script>

<table>
	<thead>
	<tr>
		<th>ID</th>
		<th>Nombre</th>
		<th>Cód. país</th>
		<th>Distrito</th>
		<th>Población</th>
		<th>Acciones</th>
	</tr>
	</thead>
	<tbody>		
	<?php
	while( $datos = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    	echo '<tr>';
    	echo '<td>'. $datos['ID'] .'</td>';
    	echo '<td>'. $datos['Name'] .'</td>';
    	echo '<td>'. $datos['CountryCode'] .'</td>';
    	echo '<td>'. $datos['District'] .'</td>';
    	echo '<td>'. $datos['Population'] .'</td>';
    	echo '<td>
    			<a href=\'form.php?ID='. $datos['ID'] . '\'> Modificar </a>
    			<a onclick="eliminar('. $datos['ID'] . ')"> Eliminar </a>
    		</td>';
    	echo '</tr>';
	}
	?>
	</tbody>
</table>

<?php  
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}

?>

