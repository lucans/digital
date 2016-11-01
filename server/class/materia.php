<?
	class Materia extends Dao{

		public $sTable = 'topicos';

		public function getMaterias($user){

			$sWhere = "WHERE coduser = '$user' ";
			$aMaterias = $this->getData($this->sTable, $sWhfere, $this->sFields);
			echo json_encode($aMaterias);
		}

		public function getOneMateria($user, $codmateria){

			$sWhere = "WHERE codtopico = '$codmateria' AND coduser = '$user' ";

			$aMaterias = $this->getData($this->sTable, $sWhere, $this->sFields);
			echo json_encode($aMaterias);
		}		

		public function getTopicosByCaderno($user, $codcaderno){

			$this->sFields = 't.nome, LEFT(c.nomecaderno, 1) as leftcaderno';

			$this->sTable = 'topicos t';

			$sWhere = "INNER JOIN cadernos c
						ON t.codcaderno = c.codcaderno

						WHERE t.codcaderno = '$codcaderno'
						AND t.ativo = 'S' 
						ORDER BY t.dtalteracao DESC,
						t.hralteracao DESC";

			$aMaterias = $this->getData($this->sTable, $sWhere, $this->sFields);

			echo json_encode($aMaterias);

		}

	}
?>