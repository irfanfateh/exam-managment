<?php
$conn = new PDO("mysql:host=localhost;dbname=exm_db","root","");
	function isExistUser($user_name){
	global $conn;
	try {
					$sql="SELECT * FROM user WHERE user_name=:username";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":username",$user_name);
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
	function updateUserDB($dataArray){
	global $conn;
	try {
					if ($dataArray['image']=="") {
						$sql="UPDATE user SET user_name=:id, name=:name, last_name=:last_name, password=:password, address=:address, qualification=:qualification, state=:state, contact=:contact WHERE user_name=:searchId";
					}else{
						$file=$dataArray['image'];
						$sql="UPDATE user SET user_name=:id, name=:name, last_name=:last_name, password=:password, address=:address, qualification=:qualification, state=:state, contact=:contact, image='$file' WHERE user_name=:searchId";
					}
					$statement=$conn->prepare($sql);
					$statement->bindParam(":id",$dataArray['id']);
					$statement->bindParam(":name",$dataArray['name']);
					$statement->bindParam(":last_name",$dataArray['lastName']);
					$statement->bindParam(":password",$dataArray['password']);
					$statement->bindParam(":address",$dataArray['address']);
					$statement->bindParam(":qualification",$dataArray['qualification']);
					$statement->bindParam(":state",$dataArray['state']);
					$statement->bindParam(":contact",$dataArray['contact']);
					// if ($dataArray['image']!="") {
					// 	$statement->bindParam(":image",$dataArray['image']);
					// }
					$statement->bindParam(":searchId",$dataArray['searchId']);
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
<?php
	function addUserDB($dataArray){
	global $conn;
	try {
					$file=$dataArray['image'];
					$sql="INSERT INTO user (user_name,name,last_name,password,address,qualification,state,contact,image,date,user_type) VALUES (:id,:name,:lastName,:password,:address,:qualification,:state,:contact,'$file',:date,:user_type)";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":id",$dataArray['id']);
					$statement->bindParam(":name",$dataArray['name']);
					$statement->bindParam(":lastName",$dataArray['lastName']);
					$statement->bindParam(":password",$dataArray['password']);
					$statement->bindParam(":address",$dataArray['address']);
					$statement->bindParam(":qualification",$dataArray['qualification']);
					$statement->bindParam(":state",$dataArray['state']);
					$statement->bindParam(":contact",$dataArray['contact']);
					// $statement->bindParam(":image",$dataArray['image']);
					$statement->bindParam(":date",$dataArray['date']);
					$statement->bindParam(":user_type",$dataArray['user_type']);
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
<?php
	function getUserDB($user_name){
	global $conn;
	try {
					$sql="SELECT * FROM user WHERE user_name=:id";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":id",$user_name);
					$statement->execute();
					$dataRow=$statement->fetch();
					if (!empty($dataRow)){
						for ($i=0; $i<count($dataRow); $i++) {
					     		unset($dataRow[$i]);
					     	}
					}
					return $dataRow;
		} catch (Exception $e) {
			echo $e;
		}
		return false;
	}
?>
<?php
	function deleteUserDB($id)
	{
		global $conn;
	try {

					$sql="DELETE FROM user WHERE user_name=:id";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":id",$id);
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
<?php
	function getAllUsersOfDB($user_type){
	global $conn;
	$dataArray=array();
	try {

					$counter=0;
					$sql="SELECT * FROM user WHERE user_type=:user";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":user",$user_type);
					$statement->execute();
					while ($dataRow=$statement->fetch()) {
					     	for ($i=0; $i<count($dataRow); $i++) {
					     		unset($dataRow[$i]);
					     	}
					     	$dataArray[$counter]=$dataRow;
					     	$counter++;
					}
		} catch (Exception $e) {
			echo $e;
		}
		return $dataArray;
	}
?>
<?php

function approveUser($id){
	global $conn;
	try {

					$sql="UPDATE user SET user_type='STUDENT' WHERE user_name=:user_name";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":user_name",$id);
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
