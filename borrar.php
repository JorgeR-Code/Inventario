<?php require_once('Connections/db.php'); ?>
<?php
$maxRows_mostrar_usuarios = 1;
$pageNum_mostrar_usuarios = 0;
if (isset($_GET['pageNum_mostrar_usuarios'])) {
  $pageNum_mostrar_usuarios = $_GET['pageNum_mostrar_usuarios'];
}
$startRow_mostrar_usuarios = $pageNum_mostrar_usuarios * $maxRows_mostrar_usuarios;

mysql_select_db($database_db, $db);
$query_mostrar_usuarios = "SELECT * FROM usuarios WHERE nombre='admin'AND password ='admin'";
$query_limit_mostrar_usuarios = sprintf("%s LIMIT %d, %d", $query_mostrar_usuarios, $startRow_mostrar_usuarios, $maxRows_mostrar_usuarios);
$mostrar_usuarios = mysql_query($query_limit_mostrar_usuarios, $db) or die(mysql_error());
$row_mostrar_usuarios = mysql_fetch_assoc($mostrar_usuarios);

$acceso = $row_mostrar_usuarios['acceso'];
echo $acceso;
?>







