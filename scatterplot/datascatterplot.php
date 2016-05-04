<?php  
 $connect = mysqli_connect("localhost", "root", "root", "dataforscatterplot");  
 $output = array();  
 $p=0;
 $sql = "SELECT * FROM test";  
 $result = mysqli_query($connect, $sql);  
 if(mysqli_num_rows($result) > 0)  
 {     
      while($row = mysqli_fetch_array($result))  
      {     
      	   //print_r(json_encode($row));
      	   //$output['xaxis'][]=$row["first_name"]; 
      	   //$output['yaxis'][]=$row["last_name"];
  			$output[$p] = array("xaxis" => $row["first_name"], "yaxis" => $row["last_name"], "color" => $row["color"]);
  			$p++;
      }   
 }

 else  
 {  
      $output .= '<tr>  
                          <td colspan="4">Data not Found</td>  
                     </tr>';  
 }  
 //echo $output;  
 echo json_encode($output);
 ?>  