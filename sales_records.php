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

$maxRows_ver_ventas = 100;
$pageNum_ver_ventas = 0;
if (isset($_GET['pageNum_ver_ventas'])) {
  $pageNum_ver_ventas = $_GET['pageNum_ver_ventas'];
}
$startRow_ver_ventas = $pageNum_ver_ventas * $maxRows_ver_ventas;

mysql_select_db($database_db, $db);

$showFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $showFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_show"])) && ($_POST["MM_show"] == "form1")) {
 
  
  date_default_timezone_set('America/Mexico_City');

  switch($_POST['filter']){

    case 'u_semana':
      $d = strtotime("-1 second tomorrow");
      $start_week = strtotime("last Sunday + 1440 minutes",$d);
      $end_week = $d;
      $startDate = date("Y/m/d",$start_week); 
      $endDate = date("Y/m/d",$end_week);  

      $startDateD = date("d/m/Y h:i A",$start_week);
      $endDateD = date("d/m/Y h:i A",$end_week);
    break;
    case 'u_mes':
       $d = strtotime("today");
       $start_month = strtotime("first day of this month +1 second",$d);
       $end_month = strtotime("-1 second tomorrow");
       $startDate = date("Y/m/d",$start_month); 
       $endDate = date("Y/m/d",$end_month);  

       $startDateD = date("d/m/Y h:i A",$start_month);
       $endDateD = date("d/m/Y h:i A",$end_month);
    break;
    case 'p_mes':
      $d = strtotime("today");
      $start_lMonth = strtotime("first day of last month",$d);
      $end_lMonth = strtotime("last day of last month +1439 minutes",$d);
      $startDate = date("Y/m/d",$start_lMonth); 
      $endDate = date("Y/m/d",$end_lMonth);

      $startDateD = date("d/m/Y h:i A",$start_lMonth);
      $endDateD = date("d/m/Y h:i A",$end_lMonth);
    break;
    case 'p_personalizado':
      $start = strtotime($_POST["startDate"]);
      $end1 = strtotime($_POST["endDate"]);
      $end = strtotime("+1439 minutes",$end1);
      $startDate = date("Y/m/d",$start);
      $endDate = date("Y/m/d",$end);

      $startDateD = date("d/m/Y h:i A",$start);
      $endDateD = date("d/m/Y h:i A",$end);
    break;
    
    }

  $query_ver_ventas = "select * from ventas where (fecha>=\"$startDate\" and fecha<=\"$endDate\") order by fecha DESC";
  $query_limit_ver_ventas = sprintf("%s LIMIT %d, %d", $query_ver_ventas, $startRow_ver_ventas, $maxRows_ver_ventas);
  $ver_ventas = mysql_query($query_limit_ver_ventas, $db) or die(mysql_error());
  $row_ver_ventas = mysql_fetch_assoc($ver_ventas);
   
  if (isset($_GET['totalRows_ver_ventas'])) {
    $totalRows_ver_ventas = $_GET['totalRows_ver_ventas'];
  } else {
    $all_ver_ventas = mysql_query($query_ver_ventas);
    $totalRows_ver_ventas = mysql_num_rows($all_ver_ventas);
  }
  $totalPages_ver_ventas = ceil($totalRows_ver_ventas/$maxRows_ver_ventas)-1;
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
        <title>Registro de ventas</title>
        <link rel="icon" href="favicon/favicon.png">
        <link href="css/styles.css" rel="stylesheet" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script src="//apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

        <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"/>
        <script src="js/table_script.js"></script>
        <script src = "js/pdf_script.js" ></script>
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
                    <h1 class="mt-4">Registro de ventas</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="panel_usuarios1.php">Panel de control</a></li>
                            <li class="breadcrumb-item active">Registro de ventas</li>
                        </ol>
                        <form action="<?php echo $showFormAction; ?>" method="post" name="form1" id="form1">
                                        
                                        <div class="row mb-3">
                                          <div class="col-md-3"></div>
                                          <div class="col-md-3">
                                          <label ><b>Filtrar:</b></label>
                                                    <div class="mb-3 mb-md-0">
                                                    
                                                        <select class="form-control" id="inputcathegory" name="filter" type="text">
                                                            <option value="u_semana" <?php if (!(strcmp("u_semana", ""))) {echo "SELECTED";} ?>>Esta semana</option>
                                                            <option value="u_mes" <?php if (!(strcmp("u_mes", ""))) {echo "SELECTED";} ?>>Este mes</option>
                                                            <option value="p_mes" <?php if (!(strcmp("p_mes", ""))) {echo "SELECTED";} ?>>Mes anterior</option>
                                                            <option value="p_personalizado">Periodo personalizado</option>
                                                        </select>
                                                    </div>
                                          </div>
                                          
                                           
                                          <div class="mt-4 col-md-3">
                                              <div class="d-grid "><input type="submit" id="showResults"class="btn btn-primary btn-block" value="Ver"/></div>
                                          </div>
                                            
                                            
                                        </div>

                                        <div class="row mb-3">
                                          <div class="col-md-3"></div>
                                            <div class="col-md-3">
                                              <div class="form-floating mb-3 mb-md-0" >
                                                <input class="form-control" id="startDate" name="startDate" type="date" placeholder="Fecha inicial" />
                                                <label for="startDate" id="startDateL">A partir del:</label>
                                              </div>
                                            </div>

                                            <div class="col-md-3">
                                              <div class="form-floating mb-3 mb-md-0">
                                                  <input class="form-control" id="endDate" name="endDate" type="date" placeholder="Fecha final"/>
                                                  <label for="endDate" id="endDateL">Hata el:</label>
                                              </div>
                                            </div>
                                          </div>

                                        <div class="row mb-3">
                                              <div class="col-md-3"></div>
                                              <div class="col-md-3">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputSdate" name="startDateD" type="text" value="<?php echo $startDateD; ?>" readonly/>
                                                        <label for="inputSdate">Fecha de inicio</label>
                                                    </div>
                                            </div>
                                            <div class="col-md-3">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputEdate" name="endDateD" type="text" value="<?php echo $endDateD ?>" readonly/>
                                                        <label for="inputEdate">Fecha de corte</label>
                                                    </div>
                                                
                                            </div>
                                        </div>

                                        <input type="hidden" name="MM_show" value="form1" />
                                    </form>
                                    <div class="row mb-3">


                                    </div>
                                   
                        <div class="card mb-4" id="tablax">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Listado de ventas
                            </div>
                            <div class="card-body" >
                            
                            <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Categoría</th>
                                            <th>Nombre</th>
                                            <th>Cantidad</th>
                                            <th>Código de barras</th>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                    <?php do { ?>
                                      
                                        <tr>
                                        <td><?php echo $row_ver_ventas['id']; ?></td>
                                            <td><?php echo $row_ver_ventas['categoria']; ?></td>
                                            <td><?php echo $row_ver_ventas['nombre']; ?></td>
                                            <td><?php echo $row_ver_ventas['cantidad']; ?></td>
                                            <td><?php echo $row_ver_ventas['codigo_barras']; ?></td>
                                            <?php
                                            
                                            $dateZ = date_format(date_create_from_format('Y/m/d', $row_ver_ventas['fecha']), 'd/m/Y');
                                            $hourZ = date_format(date_create_from_format('H:i', $row_ver_ventas['hora']), 'h:i A');
                                            ?>
                                            <td><?php echo $dateZ?></td>
                                            <td><?php echo $hourZ?></td>
                                        </tr>
                                        <?php } while ($row_ver_ventas = mysql_fetch_assoc($ver_ventas)); ?>
                                    </tbody>
               
                                </table>
                                
                                <div class="row mb-3">
                                  <div class="col-md-12">
                                    <div class="d-grid "><input type="submit" id="nameCreatePdf"  class="btn btn-primary btn-block" value="Descargar reporte"/></div>
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

        <script src="js/table_script.js"></script>        
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
<?php
mysql_free_result($ver_ventas);
?>