<?
	class Dao{

		private $link;

		public function __construct(){
			// $this->link = mysqli_connect('192.168.10.20','root','proxy','db_digitalgit');
			// $this->link = mysqli_connect('www.lucans.com.br','lucas','meupenis','db_lucas');
			$this->link = mysqli_connect("localhost","root","","db_digitalgit");
		}

		public function getData($sTable, $sWhere, $sFields){

			die($sTable . '===' .  $sWhere . '===' .  $sFields);

			if(empty($sFields)){
				$sFields = '*';
			}

			$sQuery = "SELECT $sFields FROM $sTable $sWhere";
			$oStmt = mysqli_query($this->link, $sQuery); 


			$aResult = array();	
			

			while($oResult = mysqli_fetch_assoc($oStmt)){
				array_push($aResult, $oResult);
			}
			
			$aResult = $aResult;
			
			return $aResult;
		}
	}
?>