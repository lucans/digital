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

		public function deleteCaderno($user, $codcaderno){

			$sWhere = "WHERE codcaderno = '$codcaderno'";
			$aReturn = $this->getData($this->sTable, $sWhere);	

			if (isset($aReturn)) {
				$sWhere = "WHERE codcaderno = '$codcaderno' AND coduser = '$user' " . $this->sAtivo;
				$this->deleteData($this->sTable, $sWhere);			
				echo json_encode(array('msg' => 'true'));
			} else{
				echo json_encode(array('msg' => 'false'));
			}

		}
	}
?>