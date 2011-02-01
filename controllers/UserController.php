<?php
	class UserController extends BaseController {
		private $errors = array();
		
		public function index($username = false) {
			$this->template = 'user/list';
			$this->view->title = 'Tecmo Superstars';
			$this->view->showOne = false;
			$user = new User($this->registry);
			$game = new Game($this->registry);
			if ($username) {
				$details = is_numeric($username) ? $user->getUserById($username) : $user->getUser($username);
				if (!empty($details)) {
					$this->view->showOne = true;
					$this->view->username = $details['username'];
					$this->view->games = $game->getAllGamesByUser($details['id']);
					$this->view->email = $details['email'];
					$this->view->title = 'Tecmo Superstar: ' . $details['username'];
				}
			} else {
				$users = $user->getUsers();
				$this->view->users = $users;
			}
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
								Http::redirect();
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
					if ($user->login($username,$password)){
						if (isset($_GET['ref'])) {
							Http::redirect($_GET['ref']);
						} else {
							Http::redirect();
						}
					} else {
						$this->errors[]= 'Invalid Username and/or Password.';
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
			Http::redirect();
		}
		
		public function reset() {
			$reset = isset($_POST['email']) ? true : false;
		
			if ($reset) {
				$email = $_POST['email'];
				if (!empty($email)) {
					$user = new User($this->registry);
					if ($user->resetPassword($email)) {
						$this->view->success = true;
					} else {
						$this->view->success = false;
					}
					$this->view->email = $email;
				}
			}
			$this->template = 'user/reset';
			$this->view->title = 'Reset your password';
		}
	}
?>