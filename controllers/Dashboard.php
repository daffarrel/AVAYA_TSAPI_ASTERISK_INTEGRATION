<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('tswebservice');
		if (!$this->session->userdata('getLogging')) {
			redirect('Auth');
		}
	}

	public function index()
	{
		$page['header']		= 'Dashboard';
		$page['content'] 	= $this->load->view('index', '', TRUE);
		$page['script']		= $this->load->view('index_js', '', TRUE);
		$this->load->view('layout', $page);
	}

	function getActCall() {
		$actSelected = $this->input->post('actionType');
		$currentNumber = $this->input->post('currentNumber');
		$outNumber = $this->input->post('outNumber');
		$data  = $this->tswebservice->actionConnected($actSelected, $currentNumber, $outNumber);
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */