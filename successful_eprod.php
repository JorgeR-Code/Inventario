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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script src="//apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
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
                        <h1 class="mt-4">Editar producto</h1>
                        <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="panel_usuarios1.php">Panel de control</a></li>
                            <li class="breadcrumb-item"><a href="product_list.php">Lista de productos</a></li>
                            <li class="breadcrumb-item active">Editar producto</li>
                            
                        </ol>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="text-center mt-4">
                                <h1 class="display-1">Hecho!</h1>
                                    <h1 class="lead">Tu modificación fue actualizada con éxito</h1>
                                    <a href="product_list.php">
                                        <i class="fas fa-arrow-left me-1"></i>
                                        Volver!
                                    </a>
                                </div>
                            </div>
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
        <script src="js/level_access.js"></script>

    </body>
</html>
