<?php
		require_once("questionDB.php");
		require_once("subjectDB.php");
?>
<?php
$conn = new PDO("mysql:host=localhost;dbname=exm_db","root","");
	function createTopicTable($subCode){
	global $conn;
	try {
         $subject=getSubject($subCode);
		$topicTable='sub_'.$subject['id'];
        $sql="CREATE TABLE {$topicTable} (
                      id int NOT NULL AUTO_INCREMENT,
                      topic_name varchar(300) NOT NULL,
                      entered_by varchar(32),
                      date DATE,
                      PRIMARY KEY (id)
                  );";
          $statement=$conn->prepare($sql);
          $statement->execute();
					return $statement;
		} catch (Exception $e) {
			echo $e;
		}
  }
?>

<?php
	function deleteTopicTable($subCode)
	{
		global $conn;
	try {
		$subject=getSubject($subCode);
		$topicTable='sub_'.$subject['id'];
        deleteQuestionsTable($topicTable);
        $sql="DROP TABLE {$topicTable}";
        $statement=$conn->prepare($sql);
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
	function addTopicDB($raw)
	{
		global $conn;
	try {
        $subject=getSubject($raw['subCode']);
		$topicTable='sub_'.$subject['id'];
        $sql="INSERT INTO {$topicTable} (topic_name,entered_by,date) VALUES(:topic,:by,:date)";
        $statement=$conn->prepare($sql);
				$statement->bindParam(":topic",$raw["topicName"]);
				$statement->bindParam(":by",$raw["enteredBy"]);
				$statement->bindParam(":date",$raw["date"]);
        $statement->execute();
        if ($statement){
          $topic=getTopicOfDB($raw['subCode'],$raw['topicName']);
          $questionTable='sub_'.$subject['id'].'_tp_'.$topic['id'];
          return createQuestionsTable($questionTable);
        }
		} catch (Exception $e) {
			echo $e;
		}
		return false;
	}
?>
<?php
	function isExistTopic($raw){
	global $conn;
	try {
					$subject=getSubject($raw['subCode']);
					$topicTable='sub_'.$subject['id'];
					$sql="SELECT * FROM {$topicTable} WHERE topic_name=:topicName";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":topicName",$raw["topicName"]);
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
	function getTopicsDB($subCode){
	global $conn;
	$dataArray=array();
	try {	
					$subject=getSubject($subCode);
					$topicTable='sub_'.$subject['id'];
					$counter=0;
					$sql="SELECT * FROM {$topicTable}";
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
	function getTopicOfDB($subCode,$topic){
	global $conn;
	try {
					$subject=getSubject($subCode);
					$topicTable='sub_'.$subject['id'];
					$counter=0;
					$sql="SELECT * FROM {$topicTable} WHERE topic_name=:topic";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":topic",$topic);
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
	function updateTopicDB($raw)
	{
		global $conn;
	try {
	       				$subject=getSubject($raw['subCode']);
						$topicTable='sub_'.$subject['id'];
						$sql="UPDATE {$topicTable} SET topic_name=:topic, entered_by=:by, date=:date WHERE id=:id";
						$statement=$conn->prepare($sql);
						$statement->bindParam(":id",$raw["topicId"]);
						$statement->bindParam(":topic",$raw["topicName"]);
						$statement->bindParam(":by",$raw["enteredBy"]);
						$statement->bindParam(":date",$raw["date"]);
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
	function deleteTopicDB($raw)
	{
		global $conn;
	try {
						$subject=getSubject($raw['subCode']);
						$topicTable='sub_'.$subject['id'];
        				$topic=getTopicOfDB($raw['subCode'],$raw["topicName"]);
				        $questionTable='sub_'.$subject['id'].'_tp_'.$topic['id'];
						$sql="DROP TABLE {$questionTable}";
						$statement=$conn->prepare($sql);
						$statement->execute();
						$sql="DELETE FROM {$topicTable} WHERE id=:id";
						$statement=$conn->prepare($sql);
						$statement->bindParam(":id",$raw["topicId"]);
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
