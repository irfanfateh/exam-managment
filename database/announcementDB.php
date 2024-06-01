<?php
$conn = new PDO("mysql:host=localhost;dbname=exm_db","root","");
	function getAnnouncementDB(){
	global $conn;
	$dataArray=array();
	try {

					$counter=0;
					$sql="SELECT * FROM announcement ORDER BY id DESC;";
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
	function addAnnouncementDB($raw){
	global $conn;
	try {
					$sql="SELECT * FROM announcement WHERE title=:title ";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":title",$raw["title"]);
					$statement->execute();
					$dataRow=$statement->fetch();
					if (empty($dataRow)){
							$sql="INSERT INTO announcement (title,description,announcementBy,date) VALUES (:title,:description,:announcementBy,:date)";
								$statement=$conn->prepare($sql);
								$statement->bindParam(":title",$raw["title"]);
								$statement->bindParam(":description",$raw["detail"]);
								$statement->bindParam(":announcementBy",$raw["enteredBy"]);
								$statement->bindParam(":date",$raw["date"]);
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
	function getAnnouncementOfDB($title){
	global $conn;
	$dataArray=array();
	try {
					$counter=0;
					$sql="SELECT * FROM announcement WHERE title=:title";
					$statement=$conn->prepare($sql);
					$statement->bindParam(":title",$title);
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
	function updateAnnouncementDB($raw)
	{
		global $conn;
	try {

						$sql="UPDATE  SET announcement title=:title, description=:detail, date=:date , announcementBy=:by WHERE id=:id";
						$statement=$conn->prepare($sql);
						$statement->bindParam(":id",$raw["id"]);
						$statement->bindParam(":title",$raw["title"]);
						$statement->bindParam(":by",$raw["enteredBy"]);
						$statement->bindParam(":date",$raw["date"]);
						$statement->bindParam(":detail",$raw["detail"]);
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
	function deleteAnnouncementDB($id)
	{
		global $conn;
	try {
						$sql="DELETE FROM announcement WHERE id=:id";
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
<?php
	function updateResultDB($raw)
	{
		global $conn;
	try {
						$sql="UPDATE paper_pattern SET result=:result WHERE term=:term AND subject_code=:subCode";
						$statement=$conn->prepare($sql);
						$statement->bindParam(":subCode",$raw["subCode"]);
						$statement->bindParam(":term",$raw["term"]);
						$statement->bindParam(":result",$raw["result"]);
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
