<?php
	require_once("topicDB.php");
$conn = new PDO("mysql:host=localhost;dbname=exm_db","root","");
	function deleteQuestionsTable($topicTable)
	{
		global $conn;
	try {
      $dataRow=getQuestionsOf($topicTable);
			for($i=0;$i<count($dataRow);$i++){
				$questionTable=$topicTable.'_tp_'.$dataRow[$i]["id"];
				$sql="DROP TABLE {$questionTable}";
				$statement=$conn->prepare($sql);
				$statement->execute();
			}
		} catch (Exception $e) {
			echo $e;
		}
	}
?>
<?php
function getQuestionsOf($topicTable)
{
  global $conn;
try {
				$sql="SELECT * FROM {$topicTable}";
		        $statement=$conn->prepare($sql);
		        $statement->execute();
				$counter=0;
				$dataArray=array();
				while ($dataRow=$statement->fetch()) {
							for ($i=0; $i<count($dataRow); $i++) {
								unset($dataRow[$i]);
							}
							$dataArray[$counter]=$dataRow;
							$counter++;
				}
        return $dataArray;
  } catch (Exception $e) {
    echo $e;
  }
}
?>
<?php
	function createQuestionsTable($questionTable)
	{
		global $conn;
	try {

		$sql="CREATE TABLE {$questionTable} (
									id int NOT NULL AUTO_INCREMENT,
									que_statement varchar(300) NOT NULL,
									type varchar(10) NOT NULL,
								 	option_a varchar(150),
									option_b varchar(150),
									option_c varchar(150),
									option_d varchar(150),
									correct_option varchar(2),
									PRIMARY KEY (id)
							);";
        $statement=$conn->prepare($sql);
        $statement->execute();
				return $statement;
		} catch (Exception $e) {
			echo $e;
		}
		return false;
	}
?>
<?php
	function addMcqDB($raw){
	global $conn;
	try {
			        $subject=getSubject($raw['subCode']);
			        $topic=getTopicOfDB($raw['subCode'],$raw['topicName']);
			        $questionTable='sub_'.$subject['id'].'_tp_'.$topic['id'];
					$sql="SELECT * FROM {$questionTable} WHERE que_statement=:quiz AND type='MCQ'";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":quiz",$raw["que"]);
					$statement->execute();
					$dataRow=$statement->fetch();
					if (empty($dataRow)){
							$sql="INSERT INTO {$questionTable} (que_statement,type,option_a,option_b,option_c,option_d,correct_option) VALUES (:que,:type,:a,:b,:c,:d,:correct)";
								$statement=$conn->prepare($sql);
								$statement->bindParam(":que",$raw["que"]);
								$statement->bindParam(":type",$raw["type"]);
								$statement->bindParam(":a",$raw["optA"]);
								$statement->bindParam(":b",$raw["optB"]);
								$statement->bindParam(":c",$raw["optC"]);
								$statement->bindParam(":d",$raw["optD"]);
								$statement->bindParam(":correct",$raw["correct"]);
								$statement->execute();
								if($statement) return true;
					}
		} catch (Exception $e) {
			echo $e;
		}
		return false;
	}
?>
<?php
	function addSubjectiveDB($raw){
	global $conn;
	try {
					$subject=getSubject($raw['subCode']);
			        $topic=getTopicOfDB($raw['subCode'],$raw['topicName']);
			        $questionTable='sub_'.$subject['id'].'_tp_'.$topic['id'];
					$sql="SELECT * FROM {$questionTable} WHERE que_statement=:quiz AND type!='MCQ'";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":quiz",$raw["que"]);
					$statement->execute();
					$dataRow=$statement->fetch();
					if (empty($dataRow)){
							$sql="INSERT INTO {$questionTable} (que_statement,type) VALUES (:que,:type)";
								$statement=$conn->prepare($sql);
								$statement->bindParam(":que",$raw["que"]);
								$statement->bindParam(":type",$raw["type"]);
								$statement->execute();
								if($statement) return true;
					}
		} catch (Exception $e) {
			echo $e;
		}
		return false;
	}
?>
<?php
	function getQuizOfDB($raw){
	global $conn;
	try {	
					$subject=getSubject($raw['subCode']);
			        $topic=getTopicOfDB($raw['subCode'],$raw['topicName']);
			        $questionTable='sub_'.$subject['id'].'_tp_'.$topic['id'];
					$counter=0;
					$sql="SELECT * FROM {$questionTable} WHERE que_statement=:question AND type=:type";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":question",$raw['que']);
					$statement->bindParam(":type",$raw['type']);
					$statement->execute();
					if($dataRow=$statement->fetch()){
					     	for ($i=0; $i<count($dataRow); $i++) {
					     		unset($dataRow[$i]);
					     	}
					}
		} catch (Exception $e) {
			echo $e;
		}
		return $dataRow;
	}
?>
<?php
	function getQuizesOfDB($raw){
	global $conn;
	try {
					$subject=getSubject($raw['subCode']);
			        $topic=getTopicOfDB($raw['subCode'],$raw['topicName']);
			        $questionTable='sub_'.$subject['id'].'_tp_'.$topic['id'];
					$counter=0;
					$sql="SELECT * FROM {$questionTable} WHERE type=:type";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":type",$raw['type']);
					$statement->execute();
						$dataArray=array();
					while ($dataRow=$statement->fetch()) {
								for ($i=0; $i<count($dataRow); $i++) {
									unset($dataRow[$i]);
								}
								$dataArray[$counter]=$dataRow;
								$counter++;
					}
	        return $dataArray;
		} catch (Exception $e) {
			echo $e;
		}
		return $dataArray;
	}
?>
<?php
	function updateMcqDB($raw)
	{
		global $conn;
	try {
					$subject=getSubject($raw['subCode']);
			        $topic=getTopicOfDB($raw['subCode'],$raw['topicName']);
			        $questionTable='sub_'.$subject['id'].'_tp_'.$topic['id'];
						$sql="UPDATE {$questionTable} SET que_statement=:quiz, option_a=:a,  option_b=:b,  option_c=:c,  option_d=:d, correct_option=:correct WHERE id=:id";
						$statement=$conn->prepare($sql);
						$statement->bindParam(":id",$raw["id"]);
						$statement->bindParam(":quiz",$raw["quiz"]);
						$statement->bindParam(":a",$raw["optA"]);
						$statement->bindParam(":b",$raw["optB"]);
						$statement->bindParam(":c",$raw["optC"]);
						$statement->bindParam(":d",$raw["optD"]);
						$statement->bindParam(":correct",$raw["correctOpt"]);
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
	function updateSubqUizDB($raw)
	{
		global $conn;
	try {
			        $subject=getSubject($raw['subCode']);
			        $topic=getTopicOfDB($raw['subCode'],$raw['topicName']);
			        $questionTable='sub_'.$subject['id'].'_tp_'.$topic['id'];
						$sql="UPDATE {$questionTable} SET que_statement=:quiz, type=:type WHERE id=:id";
						$statement=$conn->prepare($sql);
						$statement->bindParam(":id",$raw["id"]);
						$statement->bindParam(":quiz",$raw["quiz"]);
						$statement->bindParam(":type",$raw["type"]);
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
	function deleteQuizDB($raw)
	{
		global $conn;
	try {
					$subject=getSubject($raw['subCode']);
			        $topic=getTopicOfDB($raw['subCode'],$raw['topicName']);
			        $questionTable='sub_'.$subject['id'].'_tp_'.$topic['id'];
						$sql="DELETE FROM {$questionTable} WHERE que_statement=:id";
						$statement=$conn->prepare($sql);
						$statement->bindParam(":id",$raw["oldQuiz"]);
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
