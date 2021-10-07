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

mysql_select_db($database_db, $db);
$id = $_GET["idp"];
$query_lista_productos = "SELECT * FROM productos WHERE id = '$id'";
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

//------------------------UPDATE------------------------------------- -->

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) 
{

    $id = $_POST['id'];
    $categoria = $_POST['categoria'];
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $codigo_barras = $_POST['codigo_barras'];

    $insertSQL = sprintf("UPDATE productos SET categoria='$categoria', nombre='$nombre', cantidad='$cantidad', codigo_barras='$codigo_barras' WHERE id = '$id'");
    

        mysql_select_db($database_db, $db);
            $Result1 = mysql_query($insertSQL, $db) or die(mysql_error());

            $insertGoTo = "successful_eprod.php";
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
        <title>Editar producto</title>
        <link rel="icon" href="favicon/favicon.png">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
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
                            
                            <div class="sb-sidenav-menu-heading">Usuarios</div>
          
                            <a class="nav-link" href="register_user.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-edit"></i></div>
                                Registrar usuario
                            </a>
                            <a class="nav-link" href="user_list.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Lista de usuarios
                            </a>
                            <div class="sb-sidenav-menu-heading">Productos</div>
          
                            <a class="nav-link" href="new_product.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>
                                Nuevo producto
                            </a>
                            <a class="nav-link" href="product_list.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                                Lista de productos
                            </a>
                            <div class="sb-sidenav-menu-heading">Ventas</div>
          
                            <a class="nav-link" href="cash_register.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                                Caja registradora
                            </a>
                            <a class="nav-link" href="sales_records.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                                Registro de ventas
                            </a>

                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                    <div class="small">Iniciaste sesión como:</div>
                       <?php echo $_SESSION['MM_Username'] ;¨?>
                    </div>
                    
                </nav>
            </div>
            <div id="layoutSidenav_content">
            <main>
                    <div class="container-fluid px-4">
                    <h1 class="mt-4">Editar producto</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="panel_usuarios1.php">Panel de control</a></li>
                            <li class="breadcrumb-item active"><a href="product_list.php">Lista de productos</a></li>
                            <li class="breadcrumb-item active">Editar producto</li>
                        </ol>
                        <div class="card mb-4">
                         
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Editar producto</h3></div>
                            <div class="card-body">
                                <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                                <?php do { ?>
                                            <div class="row">
                                                <div class="col-md-1  mb-3" >
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputId" name="id" type="text" value="<?php echo $row_lista_productos['id']; ?>" readonly/>
                                                        <label for="inputId">id</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3" id="grupo__categoria">
                                                    <div class="form-floating">
                                                      <?php $valor = $row_lista_productos['categoria'];?>
                                                        <select class="form-control" id="inputcathegory" name="categoria" type="text" placeholder="Selecciona la categoría">
                                                            <option value= "<?php echo $valor ?>" <?php if (!(strcmp( "$valor", ""))) {echo "SELECTED";} ?> selected hidden><?php echo $valor ?></option>
                                                            <option value="Lácteos" <?php if (!(strcmp("Lácteos", ""))) {echo "SELECTED";} ?>>Lácteos</option>
                                                            <option value="Embutidos" <?php if (!(strcmp("Embutidos", ""))) {echo "SELECTED";} ?>>Embutidos</option>
                                                            <option value="Carnes" <?php if (!(strcmp("Carnes", ""))) {echo "SELECTED";} ?>>Carnes</option>
                                                        </select>
                                                        <i class="formulario__validation-estado fas fa-times-circle"></i>
                                                        <label class="formulario__label" for="inputcathegory">Categoría</label>
                                                    </div>
                                                    <p class="formulario__input-error">Debe asignar una categoría.</p>

                                                </div>
                                               
                                                <div class="col-md-3  mb-3" id="grupo__nombre">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputName" name="nombre" type="text" value="<?php echo $row_lista_productos['nombre']; ?>"/>
                                                        <i class="formulario__validation-estado fas fa-times-circle"></i>
                                                        <label class="formulario__label" for="inputName">Producto</label>
                                                    </div>
                                                    <p class="formulario__input-error">El nombre del producto tiene que ser de 1 a 20 dígitos y solo puede contener letras, acentos y espacios.</p>

                                                </div>
                                                <div class="col-md-3  mb-3" id="grupo__cantidad">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputCant" type="text" name="cantidad" value="<?php echo $row_lista_productos['cantidad']; ?>" />
                                                        <i class="formulario__validation-estado fas fa-times-circle"></i>
                                                        <label class="formulario__label" for="inputCant">Cantidad</label>
                                                    </div>
                                                    <p class="formulario__input-error">La cantidad debe ser de 1 a 999.</p>

                                                </div>
                                                <div class="col-md-2  mb-3" id="grupo__barras">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputCoB" name="codigo_barras" type="text" value="<?php echo $row_lista_productos['codigo_barras']; ?>" />
                                                        <i class="formulario__validation-estado fas fa-times-circle"></i>
                                                        <label class="formulario__label" for="inputCoB">Código de barras</label>
                                                    </div>
                                                    <p class="formulario__input-error">Deben ser 10 dígitos numéricos.</p>

                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0 formulario__mensaje" id="formulario__mensaje">
                                                <p><i class="fas fa-exclamation-triangle"></i><b> Error:</b> Por favor rellena el formulario correctamente!</p>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><input type="submit" id="actualizarPro"class="btn btn-primary btn-block" value="Guardar"/></div>
                                            </div>
                                            <input type="hidden" name="MM_insert" value="form1" />
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
        <script src="js/scripts.js"></script>
        <script src="js/validation_form.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
<?php
mysql_free_result($lista_productos);
?>