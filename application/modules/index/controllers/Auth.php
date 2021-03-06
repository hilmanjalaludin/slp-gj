<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Index Controller.
 * For Login, Logout, Forgot Password, Reset Password
 */
class Auth extends MX_Controller  {

    private $_view_folder = "index/";

    /**
	 * constructor.
	 */
    public function __construct() {
        parent::__construct();
        //get method.
        // load the library
		$this->load->library("geolib/geolib");
        $method = $this->router->fetch_method();

        if($method == "login" && $this->session->has_userdata(IS_LOGIN_ADMIN)) {
            //redirect to dashboard
            redirect('/dashboard');
        }
    }


    /**
	 * login controller and for login form processing.
	 */
	public function login() {
		
        //load library and model.
		$this->load->library('form_validation');
        $this->load->model("admin/Admin_model");

        //set validations rules.
        $this->form_validation->set_rules("nik", "NIK", "trim|required");
        $this->form_validation->set_rules("password", "Password", "trim|required");

        $footer = array("script" => 'assets/js/pages/index/login.js');
        $header = array("title" => 'Login');

		//check for validation.
        if ($this->form_validation->run() == FALSE){

        	//send error message to view.
			$error_message = validation_errors();
			$this->session->set_flashdata('message', $error_message);

		} else {

            //get the posted values
            $nik 		= $this->input->post("nik");
            $password	= $this->input->post("password");

			//check to the model if the username, email and password is correct.
			$result = $this->Admin_model->check_login($nik, $password);
			// pr($result);exit;
			//validate result.
			if ($result) {
                 //set session user (for login).
                $sess_data = array(
                	"IS_LOGIN_ADMIN" => TRUE,
                	"name"	   		 => $result['user_name'],
                	"full_name"      => $result['user_full_name'],
                	"email"	   		 => $result['user_email'],
                	"password"		 => $result['user_password'],
                	"user_id"		 => $result['user_id'],
                	"user_state"	 => $result['user_state'],
                	"nik"			 => $result['user_nik'],
                	"level"			 => $result['role_name'],
                	"posisi"		 => $result['user_position'],
                	"site"			 => $result['user_site']
                );
                // pr($sess_data);exit;
                
				// $externalContent = file_get_contents('http://checkip.dyndns.com/');
				// preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
				// $my_Ip = $m[1];
				// $url = "http://www.example.com/";
				// $ch = curl_init();  
				// curl_setopt($ch,CURLOPT_URL,$url);
				// curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
				// $page = curl_exec($ch);
				// curl_close($ch);
				// echo $page;
				// $ip = $_SERVER['REMOTE_ADDR'];
				// $details = json_decode(file_get_contents("http://ipinfo.io/{$my_Ip}"));
				// var_dump($details);
				// pr($details->city);exit;
                $now = date("Y-m-d H:i:s");
                $this->session->set_userdata($sess_data);
                $this->Admin_model->update(array(
                    "user_last_login" => $now,
                    "user_ip_address" => get_client_ip(),
                    // "user_login_location" => $details->city,
                    "user_state"	  => STATUS_ACTIVE
                ),array("user_id" => $result['user_id']));
                //redirect to library module
                redirect('/dashboard');

			} else {
				//invalid password or email | Username.
				$this->session->set_flashdata('message', 'Username or Password is wrong.');
            }
		}

        //load the views
        $this->load->view(MANAGER_HEADER_SIGNIN ,$header);
        $this->load->view($this->_view_folder . 'login');
        $this->load->view(MANAGER_FOOTER_SIGNIN ,$footer);
	}


	/**
	 * Logout function.
	 */
	public function logout() {

		$this->load->model("Dynamic_model");

		// $id = $this->session->userdata("user_id");

		// $result = $this->Dynamic_model->set_model("mst_user")->get_all_data(array(
		// 	"conditions" => array("user_id" => $id),
		// 	"row_array"  => true
		// ))['datas'];
  //       //unset sessions and back to login.
  //       $sess_data = array(
  //       	"IS_LOGIN_ADMIN" => TRUE,
  //       	"name"	   		 => $result['user_name'],
  //       	"email"	   		 => $result['user_email'],
  //       	"password"		 => $result['user_password'],
  //       	"user_id"		 => $result['user_id'],
  //       	"user_state"	 => $result['user_state'],
  //       	"nik"			 => $result['user_nik'],
  //       	"level"			 => $result['role_name'],
  //       	"posisi"		 => $result['user_position'],
  //       	"site"			 => $result['user_site']
  //       );
        $this->session->sess_destroy();
        // $this->session->unset_userdata($sess_data);
		redirect('/login');
	}

	function phpmailer()
	{
		$this->load->library("PhpMailerLib");
	        $mail = $this->phpmailerlib->load();
		try {
			    //Server settings
			    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
			    $mail->isSMTP();                                      // Set mailer to use SMTP
			    $mail->Host = 'smtp.yandex.com';  // Specify main and backup SMTP servers
			    $mail->SMTPAuth = true;                               // Enable SMTP authentication
			    $mail->Username = 'USERNAME';                 // SMTP username
			    $mail->Password = 'PASSWORD';                           // SMTP password
			    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
			    $mail->Port = 465;                                    // TCP port to connect to
			    //Recipients
			    $mail->setFrom('USEREMAIL', 'Ganesha from Retainly');
			    $mail->addAddress('RECEIPIENTEMAIL01', 'RICIPIENTNAME');     // Add a recipient
			    $mail->addAddress('RECEIPIENTEMAIL02');               // Name is optional
			    $mail->addReplyTo('RECEIPIENTEMAIL03', 'Ganesha');
			    //$mail->addCC('cc@example.com');
			    //$mail->addBCC('bcc@example.com');

			    //Attachments
			    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			    //Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->Subject = 'Here is the subject';
			    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
			    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			    $mail->send();
			    echo 'Message has been sent';
			} catch (Exception $e) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			}
		}

	/**
	 * Forgot password (reset password function).
	 * it will send the "reset password" email from here.
	 */
	public function forgot_password() {

		//load library and model.
		$this->load->library('form_validation');
        $this->load->model("admin/Admin_model");

        //set validations rules.
        $this->form_validation->set_rules("email", "Email", "trim|required|valid_email");

        $footer = array("script" => 'assets/js/pages/index/login.js');
        $header = array("title" => 'Forgot Password');

		//check for validation.
        if ($this->form_validation->run() == FALSE){

        	//send error message to view.
			$error_message = validation_errors();
			$this->session->set_flashdata('message', $error_message);
			$this->session->set_flashdata('alert', 'danger');

		} else {

            //get the posted values
            $email = $this->input->post("email");

			//check to the model if the email is correct.
			$result = $this->Admin_model->get_all_data(array(
                "row_array" => TRUE,
                "conditions" => array("user_email" => $email),
            ))['datas'];

			//validate result.
			if ($result) {
                //send email to reset password.

                //using transaction.
				$this->db->trans_begin();


                //end transaction.
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();

                    //error something.
					$this->session->set_flashdata('message_failed', 'There is something wrong. Please retry input your email.');
					$this->session->set_flashdata('alert', 'danger');

				} else {
                    //success and commiting.
					$this->db->trans_commit();

					$this->load->library("PhpMailerLib");
				        $mail = $this->phpmailerlib->load();

				        //get id
	                    $name      = $result['user_name'];
	                    $id 	   = $result['user_id'];
	                    // $name 	 = urlencode($name);
	                    //send url
	                    $link = base_url()."index/auth/reset-password/".urlencode($name).'<br/>';

	                    $code 	   = uniqid();
	                    $message   = "Hello, ".$result['user_name']."<br/>";
	                    $message  .= "Silahkan ikuti langkah-langkah dibawah untuk mengganti password anda <br/>";
	                    $message  .= "Click this $link to reset your password. <br/>";
	                    $message  .= "Enter code <a>$code</a> <br/>";
	                    $message  .= "Have a nice day. <br/>";
	                    $message  .= "<br/> <br/><br/>";
	                    // $message  .= "best regards"."<br/>";
	                    $message  .= "<img src=".base_url("assets/img/aks.png").">"."<br/>";
	                    $message  .= "Didi ganteng";

				        $mail->IsSMTP(); // enable SMTP
						$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
						$mail->SMTPAuth = true; // authentication enabled
						$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
						$mail->Host = "it-underground.web.id";
						$mail->Port = 25; // or 587
						$mail->IsHTML(true);
						$mail->Username = "devel@it-underground.web.id";
						$mail->Password = "";
						$mail->SetFrom("No-replay@aseanindo.com");
						$mail->Subject = "Test";
						$mail->Body = "$message";
						$mail->AddAddress($email);

						if(!$mail->Send()) {
						    echo "Mailer Error: " . $mail->ErrorInfo;
						} else {
						    echo "Message has been sent";
						}
      //               if ($this->email->send()) {
						// $this->session->set_flashdata('message_success', 'Please check your email to reset your password.');
			   //      } else {
			   //          show_error($this->email->print_debugger());
			   //      }
					//success, info to check user email.
					$this->session->set_flashdata('alert', 'success');

					$res = $this->Admin_model->update(array(
						"user_unique_code"     => $code,
						"user_forgot_passtime" => date("Y-m-d H:i:s"),
						"user_updated_date"    => date("Y-m-d H:i:s"),
						"user_ip_address"	   => get_client_ip()
					),array("user_id" => $result['user_id']));
				}

			} else {
	 			//invalid email.
				$this->session->set_flashdata('message_failed', 'Email is wrong.');
				$this->session->set_flashdata('alert', 'danger');
            }
		}

        //load the views.
		$this->load->view(MANAGER_HEADER_SIGNIN ,$header);
		$this->load->view($this->_view_folder . 'forgot-password');
		$this->load->view(MANAGER_FOOTER_SIGNIN ,$footer);
	}

	public function reset_password ($name = null) {
        //load the model.
		$this->load->model('admin/Admin_model');
		$name = urldecode($name);

        $params = array("row_array" => true,"conditions" => array("user_name" => $name));
        //get the data.
        $data['datas'] = $this->Admin_model->get_all_data($params)['datas'];

        $footer = array(
        	
        );
		//load the view.
		$this->load->view(MANAGER_HEADER_SIGNIN);
        $this->load->view($this->_view_folder . 'reset-password', $data);
		// $this->load->view(MANAGER_FOOTER, $footer);
    }

	
	/**
	 * function to reset password.
	 * from link in reset password email.
	 */
	public function process_reset_password() {

        //load model.
		$this->load->model('admin/Admin_model');
		//load server validation
		$this->load->library('form_validation');
		$message['is_error'] = true;

		$id 			= $this->input->post('id');
		$password       = $this->input->post('password');
        $new_password   = $this->input->post('conf_password');
        $code 			= $this->input->post('code');

		$this->form_validation->set_rules('password', 'Password', "trim|required|min_length[4]|max_length[20]");
        $this->form_validation->set_rules('conf_password', 'Confirmation Password', "trim|required|min_length[4]|max_length[20]|matches[password]");

		// pr($this->input->post());exit;
        if( $this->form_validation->run() == FALSE) {
        	$message['error_message'] = validation_errors();
        } else {

	        //begin transaction.
			$this->db->trans_begin();

			//cek_code
			$codes = $this->Admin_model->get_all_data(array(
				"row_array" 	=> true,
				"conditions" 	=> array("user_id" => $id)
			))['datas'];
			// pr($codes);
			if($codes['user_unique_code'] != $code) {
				$message['is_error'] 	= true;
				$message['error_msg'] 	= "Invalid code";
				$this->output->set_content_type('application/json');
				echo json_encode($message);
				exit;	
			}

			if($new_password != $password) {
				$message['is_error'] 	= true;
				$message['error_msg'] 	= "Password do not match";
				$this->output->set_content_type('application/json');
				echo json_encode($message);
				exit;	
			}

			$_save_data = array(
				"user_password" 	   => sha1(ENCRYPT_DEV_AKS.$this->db->escape_str($new_password)),
				"user_forgot_passtime" => date("Y-m-d H:i:s"),
				"user_ip_address"	   => get_client_ip()
			);

			if( $_save_data )
			{
				// pr($this->input->post());exit;
				$result = $this->Admin_model->update($_save_data, array("user_id" => $id));

				if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $message['error_msg'] = 'Internal server error.';

                } else {
                    $this->db->trans_commit();

                    $message['is_error'] = false;
                    //success.
                    //growler.
                    $message['notif_title']     = "Good!";
                    $message['notif_message']   = "Change password success.";
                    //on insert, not redirected.
                    $message['redirect_to']     = "";
                }
			}
        }

        $this->output->set_content_type('application/json');
        echo json_encode($message);
        exit;
	}

}
