<?php require_once('Connections/db.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

////----------------------------------------------------
$maxRows_mostrar_usuarios1 = 1;
$pageNum_mostrar_usuarios1 = 0;
if (isset($_GET['pageNum_mostrar_usuarios'])) {
  $pageNum_mostrar_usuarios1 = $_GET['pageNum_mostrar_usuarios'];
}
$startRow_mostrar_usuarios1 = $pageNum_mostrar_usuarios1 * $maxRows_mostrar_usuarios1;

$varNombre = $_SESSION['MM_Username'];
$varPass = $_SESSION['MM_Userpass'];

mysql_select_db($database_db, $db);
$query_mostrar_usuarios1 = "SELECT * FROM usuarios WHERE nombre='$varNombre' AND password ='$varPass'";
$query_limit_mostrar_usuarios1 = sprintf("%s LIMIT %d, %d", $query_mostrar_usuarios1, $startRow_mostrar_usuarios1, $maxRows_mostrar_usuarios1);
$mostrar_usuarios1 = mysql_query($query_limit_mostrar_usuarios1, $db) or die(mysql_error());
$row_mostrar_usuarios1 = mysql_fetch_assoc($mostrar_usuarios1);

$acceso = $row_mostrar_usuarios1['acceso'];

///-----------------------------------------------------

$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>

<!-- ///-----------Get product-----------////////// -->
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

$maxRows_lista_productos = 100;
$pageNum_lista_productos = 0;
if (isset($_GET['pageNum_lista_productos'])) {
  $pageNum_lista_productos = $_GET['pageNum_lista_productos'];
}
$startRow_lista_productos = $pageNum_lista_productos * $maxRows_lista_productos;

$showFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $showFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_show"])) && ($_POST["MM_show"] == "form1")) {
    mysql_select_db($database_db, $db);
    $codigo_barras = $_POST["codigo_barras"];
    $nombre = $_POST["nombre"];
    $query_lista_productos = "SELECT * FROM productos WHERE codigo_barras = '$codigo_barras' OR nombre = '$nombre'";
    $query_limit_lista_productos = sprintf("%s LIMIT %d, %d", $query_lista_productos, $startRow_lista_productos, $maxRows_lista_productos);
    $lista_productos = mysql_query($query_limit_lista_productos, $db) or die(mysql_error());
    $row_lista_productos = mysql_fetch_assoc($lista_productos);
    
    if (isset($_GET['totalRows_lista_productos'])) {
      $totalRows_lista_productos = $_GET['totalRows_lista_productos'];
      
    } else {
      $all_lista_productos = mysql_query($query_lista_productos);
      $totalRows_lista_productos = mysql_num_rows($all_lista_productos);
    }
    $totalPages_lista_productos = ceil($totalRows_lista_productos/$maxRows_lista_productos)-1;
}

////--------show products-----------///////

$maxRows_lista_productos1 = 100;
$pageNum_lista_productos1 = 0;
if (isset($_GET['pageNum_lista_productos'])) {
  $pageNum_lista_productos1 = $_GET['pageNum_lista_productos'];
}
$startRow_lista_productos1 = $pageNum_lista_productos1 * $maxRows_lista_productos1;

mysql_select_db($database_db, $db);
$query_lista_productos1 = "SELECT * FROM productos";
$query_limit_lista_productos1 = sprintf("%s LIMIT %d, %d", $query_lista_productos1, $startRow_lista_productos1, $maxRows_lista_productos1);
$lista_productos1 = mysql_query($query_limit_lista_productos1, $db) or die(mysql_error());
$row_lista_productos1 = mysql_fetch_assoc($lista_productos1);

if (isset($_GET['totalRows_lista_productos'])) {
  $totalRows_lista_productos1 = $_GET['totalRows_lista_productos'];
} else {
  $all_lista_productos = mysql_query($query_lista_productos1);
  $totalRows_lista_productos1 = mysql_num_rows($all_lista_productos);
}
$totalPages_lista_productos1 = ceil($totalRows_lista_productos1/$maxRows_lista_productos1)-1;

//------------------------UPDATE------------------------------------- -->

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) 
{


    $cantidad = $_POST['cantidad'];
    $codigo_barras = $_POST['codigo_barras'];

    $updateSQL = sprintf("UPDATE productos SET cantidad= cantidad -' $cantidad'  WHERE codigo_barras='$codigo_barras'");
    $insertSQL = sprintf("INSERT INTO ventas (id, categoria, nombre, cantidad, codigo_barras, fecha, hora) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['categoria'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['cantidad'], "text"),
                       GetSQLValueString($_POST['codigo_barras'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['hora'], "text"));

        mysql_select_db($database_db, $db);
            $Result1 = mysql_query($updateSQL, $db) or die(mysql_error());
            $Result2 = mysql_query($insertSQL, $db) or die(mysql_error());


            $insertGoTo = "successful_ven.php";
                if (isset($_SERVER['QUERY_STRING'])) {
                    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
                    $insertGoTo .= $_SERVER['QUERY_STRING'];
                }
                header(sprintf("Location: %s", $insertGoTo));
     

}
?>
<!DOCTYPE html>
<html lang="es-419">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Caja registradora</title>

        <link rel="icon" href="favicon/favicon.png">
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/style_search_prod.css" rel="stylesheet" />
        <script src="//apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
        
        <!-- <link href="css/font-awesome.css" rel="stylesheet" /> -->

        
   </head>
    <body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="panel_usuarios1.php">Panel de control</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Buscar..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Ajustes</a></li>
                        <li><a class="dropdown-item" href="#!">Registro de actividades</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="<?php echo $logoutAction ?>">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            
                        <div id="headerUsuarios" class="sb-sidenav-menu-heading">Usuarios</div>
                            
                            <a id="registrarUsuario" class="nav-link" href="register_user.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-edit"></i></div>
                                Registrar usuario
                            </a>
                            <a id="listarUsuarios" class="nav-link" href="user_list.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Lista de usuarios
                            </a>
                            <div id="headerProductos" class="sb-sidenav-menu-heading">Productos</div>

                            <a id="registrarProducto" class="nav-link" href="new_product.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>
                                Nuevo producto
                            </a>
                            <a id="listarProductos" class="nav-link" href="product_list.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                                Lista de productos
                            </a>
                            <div id="headerVentas" class="sb-sidenav-menu-heading">Ventas</div>

                            <a id="cajaRegistradora" class="nav-link" href="cash_register.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                                Caja registradora
                            </a>
                            <a id="registarVentas" class="nav-link" href="sales_records.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                                Registro de ventas
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                    <div class="small">Iniciaste sesión como:</div>
                       <?php echo $_SESSION['MM_Username'] ;¨?>
                       <input class="form-control" id="nivelAcc" name="nivelAcc" type="hidden" value="<?php echo $acceso; ?>"/>

                    </div>
                    
                </nav>
            </div>
            <div id="layoutSidenav_content">
            <main>
                    <div class="container-fluid px-4">
                    <h1 class="mt-4">Caja registradora</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="panel_usuarios1.php">Panel de control</a></li>
                            <li class="breadcrumb-item active">Caja registradora</li>
                        </ol>
                        <div class="card mb-4">
                         
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Registrar venta</h3></div>
                            <div class="card-body">
                            <form action="<?php echo $showFormAction; ?>" method="post" name="form1" id="form1">
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <div >
                                                    <div><h3 class="text-center font-weight-light my-2">Agregar por</h3></div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3" id="grupo__barras">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputBarCode" name="codigo_barras" type="text" placeholder="Código de barras" />
                                                    <i class="formulario__validation-estado fas fa-times-circle"></i>
                                                    <label class="formulario__label" for="inputBarCode">Código de barras</label>
                                                </div>
                                                <p class="formulario__input-error">Producto inexistente.</p>

                                            </div>
                                            <div class="col-md-1">
                                                <div >
                                                    <div><h3 class="text-center font-weight-light my-2">o</h3></div>
                                                </div>
                                            </div>
                            
                                            <div class="col-md-3 content" id="grupo__nombre">
                                                    <div class="form-floating search">
                                                        <input  class="form-control" id="busqueda" name="nombre" type="text" placeholder="Nombre del producto"/>
                                                        <i class="formulario__validation-estado fas fa-times-circle"></i>
                                                        <label class="formulario__label" for="inputName">Nombre del producto</label>
                                                    </div>
                                                    <p class="formulario__input-error">Producto inexistente.</p>
                                            </div>
                      
                                        </div>
                                        <div class="row mb-3">
                                                <div class="d-grid"><input type="submit" id="enterProduct"class="btn btn-primary btn-block" value="Agregar"/>
                                        </div>
                                        <div class="mt-4 mb-0 formulario__mensaje" id="formulario__mensaje">
                                                <p><i class="fas fa-exclamation-triangle"></i><b> Error:</b> Por favor ingrese un producto válido!</p>
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" name="MM_show" value="form1" />
                                    </form>
                                        
                                    <div class="content-search">
                                        <table id="table2">
                                                <thead>
                                                    <tr>
                                                        
                                                        <th></th>
                                                        
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                <?php do { ?>
                                                    <tr>                                   
                                                    <td><a class="nombre"><?php echo $row_lista_productos1['nombre']; ?></a></td>
                                                    <td><a class="barras"><?php echo $row_lista_productos1['codigo_barras']; ?></a></td>

                                                    </tr>
                                                    <?php } while ($row_lista_productos1 = mysql_fetch_assoc($lista_productos1)); ?>
                                                </tbody>
                                                
                                            </table>
                                    </div>
                                <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                                <?php do { ?>
                                    
                                            <div class="row mb-3">
                                            
                                                <div class="col-md-0">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputId" name="id" type="hidden"/>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <?php date_default_timezone_set('America/Mexico_City'); ?>
                                                        <input id="inputDate" name="fecha" type="dateTime" value="<?php echo date("Y/m/d");?>"  hidden/>
                                                        <input id="inputHour" name="hora" type="dateTime" value="<?php echo date("H:i");?>"  hidden/>
                                                        <input class="form-control disable" type="dateTime" value="<?php echo date("d/m/Y h:i A");?>" placeholder="Fecha" readonly/>

                                                        <label for="inputDate">Fecha</label>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control disable" id="inputCat" name="categoria" type="text" value="<?php echo $row_lista_productos['categoria']; ?>" readonly/>
                                                        <label for="inputCat">Categoría</label>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control disable" id="inputName" name="nombre" type="text" value="<?php echo $row_lista_productos['nombre']; ?>" readonly/>
                                                        <label for="inputName">Producto</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control disable" id="inputCoB" name="codigo_barras" type="text" value="<?php echo $row_lista_productos['codigo_barras']; ?>" readonly/>
                                                        <label for="inputCoB">Código de barras</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control disable" id="inputStock" name="stock" type="text" value="<?php echo $row_lista_productos['cantidad']; ?>" readonly/>
                                                        <label for="inputStock">Stock</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2" id="grupo__cantidad">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputCant" type="text" name="cantidad"/>
                                                        <i class="formulario__validation-estado fas fa-times-circle"></i>

                                                        <label class="formulario__label" for="inputCant">Cantidad</label>
                                                    </div>
                                                    <p class="formulario__input-error">No debe superar la cantidad en stock.</p>

                                                </div>
                                                
    
                                            </div>
                                            <div class="mt-4 mb-0 formulario__mensaje" id="formulario__mensaje2">
                                                <p><i class="fas fa-exclamation-triangle"></i><b> Error:</b> No puede registrar la venta sin una cantidad válida!</p>
                                            </div>
                                        </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><input type="submit" id="registerSale"class="btn btn-primary btn-block" value="Registrar venta"/></div>
                                            </div>
                                            
                                            <input type="hidden" name="MM_insert" value="form2" />
                                            <?php } while ($row_lista_productos = mysql_fetch_assoc($lista_productos)); ?>
                                    </form>
                          </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <!-- <div class="text-muted">Copyright &copy; Your Website 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div> -->
                        </div>
                    </div>
                </footer>
            </div>
        </div>
       
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
        <script src="js/search_cash.js"></script>
        <script src="js/scripts.js"></script>
        <script src="js/level_access.js"></script>

        <script src="js/all.min.js"></script>
        

        <!-- <script src="js/validation_form.js"></script> -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script> -->
        
    </body>
</html>
<?php
mysql_free_result($lista_productos);
?>