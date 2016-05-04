<html>  
      <head>  
           <title>Scatter Plot</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
           <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>  
           <script src='spectrum.js'></script>
           <link rel='stylesheet' href='spectrum.css' />
           <style>
           circle{
            opacity: 0.5;
           }
                   .axis path,
        .axis line {
            fill: none;
            stroke: black;
        }
        .axis text {
            font-family: sans-serif;
            font-size: 11px;
        }
           </style>
      </head>  
      <body>  
           <div class="container">  
                <br />  
                <br />  
                <br />  
                <div class="graph col-sm-4">
                     <h3 align="left">Scatter Plot</h3><br />  
                     <div id="graph">
                       <svg></svg>
                     </div> 
                </div> 
                <div class="table-responsive col-sm-8">  
                     <h3 align="center">Insert Data</h3><br />  
                     <div id="live_data"></div>                 
                </div> 
           </div>  
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){
                        var width = 350;
                        var height = 320;
                        var margin ={top:20, right:10,bottom:50,left:50};  //Top, right, bottom, left
                        var dotRadius = 8; 
                        var xScale = d3.scale.linear()
                                .range([ margin.left+7, width - margin.right -  margin.left+7 ]);
                        var yScale = d3.scale.linear()
                                .range([ height - margin.bottom, margin.top ]);
                        // Create your axes here.
                        var xAxis = d3.svg.axis()
                                .scale(xScale)
                                .orient("bottom")
                                .ticks(5);  // fix this to a good number of ticks for your scale later.
                        var yAxis = d3.svg.axis()
                                .scale(yScale)
                                .orient("left");
                        var svg = d3.select("svg")
                                .attr("width", width)
                                .attr("height", height);
                        svg.append("g")
                                .attr("class", "x axis")
                                .attr("transform", "translate(-7," + (height - margin.bottom+20) + ")")
                                .call(xAxis);

                        svg.append("g")
                                .attr("class", "y axis")
                                .attr("transform", "translate(" + margin.left + ",20)")
                                .call(yAxis);
function create_scatterplot(){

        d3.json("datascatterplot.php", function(error, data) {
                      console.log(data);
                        data.forEach(function(d) {
                            d.xaxis = +d.xaxis;
                            d.yaxis = +d.yaxis;
                        });
                xScale.domain(
                d3.extent(data, function(d) {
                    // pick a data value to plot on x axis
                    return +d.xaxis;
                }));
                yScale.domain(
                d3.extent(data, function(d) {
                    // pick a data value to plot for y axis
                    return +d.yaxis;
                }));
       var circles = svg.selectAll("circle")
                .data(data)
                .enter()
                .append("circle");
        circles.attr("class","dots");

        circles.attr("cx", function(d) {
            // return the value to use for your x scale here
            return xScale(d.xaxis);

        })
                .attr("cy", function(d) {
                    // return the value to use for your y scale here
                    return yScale(d.yaxis);
                })
                .attr("r", dotRadius)  // you might want to increase your dotRadius
                .attr("fill",function(d){
                    return d.color;
                    });
        svg.select(".x.axis")
                .transition()
                .duration(1000)
                .call(xAxis);
        svg.select(".y.axis")
                .transition()
                .duration(1000)
                .call(yAxis);

      });
}
create_scatterplot();
      function fetch_data()  
      {  
           $.ajax({  
                url:"select.php",  
                method:"POST",  
                success:function(data){  
                     $('#live_data').html(data); 
                }  
           });  
      }  
            function fetch_data_graph()  
      {  
           $.ajax({  
                url:"datascatterplot.php",  
                method:"POST",  
                success:function(data){  
                    console.log(data);
         d3.json("datascatterplot.php", function(error, data) {
                      console.log(data);
                        data.forEach(function(d) {
                            d.xaxis = +d.xaxis;
                            d.yaxis = +d.yaxis;
                        });
                xScale.domain(
                d3.extent(data, function(d) {
                    return +d.xaxis;
                }));
                yScale.domain(
                d3.extent(data, function(d) {
                    return +d.yaxis;
                }));
        //Create circles
        var circles=svg.selectAll("circle")
                .data(data);
        circles.enter()
                .append("circle");
        circles.attr("class","dots");
        circles.exit()
                .transition()
                .duration(500)
                .ease("exp")//the speed of transition
                .attr("r", 0)//shrink the width to 0
                .remove();
        circles
                .transition()
                .duration(500)
                .ease("quad")
                .attr("cx", function(d) {
                    return xScale(d.xaxis);
                })
                .attr("cy", function(d) {
                    return yScale(d.yaxis);
                })
                .attr("r", dotRadius)
                .attr("fill", function(d){                    
                  return d.color;
                });
        svg.select(".x.axis")
                .transition()
                .duration(1000)
                .call(xAxis);
        svg.select(".y.axis")
                .transition()
                .duration(1000)
                .call(yAxis);

      });

    }  
  });  
}  
      fetch_data_graph(); 
      fetch_data();  
      $(document).on('click', '#btn_add', function(){  
           var first_name = $('#first_name').text();  
           var last_name = $('#last_name').text(); 
           var color= $('#color').text();
           if(first_name == '')  
           {  
                alert("Enter First Name");  
                return false;  
           }  
           if(last_name == '')  
           {  
                alert("Enter Last Name");  
                return false;  
           }  
           $.ajax({  
                url:"insert.php",  
                method:"POST",  
                data:{first_name:first_name, last_name:last_name, color: color},  
                dataType:"text",  
                success:function(data)  
                {  
                     alert(data);  
                     fetch_data();
                     fetch_data_graph();  
                }  
           })  
      });  
      function edit_data(id, text, column_name)  
      {  
           $.ajax({  
                url:"edit.php",  
                method:"POST",  
                data:{id:id, text:text, column_name:column_name},  
                dataType:"text",  
                success:function(data){  
                     alert(data);  
                     fetch_data(); 
                     fetch_data_graph(); 
                }  
           });  
      }  
      $(document).on('blur', '.first_name', function(){  
           var id = $(this).data("id1");  
           var first_name = $(this).text();  
           edit_data(id, first_name, "first_name");  
      });  
      $(document).on('blur', '.last_name', function(){  
           var id = $(this).data("id2");  
           var last_name = $(this).text();  
           edit_data(id,last_name, "last_name");  
      });  
      $(document).on('blur', '.color', function(){  
           var id = $(this).data("id4");  
           var color = $(this).text();  
           edit_data(id,color, "color");  
      });
      $(document).on('click', '.btn_delete', function(){  
           var id=$(this).data("id3");  
           if(confirm("Are you sure you want to delete this?"))  
           {  
                $.ajax({  
                     url:"delete.php",  
                     method:"POST",  
                     data:{id:id},  
                     dataType:"text",  
                     success:function(data){  
                          alert(data);  
                          fetch_data(); 
                          fetch_data_graph(); 
                     }  
                });  
           }  
      });  
 });  

 </script>  