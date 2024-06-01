<?php
$conn = new PDO("mysql:host=localhost;dbname=exm_db","root","");
function getLogInConfirmation($id,$pass)
{
  global $conn;
  $actor="none";
	try {
					$sql="SELECT * FROM user WHERE user_name=:id AND password=:pass";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":id",$id);
          $statement->bindParam(":pass",$pass);
					$statement->execute();
					$dataRow=$statement->fetch();
					if (!empty($dataRow)){
						for ($i=0; $i<count($dataRow); $i++) {
					     		unset($dataRow[$i]);
					     	}
                session_start();
              $_SESSION['actorData']=$dataRow;
              $actor=$dataRow["user_type"];
					}

		} catch (Exception $e) {
			echo $e;
		}
  return $actor;
}
 ?>
