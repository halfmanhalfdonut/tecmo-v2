<?php
	
	class Game {
		
		const GAME_TABLE				= 'Games';
		const GAME_ID				= 'game_id';
		const USER_UPLOAD			= 'user_upload';
		const HOME_TEAM				= 'home_team';
		const AWAY_TEAM				= 'away_team';
		const HOME_USER				= 'home_user';
		const AWAY_USER				= 'away_user';
		const FLAGGED				= 'flagged';
		const HOME_Q1				= 'home_q1_score';
		const AWAY_Q1				= 'away_q1_score';
		const HOME_Q2				= 'home_q2_score';
		const AWAY_Q2				= 'away_q2_score';
		const HOME_Q3				= 'home_q3_score';
		const AWAY_Q3				= 'away_q3_score';
		const HOME_Q4				= 'home_q4_score';
		const AWAY_Q4				= 'away_q4_score';
		const HOME_SCORE			= 'home_total_score';
		const AWAY_SCORE			= 'away_total_score';
		const HOME_RUSH_ATTEMPTS	= 'home_rush_att';
		const AWAY_RUSH_ATTEMPTS	= 'away_rush_att';
		const HOME_RUSH_YARDS		= 'home_rush_yards';
		const AWAY_RUSH_YARDS		= 'away_rush_yards';
		const HOME_PASS_YARDS		= 'home_pass_yards';
		const AWAY_PASS_YARDS		= 'away_pass_yards';
		const HOME_FIRST_DOWNS		= 'home_first_downs';
		const AWAY_FIRST_DOWNS		= 'away_first_downs';
	
		private $db = false;
		
		function __construct($registry = null){
			if(!isset($registry)){
				throw new Exception('Game constructor MUST recieve a registry object.');
			}
			$this->db = $registry->db;
		}
		
		public function deleteGame($id){
			
			if(!is_numeric($id)) throw new Exception('Game deleteGame($id) MUST receive an integer record id');
			
			$this->db->Execute('DELETE FROM '. self::GAME_TABLE .' WHERE '. self::GAME_ID .' = ? ',$id);				
		}
		
		public function getTableNames(){
			$tableNames = array(self::GAME_TABLE);
			
			return $tableNames;
		}
		
		public function getStandings(){
			//$this->db->SetFetchMode( ADODB_FETCH_ASSOC );
			return $this->db->GetAll('SELECT * FROM '. self::GAME_TABLE );
		}
		
		public function getGame($id){
			//make sure an int id is sent
			if(!is_numeric($id)){
				throw new Exception('Game getGame($id) MUST receive an int id');
			}
			
			$this->db->SetFetchMode( ADODB_FETCH_ASSOC );
			return $this->db->GetAssoc('SELECT * FROM '. self::GAME_TABLE .' WHERE '. self::GAME_ID .' = ? ',$id);
		}
		
		public function getRecentGames($count = 10) {
			if (!is_numeric($count)) {
				throw new Exception('Game getRecentGames($count) MUST receive a number of games to retrieve.');
			}
			$this->db->SetFetchMode(ADODB_FETCH_ASSOC);
			return $this->db->GetAssoc('SELECT * FROM '. self::GAME_TABLE . ' ORDER BY ' . self::GAME_ID . ' DESC LIMIT ?', $count);
		}
		
		public function getAllGamesByUser($id) {
			if (!is_numeric($id)) { throw new Exception('Game getGamesByUser($id) MUST receive a numerical id.'); }
			$this->db->SetFetchMode(ADODB_FETCH_ASSOC);
			return $this->db->GetAssoc('SELECT * FROM '. self::GAME_TABLE . ' WHERE ' . self::HOME_USER . ' = ? OR ' . self::AWAY_USER . ' = ? ORDER BY ' . self::GAME_ID . ' DESC', array($id, $id));
		}
		
		public function getRecentGamesByUser($id, $count = 10) {
			if (!is_numeric($id)) { throw new Exception('Game getGamesByUser($id) MUST receive a numerical id.'); }
			if ($count && !is_numeric($count)) { throw new Exception('Game getGamesByUser($id, $count) MUST receive a numerical count.'); }
			$this->db->SetFetchMode(ADODB_FETCH_ASSOC);
			return $this->db->GetAssoc('SELECT * FROM '. self::GAME_TABLE . ' WHERE ' . self::HOME_USER . ' = ? OR ' . self::AWAY_USER . ' = ? ORDER BY ' . self::GAME_ID . ' DESC LIMIT ?', array($id, $id, $count));
		}
		
		public function saveGame($gameStats){
			//make sure an array is sent
			if(!is_array($gameStats)){
				throw new Exception('Game saveGame($array) MUST receive an ARRAY of game stats');
			}
			
			$record = array();
			$record[self::USER_UPLOAD]			= $gameStats['user_upload'];
			$record[self::HOME_TEAM]			= $gameStats['home']['team'];
			$record[self::AWAY_TEAM]			= $gameStats['away']['team'];
			$record[self::HOME_USER]	 		= $gameStats['home_user'];
			$record[self::AWAY_USER]		 	= $gameStats['away_user'];
			
			$record[self::HOME_Q1] 				= $gameStats['home']['score']['q1'];
			$record[self::HOME_Q2] 				= $gameStats['home']['score']['q2'];
			$record[self::HOME_Q3] 				= $gameStats['home']['score']['q3'];
			$record[self::HOME_Q4] 				= $gameStats['home']['score']['q4'];
			$record[self::HOME_SCORE] 			= $gameStats['home']['score']['total'];
			
			$record[self::AWAY_Q1] 				= $gameStats['away']['score']['q1'];
			$record[self::AWAY_Q2] 				= $gameStats['away']['score']['q2'];
			$record[self::AWAY_Q3] 				= $gameStats['away']['score']['q3'];
			$record[self::AWAY_Q4] 				= $gameStats['away']['score']['q4'];
			$record[self::AWAY_SCORE] 			= $gameStats['away']['score']['total'];
			
			$record[self::HOME_RUSH_ATTEMPTS] 	= $gameStats['home']['teamStats']['runs']['att'];
			$record[self::HOME_RUSH_YARDS] 	= $gameStats['home']['teamStats']['runs']['yards'];
			$record[self::HOME_PASS_YARDS] 	= $gameStats['home']['teamStats']['pass'];
			$record[self::HOME_FIRST_DOWNS] 	= $gameStats['home']['teamStats']['firsts'];			
			
			$record[self::AWAY_RUSH_ATTEMPTS] 	= $gameStats['away']['teamStats']['runs']['att'];
			$record[self::AWAY_RUSH_YARDS] 	= $gameStats['away']['teamStats']['runs']['yards'];
			$record[self::AWAY_PASS_YARDS] 		= $gameStats['away']['teamStats']['pass'];
			$record[self::AWAY_FIRST_DOWNS] 	= $gameStats['away']['teamStats']['firsts'];

		
			$this->db->AutoExecute(self::GAME_TABLE,$record,'INSERT');
			
			return $this->db->Insert_ID();
		}
	}
?>