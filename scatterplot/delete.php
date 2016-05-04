<?php  
 $connect = mysqli_connect("localhost", "root", "root", "dataforscatterplot");  
 $sql = "DELETE FROM test WHERE id = '".$_POST["id"]."'";  
 if(mysqli_query($connect, $sql))  
 {  
      echo 'Data Deleted';  
 }  
 ?>  
