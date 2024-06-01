<?php 
	require_once("database/subjectDB.php");
	require_once("business/utilities.php");
	function addSubject($subCode,$subName){
		$subName=strtoupper($subName);
		$subCode=strtoupper($subCode);
		if (!isExist($subCode) && addSubjectDb($subCode,$subName,"NILL",date("Y-m-d"))){
			printErrorMsg("added new subject.",true);
		}else{
			printErrorMsg("system failed to add new subject.",false);
		}
	}
?>
<?php
	function searchSubject($subCode){
		$subCode=strtoupper($subCode);
		if (isExist($subCode)){
			return getSubject($subCode);
		}
		return false;
	}
?>
<?php
	function updateSubject($id,$subCode,$subName){
		$subCode=strtoupper($subCode);
		$subName=strtoupper($subName);
		if(isExist($id) && updateSubjectDb($id,$subCode,$subName,"NILL",date("Y-m-d"))) {
			printErrorMsg("updated subject.",true);
		}else {
			printErrorMsg("system failed to update subject.",false);
		}
	}
?>
<?php
	function deleteSubject($subCode)
	{
		if(isExist($subCode) && deleteSubjectDb($subCode)) {
			printErrorMsg("changes saved into database",true);
		}else {
			printErrorMsg("system failed to update subject.",false);
		}
	}
?>
<?php
	function getAssignData(){
		$subjectArray=getUnAssignedSubjects();
		$tchrArray=getTeacherArrayDB();
		$assignedSubject=getAssignSubject();
		$data=array($subjectArray,$tchrArray,$assignedSubject);
		return $data;
	}
?>
<?php
	function assignSubToTchr(){
		if (isExist($_POST['subCodeToAssign'])) {
			if (assignSubToTchrDB($_POST['subCodeToAssign'],$_POST['emailToAssign'])) {
			printErrorMsg("changes saved into database",true);

				} else {
			printErrorMsg("system failed to assign subject.",false);

				}
		}else{
			printErrorMsg("system failed to assign subject.",false);
		}
	}
?>
<?php
	function unassignSub(){
		if (isExist($_POST['subCodeToUnssign'])) {
			if (unassignSubDB($_POST['subCodeToUnssign'])) {
			printErrorMsg("changes saved into database",true);

				} else {
			printErrorMsg("system failed to unassign subject.",false);

				}
		}else{
			printErrorMsg("system failed to unassign subject.",false);
		}
	}
?>
