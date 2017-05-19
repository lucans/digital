<?
	class Materia extends Dao{

		public $sTable = 'materias';
		public $sFields = '';



		public function getConexoes($user, $conteudo){		

			if (count_chars($conteudo)) {

				$this->sFields = 'nome';
				$sWhere = "WHERE coduser = '$user'";

				$aNomeCadernos = $this->getData($this->sTable, $sWhere, $this->sFields);

				$aConexoes = self::getOnlyConexoes($aNomeCadernos, $conteudo);

				$sConexoes = implode(',', $aConexoes);

				return $sConexoes;

			} else {
				return false;
			}

		}


		function getOnlyConexoes(&$aNomeCadernos, $conteudo){

			$conteudo = strip_tags($conteudo);
			$aConteudo = explode(' ', $conteudo);

			$aConexoes = array();

			$aNomeCadernos = (array)$aNomeCadernos;

			foreach ($aConteudo as $palavra) {
				foreach ($aNomeCadernos as $nome) {
					if (strtoupper($palavra) == strtoupper($nome["nome"])) {
						array_push($aConexoes, $palavra);
					} 
				}
			}

			return $aConexoes;
			
		}



		public function getMaterias($coduser){

			$this->sFields = 'm.nome, LEFT(c.nomecaderno, 1) as leftcaderno, m.*';

			$this->sTable = 'materias m';

			$sWhere = "INNER JOIN cadernos c
						ON m.codcaderno = c.codcaderno
						WHERE m.ativo = 'S' 
						AND m.coduser = '$coduser'
						ORDER BY m.dtalteracao DESC";


			$aMaterias = $this->getData($this->sTable, $sWhere, $this->sFields);

			foreach ($aMaterias as $key => $value) {
				$aMaterias[$key]['teste'] = explode(',', $value['conexoes']); 
			}

			echo json_encode($aMaterias);
		}


		public function insertMateria($user, $aDados){

			$aDados->oMateria->coduser = $user;
			$aDados->oMateria->dtalteracao = date('Y-m-d H-i-s');

			$sSet = buildSet($aDados);
			
			$this->insertData($this->sTable, $sSet);

		}

		public function updateMateria($user, $q, $aDados){

			$aDados->oMateria->palavras = self::countPalavras($aDados->oMateria->conteudo);		
			$aDados->oMateria->conexoes = self::getConexoes($user, $aDados->oMateria->conteudo);	
			$aDados->oMateria->dtalteracao = date('Y-m-d H-i-s');	

			$sSet = buildSet($aDados);
			$sWhere = "WHERE codmateria = '" . $aDados->oMateria->codmateria . "' AND coduser = '$user' ";
			
			$this->updateData($this->sTable, $sWhere, $sSet);

		}


		public function countPalavras($conteudo){
			
			if (count_chars($conteudo)) {
				$conteudo = strip_tags($conteudo);
				$aConteudo = explode(' ', $conteudo);
				$iPalavras = count($aConteudo);
				return $iPalavras;		
			}

			return $iPalavras;
		}


		public function getMateriasByCaderno($codcaderno){	

			$sWhere = "WHERE codcaderno = '$codcaderno'
						AND ativo = 'S' 
						ORDER BY dtalteracao DESC";

			$aMaterias = $this->getData($this->sTable, $sWhere, $this->sFields);
			foreach ($aMaterias as $key => $value) {
				$tema = explode(" ", $aMaterias[$key]['tema']);
				$aMaterias[$key]['tema_main'] = $tema[0]; 
			}
			return $aMaterias;
			
		}


		public function getOneMateria($user, $codmateria){

			$sWhere = "WHERE codmateria = '$codmateria' AND coduser = '$user' ";

			$aMateria = $this->getData($this->sTable, $sWhere, $this->sFields);
			
			$aMateria[0]['conexoes'] = explode(',', $aMateria[0]['conexoes']); 			

			echo json_encode($aMateria);

		}		



	}
?>