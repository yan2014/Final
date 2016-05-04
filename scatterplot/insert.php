<?php  
 $connect = mysqli_connect("localhost", "root", "root", "dataforscatterplot");  
 $sql = "INSERT INTO test(first_name, last_name, color) VALUES('".$_POST["first_name"]."', '".$_POST["last_name"]."', '".$_POST["color"]."')"; 
 if(mysqli_query($connect, $sql))  
 {  
      echo 'Data Inserted';  
 }  
 ?>  