<?
	class Tarefa extends Dao{

		public $sTable = 'tarefas';
		public $sFields = '';

		public function getTarefas($caderno){

			$sWhere = "WHERE codcaderno = '$caderno'";
			$aTarefas = $this->getData($this->sTable, $sWhere, $this->sFields);
			echo json_encode($aTarefas);

		}
		
		// public function deleteData($user, $aDados){

		// 	$sSet = buildSet($aDados);
		// 	$sWhere = "WHERE codcaderno = '" . $aDados->oCaderno->codcaderno . "' AND coduser = '$user' ";
			
		// 	$this->updateData($this->sTable, $sWhere, $sSet);

		// }	

		// public function insertCaderno($user, $aDados){

		// 	$aDados->oCaderno->coduser = $user;

		// 	$sSet = buildSet($aDados);		
			
		// 	$this->insertData($this->sTable, $sSet);

		// }	



	}
?>