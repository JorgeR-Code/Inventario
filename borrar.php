
<?php
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
?>


<div class="card-body">
                            <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Categoría</th>
                                            <th>Nombre</th>
                                            <th>Cantidad</th>
                                            <th>Código de barras</th>
                                            <th>Editar</th>
                                            <th>Borrar</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                    <?php do { ?>
                                        <tr>
                                        <td><?php echo $row_lista_productos1['id']; ?></td>
                                        <td><?php echo $row_lista_productos1['categoria']; ?></td>
                                        <td><?php echo $row_lista_productos1['nombre']; ?></td>
                                        <td><?php echo $row_lista_productos1['cantidad']; ?></td>
                                        <td><?php echo $row_lista_productos1['codigo_barras']; ?></td>
                                        <td>
                                          <a class="nav-link" href="edit_p.php?idp=<?php echo $row_lista_productos1['id']; ?>"><i class="fas fa-edit"></i></a>
                                        </td>
                                        <td>
                                        <a class="nav-link delete" onclick="confirmation(event)" href="delete_p.php?idu=<?php echo $row_lista_productos1['id']; ?>"><i class="fas fa-trash" ></i></a>

                                        </td>
                                        </tr>
                                        <?php } while ($row_lista_productos1 = mysql_fetch_assoc($lista_productos1)); ?>
                                    </tbody>
                                    
                                </table>
                          </div>