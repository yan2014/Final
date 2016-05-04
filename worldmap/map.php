<html>  
      <head>  
           <title>Map</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
           <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>  
           <script src="http://d3js.org/queue.v1.min.js"></script>
           <script src="http://d3js.org/topojson.v1.min.js"></script>
           <style>
           .container{
            width:1700px;
           }

            .tooltip {
                position: absolute;
                z-index: 10;
                text-align: left;
                width: 170px;
                padding: 10px;
                font-size: 10px;
                font-family: Helvetica, sans-serif;
                background: #ffffff;
                pointer-events: none;
                opacity: 0;
            }
            .tooltip h3 {
              font-size: 12px; margin: 0 0 7px 0;
              line-height: 1.2em;
            }
            div.tooltip .line { clear: both; margin-top: 3px; font-size: 11px; }
            div.tooltip .symbol { float: left; width: 6px; height: 6px; margin: 3px 4px 0 0; }
            div.tooltip .val { float: right; width: 25px; text-align: center; margin-right: 4px; background: none; }


            .overlay {
              fill: none;
              pointer-events: all;
            }

            .button {
              fill: #000;
            }

            .scalebutton {
              cursor: pointer;
            }

            .countries {
              stroke: #fff;
              stroke-linejoin: round;
            }
            .countries path.selected {
                stroke: #000;
                stroke-width: 0.5px;
            }

            path.richest, #metrics ul li.selected.richest, .tooltip .richest { fill: #8dd3c7; background: #8dd3c7; }
            path.poorest, #metrics ul li.selected.poorest, .tooltip .poorest { fill: #bc80bd; background: #bc80bd; }
            path.differenceIncome, #metrics ul li.selected.differenceIncome, .tooltip .differenceIncome { fill: #bebada; background: #bebada; }
            path.urban, #metrics ul li.selected.urban, .tooltip .urban { fill: #80b1d3; background: #80b1d3; }
            path.rural, #metrics ul li.selected.rural, .tooltip .rural { fill: #fdb462; background: #fdb462; }
            path.differenceLoc, #metrics ul li.selected.differenceLoc, .tooltip .differenceLoc { fill: #b3de69; background: #b3de69; }

            .clr { clear: both; }

            #vis {
              padding: 25px;
              display: inline-block;
            }
           </style>
      </head>  
      <body>  
          <div id="tooltip" class="tooltip">
        <h3 class="name"></h3>
        <hr>
        <div data-metric="urban" class="line">
            <div class="urban symbol"></div>Value
            <div class="urban val"></div>
        </div>
    </div>
           <div class="container">  
                <br />  
                <br />  
                <br />  
                <div class="graph col-sm-8">
                     <h3 align="left">Map</h3><br />  

                     <div id="vis">
                       
                     </div> 
                </div> 
                <div class="table-responsive col-sm-4">  
                     <h3 align="center">Insert Data</h3><br />  
                     <div id="live_datamap"></div>                 
                </div> 
           </div>  
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){
 
function create_map(){
   var width = 1000,
            height = 700,
            center = [width / 2, height / 2],
            defaultFill = "white";
    var color = d3.scale.linear().range(["#ffffff", "#80b1d3"]).interpolate(d3.interpolateLab);
    var countryById = d3.map();
    var projection = d3.geo.mercator()
            .scale(200)
            .translate([width / 2, height / 2]);
    var path = d3.geo.path()
            .projection(projection);
    var zoom = d3.behavior.zoom()
            .scaleExtent([1, 8])
            .on("zoom", move);
    var svg = d3.select("#vis").append("svg")
            .attr("width", width)
            .attr("height", height)
            .append("g")
            .call(zoom);
    svg.on("wheel.zoom", null);
    svg.on("mousewheel.zoom", null);
    var countryById = d3.map();

    var g = svg.append("g");
    var tooltip = d3.select("#tooltip")
            .attr("class", "tooltip")
            .style("opacity", 0);
    var CURR_SELECT = "urban";
    function typeAndSet(d) {
        console.log("you can make it", d);
        d.Value=+d.Value;
        countryById.set(d.ISO, d);
        console.log("you can make it restructure", d);
        return d;
    }
    queue()
            .defer(d3.json, "countries.json")
            .defer(d3.csv, "datamap.php", typeAndSet)
            .await(ready);
    function ready(error, world, stunting) {
        console.log("you are here!!!");
        color.domain(d3.extent(stunting, function(d) {return d.Value;}));
        g.append("g")
                .attr("class", "countries")
                .selectAll("path")
                .data(topojson.feature(world, world.objects.units).features)
                .enter().append("path")
                .attr("d", path)
                .on("mouseover", mouseover)
                .on("mouseout", function() {
                    d3.select(this).classed("selected", false);
                    tooltip.transition().duration(300)
                            .style("opacity", 0);
                })
                .attr("fill",function(d) {
                    return color(getColor(d));
                });

        make_buttons(); // create the zoom buttons
    } // end function ready
    function make_buttons() {
        // Zoom buttons actually manually constructed, not images
        svg.selectAll(".scalebutton")
                .data(['zoom_in', 'zoom_out'])
                .enter()
                .append("g")
                .attr("id", function(d){return d;})  // id is the zoom_in and zoom_out
                .attr("class", "scalebutton")
                .attr({x: 20, width: 20, height: 20})
                .append("rect")
                .attr("y", function(d,i) { return 20 + 25*i })
                .attr({x: 20, width: 20, height: 20})
        // Plus button
        svg.select("#zoom_in")
                .append("line")
                .attr({x1: 25, y1: 30, x2: 35, y2: 30 })
                .attr("stroke", "#fff")
                .attr("stroke-width", "2px");
        svg.select("#zoom_in")
                .append("line")
                .attr({x1: 30, y1: 25, x2: 30, y2: 35 })
                .attr("stroke", "#fff")
                .attr("stroke-width", "2px");
        // Minus button
        svg.select("#zoom_out")
                .append("line")
                .attr({x1: 25, y1: 55, x2: 35, y2: 55 })
                .attr("stroke", "#fff")
                .attr("stroke-width", "2px");
        svg.selectAll(".scalebutton")
                .on("click", function() {
                    d3.event.preventDefault();
                    var scale = zoom.scale(),
                            extent = zoom.scaleExtent(),
                            translate = zoom.translate(),
                            x = translate[0], y = translate[1],
                            factor = (this.id === 'zoom_in') ? 2 : 1/2,
                            target_scale = scale * factor;
                    var clamped_target_scale = Math.max(extent[0], Math.min(extent[1], target_scale));
                    if (clamped_target_scale != target_scale){
                        target_scale = clamped_target_scale;
                        factor = target_scale / scale;
                    }
                    // Center each vector, stretch, then put back
                    x = (x - center[0]) * factor + center[0];
                    y = (y - center[1]) * factor + center[1];
                    // Transition to the new view over 350ms
                    d3.transition().duration(350).tween("zoom", function () {
                        var interpolate_scale = d3.interpolate(scale, target_scale),
                                interpolate_trans = d3.interpolate(translate, [x,y]);
                        return function (t) {
                            zoom.scale(interpolate_scale(t))
                                    .translate(interpolate_trans(t));
                            svg.call(zoom.event);
                        };
                    });
                });
    }
    function mouseover(d){
        d3.select(this).classed("selected", true);
        tooltip.transition().duration(100)
                .style("opacity", 1);
        tooltip
                .style("top", (d3.event.pageY - 10) + "px" )
                .style("left", (d3.event.pageX + 10) + "px");
        tooltip.selectAll(".symbol").style("opacity", "0");
        tooltip.selectAll(".val").style("font-weight", "normal");
        tooltip.selectAll(".val").style("color", "darkgray");
        tooltip.select(".symbol." + CURR_SELECT).style("opacity", "1");
        tooltip.select(".val." + CURR_SELECT).style({
            "font-weight": "bolder",
            "color": "black"
        });
        if (countryById.get(d.id)) {
            tooltip.select(".name").text(countryById.get(d.id)['Country']);
            tooltip.select(".urban.val").text(d3.round(countryById.get(d.id)['Value']));
        } else {
            tooltip.select(".name").text("No data for " + d.properties.name);
            tooltip.select(".urban.val").text("NA");
        }
    } // end mouseover

    function getColor(d) {
        var dataRow = countryById.get(d.id);
        if (dataRow) {
            console.log(dataRow);
            return dataRow.Value;
        } else {
            console.log("grey");
            return 0;
        }
    }
    function zoomIn() {
        zoom.scale(zoom.scale()*2);
        move();
    }
    function move() {
        var t = d3.event.translate,
                s = d3.event.scale;
        t[0] = Math.min(width * (s - 1), Math.max(width * (1 - s), t[0]));
        t[1] = Math.min(height * (s - 1), Math.max(height * (1 - s), t[1]));
        zoom.translate(t);
        g.style("stroke-width", 1 / s).attr("transform", "translate(" + t + ")scale(" + s + ")");
    }
}
create_map();
      function fetch_data()  
      {  
           $.ajax({  
                url:"select.php",  
                method:"POST",  
                success:function(data){  
                     $('#live_datamap').html(data); 
                }  
           });  
      }  
            function fetch_data_graph()  
      {  
           $.ajax({  
                url:"datamap.php",  
                method:"POST",  
                success:function(data){  
    }  
  });  
}  
      fetch_data_graph(); 
      fetch_data();  
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
      $(document).on('blur', '.Value', function(){  
           var id = $(this).data("id4");  
           var Value = $(this).text();  
           edit_data(id,Value, "Value");  
      }); 
 });  

 </script>  