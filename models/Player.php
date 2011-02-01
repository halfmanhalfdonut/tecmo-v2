<?php
	
	class Player {
		
		const PLAYER_TABLE			= 'Players';
		const RECORD_ID				= 'record_id';
		const GAME_ID				= 'game_id';
		const TEAM					= 'team';
		const HOME_OR_AWAY			= 'home_away';
		const NAME					= 'name';
		const POSITION				= 'position';
		const RUSH_ATTEMPTS			= 'rush_att';
		const RUSH_YARDS			= 'rush_yards';
		const PASS_PERCENT			= 'pass_percent';
		const PASS_YARDS				= 'pass_yards';
		const INTERCEPTIONS			= 'interceptions';
		const RECEIVED_YARDS		= 'rec_yards';
		const CATCHES				= 'catches';
	
		private $db = false;
		
		function __construct($registry = null){
			if(!isset($registry)){
				throw new Exception('Player constructor MUST recieve a Registry object.');
			}
			$this->db = $registry->db;
		}
		
		public function deletePlayerRecord($arrayOfIds){
			
			if(!is_array($arrayOfIds)) throw new Exception('Player deletePlayerRecord($array) -> MUST receive an ARRAY of record ids');
			
			//this can be updated to delete more than one at a time.
			foreach($arrayOfIds as $thisId){
				$this->db->Execute('DELETE FROM '. self::PLAYER_TABLE .' WHERE '. self::RECORD_ID .' = ?',array($thisId));				
			}
		}
		
		public function deletePlayerStatsByGame($id){
			if(!is_numeric($id)) throw new Exception('Player deletePlayerStatsByGame($id) MUST receive a numeric game id');
			
			$this->db->Execute('DELETE FROM '. self::PLAYER_TABLE .' WHERE '. self::GAME_ID .' = ?',array($id));	
		}
		
		public function getTableNames(){
			$tableNames = array(self::PLAYER_TABLE);
			
			return $tableNames;
		}
		
		public function savePlayerStats($playerStats){
			//make sure an array is sent
			if(!is_array($playerStats)){
				throw new Exception('Player savePlayerStats($array) MUST receive an ARRAY of player stats');
			}
		
			$this->db->AutoExecute(self::PLAYER_TABLE,$playerStats,'INSERT');
		}
		
		public function getPlayersByGame($gameId){
			if(!is_numeric($gameId)){
				throw new Exception('Player getPlayersByGame($gameId) MUST receive an integer game id');
			}
			
			$this->db->SetFetchMode( ADODB_FETCH_ASSOC );
			return $this->db->GetAll('SELECT * FROM '. self::PLAYER_TABLE .' WHERE '. self::GAME_ID .' = ? ',$gameId);
		}
		
		public function getStatsByGameAndSide($gameId, $side) {
			if(!is_numeric($gameId)){
				throw new Exception('Player getHomeStatsByGame($gameId) MUST receive an integer game id');
			}
			
			$this->db->SetFetchMode( ADODB_FETCH_ASSOC );
			return $this->db->GetAll('SELECT * FROM '. self::PLAYER_TABLE .' WHERE '. self::GAME_ID .' = ? AND '. self::HOME_OR_AWAY . '=?',array($gameId,$side));
		}
	}
?>