<?
	class User extends Dao{

		public $sTable = 'usuarios';
		public $sFields = '';


		function userAuth($coduser, $q, $aDados){


			$sWhere = "WHERE email = '" . $aDados->oUser->email . "' ";

			$aUser = $this->getData($this->sTable, $sWhere, $this->sFields);

			if (is_array($aUser)) {		
				if ($aUser[0]['password'] == $aDados->oUser->password) {

					$_SESSION['user'] = $this->loadUser($aDados->oUser->email);

					echo json_encode($_SESSION['user']);
				}		
			}

		}

		function loadUser($email){

			$sFields = "*, UPPER(LEFT(nome, 1)) as inicial, coduser, email, nome, semestre, ano";
			$sWhere = "WHERE email = '" . $email . "'";
		
			$aUser = $this->getData($this->sTable, $sWhere, $this->sFields);

			return $aUser;
		}

		function verificaUserSession(){
			if (isset($_SESSION['user'])) {
				echo json_encode($_SESSION['user']);
			} else { 
				echo 'false'; 
			}
		}

		function cleanUserSession(){
			session_destroy();
		}

	}
?>