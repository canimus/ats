<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/ats.css">
	<script src="/jquery-1.8.2.min.js"></script>
  <script src="/d3.v2.min.js"></script>
</head>
<body>
  <img src="/ats.png" alt="ATS Asociacion de Sport - Baloncesto Elche"/>
<h1>Associació Torrellano amb l'Sport
</h1>

<div class="rounded">
<ul class="menu rounded">
  <li><a href="/">Inicio</a></li>
  <li><a href="/game/players">Jugadores</a></li>
  <li><a href="/game/results">Resultados</a></li>
  <li><a href="#" class="active">Estadísticas</a></li>
  <li><a href="/game/contact">Contacto</a></li>
</ul>   
</div>

<div style="display: none" id="control_panel">
  <select name="game_name" id="game_name">
    <?php 
    foreach ($games as $game) {
    ?>
    <option value="<?php echo $game->id ?>"><?php echo $game->team_1 . " vs. " . $game->team_2; ?></option>
    <?php } ?>
  </select>
  <select name="player_name" id="player_name">
    <?php 
    foreach ($players as $player) {
    ?>
    <option value="<?php echo $player->id ?>"><?php echo $player->first_name . " " . $player->last_name; ?></option>
    <?php } ?>
  </select>
  <select name="stat_type" id="stat_type">
    <option value="p">Tiro</option>
    <option value="p3">Triple</option>
    <option value="p2">Doble</option>
    <option value="p1">Libre</option>
    <option value="r">Rebote</option>
    <option value="l">Perdida</option>
    <option value="s">Robo</option>
    <option value="a">Asistencia</option>
    <option value="b">Tapón</option>
    <option value="f">Falta</option>
  </select>
  <select name="coord_z" id="coord_z">
    <option value="1">Enceste</option>
    <option value="0">Fallo</option>
  </select>
  <input type="button" value="Guardar Estadísticas" onclick="post_stats()" />
</div>


<div id="court">
</div>
<script src="/court.js"></script>
<script>
  var h = 540, w=960;
  var shoot_collection = [];
  var color_scale = d3.scale.category10();
  var arc_pct = d3.svg.arc().outerRadius(42).innerRadius(35);

  

  // 94ft x 50ft dimension
  court_scale = d3.scale.linear().domain([0,94]).range([0,800]);

  /* d3.select(this).append("g").attr("class", "shoot").append("circle")
    .attr("cx", d3.mouse(this)[0])
    .attr("cy", d3.mouse(this)[1])
    .attr("r", "8") */

  svg = d3.select("#court").append("svg").attr("width", w).attr("height", h).on("click", function() {
    shoot = {
      "coord_x": d3.mouse(this)[0], 
      "coord_y": d3.mouse(this)[1],
      "coord_z": $("#coord_z").val(),
      "player_id": $("#player_name").val(), 
      "game_id": $("#game_name").val(), 
      "stat_type": $("#stat_type").val()
    };
    if (d3.mouse(this)[0] > 160 && d3.mouse(this)[1] <= 430) {
      shoot_collection.push(shoot);
      d3.select(this).append("g").attr("class", "shoot").append("circle")
        .attr("cx", d3.mouse(this)[0])
        .attr("cy", d3.mouse(this)[1])
        .attr("r", "4");
    }
    

    
  });

  g = svg.append("g").attr("transform", "translate(160,10)").attr("id", "court_graphic");
  legend = svg.append("g").attr("transform", "translate(15,25)").attr("id", "legend_graphic");
  z = d3.scale.category20();

  g.selectAll("rect").data(court_shapes.filter(function(d) { return d.shape=="rect"}))
    .enter()
    .append("g")
    .attr("id", function(d) { return d.id;})
    .append("rect")
    .attr("width", function(d) { return court_scale(d.width)})
    .attr("height", function(d) { return court_scale(d.height)})
    .attr("x", function(d) { return court_scale(d.x)})
    .attr("y", function(d) { return court_scale(d.y)});

  g.selectAll("circle").data(court_shapes.filter(function(d) { return d.shape=="circle"}))
    .enter()
    .append("g")
    .attr("id", function(d) { return d.id;})
    .append("circle")
    .attr("cx", function(d) { return court_scale(d.cx)})
    .attr("cy", function(d) { return court_scale(d.cy)})
    .attr("r", function(d) { return court_scale(d.r)});

  g.selectAll("line").data(court_shapes.filter(function(d) { return d.shape=="line"}))
    .enter()
    .append("g")
    .attr("id", function(d) { return d.id;})
    .append("line")
    .attr("class", function(d) { if (d.class) { return d.class}})
    .attr("x1", function(d) { return court_scale(d.x1)})
    .attr("x2", function(d) { return court_scale(d.x2)})
    .attr("y1", function(d) { return court_scale(d.y1)})
    .attr("y2", function(d) { return court_scale(d.y2)});
  
  g.selectAll("path").data(court_shapes.filter(function(d) { return d.shape=="path"}))
    .enter()
    .append("g")
    .attr("id", function(d) { return d.id;})
    .append("path")
    .attr("d", function(d) { return resolve_path(d)});

  // Rotate images for right side of court
  d3.select("#three_point_right").attr("transform", "rotate(180 "+ court_scale(47)+" "+court_scale(25)+")");
  d3.select("#rim_right").attr("transform", "rotate(180 "+ court_scale(47)+" "+court_scale(25)+")");
  d3.select("#board_right").attr("transform", "rotate(180 "+ court_scale(47)+" "+court_scale(25)+")");
  d3.selectAll("line[class='thick right']").attr("transform", "rotate(180 "+ court_scale(47)+" "+court_scale(25)+")");

  // Player name and shoot legend
  player_legend = svg.append("g").attr("transform", "translate(160,460)").attr("id", "player_legend");
  player_legend.append("text").attr("id","score_player").attr("x", 0).attr("y", 8).text("").style("font-weight", "bold").style("font-size", "22px");
  player_legend.append("circle").attr("cx", 5).attr("cy", 24).attr("r",6).style("fill", "#59ce29").style("stroke", "#46a321");
  player_legend.append("text").attr("x", 16).attr("y", 28).text("Enceste").style("font-weight", "normal").style("font-size", "11px").style("fill","#555").style("stroke", "none");
  player_legend.append("circle").attr("cx", 5).attr("cy", 40).attr("r",6).style("fill", "#ea808e").style("stroke", "#dc2c44");
  player_legend.append("text").attr("x", 16).attr("y", 44).text("Fallo").style("font-weight", "normal").style("font-size", "11px").style("fill","#555").style("stroke", "none");

  // Three pointers
  player_legend.append("text").attr("x", 210).attr("y", 5).text("Triples:").style("font-weight", "normal").style("font-size", "11px").style("fill","#555").style("stroke", "none");
  player_legend.append("text").attr("id","score_3p").attr("x", 260).attr("y", 5).text("0").style("font-weight", "bold").style("fill","#000").style("opacity", 0).style("font-size", "14px");

  // Throws inside the area
  player_legend.append("text").attr("x", 210).attr("y", 25).text("Dobles:").style("font-weight", "normal").style("font-size", "11px").style("fill","#555").style("stroke", "none");
  player_legend.append("text").attr("id","score_2p").attr("x", 260).attr("y", 25).text("5").style("font-weight", "bold").style("fill","#000").style("opacity", 0).style("font-size", "14px");

  // Free throws
  player_legend.append("text").attr("x", 210).attr("y", 45).text("Libres:").style("font-weight", "normal").style("font-size", "11px").style("fill","#555").style("stroke", "none");
  player_legend.append("text").attr("id","score_1p").attr("x", 260).attr("y", 45).text("0").style("font-weight", "bold").style("fill","#000").style("opacity", 0).style("font-size", "14px");

  // Score Total
  player_legend.append("text").attr("id","score_total").attr("x", 345).attr("y", 22).attr("text-anchor", "middle").text("0").style("font-weight", "bold").style("font-size", "26px").style("fill","#000").style("opacity", 1);
  player_legend.append("text").attr("x", 345).attr("y", 35).attr("text-anchor", "middle").text("Puntos").style("font-weight", "bold").style("font-size", "14px").style("fill","#000").style("opacity", 1);
  player_legend.append("text").attr("id","score_relative").attr("x", 345).attr("y", 50).attr("text-anchor", "middle").text("(0/0)").style("font-weight", "normal").style("font-size", "11px").style("fill","#555").style("stroke", "none").style("opacity", 1);

  // Fouls Total
  player_legend.append("text").attr("id","fouls_total").attr("x", 725).attr("y", 22).attr("text-anchor", "middle").text("0").style("font-weight", "bold").style("font-size", "26px").style("fill","#000").style("opacity", 1);
  player_legend.append("text").attr("x", 725).attr("y", 35).attr("text-anchor", "middle").text("Faltas").style("font-weight", "bold").style("font-size", "14px").style("fill","#000").style("opacity", 1);
  player_legend.append("text").attr("id","fouls_relative").attr("x", 725).attr("y", 50).attr("text-anchor", "middle").text("(0/0)").style("font-weight", "normal").style("font-size", "11px").style("fill","#555").style("stroke", "none").style("opacity", 1);  
  //player_legend.append("text").attr("id","score_pct").attr("x", 345).attr("y", 62).attr("text-anchor", "middle").text("(0/0)").style("font-weight", "bold").style("font-size", "11px").style("fill","#9e7cc6").style("stroke", "none").style("opacity", 0);


  $.ajax({
    type: "POST",
    url: "/game/stats",
    data: {"game_id": <?php echo $game_id ?>},
    success: function(ajax_result) { 
      

      players = d3.nest().key(function(d) {
        return d.name
      }).entries(ajax_result.stats).map(function(d) { 
        return {
          "name":d.key,
          "shoot": d.values.filter(function(d) { return d.stat_type == "p"; }),
          "p2": d3.sum(d.values.filter(function(u){ return u.stat_type=="p2";}), function(o){ return +o.z*1}),
          "p1": d3.sum(d.values.filter(function(u){ return u.stat_type=="p1";}), function(o){ return +o.z*1}), 
          "p3": d3.sum(d.values.filter(function(u){ return u.stat_type=="p3";}), function(o){ return +o.z*1}),
          //"stats": d.values.filter(function(d) { return d.stat_type.match(/r|a|l|s|b/); })
          "stats": count_stats(d),
          "f":1
        }
        });
      
      players.forEach(function(d) {
        d.total = (+d.p3*3)+(+d.p2*2)+d.p1;
      });
      players.sort(function(a,b) { return d3.descending(a.total, b.total)});
      score_final = players.map(function(d) { return +d.total}).reduce(function(a,b) {return a+b});

      // Adding players legend
      legend.selectAll("circle").data(players)
        .enter()
        .append("circle")
        .attr("cx", 0)
        .attr("cy", function(d,i) { return i*30})
        .attr("r", 6)
        .attr("class", "legend")
        //.style("fill", function(d,i) { return z(i);})
        .style("fill", "#fff")
        //.style("stroke", function(d,i) { return z(i);})
        .style("stroke", "#aaa")
        // .on("mouseover", function() { d3.select(this).transition().duration(500).ease("elastic").attr("r", 8)})
        // .on("mouseout", function() { d3.select(this).transition().duration(500).ease("cubic-out").attr("r", 5)})
        // .on("click", function(d,l) { return draw_shoots(d,l);})
        .call(function(d) { return empty_shoot(d)});
        //.call(function(d) { return draw_shoots(d);})


      legend.selectAll("text").data(players)
        .enter()
        .append("text")
        .attr("x", 14)
        .attr("y", function(d,i) { return (i*30)+4})
        .text(function(d) {return d.name})

      // Animation start page to show clickable elements
      d3.selectAll("circle.legend")
        .transition().ease("elastic").duration(100).delay(function(d,i) {return i*100;}).style("fill", "#ddd").attr("r", 8)

      d3.selectAll("circle.legend")
        .transition().duration(100).delay(function(d,i) {return (i*100)+100;}).ease("cubic-out").attr("r", 6).style("fill", "#fff");
    },
    dataType: 'json'
  }); //  End Ajax Call


  function draw_stat_bar(stat_array) {
    var x = d3.scale.linear()
          .domain([0, d3.max(stat_array)])
          .range([0, 150]);

         var stat_chart = player_legend.append("g")
         .attr("id", "stat_chart")
          .attr("width", 200)
          .attr("height", 14 * stat_array.length)
          .attr("transform", "translate(510,-10)");

        stat_chart.selectAll("rect")
           .data(stat_array)
         .enter().append("rect")
           .attr("y", function(d, i) { return i * 14; })
           .attr("width", 0)
           .style("fill", "#ddd")
           .style("stroke", "white")
           .style("stroke-width", "0,5px")
           .style("shape-rendering", "crisp-edges")
           .attr("height", 14)
           .transition()
           .delay(2100)
           .duration(800)
           .ease("linear")
           .attr("width", x)


        stat_chart.selectAll("text")
          .data(stat_array)
        .enter().append("text")
          .attr("x", 14)
          .attr("y", function(d,i) { return (i*14)+7;})
          .attr("dx", function(d) {
            if (d>0) {
              return -5;
            } else {
              return 0;
            }
          }) // padding-right
          .attr("dy", ".35em") // vertical-align: middle
          .attr("text-anchor", "end") // text-align: right
          .style("fill", "black")
          .style("stroke", "none")
          .style("font-size", "10px")
          .style("font-weight", "bold")
          .text(String)
          .transition()
          .delay(2100)
           .duration(800)
           .ease("linear")
           .attr("x", function(d) {
            if (d > 0) {
              return x(d);
            } else {
              return 10;
            }
           });

          stat_chart.selectAll("text.leg")
          .data(stat_array)
        .enter().append("text")
          .attr("x", 0)
          .attr("class", "leg")
          .attr("y", function(d,i) { return (i*14)+6;})
          .attr("dx", -5) // padding-right
          .attr("dy", ".35em") // vertical-align: middle
          .attr("text-anchor", "end") // text-align: right
          .style("fill", "black")
          .style("stroke", "none")
          .style("font-size", "10px")
          .style("shape-rendering", "geometric-precision")
          .style("font-weight", "normal")
          .text(function(d,i) {
            var lab_text = "";
            switch(i) {
              case 0:
                lab_text = "rebotes";
                break;
              case 1:
                lab_text = "asistencias";
                break;
              case 2:
                lab_text = "perdidas";
                break;
              case 3:
                lab_text = "robos";
                break;
              case 4:
                lab_text = "tapones";
                break;
              default:
                lab_text = "none"
                break;
            }
            return lab_text;
          });

        stat_chart.append("line")
        .attr("y1",0)
        .attr("y2", 70)
        .style("stroke", "#555")
        .style("stroke-width", "2px");
  }

  function empty_shoot(d) {
    d.filter(function(d) {return +d.total == 0;})
    .style("stroke-dasharray", "2 2")
    .style("fill", "none");

    //d.filter(function(d) {return +d.total > 0;})
    d
    .on("mouseover", function() { d3.select(this).transition().duration(500).ease("elastic").attr("r", 8).style("fill", "#ddd").style("cursor", "pointer")})
    .on("mouseout", function() { d3.select(this).transition().duration(500).ease("cubic-out").attr("r", 6).style("fill", "#fff").style("cursor", "auto")})
    .on("click", function(d,l) { return draw_shoots(d,l);})
  }

  function resolve_path(d) {
    var path_string = "";
    var command_list = d.commands;
    
    command_list.forEach(function(item) {
      path_string += item.command;
      item.coordinates.forEach(function(coord) {
        path_string += court_scale(+coord.x);  
        path_string += ",";
        path_string += court_scale(+coord.y);
        path_string += " ";
      });
      
    
    });
    return path_string;
  }

  function draw_shoots(d,l,sel) {
    
    
    svg.selectAll(".shoot").transition().duration(200).style("opacity",0);
    svg.selectAll(".shoot").transition().delay(200).duration(100).remove();
    d3.select("#stat_chart").remove();

    d3.select("#score_player").text(d.name);
    d3.select("#score_3p").text(d.p3).style("opacity", 1);
    d3.select("#score_2p").text(d.p2).style("opacity", 1);
    d3.select("#score_1p").text(d.p1).style("opacity", 1);
    d3.select("#score_total").text("0").style("opacity", 1);
    score_transition = d3.select("#score_total").transition().ease("linear")
    score_transition
    .duration(500)
    .delay(700)
    .tween("text", function(w) {
      i_number = d3.interpolateNumber(parseInt(this.textContent), d.total);
      return function(t_number) {
        this.textContent = parseInt(i_number(t_number))
      }
    });

    d3.select("#fouls_total").text("0").style("opacity", 1);
    fouls_transition = d3.select("#fouls_total").transition().ease("linear");

    fouls_transition
    .duration(500)
    .tween("text", function(w) {
      
      l = d3.interpolateNumber(parseInt(this.textContent), d.f);
      return function(e) {
        this.textContent = parseInt(l(e));
      }
    });
    
    var good_shoots = d.shoot.filter(function(shoot_good) { return +shoot_good.z == 1 }).length;
    var total_shoots = d.shoot.length;

    d3.select("#score_relative").text(  good_shoots + " de " + total_shoots);
    if ( total_shoots == 0) {
      total_shoots += 1;
    }

    d3.select("#fouls_relative").text(  d.f + " de 5");
    
    //d3.select("#score_pct").text( d3.round( ( good_shoots / total_shoots)*100 , 2)+"% efectividad").style("opacity", 1);

    draw_stat_bar(d.stats);

    draw_foul_chart(d.f*20);
    
    draw_eficiency(d3.round( ( good_shoots / total_shoots)*100 , 2));

    // Draw each shoot circle in court
    d.shoot.forEach(function(i,p) {      

      svg.append("text")
        .attr("class", "shoot")
        .attr("y", parseInt(i.y)+4)
        .attr("x", function(d) { 
          if (p>=9) {
            return i.x-20;
          } else {
            return i.x-14;
          }
        })
        .style("font-weight", "bold")
        .style("opacity", 0)
        .text(p+1)
        .transition()
        .delay(1000)
        .style("opacity", 1);

      svg.append("circle")
        .attr("class", "shoot")
        .attr("cx", court_scale(47)+160)
        .attr("cy", court_scale(25)+10)
        .attr("r", 4)
        .style("fill", "none")
        //.style("stroke", function(d) { return z(l)})
        .style("stroke", function(d) { 
          if (i.z==1) {
            return "#46a321";
          } else {
            return "#dc2c44";
          }
        })
        .transition()
        .duration(800)
        .delay(200)
        .ease("cubic-out")
        .attr("cx", i.x)
        .attr("cy", i.y)
        .attr("r",6)
        .style("fill", function(d) { 
          if (i.z==1) {
            return "#59ce29";
          } else {
            return "#ea808e";
          }
        });

    });
  }

  function post_stats() {
    console.log(shoot_collection);
    $.ajax({
      type: 'POST',
      url: '/game/store',
      data: {"stats":JSON.stringify(shoot_collection)},
      success: function(d) {
        console.log("Successfully saved values");
        shoot_collection = [];
      },
      dataType: 'json'
    });


  }

  function count_stats(d) {
    var local_stat_array = [];
    q=d.values.filter(function(d) { return d.stat_type.match(/r|a|l|s|b/); });
    
    local_stat_array.push(d3.sum(d3.values(q).map(function(v) {return v.stat_type}), function(z) { return z=="r"}));
    local_stat_array.push(d3.sum(d3.values(q).map(function(v) {return v.stat_type}), function(z) { return z=="a"}));
    local_stat_array.push(d3.sum(d3.values(q).map(function(v) {return v.stat_type}), function(z) { return z=="l"}));
    local_stat_array.push(d3.sum(d3.values(q).map(function(v) {return v.stat_type}), function(z) { return z=="s"}));
    local_stat_array.push(d3.sum(d3.values(q).map(function(v) {return v.stat_type}), function(z) { return z=="b"}));
    return local_stat_array;
  }

  function tweenPie(b) {
    i = d3.interpolate({startAngle:0, endAngle:0}, b);
    return function(t) {
      return arc_pct(i(t));
    }
   }

  function draw_eficiency(percentage_good) {
    
    var arc = d3.svg.arc().outerRadius(42).innerRadius(35);
    // var arc_total = d3.svg.arc().outerRadius(42).innerRadius(35).startAngle(0).endAngle(Math.PI*2);
    svg.select("#arc_container").remove();
    var arc_container = svg.append("g").attr("transform", "translate(505,485)").attr("id", "arc_container");
    arc_container.append("path").attr("d", function(d) { return arc_pct({startAngle:0, endAngle:Math.PI*2});}).style("fill", "#eee").style("stroke", "none");
    arc_container.append("path").attr("d", function(d) { return arc_pct({startAngle:0, endAngle:0});}).style("fill", "#59ce29").style("stroke", "none").attr("id", "good_path");
    arc_container.append("text").attr("transform", function(d) { 
      return "translate(" +arc_pct.centroid({startAngle:0, endAngle:0})+ ")";
    }).text(percentage_good+"%").style("font-weight", "bold").attr("dx","10px").attr("id", "good_percentage").style("opacity",0);

    text_trans = d3.select("#good_percentage").transition();
    text_trans.ease("elastic").duration(1200).delay(1800).attr("transform", function(d) {
      return "translate(" +arc_pct.centroid({startAngle:0, endAngle:percentage_good*((Math.PI*2)/100)})+ ")";
    }).style("opacity",1);
    

    my_trans = d3.select("#good_path").transition();
    my_trans.ease("circle").delay(1100).duration(800).attrTween("d", function(d) {
      return tweenPie({endAngle:percentage_good*((Math.PI*2)/100)});
    });
    
    // trans_arc.duration(1000).ease("elastic")
    // .attr("transform", function(d,i) {
    //   if (i==0) {
    //     return "rotate(-"+(d.startAngle*(180/Math.PI))+")"
    //   } else {
    //     return "rotate(-"+(d.endAngle*(180/Math.PI))+")"
    //   }
    // });

  }

  function draw_foul_chart(number_of_fouls) {
    
    var arc = d3.svg.arc().outerRadius(42).innerRadius(35);
    // var arc_total = d3.svg.arc().outerRadius(42).innerRadius(35).startAngle(0).endAngle(Math.PI*2);
    svg.select("#foul_container").remove();
    var foul_container = svg.append("g").attr("transform", "translate(885,485)").attr("id", "foul_container");
    foul_container.append("path").attr("d", function(d) { return arc_pct({startAngle:0, endAngle:Math.PI*2});}).style("fill", "#eee").style("stroke", "none");
    foul_container.append("path").attr("d", function(d) { return arc_pct({startAngle:0, endAngle:0});}).style("fill", "#ea808e").style("stroke", "none").attr("id", "foul_path");
    foul_container.append("text").attr("transform", function(d) { 
      return "translate(" +arc_pct.centroid({startAngle:0, endAngle:0})+ ")";
    }).text(number_of_fouls+"%").style("font-weight", "bold").attr("dx","10px").attr("id", "foul_percentage").style("opacity",0);

    text_trans = d3.select("#foul_percentage").transition();
    text_trans.ease("elastic").duration(1200).delay(3500).attr("transform", function(d) {
      return "translate(" +arc_pct.centroid({startAngle:0, endAngle:number_of_fouls*((Math.PI*2)/100)})+ ")";
    }).style("opacity",1);
    

    my_trans = d3.select("#foul_path").transition();
    my_trans.ease("circle").delay(2900).duration(800).attrTween("d", function(d) {
      return tweenPie({endAngle:number_of_fouls*((Math.PI*2)/100)});
    });


    

    // var donut = d3.layout.pie();
    // var arc = d3.svg.arc().outerRadius(42).innerRadius(35);
    // var arc_total = d3.svg.arc().outerRadius(42).innerRadius(35).startAngle(0).endAngle(Math.PI*2);

    // svg.select("#foul_container").remove();

    // var foul_container = svg.append("g").attr("transform", "translate(885,485)").attr("id", "foul_container").data([arc_data]);
    // var arc_data = donut([(number_of_fouls*20),(100-(number_of_fouls*20))]);
    // foul_container.selectAll("path.arc").data(arc_data.sort(function(a,b) { return d3.descending(a,b)} ), function(d) { return d.value;}).enter()
    // .append("path")
    // .attr("class", "arc")
    // .style("fill", function(d,i) { 
    //   if (i==0) {
    //     return "#ea808e";
    //   } else {
    //     return "#eee";
    //   }
    // })
    // .style("stroke", "none")
    // .attr("d", function(d,i) { 
    //   if (i==0) {
    //     return arc(d);
    //   } else {
    //     return arc(d);
    //   }
    // });


    // foul_container.selectAll("text.arc").data(arc_data.sort(function(a,b) { return d3.descending(a,b)} ), function(d) { return d.value;}).enter()
    // .append("text")
    // .attr("class", function(d,i) { return "arc_"+i; })
    // .attr("transform", function(d) { return "translate("+arc.centroid(d)+") rotate(0)" })
    // .text(function(d) { return d3.round(d.value,2)+"%"; })
    // .style("font-weight", "bold")
    // .style("font-size", "11px")
    // .style("opacity", function(d,i) {
    //   if (i>0) {
    //     return 0;
    //   } else {
    //     return 0;
    //   }
    // });



    // // Animation of text
    // foul_container.selectAll("text.arc_1").remove();
    // foul_container.selectAll("text.arc_0").transition().duration(1000).ease("cubic-out").attr("transform", "translate(45,-15)").style("opacity",1);


    // trans_arc = foul_container.selectAll("path.arc").transition();
    // trans_arc.duration(1000).ease("elastic")
    // .attr("transform", function(d,i) {
    //   if (i==0) {
    //     return "rotate(-"+(d.startAngle*(180/Math.PI))+")"
    //   } else {
    //     return "rotate(-"+(d.endAngle*(180/Math.PI))+")"
    //   }
    // });



  }
</script>
</body>
</html>
