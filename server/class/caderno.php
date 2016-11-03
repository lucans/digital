<?
	class Caderno extends Dao{

		public $sTable = 'cadernos';
		public $sFields = '';

		public function getCadernos($user){

			$sWhere = "WHERE coduser = '$user' ";
			$aCadernos = $this->getData($this->sTable, $sWhere, $this->sFields);
			echo json_encode($aCadernos);

		}

		public function getOneCaderno($user, $codcaderno){

			$sWhere = "WHERE codcaderno = '$codcaderno' AND coduser = '$user' ";
			$aCaderno = $this->getData($this->sTable, $sWhere, $this->sFields);
			echo json_encode($aCaderno);

		}
		
		public function updateCaderno($user, $aDados){

			$sSet = buildSet($aDados);
			$sWhere = "WHERE codcaderno = '" . $aDados->oCaderno->codcaderno . "' AND coduser = '$user' ";
			$this->updateData($this->sTable, $sWhere, $sSet);

		}		

		public function deleteCaderno($user, $codcaderno){

			$sWhere = "WHERE codcaderno = '$codcaderno' AND coduser = '$user' ";
			$this->deleteData($this->sTable, $sWhere);

		}

	}
?>