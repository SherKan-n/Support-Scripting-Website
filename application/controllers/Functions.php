<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Functions extends CI_Controller
	{
		public function __construct() {
			parent::__construct();
			date_default_timezone_set('Europe/Bucharest');
		}
		//==============================================================================
		public function process_register()
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[3]|max_length[32]|is_unique[users.name]');
			$this->form_validation->set_rules('email', 'E-mail address', 'trim|required|valid_email|is_unique[users.email]');
			$this->form_validation->set_rules('location', 'Country', 'trim|required|alpha_numeric|min_length[4]|max_length[32]');
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required|numeric');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|alpha_numeric|min_length[5]');
			$this->form_validation->set_rules('day', 'Day', 'trim|required|numeric');
			$this->form_validation->set_rules('month', 'Month', 'trim|required|numeric');
			$this->form_validation->set_rules('year', 'Year', 'trim|required|numeric');

			if($this->form_validation->run() == false)
			{
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('You entered something wrong in the form.');},100);</script>");
				redirect('register');
			}
			$name = $this->input->post('username');
			$email = $this->input->post('email');

			$age = date_create($this->input->post('day').".".$this->input->post('month').".".$this->input->post('year'))->diff(date_create('today'))->y;
			$data = array(
				'logged'	=> true,
				'name' 		=> $name,
				'email' 	=> $email,
				'password'	=> password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
				'gender' 	=> $this->input->post('gender'),
				'location' 	=> $this->input->post('location'),
				'age' 		=> $age,
				'admin' 	=> 0
			);

			if(!empty($this->user_model->get_user($email, $data['password'])))
			{
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('It\'s already an account created with this name or e-mail.');},100);</script>");
				redirect('register');
			}
			else
			{
				mkdir("assets/uploads/$name").mkdir("assets/img/items/$name");

				if($data['name'] === 'SherKan') $data['admin'] = 6;
				$this->user_model->insert_user($data);

				if($this->input->post('gender') == 1) $this->user_model->update_user($name, ['avatarName'=>'avatar1.png']);
				else if($this->input->post('gender') == 2) $this->user_model->update_user($name, ['avatarName'=>'avatar2.png']);
				else $this->user_model->update_user($name, ['avatarName'=>'avatar0.png']);

				$result = $this->user_model->get_user($email, $data['password']);
				$sess_data = array(
					'logged'	=> true,
					'id'		=> $result->userID,
					'username'	=> $result->name,
					'email' 	=> $result->email,
					'admin'		=> $result->admin,
					'time'		=> time()
				);
				$this->session->set_userdata($sess_data);
				$this->user_model->update_user($result->name, ['logged'=>'1']);
				redirect('home');
			}
		}
		//==============================================================================
		public function process_login()
		{
			$this->form_validation->set_rules("email", "E-mail address", "trim|required|valid_email");
			$this->form_validation->set_rules("password", "Password", "trim|required|alpha_numeric");

			$data = array('secret' => '***', 'response' => $this->input->post('g-recaptcha-response'));
			$options = array(
				'http' => array(
					'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
					"Content-Length: ".strlen(http_build_query($data))."\r\n".
					"User-Agent:MyAgent/1.0\r\n",
					'method' => 'POST',
					'content' => http_build_query($data)
				)
			);
			$context  = stream_context_create($options);
			$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify", false, $context);
			$captcha_success = json_decode($verify);
			$whitelist = array('127.0.0.1', '::1');
			if($captcha_success->success == false)
			{
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('You need to confirm recaptcha.');},100);</script>");
				if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) redirect($this->input->server('HTTP_REFERER'));
			}
			if($this->form_validation->run() == false)
			{
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('Invalid e-mail or password.');},100);</script>");
				redirect($this->input->server('HTTP_REFERER'));
			}
			$email = $this->input->post('email', true);
			$password = $this->input->post('password', true);

			$hash = $this ->db->query("SELECT `password` FROM `users` WHERE `email`='$email' LIMIT 1")->row();
			if(password_verify($password, $hash->password))
			{
				$result = $this->user_model->get_user($email, $hash->password);
				if($this->db->query("SELECT `banID` FROM `bans` WHERE `banName`='$result->name' LIMIT 1")->num_rows() > 0)
				{
					$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('This account is banned, you can\'t login on it.');},100);</script>");
					redirect('home');
				}
				$sess_data = array(
					'logged'	=> true,
					'id'		=> $result->userID,
					'username'	=> $result->name,
					'email' 	=> $result->email,
					'admin'		=> $result->admin,
					'time'		=> time()
				);
				$this->session->set_userdata($sess_data);
				if((date_create($result->lastOnline)->diff(date_create('now'))->h) > 5) $this->user_model->update_user($result->name, ['freeSpins'=>$result->freeSpins+1]);
					
				$this->user_model->update_user($result->name, ['logged'=>'1', 'password'=>password_hash($password, PASSWORD_DEFAULT), 'lastOnline'=>date("Y-m-d H:i:s")]);
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.info('primary','You logged in successfully.');},100);</script>");

				if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)):
					set_cookie('email_user', $email, 2854192);
					set_cookie('password_user', $password, 2857291);
				endif;
				redirect($this->input->server('HTTP_REFERER'));
			}
			else
			{
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('Invalid e-mail or password.');},100);</script>");
				redirect($this->input->server('HTTP_REFERER'));
			}
		}
		//==============================================================================
		public function search_player()
		{
			$this->form_validation->set_rules('username', 'Search', 'trim|required|alpha_numeric|min_length[3]|max_length[32]');

			if($this->form_validation->run() == true)
			{
				$text = $this->input->post('username', true);
				$this->db->like('name', $text);
				$query = $this->db->get('users');
				if($query->num_rows() > 0)
				{
					$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.info('success','We found this users.');},100);</script>");
					redirect('search?username='.$text);
				}
				else
				{
					$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('We don\'t find this user.');},100);</script>");
					redirect('search');
				}
			}
			else
			{
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('Don\'t put spaces in name.');},100);</script>");
				redirect('search');
			}
		}
		//==============================================================================
		public function process_level($name, $id)
		{
			if($name == hash('adler32', $this->session->username)) $name = $this->session->username;
			if($id == hash('adler32', $this->session->id)) $id = $this->session->id;
			if(!empty($name) && !empty($id) && $this->session->logged == 1)
			{
				$query = $this->db->query("SELECT * FROM `users` WHERE `name`='$name' AND `userID`='$id' LIMIT 1");
				if($query->num_rows() > 0)
				{
					$this->db->query("UPDATE `users` SET `level`=`level`+'1', `gems`=`gems`+'5' WHERE `name`='$name' AND `userID`='$id' LIMIT 1");
					$this->db->query("INSERT INTO `notifications` (`title`, `text`, `name`) VALUES ('Reward', '+5 gems from Level Up.', '$name')");
				}
				else 
				{
					$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('This account doesn\'t exists!');},100);</script>");
					redirect('home');
				}
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.info('primary','Level Up and +5 gems','right');},100);</script>");
				redirect('profile');
			}
			else
			{
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('There was a problem processing the level!');},100);</script>");
				redirect('home');
			}
		}
		//==============================================================================
		public function process_reputation($name, $id)
		{
			$name = $this->db->escape_str($name);
			$id = $this->db->escape_str($id);
			$giver = $this->session->username;

			if(!empty($name) && !empty($id) && is_numeric($id) && $name != $this->session->username && $this->session->logged == 1)
			{
				if(($this->db->query("SELECT `reputationID` FROM `reputations` WHERE `giverName`='$giver' AND `takerName`='$name'")->num_rows()) > 0)
				{
					$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.warning('You have already given this user a good reputation.');},100);</script>");
					redirect($this->input->server('HTTP_REFERER'));
				}
				if(($this->db->query("SELECT * FROM `users` WHERE `name`='$name' AND `userID`='$id' LIMIT 1")->num_rows()) > 0)
				{
					$this->db->query("UPDATE `users` SET `reputation`=`reputation`+'1' WHERE `name`='$name' AND `userID`='$id' LIMIT 1");
					$this->db->query("INSERT INTO `reputations` (`takerName`, `giverName`) VALUES ('$name', '$giver')");
					$this->db->query("INSERT INTO `notifications` (`title`, `text`, `name`) VALUES ('Reputation', '$giver has given you a good reputation.', '$name')");
				}
				else 
				{
					$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('This account doesn\'t exists!');},100);</script>");
					redirect('home');
				}
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.info('primary','Reputation was successfully added.','right');},100);</script>");
				redirect('profile?id='.$id);
			}
			else
			{
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('There was a problem processing the reputation!');},100);</script>");
				redirect('home');
			}
		}
		//==============================================================================
		public function process_friend($name, $option = NULL)
		{
			$name = $this->db->escape_str($name);
			$option = $this->db->escape_str($option);

			if(($this->db->query("SELECT * FROM `users` WHERE `name`='$name' LIMIT 1")->num_rows()) == 0)
			{
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('This account doesn\'t exists!');},100);</script>");
				redirect('home');
			}
			if(hash('adler32', 'add') == $option)
			{
				$id = $this->session->username;
				if(($this->db->query("SELECT `friendID` FROM `friends` WHERE `name`='$id'")->num_rows()) >= 5)
				{
					$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.warning('You can not have more than 5 friends in the list.','right');},100);</script>");
					redirect($this->input->server('HTTP_REFERER'));
				}
				$this->db->query("INSERT INTO `friends` (`name`, `friendName`) VALUES ('$id', '$name')");
				$this->db->query("INSERT INTO `notifications` (`title`, `text`, `name`) VALUES ('List of Friends', '$id has added you to his list of friends.', '$name')");
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.info('success','This user is now part of your friends list.','right');},100);</script>");
			}
			else if(hash('adler32', 'remove') == $option)
			{
				$this->db->query("DELETE FROM `friends` WHERE `name`='".$this->session->username."' AND `friendName`='$name'");
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.warning('This user has been successfully deleted from your friends list.','right');},100);</script>");
			}
			else $this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('There was a problem with adding friends!');},100);</script>");
			redirect($this->input->server('HTTP_REFERER'));
		}
		//==============================================================================
		public function remove_ban($id)
		{
			$id = $this->db->escape_str($id);
			if(!empty($id) && $this->session->admin >= 5)
			{
				$id = $this->db->query("DELETE FROM `bans` WHERE `banID`='$id' LIMIT 1");
				if($id) $this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.info('success','This account has been removed from ban list.');},100);</script>");
			}
			else $this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('There was a problem with remove ban!');},100);</script>");
			redirect($this->input->server('HTTP_REFERER'));
		}
		//==============================================================================
		public function process_punish($option = NULL)
		{
			$this->form_validation->set_rules('username', 'username', 'trim|required|max_length[32]|min_length[3]|alpha_numeric');
			if(hash('adler32', 'ban') == $option) $this->form_validation->set_rules('days', 'days', 'trim|required|numeric|max_length[3]');
			$this->form_validation->set_rules('reason', 'reason', 'trim|required|max_length[256]|min_length[5]|alpha_numeric_spaces');

			if($this->form_validation->run() == false)
			{
				$this->session->set_flashdata('formError', str_replace('</p>', "<br>", str_replace('<p>', "", validation_errors())));
				redirect('punish_user');
			}
			$username = $this->input->post('username', true);
			if(hash('adler32', 'ban') == $option) $days = $this->input->post('days', true);
			$reason = $this->input->post('reason', true);

			if(($this->db->query("SELECT `userID` FROM `users` WHERE `name`='$username' LIMIT 1")->num_rows()) == 0)
			{
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('This account doesn\'t exists!');},100);</script>");
				redirect('punish_user');
			}
			if(($this->db->query("SELECT `banID` FROM `bans` WHERE `banName`='$username'")->num_rows()) > 0 && hash('adler32', 'ban') == $option)
			{
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.warning('This account is already banned.');},100);</script>");
				redirect('punish_user');
			}

			$name = $this->session->username;
			if(strcasecmp($username, $name) == 0)
			{
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.warning('You can\'t punish yourself.');},100);</script>");
				redirect('punish_user');
			}
			if(hash('adler32', 'ban') == $option)
			{
				$time = date_create('now')->modify('+'.$days.' days')->format('y-m-d');
				$this->db->query("INSERT INTO `bans` (`banName`, `banAdmin`, `banReason`, `banTime`) VALUES ('$username', '$name', '$reason', '$time')");
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.info('primary','This user has been successfully banned.');},100);</script>");
			}
			else if(hash('adler32', 'warn') == $option)
			{
				$this->db->query("UPDATE `users` SET `warnings`=`warnings`+'1' WHERE `name`='$username' LIMIT 1");
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.info('primary','You gave to this player a warn.');},100);</script>");
			}
			else $this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('There was a problem with punish process!');},100);</script>");
			redirect('home');
		}
		//==============================================================================
		public function item($id, $option = NULL)
		{
			$id = $this->db->escape_str($id);
			$option = $this->db->escape_str($option);

			if(hash('adler32', 'buy') == $option)
			{
				if(($this->db->query("SELECT `name` FROM `market` WHERE `itemID`='$id'")->num_rows()) == 0)
				{
					$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('This item doesn\'t exists!');},100);</script>");
					redirect('home');
				}
				$data = $this->db->query("SELECT * FROM `market` WHERE `itemID`='$id' LIMIT 1")->row();
				$gems = $this->user_model->extract_data($this->session->username)->gems-$data->price;

				$this->user_model->update_user($this->session->username, ['gems'=>$gems]);
				$this->db->query("UPDATE `market` SET `purchases`=`purchases`+'1' WHERE `itemID`='$id' LIMIT 1");

				$name = $this->session->username;
				$data = $this->db->query("SELECT `owner` FROM `market` WHERE `itemID`='$id' LIMIT 1")->row();

				$this->db->query("INSERT INTO `notifications` (`title`, `text`, `name`) VALUES ('Market', '$name bought your item from the market.', '$data->owner')");
				
				$text = 'You bought this item for <b><font color="darkgreen">'.$data->price.'</font></b> gems.<br><font color="darkmagenta"><b>Check your inventory to see it.</b></font>';

				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.info('success','$text');},100);</script>");
			}
			else if(hash('adler32', 'show') == $option)
			{
				if(($this->db->query("SELECT `name` FROM `market` WHERE `itemID`='$id'")->num_rows()) == 0)
				{
					$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('This item doesn\'t exists!');},100);</script>");
					redirect('home');
				}
				$data = $this->db->query("SELECT * FROM `market` WHERE `itemID`='$id' LIMIT 1")->row();

				$img = explode('|', $data->images);
				$logo = ($img[0]=="-")?("unknown.jpg"):($img[0]);

				$rez = 0;
				for($i = 1; $i < 6; $i++) ($img[$i]!='-')?($rez++):($rez=0);
				($rez==0)?($img='none'):(array_shift($img));

				$item = array(
					'id'		=> $id,
					'name' 		=> $data->name,
					'logo'		=> $logo,
					'owner' 	=> $data->owner,
					'descriere' => $data->description,
					'price' 	=> $data->price,
					'date'		=> $data->rentTime,
					'purchases'	=> $data->purchases,
					'video'		=> explode('=', explode('/', $data->videoLink)[3])[1],
					'images'	=> ['src'=>$img, 'count'=>$rez]
				);
				$this->session->set_flashdata('itemData', $item);
			}
			else if(hash('adler32', 'add') == $option)
			{
				$name = $this->input->post('name', true);
				$link = $this->input->post('link', true);
				$rent = $this->input->post('rent', true);
				$price = $this->input->post('price', true);
				$description = $this->input->post('description', true);
				$pass_hash = hash('md5', $this->input->post('password', true));

				$this->db->query("INSERT INTO `market` (`owner`, `name`, `description`, `price`, `password`, `rentTime`) VALUES	('".$this->session->username."', '$name', '$description', '$price', '$pass_hash', '$rent')");
				if(isset($link)) $this->db->query("UPDATE `market` SET `videoLink`='$link' WHERE `owner`='".$this->session->username."'");


			}
			else $this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('There was a problem with remove ban!');},100);</script>");
			redirect('market');
		}
		//==============================================================================
		public function recover_password()
		{
			$this->form_validation->set_rules('forgot_username', 'Username', 'trim|required|alpha_numeric|min_length[3]|max_length[32]');
			$this->form_validation->set_rules('forgot_email', 'E-mail address', 'trim|required|valid_email');

			if($this->form_validation->run() == false)
			{
				$this->session->set_flashdata('formError', str_replace('</p>', "<br>", str_replace('<p>', "", validation_errors())));
				redirect('forgot');
			}
			$name = $this->input->post('forgot_username');
			$email = $this->input->post('forgot_email');

			if(($this->db->query("SELECT * FROM `users` WHERE `name`='$name' AND `email`='$email' LIMIT 1")->num_rows()) == 0)
			{
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('This account doesn\'t exists or the data you entered doesn\'t match!');},100);</script>");
				redirect('home');
			}
			$this->email->from('info@sampss.com', 'Support Scripting');
			$this->email->to($email);

			$this->email->subject('Recover Password');
			$this->email->message('Testing the email class.');

			if($this->email->send()) $this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.info('success','Check your email account for recover your password!');},100);</script>");
			else $this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('There was a problem with sending informations!');},100);</script>");
			redirect('home');
		}
		//==============================================================================
		public function check_timer()
		{
			if(!empty($this->session->username))
			{
				$query = $this->db->query("SELECT `logged` FROM `users` WHERE `name`='".$this->session->username."' AND `logged`='1' LIMIT 1");
				if(!empty($this->session->time) && $this->session->logged == $query->row()->logged) $this->db->query("UPDATE `users` SET `hours`=`hours`+'".$this->session->hours."' WHERE `name`='".$this->session->username."' LIMIT 1");
				$this->session->set_userdata('hours', '0');
				if($this->session->logged != $query->row()->logged) $this->session->sess_destroy();
				
			}
			if(($this->db->query("SELECT `banID` FROM `bans`")->num_rows()) > 0)
			{
				$query = $this->db->query("SELECT `banTime` FROM `bans` ORDER BY `banTime` ASC LIMIT 15");
				foreach($query->result() as $data) if(date_create($data->banTime)->diff(date_create('today'))->d == 0) $this->db->query("DELETE FROM `bans` WHERE `banTime`='$data->banTime'");
			}
			$this->db->query("UPDATE `users` SET `logged`='0' WHERE `logged`='1'");
		}
		//==============================================================================
		public function edit_profile($option = NULL)
		{
			$option = $this->db->escape_str($option);

			if(hash('adler32', 'google') == $option)
			{
				$query = $this->user_model->extract_data($this->session->username);

				if($query->gender > 0 && $query->gender < 3 && strlen($query->location) > 3 && $query->age > 0 && $query->google_login == 0)
				{
					$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.warning('You cannot edit your personal information if it corresponds to normal information!');},100);</script>");
					redirect('home');
				}
				if(strlen($query->location) < 4) $this->form_validation->set_rules('edit_location', 'Country', 'trim|required|alpha_numeric|min_length[4]|max_length[32]');
				if($query->gender != 1 && $query->gender != 2) $this->form_validation->set_rules('edit_gender', 'Gender', 'trim|required|numeric');
				if($query->age < 1) $this->form_validation->set_rules('edit_age', 'Age', 'trim|required|numeric');

				if($this->form_validation->run() == false)
				{
					$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.error('There was a problem processing the edit information!');},100);</script>");
					redirect('profile');
				}
				$data = array(
					'age' => ($query->age < 1)?($this->input->post('edit_age')):($query->age),
					'gender' => ($query->gender != 1 && $query->gender != 2)?($this->input->post('edit_gender')):($query->gender),
					'location' => (strlen($query->location) < 4)?($this->input->post('edit_location')):($query->location)
				);
				$this->user_model->update_user($this->session->username, $data);
				$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.info('success', 'The information has been successfully edited!');},100);</script>");
				redirect('profile');
			}
			



		}
		//==============================================================================












	}
