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