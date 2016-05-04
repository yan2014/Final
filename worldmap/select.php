<?php  
 $connect = mysqli_connect("localhost", "root", "root", "dataforscatterplot");  
 $output = '';  
 $sql = "SELECT * FROM sheet1 ORDER BY id DESC";  
 $result = mysqli_query($connect, $sql);  
 $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">  
                <tr>  
                     <th width="6%">Id</th>  
                     <th width="40%">ISO</th>  
                     <th width="40%">Country</th>  
                     <th width="7%">Value</th> 
                </tr>';  
 if(mysqli_num_rows($result) > 0)  
 {  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '  
                <tr>  
                     <td>'.$row["id"].'</td>  
                     <td class="ISO" data-id1="'.$row["id"].'">'.$row["ISO"].'</td>  
                     <td class="Country" data-id2="'.$row["id"].'">'.$row["Country"].'</td>  
                     <td class="Value" data-id4="'.$row["id"].'" contenteditable>'.$row["Value"].'</td>
                </tr>  
           ';  
      }  
      $output .= '  
           <tr>  
                <td></td>  
                <td id="ISO"></td>  
                <td id="Country"></td>
                <td id="Value" contenteditable></td>  
           </tr>  
      ';  
 }  
 else  
 {  
      $output .= '<tr>  
                          <td colspan="4">Data not Found</td>  
                     </tr>';  
 }  
 $output .= '</table>  
      </div>';  
 echo $output;  
 ?>  