
<?php
 date_default_timezone_set('America/Mexico_City');

 $d = strtotime("today");
      $start_lMonth = strtotime("first day of last month",$d);
      $end_lMonth = strtotime("last day of last month +1439 minutes",$d);
      $startDate = date("d/m/Y",$start_lMonth); 
      $endDate = date("d/m/Y",$end_lMonth);

      $startDateD = date("Y/m/d h:i A",$start_lMonth);
      $endDateD = date("Y/m/d h:i A",$end_lMonth);




$dateZ = date("d/m/Y",strtotime($row_ver_ventas['fecha']));
$hourZ = date("h:i A",strtotime($row_ver_ventas['hora']));

$dateZ1 = date_format(date_create_from_format('Y/m/d', "2021/10/05"), 'd/m/Y');
$hourZ1 = date_format(date_create_from_format('H:i', "23:54"), 'h:i A');

$dateZ2 = new DateTime('2021/10/05');
$dateZ22 = $dateZ2 -> format('d/m/Y');
$hourZ2 = date_format(date_create_from_format('H:i A', "23:54"), 'h:i A');
        
echo $dateZ1, ' '.$hourZ1;

?>