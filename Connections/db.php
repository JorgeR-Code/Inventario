<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_db = "137.184.194.132:3306";
$database_db = "jorgeriv_inventario";
$username_db = "jorgeriv_user";
$password_db = "inventario1*Prueba";
$db = mysql_pconnect($hostname_db, $username_db, $password_db) or trigger_error(mysql_error(),E_USER_ERROR); 
?>