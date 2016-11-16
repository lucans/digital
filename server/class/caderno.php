<?
	class Caderno extends Dao{

		public $sTable = 'cadernos';
		public $sFields = '';
		public $sAtivo = "AND ativo = 'S'";


		public function getCadernos($user){

			$sWhere = "WHERE coduser = '$user'" . $this->sAtivo;
			$aCadernos = $this->getData($this->sTable, $sWhere, $this->sFields);
			echo json_encode($aCadernos);

		}

		public function getOneCaderno($user, $codcaderno){

			$sWhere = "WHERE codcaderno = '$codcaderno' AND coduser = '$user' " . $this->sAtivo;
			$aCaderno = $this->getData($this->sTable, $sWhere, $this->sFields);
			echo json_encode($aCaderno);

		}
		
		public function updateCaderno($user, $aDados){

			$sSet = buildSet($aDados);
			$sWhere = "WHERE codcaderno = '" . $aDados->oCaderno->codcaderno . "' AND coduser = '$user' ";
			
			$this->updateData($this->sTable, $sWhere, $sSet);

		}	

		public function insertCaderno($user, $aDados){

			$aDados->oCaderno->coduser = $user;

			$sSet = buildSet($aDados);		
			
			$this->insertData($this->sTable, $sSet);

		}	

		public function deleteCaderno($user, $codcaderno){

			$aReturn = [];

			$sWhere = "WHERE codcaderno = '$codcaderno'";
			$sTableMaterias = 'materias';

			$aReturn = $this->getData($sTableMaterias, $sWhere, $this->sFields);	

			if (count($aReturn) > 0) {
				echo json_encode(array('msg' => 'false'));
			} else {
				$sWhere = "WHERE codcaderno = '$codcaderno' AND coduser = '$user' " . $this->sAtivo;
				$this->deleteData($this->sTable, $sWhere);			
				echo json_encode(array('msg' => 'true'));
			}			

		}
	}
?>