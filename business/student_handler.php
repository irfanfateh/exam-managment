<?php
	require_once("database/userDB.php");
	require_once("business/utilities.php");
?>
<?php
	function addStudent()
	{
		if (!isExistUser(strtoupper($_POST['stdEmail']))) {
				$file=addslashes(file_get_contents($_FILES['image']["tmp_name"]));
				$std=array(
					"name"=>strtoupper($_POST['stdName']),
					"lastName"=>strtoupper($_POST['stdLastName']),
					"id"=>strtoupper($_POST['stdEmail']),
					"password"=>$_POST['stdPassword'],
					"address"=>strtoupper($_POST['stdAddress']),
					"qualification"=>strtoupper($_POST['stdQual']),
					"state"=>strtoupper($_POST['stdState']),
					"contact"=>$_POST['stdContact'],
					"image"=>$file,
					"date"=>date("Y-m-d"),
					"user_type"=>"NOT APPROVED"
				);
				if (addUserDB($std)){
				      return true;
				}else{
					return false;
				}
		} else {
			return false;
		}
	}
?>
<?php
	function getUnApproveSt()
	{
		return getAllUsersOfDB("NOT APPROVED");
	}
?>
<?php
	function approveStudent()
	{
		if(approveUser($_POST['id'])){
				printErrorMsg("deleted student request.",true);
		}else{
			printErrorMsg("system failed to approve request.",false);
		}

	}
?>
<?php
	function deleteStudent()
	{
		if(deleteUserDB($_POST['id'])){
				printErrorMsg("deleted student request.",true);
		}else{
			printErrorMsg("system failed to approve request.",false);
		}
	}
?>
