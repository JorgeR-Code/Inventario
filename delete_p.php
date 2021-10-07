<?php require_once('Connections/db.php'); ?>
            <?php

            $id = $_GET['idu'];
            ?>
            <?php
            $eliminar = sprintf("DELETE FROM productos WHERE id = '$id'");
    

            mysql_select_db($database_db, $db);
            $Result1 = mysql_query($eliminar, $db) or die(mysql_error());

            if ($Result1){
                echo "<script>window.location.href='product_list.php';</script>";
                exit;
            }else{
                echo"<script>alert('Nose pudo eliminar'); window.history.go(-1);</script>";
            }
     
            
            ?>           