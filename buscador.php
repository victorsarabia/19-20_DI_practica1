<?php
require_once "inc/auth.inc.php";

// Definición de variables por si no lo hace el archivo padre donde se incluya
$id = isset($id)? $id : null;
$name = isset($name)? $name : null;
$countryCode = isset($countryCode)? $countryCode : null;
$district = isset($district)? $district : null;
$population = isset($population)? $population : null;
$population_sign = isset($population_sign)? $population_sign : null;

?>


<fieldset>
    <legend>Buscador</legend>

    ID: <input type="text" name="ID" value="<?php echo $id?>" />
    Nombre: <input type="text" name="Name" value="<?php echo $name?>" />
    Cód. País: <input type="text" name="CountryCode" value="<?php echo $countryCode?>" />
    Distrito: <input type="text" name="District" value="<?php echo $district?>" />
    Población:
        <select name="population_sign">
            <option value=">" <?php echo $population_sign==">"? "selected":""?>>&gt;</option>
            <option value="<" <?php echo $population_sign=="<"? "selected":""?>>&lt;</option>
            <option value="=" <?php echo $population_sign=="="? "selected":""?>>=</option>
        </select>
        <input type="text" name="Population" value="<?php echo $population?>" />

    <input type="submit" name="Buscar" value="Buscar" />
    <input type="reset" value="Limpiar" />

</fieldset>


