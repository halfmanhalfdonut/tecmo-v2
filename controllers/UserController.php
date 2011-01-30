<?php
	class UserController extends BaseUserController {
		private $errors = array();
		
		public function index($user = false) {
			$this->template = 'user';
			$this->view->title = 'BAMBOO WOMBAT';
		}
		
		public function register() {
			$this->template = 'user/register';
			$this->view->title = "Register as a new user";
		}

		public function create() {
			$this->template = 'user/create';
			$this->errors = array();
			if (isset($_POST['email1'])) {
				$email1 = $_POST['email1'];
				$email2 = $_POST['email2'];
				$username = $_POST['username'];
				$pass1 = $_POST['password1'];
				$pass2 = $_POST['password2'];
				
				if (empty($email1)) $this->errors[] = 'You must enter an email address';
				if (empty($email2)) $this->errors[] = 'You must confirm your email address';
				if (empty($username)) $this->errors[] = 'You must enter a username';
				if (empty($pass1)) $this->errors[] = 'You must enter a password';
				if (empty($pass2)) $this->errors[] = 'You must confirm your password';
				
				if (empty($this->errors)) {
					//check that email and passwords match
					if($email1 != $email2) $this->errors[]= 'Email fields do not match';
					if($pass1 != $pass2) $this->errors[]= 'Password fields do not match';
				}
				
				//fields match - check that email is valid and available
				if (empty($this->errors)){
					$user = new User($this->registry);
					if(!$user->emailValid($email1)){
						//invalid email
						$this->errors[]= $email1 . ' is not a valid email address';

					}//valid email, check if it is being used
					elseif(!$user->emailAvailable($email1)){
						//email in use
						$this->errors[]= 'Email address already in use';

					} elseif(!$user->userNameAvailable($username)){
						//user name in use
						$this->errors[]= 'Username already in use';

					}//email is valid and not in use, user name is not in use, password is not empty. MAKE THAT USER!
					else{
						//make user
						$createStatus = $user->createUser($email1,$pass1,$username);
						if ($createStatus == true) {
							if ($user->login($username,$pass1)) {
								$this->redirect();
							}
						} else {
							$this->errors[]= $createStatus;
						}
					}
				}
			} else {
				echo" NO POST";
			}
			$this->view->errors = $this->errors;
		}
		
		public function login() {
			$login = isset($_POST['username']) ? true : false;
			$this->errors = array();
			
			if ($login) {
				$username = $_POST['username'];
				$password = $_POST['password'];
				if(!empty($username) && !empty($password)) {
					$user = new User($this->registry);
					if($user->checkLoginInfo($username,$password)){
						//login user
						if ($user->login($username,$password)){
							$this->redirect();
						}
						else{
							$this->errors[]= 'LOGIN FAILED!'; //this would be strange, but hey...
						}
					}
					else{
							$this->errors[]= 'LOGIN FAILED! - Supplied Username and Password did not match any registered user!';
					}
				}

				//send error messages to template
				if(!empty($this->errors)){
					$this->view->errors = $this->errors;
				}
			}
			$this->template = 'user/login';
			$this->view->title = 'Log in and TASTE THE BEAST';
		}
		
		public function logout() {
			session_destroy();
			$this->redirect();
		}
		
		public function redirect($url = false) {
			if ($url) {
				header("Location: " . $url);
			} else {
				header("Location: " . ENV);
			}
		}
	}
?>