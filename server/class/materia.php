<?
	class Materia extends Dao{

		public $sTable = 'materias';

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

			$this->sFields = 'm.nome, LEFT(c.nomecaderno, 1) as leftcaderno';

			$this->sTable = 'materias m';

			$sWhere = "INNER JOIN cadernos c
						ON m.codcaderno = c.codcaderno

						WHERE m.codcaderno = '$codcaderno'
						AND m.ativo = 'S' 
						ORDER BY m.dtalteracao DESC,
						m.hralteracao DESC";

			$aMaterias = $this->getData($this->sTable, $sWhere, $this->sFields);

			echo json_encode($aMaterias);

		}

	}
?>