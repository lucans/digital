<?
	class Session extends Dao{


		public function set($position, $value){
			$SESSION[$position] = $value;		
		}

		public function get($position){
			return $SESSION[$position];		
		}	



	}
?>