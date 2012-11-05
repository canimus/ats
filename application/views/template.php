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
  <li><a href="#" class="active">Inicio</a></li>
  <li><a href="#">Jugadores</a></li>
  <li><a href="#">Resultados</a></li>
  <li><a href="#">Estadísticas</a></li>
  <li><a href="#">Contacto</a></li>
</ul>   
</div>

<div>
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
<script>
  var h = 540, w=960;
  var shoot_collection = [];

  court_shapes = [
    { // Base Court
      "shape":"rect",
      "id": "base_court",
      "width":94,
      "height":50,
      "x":0,
      "y":0
    },
    { // Mid field
      "shape":"rect",
      "id": "mid_court",
      "width":47,
      "height":50,
      "x":0,
      "y":0
    },
    { // Left Area
      "shape":"rect",
      "id": "area_left",
      "width":18,
      "height":12,
      "x":0,
      "y":19
    },
    { // Right Area
      "shape":"rect",
      "id": "area_right",
      "width":18,
      "height":12,
      "x":76,
      "y":19
    },
    { // Center Circle
      "shape":"circle",
      "id": "center_area",
      "r":6,
      "cx":47,
      "cy":25
    },
    { // Left Free Throw Area
      "shape":"circle",
      "id": "free_throw_area_left",
      "r":6,
      "cx":18,
      "cy":25
    },
    { // Right Free Throw Area
      "shape":"circle",
      "id": "free_throw_area_right",
      "r":6,
      "cx":76,
      "cy":25
    },
    { // Left rim
      "shape":"circle",
      "id": "rim_left",
      "r":0.75,
      "cx":5.25,
      "cy":25
    },
    {  // Left Board
      "shape":"line",
      "id": "board_left",
      "x1":4,
      "y1":22,
      "x2":4,
      "y2":28
    },
    { // Right rim
      "shape":"circle",
      "id": "rim_right",
      "r":0.75,
      "cx":5.25,
      "cy":25
    },
    {  // Right Board
      "shape":"line",
      "id": "board_right",
      "x1":4,
      "y1":22,
      "x2":4,
      "y2":28
    },
    { // Left 3 Point Limit
      "shape":"path",
      "id": "three_point_left",
      "commands": [
        {
          "command":"M",
          "coordinates": [{ "x":0, "y":6}]
        },
        {
          "command":"L",
          "coordinates": [{ "x":5.25, "y":6}]
        },
        {
          "command":"C",
          "coordinates": [
          {"x":31, "y":6},
          {"x":31, "y":44},
          {"x":5.25, "y":44}
          ]
        },
        {
          "command":"L",
          "coordinates": [{ "x":0, "y":44}]
        }
      ]
    },
    { // Right 3 Point Limit
      "shape":"path",
      "id": "three_point_right",
      "commands": [
        {
          "command":"M",
          "coordinates": [{ "x":0, "y":6}]
        },
        {
          "command":"L",
          "coordinates": [{ "x":5.25, "y":6}]
        },
        {
          "command":"C",
          "coordinates": [
          {"x":31, "y":6},
          {"x":31, "y":44},
          {"x":5.25, "y":44}
          ]
        },
        {
          "command":"L",
          "coordinates": [{ "x":0, "y":44}]
        }
      ]
    },
    { // Up-Left Free Throw Dividers
      "shape":"line",
      "id": "left_up_thick_divider",
      "class": "thick left",
      "x1":7,
      "y1":18.7,
      "x2":8,
      "y2":18.7
    },
    { // Down-Left Free Throw Dividers
      "shape":"line",
      "id": "left_down_thick_divider",
      "class": "thick left",
      "x1":7,
      "y1":31.3,
      "x2":8,
      "y2":31.3
    },
    { // Up-Left Free Throw Dividers
      "shape":"line",
      "id": "left_up_thin_1_divider",
      "class": "thick left",
      "x1":11,
      "y1":18.7,
      "x2":11.2,
      "y2":18.7
    },
    { // Up-Left Free Throw Dividers
      "shape":"line",
      "id": "left_up_thin_2_divider",
      "class": "thick left",
      "x1":14,
      "y1":18.7,
      "x2":14.2,
      "y2":18.7
    },
    { // Up-Left Free Throw Dividers
      "shape":"line",
      "id": "left_up_thin_3_divider",
      "class": "thick left",
      "x1":17,
      "y1":18.7,
      "x2":17.2,
      "y2":18.7
    },
    { // Down-Left Free Throw Dividers
      "shape":"line",
      "id": "left_down_thin_1_divider",
      "class": "thick left",
      "x1":11,
      "y1":31.3,
      "x2":11.2,
      "y2":31.3
    },
    { // Down-Left Free Throw Dividers
      "shape":"line",
      "id": "left_down_thin_2_divider",
      "class": "thick left",
      "x1":14,
      "y1":31.3,
      "x2":14.2,
      "y2":31.3
    },
    { // Down-Left Free Throw Dividers
      "shape":"line",
      "id": "left_down_thin_3_divider",
      "class": "thick left",
      "x1":17,
      "y1":31.3,
      "x2":17.2,
      "y2":31.3
    },
    { // Up-Left Free Throw Dividers
      "shape":"line",
      "id": "right_up_thick_divider",
      "class": "thick right",
      "x1":7,
      "y1":18.7,
      "x2":8,
      "y2":18.7
    },
    { // Down-Left Free Throw Dividers
      "shape":"line",
      "id": "right_down_thick_divider",
      "class": "thick right",
      "x1":7,
      "y1":31.3,
      "x2":8,
      "y2":31.3
    },
    { // Up-Left Free Throw Dividers
      "shape":"line",
      "id": "right_up_thin_1_divider",
      "class": "thick right",
      "x1":11,
      "y1":18.7,
      "x2":11.2,
      "y2":18.7
    },
    { // Up-Left Free Throw Dividers
      "shape":"line",
      "id": "right_up_thin_2_divider",
      "class": "thick right",
      "x1":14,
      "y1":18.7,
      "x2":14.2,
      "y2":18.7
    },
    { // Up-Left Free Throw Dividers
      "shape":"line",
      "id": "right_up_thin_3_divider",
      "class": "thick right",
      "x1":17,
      "y1":18.7,
      "x2":17.2,
      "y2":18.7
    },
    { // Down-Left Free Throw Dividers
      "shape":"line",
      "id": "right_down_thin_1_divider",
      "class": "thick right",
      "x1":11,
      "y1":31.3,
      "x2":11.2,
      "y2":31.3
    },
    { // Down-Left Free Throw Dividers
      "shape":"line",
      "id": "right_down_thin_2_divider",
      "class": "thick right",
      "x1":14,
      "y1":31.3,
      "x2":14.2,
      "y2":31.3
    },
    { // Down-Left Free Throw Dividers
      "shape":"line",
      "id": "right_down_thin_3_divider",
      "class": "thick right",
      "x1":17,
      "y1":31.3,
      "x2":17.2,
      "y2":31.3
    }
  ];

  players1 = [
    {
      "name": "Herminio Vazquez",
      "p3":0,
      "p2":3,
      "p1":2,
      "f":5,
    },
    {
      "name": "Roberto Rojas",
      "p3":0,
      "p2":5,
      "p1":0,
      "f":2,
      "stats": [9,1,2,1,0],
      "shoot":
      [
        {"x":206, "y":248.5833282470703, "z":0},
        {"x":232, "y":286.58331298828125, "z":1},
        {"x":201, "y":301.58331298828125, "z":0},
        {"x":224, "y":355.58331298828125, "z":1},
        {"x":224, "y":409.58331298828125, "z":0},
        {"x":322, "y":227.5833282470703, "z":0 },
        {"x":322, "y":204.5833282470703, "z":1 },
        {"x":381, "y":211.5833282470703, "z":0 },
        {"x":260, "y":123.58332824707031, "z":0},
        {"x":935, "y":82.58332824707031, "z":0 },
        {"x":797, "y":218.5833282470703, "z":1 },
        {"x":914, "y":188.5833282470703, "z":0 },
        {"x":908, "y":201.5833282470703, "z":1 },
        {"x":905, "y":243.5833282470703, "z":0}
      ]
    },
    {
      "name": "Luis Maya",
      "p3":0,
      "p2":3,
      "p1":3,
      "f":2,
      "stats": [1,1,1,3,0],
      "shoot":
      [
        {"x":209, "y": 181.5833282470703, "z":1 },
        {"x":208, "y": 203.5833282470703, "z":1 },
        {"x":217, "y": 191.5833282470703, "z":0 },
        {"x":231, "y": 202.5833282470703, "z":0 },
        {"x":892, "y": 103.58332824707031, "z":0},
        {"x":896, "y": 238.5833282470703, "z":1 },
        {"x":906, "y": 254.5833282470703, "z":0 },
        {"x":914, "y": 297.58331298828125, "z":1}
      ]
    },
    {
      "name": "Emmanuel Offor",
      "p3":1,
      "p2":0,
      "p1":2,
      "f":5,
      "total":0
    },
    {
      "name": "Álvaro Guilabert",
      "p3":1,
      "p2":0,
      "p1":0,
      "f":2,
      "total":0
    },
    {
      "name": "Alejandro García",
      "p3":0,
      "p2":0,
      "p1":0,
      "f":2,
      "total":0
    },
    {
      "name": "Ian Triguero",
      "p3":0,
      "p2":1,
      "p1":1,
      "f":1,
      "total":0
    },
    {
      "name": "Daniel Garrido",
      "p3":0,
      "p2":0,
      "p1":0,
      "f":1,
      "total":0
    },
    {
      "name": "Carlos Coves",
      "p3":0,
      "p2":2,
      "p1":0,
      "f":2,
      "total":0
    },
    {
      "name": "Miguel Cremades",
      "p3":0,
      "p2":0,
      "p1":0,
      "f":1,
      "total":0
    },
    {
      "name": "Alexander Datko",
      "p3":0,
      "p2":0,
      "p1":0,
      "f":3,
      "total":0
    },
    {
      "name": "Gabri",
      "p3":0,
      "p2":0,
      "p1":0,
      "f":0,
      "total":0
    },
    {
      "name": "Leo",
      "p3":0,
      "p2":0,
      "p1":0,
      "f":0,
      "total":0
    }
  ]

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

  player_legend = svg.append("g").attr("transform", "translate(160,460)").attr("id", "player_legend");
  player_legend.append("text").attr("id","score_player").attr("x", 0).attr("y", 8).text("").style("font-weight", "bold").style("font-size", "22px");
  player_legend.append("circle").attr("cx", 5).attr("cy", 24).attr("r",6).style("fill", "#59ce29").style("stroke", "#46a321");
  player_legend.append("text").attr("x", 16).attr("y", 28).text("Enceste").style("font-weight", "normal").style("font-size", "11px").style("fill","#555").style("stroke", "none");
  player_legend.append("circle").attr("cx", 5).attr("cy", 40).attr("r",6).style("fill", "#ea808e").style("stroke", "#dc2c44");
  player_legend.append("text").attr("x", 16).attr("y", 44).text("Fallo").style("font-weight", "normal").style("font-size", "11px").style("fill","#555").style("stroke", "none");

  player_legend.append("text").attr("x", 200).attr("y", 5).text("Triples:").style("font-weight", "normal").style("font-size", "11px").style("fill","#555").style("stroke", "none");
  player_legend.append("text").attr("id","score_3p").attr("x", 260).attr("y", 5).text("0").style("font-weight", "bold").style("fill","#000").style("opacity", 0).style("font-size", "14px");

  player_legend.append("text").attr("x", 200).attr("y", 25).text("Dobles:").style("font-weight", "normal").style("font-size", "11px").style("fill","#555").style("stroke", "none");
  player_legend.append("text").attr("id","score_2p").attr("x", 260).attr("y", 25).text("5").style("font-weight", "bold").style("fill","#000").style("opacity", 0).style("font-size", "14px");

  player_legend.append("text").attr("x", 200).attr("y", 45).text("Libres:").style("font-weight", "normal").style("font-size", "11px").style("fill","#555").style("stroke", "none");
  player_legend.append("text").attr("id","score_1p").attr("x", 260).attr("y", 45).text("0").style("font-weight", "bold").style("fill","#000").style("opacity", 0).style("font-size", "14px");

  player_legend.append("text").attr("id","score_total").attr("x", 300).attr("y", 15).text("0").style("font-weight", "bold").style("font-size", "30px").style("fill","#000").style("opacity", 1);
  player_legend.append("text").attr("x", 300).attr("y", 35).text("Puntos").style("font-weight", "bold").style("font-size", "16px").style("fill","#000").style("opacity", 1);
  player_legend.append("text").attr("id","score_relative").attr("x", 300).attr("y", 50).text("(0/0)").style("font-weight", "normal").style("font-size", "11px").style("fill","#555").style("stroke", "none").style("opacity", 1);
  player_legend.append("text").attr("id","score_pct").attr("x", 300).attr("y", 62).text("(0/0)").style("font-weight", "bold").style("font-size", "11px").style("fill","#9e7cc6").style("stroke", "none").style("opacity", 0);


  $.ajax({
    type: "POST",
    url: "/index.php/welcome/stats",
    data: {"game_id":1},
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
          "stats": count_stats(d)
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
          .range([0, 200]);

         var stat_chart = player_legend.append("g")
         .attr("id", "stat_chart")
          .attr("width", 320)
          .attr("height", 14 * stat_array.length)
          .attr("transform", "translate(480,-10)");

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
           .duration(800)
           .ease("linear")
           .attr("width", x)


        stat_chart.selectAll("text")
          .data(stat_array)
        .enter().append("text")
          .attr("x", 10)
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
    .tween("text", function(w) {
      i = d3.interpolateNumber(parseInt(this.textContent), d.total);
      return function(t) {
        this.textContent = parseInt(i(t))
      }
    });
    
    var good_shoots = d.shoot.filter(function(shoot_good) { return +shoot_good.z == 1 }).length;
    var total_shoots = d.shoot.length;

    d3.select("#score_relative").text(  good_shoots + " de " + total_shoots);
    if ( total_shoots == 0) {
      total_shoots += 1;
    }
    d3.select("#score_pct").text( d3.round( ( good_shoots / total_shoots)*100 , 2)+"% efectividad").style("opacity", 1);

    draw_stat_bar(d.stats);

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
      url: '/index.php/welcome/store',
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
</script>
</body>
</html>
