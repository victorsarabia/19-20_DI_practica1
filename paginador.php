<?php
require_once "inc/auth.inc.php";

// Definición de variables por si no lo hace el archivo padre donde se incluya
$pagina = isset($pagina)? $pagina : 1;
$num_registros = isset($num_registros)? $num_registros : 10;
$total_registros = isset($total_registros)? $total_registros : 0;
$paginas = isset($paginas)? $paginas : 0;

?>

<div>
    <input type="submit" value="<<" name="primero" /> &nbsp;
    <input type="submit" value="<" name="anterior" /> &nbsp;
    <input type="text" name="pagina" value="<?php echo $pagina?>" /> &nbsp;
    <input type="submit" value=">" name="siguiente" /> &nbsp;
    <input type="submit" value=">>" name="ultimo" /> &nbsp;
    <label for="num_registros">Registros por página: </label>
    <select name="num_registros">
        <option value="10" <?php echo ($num_registros==10? "selected":"")?>>10</option>
        <option value="15" <?php echo ($num_registros==15? "selected":"")?>>15</option>
        <option value="20" <?php echo ($num_registros==20? "selected":"")?>>20</option>
        <option value="todos" <?php echo ($num_registros=="todos"? "selected":"")?>>todos</option>
    </select>
    <input type="submit" value="Mostrar" name="mostrar" />
    <br/><br/>
    <span>Núm. Registros: <?php echo number_format($total_registros,0,",",".");?></span> &nbsp;
    <span>
        Página
        <?php
            echo number_format($pagina,0,",",".")
            ." / "
            . number_format($paginas,0,",",".");
        ?>
    </span>
</div>

