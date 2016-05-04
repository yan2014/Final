<?php  
 $connect = mysqli_connect("localhost", "root", "root", "dataforscatterplot");  
 $output = array();  
 $p=0;
 $sql = "SELECT * FROM sheet1";  
 $result = mysqli_query($connect, $sql);  
 if(mysqli_num_rows($result) > 0)  
 {     
      while($row = mysqli_fetch_array($result))  
      {     
      	   //print_r(json_encode($row));
      	   //$output['xaxis'][]=$row["first_name"]; 
      	   //$output['yaxis'][]=$row["last_name"];
  			$output[$p] = array("ISO" => $row["ISO"], "Country" => $row["Country"], "Value" => $row["Value"]);
  			$p++;
      }   
 }

 else  
 {  
      $output .= '<tr>  
                          <td colspan="4">Data not Found</td>  
                     </tr>';  
 }  


function generateCsv($data, $delimiter = ',', $enclosure = '"') {
       $handle = fopen('php://temp', 'r+',array_keys($line));
       foreach ($data as $line) {
               fputcsv($handle, $line, $delimiter, $enclosure);
       }
       rewind($handle);
       while (!feof($handle)) {
               $contents .= fread($handle, 8192);
       }
       fclose($handle);
       return $contents;
}
echo generateCsv($output);
 ?>  