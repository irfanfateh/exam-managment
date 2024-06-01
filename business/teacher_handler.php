<?php
	require_once("database/userDB.php");
	require_once("business/utilities.php");
?>
<?php
	function addTeacher()
	{
		if (!isExistUser(strtoupper($_POST['tchrEmail']))) {
				$file=addslashes(file_get_contents($_FILES['image']["tmp_name"]));
				$tchr=array(
					"name"=>strtoupper($_POST['tchrName']),
					"lastName"=>strtoupper($_POST['tchrLastName']),
					"id"=>strtoupper($_POST['tchrEmail']),
					"password"=>$_POST['tchrPassword'],
					"address"=>strtoupper($_POST['tchrAddress']),
					"qualification"=>strtoupper($_POST['tchrQual']),
					"state"=>strtoupper($_POST['tchrState']),
					"contact"=>$_POST['tchrContact'],
					"image"=>$file,
					"date"=>date("Y-m-d"),
					"user_type"=>"TEACHER"
				);
				if (addUserDB($tchr)){
					printErrorMsg("added new teacher.",true);
				}else{
					printErrorMsg("system failed to add new teacher.",false);
				}
		} else {
			printErrorMsg("system failed to add new teacher.",false);
		}
	}
?>
<?php
	function searchTeacher($email){
		if (isExistUser(strtoupper($email))){
			return getUserDB($email);
		}else{
			return false;
		}
	}
?>
<?php
	function updateTeacher()
	{
		if (isExistUser(strtoupper($_POST['id']))) {
			if (!empty($_FILES['image']['tmp_name'])) {
				$file=addslashes(file_get_contents($_FILES['image']["tmp_name"]));
			}else{$file="";}
				$tchr=array(
					"name"=>strtoupper($_POST['tchrName']),
					"lastName"=>strtoupper($_POST['tchrLastName']),
					"id"=>strtoupper($_POST['tchrEmail']),
					"password"=>$_POST['tchrPassword'],
					"address"=>strtoupper($_POST['tchrAddress']),
					"qualification"=>strtoupper($_POST['tchrQual']),
					"state"=>strtoupper($_POST['tchrState']),
					"contact"=>$_POST['tchrContact'],
					"image"=>$file,
					"searchId"=>strtoupper($_POST['id'])
				);
				if (updateUserDB($tchr)){
					printErrorMsg("updated teacher into database.",true);
				}else{
					printErrorMsg("system failed to update teacher.",false);
				}
		} else {
			printErrorMsg("user not exist in database.",false);
		}
	}
?>
<?php
	function deleteTeacher()
	{
		if(isExistUser($_POST['id']) && deleteUserDB($_POST['id'])) {
			printErrorMsg("changes saved into database",true);
		}else {
			printErrorMsg("system failed to delete teacher.",false);
		}
	}
?>
<?php
	function getTeachers()
	{
		return getAllUsersOfDB('TEACHER');
	}
?>
