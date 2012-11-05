<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
* select (select name from teams where id=a.team_1) as team_1,(select name from teams where id=a.team_2) as team_2 from games a
* union
* select b.final_score_team_1,b.final_score_team_2 from games b
**/
class Game_model extends CI_Model {
  function __construct() {
     parent::__construct();
  }

  function get_players() {
    $query = $this->db->get('players');
    return $query->result();
  }

  function store_stats($stat_json) {
    return $this->db->insert_batch('game_stats',$stat_json);
  }

  function get_games() {
    $query = $this->db->query("select a.id,(select name from teams where id=a.team_1) as team_1,(select name from teams where id=a.team_2) as team_2 from games a");
    return $query->result();
  }

  function get_player_stats($game_id = 1) {
    $query = $this->db->query("select concat(a.first_name,' ',a.last_name) as name,b.coord_x as x,b.coord_y as y,b.coord_z as z,b.stat_type from game_stats b inner join players a on (a.id = b.player_id) where game_id = ?", array($game_id));
    return $query->result();
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */