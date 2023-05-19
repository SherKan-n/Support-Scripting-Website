<?php
    defined('BASEPATH') or exit('No direct script access allowed');
    class Ajax extends CI_Controller
    {
		public function __construct() {
			parent::__construct();
			date_default_timezone_set('Europe/Bucharest');
			include_once 'vendor/autoload.php';
		}
		//==============================================================================
        public function findname($name = NULL)
		{
            if(!empty($name)) $name = $this->db->escape_str($name);

            $this->db->like('name', $name);
            $this->db->limit(5);
            $query = $this->db->get('users');

            $findname = NULL;
            $count = 0;

            if(strlen($name) > 1):
                foreach($query->result() as $data):
                    if(stristr($name, substr($data->name, 0, strlen($name)))):
                        $findname .= $data->name."&nbsp;&nbsp;";
                        ($count++ == 2)?($findname.="<br>"):("");
                    endif;
                endforeach;
            endif;

			echo (empty($findname))?("user not found"):($findname);
        }
        //==============================================================================
        public function sendskills($id)
		{
            $count = $get = 0;
            $languages = array(1=>'C', 'C++', 'C#', 'Java', 'Python', 'PAWN', 'HTML', 'CSS', 'JavaScript', 'PHP', 'Ruby', 'MySQL');
            while($count++ < sizeof($languages)) if($id == hash('adler32', $count)) $get = $count;
            if($get == 0) exit;

            $skills = explode("|", $this->user_model->extract_data($this->session->username)->skills);
            $skills[$get-1] = 1;
            $skills = implode("|", $skills);

            $this->user_model->update_user($this->session->username, ['skills'=>$skills]);

			echo "<b>".$languages[$get]."</b> skill was successfully updated.";
        }
		//==============================================================================
		public function sendreward($option, $value = NULL)
		{
			if($option == "spin")
			{
				$query = $this->user_model->extract_data($this->session->username);
				if($query->freeSpins < 1 || !is_numeric($value)) exit;
				$this->user_model->update_user($this->session->username, ['gems'=>$query->gems+$value, 'freeSpins'=>$query->freeSpins-1]);
			
				if($value == 50) $color = "red";
				else if($value == 30) $color = "orange";
				else if($value == 15) $color = "#00c2ab";
				else $color = "grey";

				$text = "<b style='color:purple;'>".$this->session->username."</b> won <b style='color:$color;'>$value <i class='far fa-gem'></i></b> from <b style='color:blue;'>Wheel Spin</b>";
				if(write_file('assets/logs/wheelspin.log', $text.",\n", 'a'))
				{
					$json = array(
						"notification" => "You win +$value gems from this spin.",
						"lastwin"	   => "Your Last Reward:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$value <i class='far fa-gem'></i> from Wheel Spin", 
						"winslog"	   => $text
					);
					echo json_encode($json);
				}
			}
		}
		//==============================================================================
        public function google_login()
		{
			$google_client = new Google_Client();
			$google_client->setClientID('*****');
			$google_client->setClientSecret('*****');
			$google_client->setRedirectUri(base_url().'ajax/google_login');
			$google_client->addScope('email');
			$google_client->addScope('profile');

			if(isset($_GET['code']))
			{
				$token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);

				if(empty($token['error']))
				{
					$google_client->setAccessToken($token['access_token']);
					$google_services = new Google_Service_Oauth2($google_client);
					$result = $google_services->userinfo->get();

					if(($this->db->query("SELECT * FROM `users` WHERE `email`='$result->email'")->num_rows()) == 0)
					{
						$diacritice = array('Š'=>'S', 'š'=>'s', 'Ð'=>'Dj', 'Ž'=>'Z', 'ž'=>'z', 'C'=>'C', 'c'=>'c', 'C'=>'C', 'c'=>'c',
							'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
							'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
							'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
							'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
							'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
							'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
							'ÿ'=>'y', 'R'=>'R', 'r'=>'r', 'ș'=>'s', 'ă'=>'a', 'ț'=>'t', 'Ș'=>'S', 'Ț'=>'T', 'Ă'=>'A', '-'=>''
						);

						$name = strtr(str_replace(" ", "", $result->name), $diacritice);
						$data = array(
							'logged'	=> true,
							'name' 		=> $name,
							'email' 	=> $result->email,
							'password'	=> password_hash(rand(), PASSWORD_DEFAULT),
							'google_login' => true,
							'location' 	=> $result->locale,
							'avatarName'=> $result->picture,
							'admin' 	=> 0
						);
						mkdir("assets/uploads/$name").mkdir("assets/img/items/$name");
		
						if($data['name'] === 'SherKan') $data['admin'] = 6;
						$this->user_model->insert_user($data);
					}
					$query = $this->db->query("SELECT * FROM `users` WHERE `google_login`='1' AND `email`='$result->email' LIMIT 1")->row();
					$sess_data = array(
						'logged'	=> true,
						'id'		=> $query->userID,
						'access_token' => $token['access_token'],
						'username'	=> $query->name,
						'email' 	=> $query->email,
						'admin'		=> $query->admin,
						'time'		=> time()
					);
					$this->session->set_userdata($sess_data);
					if((date_create($query->lastOnline)->diff(date_create('now'))->h) > 5) $this->user_model->update_user($query->name, ['freeSpins'=>$query->freeSpins+1]);
	
					$this->user_model->update_user($query->name, ['logged'=>'1', 'lastOnline'=>date("Y-m-d H:i:s")]);
					$this->session->set_flashdata('messageError', "<script>setTimeout(function(){notify.info('primary','You logged in successfully.');},100);</script>");
					redirect('home');
				}
            }
            if(empty($this->session->access_token)):
                echo '<a href="'.$google_client->createAuthUrl().'"><img src="assets/img/btn_google_signin.png" border="1" style="border-radius:3px; width:150px;"></a>';
            endif;
		}
		//==============================================================================
		public function update()
		{
			if($this->session->admin < 5 || empty($this->session->username)) exit;
			
			$text = $this->db->escape_str(get_cookie("update_text", TRUE));
			if(empty($text)) exit;

			$query = $this->db->query("SELECT * FROM `updates` ORDER BY `date` DESC, `updateID` DESC LIMIT 1")->row();
			
			$version = "v".(preg_replace("/[a-z]/", '', $query->version) + 0.01)."b";
			$date = date_format(date_create(), "Y-m-d");
			
			if($this->db->query("INSERT INTO `updates` (`text`, `version`, `date`) VALUES ('$text', '$version', '$date')")) echo "Update successfully added.";
			else echo "There was a problem adding the update.";
			delete_cookie("update_text");
		}
        //==============================================================================
    }
