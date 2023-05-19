<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Home extends CI_Controller
	{
		public function __construct() {
			parent::__construct();
			date_default_timezone_set('Europe/Bucharest');
		}
		//==============================================================================
		function check_logged()
		{
			if(!empty($this->session->username) && !empty($this->session->email)):
				$udata = ($this->db->query("SELECT `userID` FROM `users` WHERE `name`='".$this->session->username."' AND `email`='".$this->session->email."' LIMIT 1"))->row();
				if(isset($udata->userID)):
					$this->db->query("UPDATE `users` SET `logged`='1' WHERE `name`='".$this->session->username."' AND `logged`='0' LIMIT 1");
					if(!empty($this->session->time) && $this->session->logged == 1) $this->session->set_userdata('hours', abs(number_format((time()-$this->session->time)/3600,2)));
					if($this->input->get('logout')):
						$this->db->query("UPDATE `users` SET `logged`='0', `hours`=`hours`+'".$this->session->hours."' WHERE `name`='".$this->session->username."' LIMIT 1");
						redirect('home');
					endif;
				endif;
			else:
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('You need to be logged.');},100);</script>");
				redirect(base_url());
			endif;
		}
		//==============================================================================
		function load_template($name_page, $page)
		{
			$this->session->set_userdata('page', $name_page);
			$this->load->view('templates/header');
			$this->load->view('pages/'.$page);
			$this->load->view('templates/footer');
		}
		//==============================================================================
		public function index()
		{
			$this->load_template('Home', 'home_page');
		}
		//==============================================================================
		public function register()
		{
			$this->load_template('Register', 'register_page');
		}
		//==============================================================================
		public function profile()
		{
			$this->check_logged();
			$this->load_template('Profile', 'profile_page');
		}
		//==============================================================================
		public function notifications()
		{
			$this->check_logged();
			$this->load_template('Notification Panel', 'notifications_page');
		}
		//==============================================================================
		public function punish_user()
		{
			$this->check_logged();
			$this->load_template('Admin Panel', 'punish_page');
		}
		//==============================================================================
		public function search()
		{
			$this->load_template('Search', 'search_page');
		}
		//==============================================================================
		public function policy()
		{
			$this->load_template('Policy', 'policy_page.html');
		}
		//==============================================================================
		public function tops()
		{
			$this->load_template('Tops', 'tops_page');
		}
		//==============================================================================
		public function online_users()
		{
			$this->load_template('Online Users', 'online_page');
		}
		//==============================================================================
		public function banlist()
		{
			$this->load_template('Ban List', 'banlist_page');
		}
		//==============================================================================
		public function staff()
		{
			$this->load_template('Staff', 'staff_page');
		}
		//==============================================================================
		public function minigames()
		{
			$this->check_logged();
			$this->load_template('MiniGames', 'minigames_page');
		}
		//==============================================================================
		public function upgrade()
		{
			$this->load_template('Upgrade', 'upgrade_page.html');
		}
		//==============================================================================
		public function forgot_password()
		{
			$this->load_template('Forgot Password', 'forgot_page');
		}
		//==============================================================================
		public function market()
		{
			$this->check_logged();
			$this->load_template('Market', 'market_page');
		}
		//==============================================================================
		public function resetti()
		{
			$this->load->view('pages/_resetti');
		}
		//==============================================================================
		public function logout()
		{
			$this->db->query("UPDATE `users` SET `logged`='0', `hours`=`hours`+'".$this->session->hours."' WHERE `name`='".$this->session->username."' LIMIT 1");
			$this->session->sess_destroy();
			redirect('home');
		}
	}
