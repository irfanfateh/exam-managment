<?php
		require_once("topicDB.php");
?>
<?php
$conn = new PDO("mysql:host=localhost;dbname=exm_db","root","");
	function getSubject($subCode){
	global $conn;
	try {
					$sql="SELECT * FROM subjects WHERE subject_code=:subCode";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":subCode",$subCode);
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
	function isExist($subCode){
	global $conn;
	try {
					$sql="SELECT * FROM subjects WHERE subject_code=:subCode";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":subCode",$subCode);
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
	function addSubjectDb($subCode,$subName,$assignedTo,$date){
	global $conn;
	try {

					$sql="INSERT INTO subjects (subject_code,subject_name,assigned_to,date) VALUES (:subCode,:subName,:assigned,:date)";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":subCode",$subCode);
					$statement->bindParam(":subName",$subName);
					$statement->bindParam(":assigned",$assignedTo);
					$statement->bindParam(":date",$date);
					$statement->execute();
					if ($statement && createTopicTable($subCode)){
						return true;
					}
		} catch (Exception $e) {
			echo $e;
		}
		return false;
	}
?>
<?php
	function updateSubjectDb($id,$subCode,$subName,$assignedTo,$date){
	global $conn;
	try {

					$sql="UPDATE subjects SET subject_code=:subCode, subject_name=:subName, assigned_to=:assigned, date=:date WHERE subject_code=:id";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":subCode",$subCode);
					$statement->bindParam(":subName",$subName);
					$statement->bindParam(":assigned",$assignedTo);
					$statement->bindParam(":date",$date);
					$statement->bindParam(":id",$id);
					$statement->execute();
					if ($statement){
						$oldTopicTable=strtolower($id)."_topics";
						$newTopicTable=strtolower($subCode)."_topics";
						$sql="ALTER TABLE {$oldTopicTable} RENAME TO {$newTopicTable};";
						$statement=$conn->prepare($sql);
						$statement->execute();
						return true;
					}
		} catch (Exception $e) {
			echo $e;
		}
		return false;
	}
?>
<?php
	function deleteSubjectDb($id)
	{
		global $conn;
	try {
					if (deleteTopicTable($id)){
					$sql="DELETE FROM subjects WHERE subject_code=:id";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":id",$id);
					$statement->execute();
						return $statement;
					}
		} catch (Exception $e) {
			echo $e;
		}
		return false;
	}
?>
<?php
	function getTeacherArrayDB(){
	global $conn;
	$dataArray=array();
	try {

					$counter=0;
					$sql="SELECT user_name FROM user WHERE user_type='TEACHER'";
					$statement=$conn->prepare($sql);
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
	function getUnAssignedSubjects(){
	global $conn;
	$dataArray=array();
	try {

					$counter=0;
					$sql="SELECT subject_code FROM subjects WHERE assigned_to='NILL'";
					$statement=$conn->prepare($sql);
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
	function getAssignSubject(){
	global $conn;
	$dataArray=array();
	try {

					$counter=0;
					$sql="SELECT subject_code FROM subjects WHERE assigned_to!='NILL'";
					$statement=$conn->prepare($sql);
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

function assignSubToTchrDB($code,$email){
	global $conn;
	try {

					$sql="UPDATE subjects SET assigned_to=:assigned WHERE subject_code=:subCode";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":subCode",$code);
					$statement->bindParam(":assigned",$email);
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

function unassignSubDB($code){
	global $conn;
	try {

					$sql="UPDATE subjects SET assigned_to='NILL' WHERE subject_code=:subCode";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":subCode",$code);
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
	function getAssignSubjectFor($teacher){
	global $conn;
	$dataArray=array();
	try {

					$counter=0;
					$sql="SELECT * FROM subjects WHERE assigned_to=:tchr";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":tchr",$teacher);
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
