<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
		$this->load->model("Game_model", "coach");
		$data['players'] = $this->coach->get_players();
		$this->load->view('welcome_message');
	}
	
	public function test() {
		$this->load->model("Game_model", "coach");
		$data['players'] = $this->coach->get_players();
		$data['games'] = $this->coach->get_games();
		$this->load->view('template', $data);
	}

	public function store() {
		$this->load->model("Game_model", "coach");
		if ($this->input->post('stats') &&  (count(json_decode($this->input->post('stats'),true)) > 0)) {
			$status_insert = $this->coach->store_stats(json_decode($this->input->post('stats'),true));	
		} else {
			$status_insert = false;
		}
		
		$this->output
    	->set_content_type('application/json')
    	->set_output(json_encode(array('status_insert' => $status_insert)));
	}

	public function stats() {
		$this->load->model("Game_model", "coach");
		if ( $this->input->post('game_id') ) {
			$stats = $this->coach->get_player_stats(json_decode($this->input->post('game_id'),true));	
		} else {
			$stats = false;
		}
		
		$this->output
    	->set_content_type('application/json')
    	->set_output(json_encode(array('stats' => $stats)));	
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */