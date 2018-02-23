<?php
//利用Mysql的FOR UPDATE语句和事物隔离性。注意FOR UPDATE仅适用于InnoDB，且必须在事务（BEGIN/COMMIT）中才能生效.
$conn = mysqli_connect('127.0.0.1', 'root', '111111') or die(mysqli_error());

mysqli_select_db($conn, 'mraz');
mysqli_query($conn, 'BEGIN');
$rs = mysqli_query($conn, 'SELECT count(*) as total FROM test WHERE username = "mraz" FOR UPDATE');
$row = mysqli_fetch_array($rs);
if($row['total']>0){
    exit('exist');
}

mysqli_query($conn, "insert into test(username) values ('mraz')");
var_dump('error:'.mysqli_errno($conn));
$insert_id = mysqli_insert_id($conn);

mysqli_query($conn, 'COMMIT');
echo 'insert_id：'.$insert_id.'<br>';

mysqli_free_result($rs);
mysqli_close($conn);
