<?php
	class GameController extends BaseController {
		public function index() {
			$this->template = 'game/recent';
			$this->view->title = "Recent Scores";
			$game = new game($this->registry);
			$this->view->recent = $game->getRecentGames();
		}
		
		public function add() {
			$this->template = 'game/add';
			$this->view->title = 'Upload your game';
			$this->view->success = false;
			$this->view->errors = array();
			$add = isset($_FILES['file']) ? true : false;
			$user = new User($this->registry);
			if (isset($_SESSION['userName'])) {
				$this->view->users = $user->getOtherUsers($_SESSION['userName']);
			} else {
				Http::redirect();
			}
			if ($add) {
				$homeAway = $_POST['homeAway'];
				$opponent = $_POST['opponent'];
				if ($homeAway == 'none') $this->view->errors[] = 'Select home or away team';
				if ($opponent == 'none') $this->view->errors[] = 'Select your opponent';
				//temporary directory to store uploaded files 
				$target_path = SITE_PATH . "/states/";
				$target_path = $target_path . basename( $_FILES['file']['name']);

				if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
					//make sure file is not too large
					if($_FILES['file']['size'] > 20000){
						$this->view->errors[]='Error - file size may not exceed 20K';
					}

					//check is file has a valid nestopia extension
					$allowedExtensions = array('nst', 'ns0', 'ns1', 'ns2', 'ns3', 'ns4', 'ns5', 'ns6', 'ns7', 'ns8', 'ns9');
					foreach ($_FILES as $file) {
						if ($file['tmp_name'] > '') {
							if (!in_array(end(explode(".",strtolower($file['name']))),$allowedExtensions)) {
								$this->view->errors[]= 'Error - '.$file['name']. ' does not have a valid Nestopia extension (ex: .nst, .ns0, .ns9)';
							}
						}
					}

					if(empty($this->view->errors)){
						//call extactor class and parse file
						$extractor = new NestopiaExtractor($_FILES['file']['name']);

						//save stats to stats var
						$stats = $extractor->getVals();

						// GameStats and PlayerStats models handle saving the game info
						$gameStats = new Game($this->registry);
						$playerStats = new Player($this->registry);
						
						if ($homeAway == 'home') {
							$homeUser = $_POST['uploader'];
							$awayUser = $_POST['opponent'];
						} else {
							$homeUser = $_POST['opponent'];
							$awayUser = $_POST['uploader'];
						}

						//tell the game stats class who is uploading the game and who they played against
						$uploaderInfo = array('user_upload' => $user->userName(), 'home_user' => $homeUser, 'away_user'  => $awayUser);

						//save game stats, get insert id for player stats
						$gameID = $gameStats->saveGame(array_merge($stats,$uploaderInfo));

						//tell team name, game id, etc...
						$extraHomeStats = array('team' => $stats['home']['team'], 'home_away'  => 'home' , 'game_id' => $gameID);
						$extraAwayStats = array('team' => $stats['away']['team'], 'home_away'  => 'away' , 'game_id' => $gameID);


						//save player stats to player stats db
						$positions = array('QB','RB','WR');
						foreach($positions as $thisPosition){
							$position = array('position' => $thisPosition);

							$playerStatsHome = array_merge($position,$stats['home'][$thisPosition],$extraHomeStats);
							$playerStats->savePlayerStats($playerStatsHome);

							$playerStatsAway = array_merge($position,$stats['away'][$thisPosition],$extraAwayStats);
							$playerStats->savePlayerStats($playerStatsAway);
						}

						// Update the template
						$this->view->filename = basename( $_FILES['file']['name']);
						$this->view->gameId = $gameID;
						$this->view->success = true;
						$this->view->homeUser = $user->getUserById($homeUser);
						$this->view->awayUser = $user->getUserById($awayUser);
						$this->view->stats = $stats;
					}

					//delete file
					unlink($target_path);
				} else{
					//send error message to template
					$this->view->errors[]='There was an error uploading the file, please try again!';
				}
			}
		}
		
		public function view($id = false) {
			$this->template = 'game/view';
			$this->view->title = 'Box Score';
			if ($id) {
				$id = is_array($id) ? array_shift($id) : $id;
				$gameStats = new Game($this->registry);
				$player = new Player($this->registry);
				$user = new User($this->registry);
				$stats = array_shift($gameStats->getGame($id));
				$users['home'] = $user->getUserById($stats['home_user']);
				$users['away'] = $user->getUserById($stats['away_user']);
				$this->view->gameStats = $stats;
				$this->view->home = $player->getStatsByGameAndSide($id, 'home');
				$this->view->away = $player->getStatsByGameAndSide($id, 'away');
				$this->view->users = $users;
			} else {
				Http::redirect("/tecmo/game");
			}
		}
	}
?>