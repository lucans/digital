<?
	class Tarefa extends Dao{

		public $sTable = 'tarefas';
		public $sFields = '';

		public function getTarefas($user, $q, $caderno){
	
			if (isset($q) && $q > 0) {				
				$_SESSION['last_codcaderno'] = $q;
			}

			$sWhere = "WHERE codcaderno = " . $_SESSION['last_codcaderno'] . "";
			$aTarefas = $this->getData($this->sTable, $sWhere, $this->sFields);

			echo json_encode($aTarefas);

		}
		


		public function updateTarefa($user, $q, $aDados){

			$sWhere = "WHERE codtarefa = '" . $aDados->oTarefa->codtarefa . "' ";
			$this->switchTarefa($this->sTable, $sWhere);		

			echo json_encode(array('msg' => 'true'));		

		}

		public function insertTarefa($user, $q, $aDados){
			// die(print_r($aDados));
			$sSet = buildSet($aDados);		
			
			$this->insertData($this->sTable, $sSet, "morre");

		}	



	}
?>