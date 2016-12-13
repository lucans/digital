<?
	class Tarefa extends Dao{

		public $sTable = 'tarefas';
		public $sFields = '';

		public function getTarefas($user, $caderno){

			$sWhere = "WHERE codcaderno = '$caderno'";
			$aTarefas = $this->getData($this->sTable, $sWhere, $this->sFields);
			echo json_encode($aTarefas);

		}
	
		public function updateTarefa($user, $aDados){

			$sWhere = "WHERE codtarefa = '" . $aDados->oTarefa->codtarefa . "' ";
			$this->switchTarefa($this->sTable, $sWhere);		

			echo json_encode(array('msg' => 'true'));		

		}

		public function insertTarefa($user, $aDados){
			die(print_r($aDados));
			$sSet = buildSet($aDados);		
			
			$this->insertData($this->sTable, $sSet);

		}	



	}
?>