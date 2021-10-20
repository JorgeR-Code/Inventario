<?php require_once('Connections/db.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_mostrar_usuarios = 100;
$pageNum_mostrar_usuarios = 0;
if (isset($_GET['pageNum_mostrar_usuarios'])) {
  $pageNum_mostrar_usuarios = $_GET['pageNum_mostrar_usuarios'];
}
$startRow_mostrar_usuarios = $pageNum_mostrar_usuarios * $maxRows_mostrar_usuarios;

mysql_select_db($database_db, $db);
$query_mostrar_usuarios = "SELECT * FROM usuarios";
$query_limit_mostrar_usuarios = sprintf("%s LIMIT %d, %d", $query_mostrar_usuarios, $startRow_mostrar_usuarios, $maxRows_mostrar_usuarios);
$mostrar_usuarios = mysql_query($query_limit_mostrar_usuarios, $db) or die(mysql_error());
$row_mostrar_usuarios = mysql_fetch_assoc($mostrar_usuarios);

if (isset($_GET['totalRows_mostrar_usuarios'])) {
  $totalRows_mostrar_usuarios = $_GET['totalRows_mostrar_usuarios'];
} else {
  $all_mostrar_usuarios = mysql_query($query_mostrar_usuarios);
  $totalRows_mostrar_usuarios = mysql_num_rows($all_mostrar_usuarios);
}
$totalPages_mostrar_usuarios = ceil($totalRows_mostrar_usuarios/$maxRows_mostrar_usuarios)-1;

echo $row_mostrar_usuarios['acceso'];
?>







