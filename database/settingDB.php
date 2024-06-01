<?php
$conn = new PDO("mysql:host=localhost;dbname=exm_db","root","");
	function isOldPass($oldPass,$user_name){
	global $conn;
	try {

					$sql="SELECT * FROM user WHERE password=:oldPass AND user_name=:user_name";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":oldPass",$oldPass);
					$statement->bindParam(":user_name",$user_name);
					$statement->execute();
					$dataRow=$statement->fetch();
					if (!empty($dataRow)){
						return true;
					}
		} catch (Exception $e) {
			echo $e;
		}
		return false;
	}
?>
<?php
	function changeAdminPassDB($password,$user_name){
	global $conn;
	try {
					$sql="UPDATE user SET password=:password WHERE user_name=:user_name";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":password",$password);
					$statement->bindParam(":user_name",$user_name);
					$statement->execute();
					if ($statement){
						return true;
					}
		} catch (Exception $e) {
			echo $e;
		}
		return false;
	}
?>
