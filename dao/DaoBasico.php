<?
	class Dao{

		private $link;

		public function __construct(){
			// $this->link = mysqli_connect('192.168.10.20','root','proxy','db_digitalgit');
			// $this->link = mysqli_connect('www.lucans.com.br','lucas','meupenis','db_lucas');
			$this->link = mysqli_connect("localhost","root","","db_digitalgit");
		}

		public function getData($sTable, $sWhere, $sFields){

			$sFields = empty($sFields) ? '*' : $sFields;			

			$sQuery = "SELECT $sFields FROM $sTable $sWhere";		

			// die($sQuery);

			$oStmt = mysqli_query($this->link, $sQuery); 

			$aResult = array();				

			while($oResult = mysqli_fetch_assoc($oStmt)){
				array_push($aResult, ArrayEncode($oResult));
			}
			
			$aResult = $aResult;
			
			unset($sWhere);
			
			return $aResult;
		}		


		public function insertData($sTable, $sSet){

			$sQuery = "INSERT INTO $sTable $sSet";

			mysqli_query($this->link, $sQuery); 
			unset($sWhere);
			
		}		


		public function updateData($sTable, $sWhere, $sSet){

			$sQuery = "UPDATE $sTable $sSet $sWhere";

			mysqli_query($this->link, $sQuery); 
			unset($sWhere);
			
		}		

		public function deleteData($sTable, $sWhere){

			$sQuery = "UPDATE $sTable SET ativo = IF(ativo = 'S', 'N', 'S') $sWhere";
			mysqli_query($this->link, $sQuery); 
			unset($sWhere);
			
		}

		public function switchTarefa($sTable, $sWhere){

			$sQuery = "UPDATE $sTable SET valor = IF(valor = '1', '0', '1') $sWhere";			
			mysqli_query($this->link, $sQuery); 
			unset($sWhere);
			
		}

	}
?>