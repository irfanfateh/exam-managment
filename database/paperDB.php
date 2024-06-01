<?php
$conn = new PDO("mysql:host=localhost;dbname=exm_db","root","");
	function addPaperDB($raw){
	global $conn;
	try {
        $sql="INSERT INTO paper_pattern (subject_code,term,open_date,last_date,total_marks,n_mcq,n_short,n_long,time,result) 
          VALUES(:subCode,:paperTerm,:paperOpDate,:paperLDate,:paperTMarks,:paperNMcq,:paperNShort,:paperNLong,:paperTime,:result)";
        $statement=$conn->prepare($sql);
        $statement->bindParam(":subCode",$raw["subCode"]);
        $statement->bindParam(":paperTerm",$raw["paperTerm"]);
        $statement->bindParam(":paperOpDate",$raw["paperOpDate"]);
        $statement->bindParam(":paperLDate",$raw["paperLDate"]);
        $statement->bindParam(":paperTMarks",$raw["paperTMarks"]);
        $statement->bindParam(":paperNMcq",$raw["paperNMcq"]);
        $statement->bindParam(":paperNShort",$raw["paperNShort"]);
        $statement->bindParam(":paperNLong",$raw["paperNLong"]);
        $statement->bindParam(":paperTime",$raw["paperTime"]);
        $statement->bindParam(":result",$raw["result"]);
        $statement->execute();

        if ($statement) {
              $pattern=getPatternDB($raw["subCode"],$raw["paperTerm"]);
              $attendanceTable="atn_".$pattern["id"];
                $sql="CREATE TABLE {$attendanceTable} (
                          id int NOT NULL AUTO_INCREMENT,
                          student_id varchar(32) NOT NULL,
                          status varchar(10),
                          check_status varchar(10),
                          date DATE,
                          PRIMARY KEY (id)
                  );";
                   $statement=$conn->prepare($sql);
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
  function isExistPaperPattern($raw){
  global $conn;
  try {
          $sql="SELECT * FROM paper_pattern WHERE term=:term AND subject_code=:subCode";
          $statement=$conn->prepare($sql);
          $statement->bindParam(":term",$raw["paperTerm"]);
           $statement->bindParam(":subCode",$raw["subCode"]);
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
  function getQuestionsCount($queTable){
  global $conn;
  try {
    $counts=array();
          $sql="SELECT COUNT(*)
                          FROM {$queTable} WHERE type='3'";
                $statement=$conn->prepare($sql);
                $statement->execute();
                $dataRow=$statement->fetch();
                if (!empty($dataRow)){
                  $counts['short']=$dataRow['COUNT(*)'];
                }
                $sql="SELECT COUNT(*)
                          FROM {$queTable} WHERE type='5'";
                $statement=$conn->prepare($sql);
                $statement->execute();
                $dataRow=$statement->fetch();
                if (!empty($dataRow)){
                  $counts['long']=$dataRow['COUNT(*)'];
                }
                $sql="SELECT COUNT(*)
                          FROM {$queTable} WHERE type='MCQ'";
                $statement=$conn->prepare($sql);
                $statement->execute();
                $dataRow=$statement->fetch();
                if (!empty($dataRow)){
                  $counts['mcq']=$dataRow['COUNT(*)'];
                }
          return $counts;
    } catch (Exception $e) {
      echo $e;
    }
    return false;
  }
?>
<?php
  function getTermsDB($subCode){
  global $conn;
  $dataArray=array();
  try {

          $counter=0;
          $sql="SELECT * FROM paper_pattern WHERE subject_code='{$subCode}'";
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
  function getPatternDB($subCode,$term){
  global $conn;
  try {
          $counter=0;
          $sql="SELECT * FROM paper_pattern WHERE term=:term AND subject_code=:subCode";
          $statement=$conn->prepare($sql);
          $statement->bindParam(":term",$term);
          $statement->bindParam(":subCode",$subCode);
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
  function updatePatternDB($raw)
  {
    global $conn;
  try {
        
            $sql="UPDATE paper_pattern SET term=:term, open_date=:opDate, last_date=:lDate, total_marks=:tMarks,
            n_mcq=:nMcq, n_short=:nShort, n_long=:nLong, time=:time WHERE id=:id";
            $statement=$conn->prepare($sql);
            $statement->bindParam(":id",$raw["id"]);
            $statement->bindParam(":term",$raw["paperTerm"]);
            $statement->bindParam(":opDate",$raw["paperOpDate"]);
            $statement->bindParam(":lDate",$raw["paperLDate"]);
            $statement->bindParam(":tMarks",$raw["paperTMarks"]);
            $statement->bindParam(":nMcq",$raw["paperNMcq"]);
            $statement->bindParam(":nShort",$raw["paperNShort"]);
            $statement->bindParam(":nLong",$raw["paperNLong"]);
            $statement->bindParam(":time",$raw["paperTime"]);
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
  function deletePatternDB($id)
  {
    global $conn;
  try {
            $sql="DELETE FROM paper_pattern WHERE id=:id";
            $statement=$conn->prepare($sql);
            $statement->bindParam(":id",$id);
            $statement->execute();
        if ($statement){
            $table="atn_".$id;
            $sql="SELECT * FROM {$table}";
            $statement=$conn->prepare($sql);
            $statement->execute();
              while ($dataRow=$statement->fetch()) {
                    $innerTable="ptn_".$id."_std_".$dataRow['student_id'];
                    $sql="DROP TABLE {$innerTable}";
                    $statement=$conn->prepare($sql);
                    $statement->execute();
              }
            $sql="DROP TABLE {$table}";
            $statement=$conn->prepare($sql);
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
  function getQuesFromTable($table,$noOfQuiz,$type){
  global $conn;
  $dataArray=array();
  try {

          $counter=0;
          // $sql="SELECT id FROM $table WHERE ";
          $sql="SELECT id FROM {$table} WHERE type='{$type}'
                    ORDER BY RAND()
                    LIMIT {$noOfQuiz}";
          $statement=$conn->prepare($sql);
          $statement->execute();
          while ($dataRow=$statement->fetch()) {

                for ($i=0; $i<count($dataRow); $i++) {
                  unset($dataRow[$i]);
                }
                $dataArray[$counter]=$dataRow['id'];
                $counter++;
          }
    } catch (Exception $e) {
      echo $e;
    }
    return $dataArray;
  }
?>
<?php
  function makePaperAttendence($raw,$remark){
  global $conn;
  try {
        if(!isAttempted($raw,$remark)) {
            $pattern=getPatternDB($raw["subCode"],$raw["term"]);
            $attendanceTable="atn_".$pattern["id"];
            if ($remark=="started") {
                $sql="INSERT INTO {$attendanceTable} (student_id,date,status,check_status)  VALUES(:id,:date,:status,'Pending')";
                $statement=$conn->prepare($sql);
                $statement->bindParam(":status",$remark);
                $statement->bindParam(":date",$raw["date"]);
            }else if ($remark=="submitted") {
              $sql="UPDATE {$attendanceTable} SET status='submitted' WHERE student_id=:id";
                $statement=$conn->prepare($sql);
            }else if ($remark=="checked") {
              $sql="UPDATE {$attendanceTable} SET check_status='checked' WHERE student_id=:id";
                $statement=$conn->prepare($sql);
            }
            $statement->bindParam(":id",$raw["student_id"]);
            $statement->execute();
            return $statement;      
        }
        
    } catch (Exception $e) {
      echo $e;
    }
    return true;
  }
?>
<?php
  function makeStudentPaper($raw,&$paper){
  global $conn;
  try {
        // $tempArray=explode("_","atn_10_std_20");
              // $atnId=$tempArray[1];
              // $stdId=$tempArray[3];
        $pattern=getPatternDB($raw["subCode"],$raw["term"]);
        $tableName="ptn_".$pattern['id']."_std_".$raw['student_id'];
        if(isAttempted($raw,'started')){
            $sql="DROP TABLE {$tableName}";
            $statement=$conn->prepare($sql);
            $statement->execute();
            if(!$statement) {return false;}
        }
        $sql="CREATE TABLE {$tableName} (
                          id int NOT NULL AUTO_INCREMENT,
                          q_table varchar(64) NOT NULL,
                          q_id int,
                          q_type varchar(5),
                          status varchar(8),
                          answer varchar(300),
                          obtain_marks int,
                          PRIMARY KEY (id)
                  );";
                   $statement=$conn->prepare($sql);
                    $statement->execute();
                
                if ($statement) {
                  for ($i=0; $i<count($paper); $i++) { 
                    $qId=$paper[$i]["q_id"];
                    $qTable=$paper[$i]["q_table"];
                    $qtype=$paper[$i]["q_type"];
                    $sql="INSERT INTO {$tableName} (q_id,q_table,q_type)  VALUES(:qId,:qTable,:qType)";
                    $statement=$conn->prepare($sql);
                    $statement->bindParam(":qId",$qId);
                    $statement->bindParam(":qTable",$qTable);
                    $statement->bindParam(":qType",$qtype);
                    $statement->execute();
                    $paper[$i]["id"]=$i+1;
                  }
                    
                            return $statement;
                }
        
    } catch (Exception $e) {
      echo $e;
    }
    return false;
  }
?>
<?php
  function isAttempted($raw,$remark){
  global $conn;
  try {
          $pattern=getPatternDB($raw["subCode"],$raw["term"]);
          $table="atn_".$pattern['id'];
          $sql="SELECT * FROM {$table} WHERE student_id=:stdId AND status=:status";
          $statement=$conn->prepare($sql);
          $statement->bindParam(":stdId",$raw["student_id"]);
          $statement->bindParam(":status",$remark);
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
  function getQuestionsInfo(&$paper){
  global $conn;
  try {
          for ($i=0; $i<count($paper); $i++) { 
            $table=$paper[$i]['q_table'];
            $sql="SELECT * FROM {$table} WHERE id=:id";
            $statement=$conn->prepare($sql);
            $statement->bindParam(":id",$paper[$i]['q_id']);
            $statement->execute();
              if($dataRow=$statement->fetch()){
                  $paper[$i]['q_statement']=$dataRow['que_statement'];
                  if ($paper[$i]['q_type']=='MCQ') {
                    $paper[$i]['option_a']=$dataRow['option_a'];
                    $paper[$i]['option_b']=$dataRow['option_b'];
                    $paper[$i]['option_c']=$dataRow['option_c'];
                    $paper[$i]['option_d']=$dataRow['option_d'];
                  }
              }
          }
          
          
    } catch (Exception $e) {
      echo $e;
    }
    return $dataRow;
  }
?>
<?php
  function getPaperDb($raw){
  global $conn;
  $dataArray=array();
  try {
          $counter=0;
          $pattern=getPatternDB($raw["subCode"],$raw["term"]);
          $table="ptn_".$pattern['id']."_std_".$raw["student_id"];
          $sql="SELECT * FROM {$table}";
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
  function savePaperDb($paper,$raw){
  global $conn;
  try {
          $pattern=getPatternDB($raw["subCode"],$raw["term"]);
          $table="ptn_".$pattern['id']."_std_".$raw['student_id'];
          for ($i=0; $i<count($paper); $i++) {
                    $sql="UPDATE {$table} SET answer=:answer, obtain_marks=:obt WHERE id=:id";
                    $statement=$conn->prepare($sql);
                    $statement->bindParam(":answer",$paper[$i]['answer']);
                    $statement->bindParam(":obt",$paper[$i]['obtain_marks']);
                    $statement->bindParam(":id",$paper[$i]['id']);
                    $statement->execute();
                    if(!$statement){return false;}
                  }
    } catch (Exception $e) {
      echo $e;
    }
    return true;
  }
?>
<?php
  function getAttendanceDb($raw){
  global $conn;
  $dataArray=array();
  try {
          $counter=0;
          $pattern=getPatternDB($raw["subCode"],$raw["term"]);
          $table="atn_".$pattern['id'];
          $sql="SELECT * FROM {$table}";
          $statement=$conn->prepare($sql);
          $statement->execute();
          while ($dataRow=$statement->fetch()) {
                for ($i=0; $i<count($dataRow); $i++) {
                  unset($dataRow[$i]);
                }
                $student=getStudent($dataRow['student_id']);
                $dataRow['name']=$student['name'];
                $dataRow['lastName']=$student['last_name'];
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
  function checkMCQ($raw,$paper){
  global $conn;
  try {
          for ($i=0; $i<count($paper); $i++) {
             if ($paper[$i]['q_type']=='MCQ') {
                $table=$paper[$i]['q_table'];
                $sql="SELECT * FROM {$table} WHERE id=:id";
                $statement=$conn->prepare($sql);
                $statement->bindParam(":id",$paper[$i]['q_id']);
                $statement->execute();
                $que=$statement->fetch();
                if ($que['correct_option']==$paper[$i]['answer']) {
                    $paper[$i]['obtain_marks']=1;
                }else{
                  $paper[$i]['obtain_marks']=0;
                }
             }
          }
          if (savePaperDb($paper,$raw)) {
            return true;
          }
         
          
    } catch (Exception $e) {
      echo $e;
    }
    return $dataArray;
  }
?>
<?php
  function getStudent($id){
  global $conn;
  try {
                $sql="SELECT * FROM user WHERE id=:id";
                $statement=$conn->prepare($sql);
                $statement->bindParam(":id",$id);
                $statement->execute();
                $student=$statement->fetch();
                return $student;
    } catch (Exception $e) {
      echo $e;
    }
  }
?>
<?php
  function deletePaperDB($raw)
  {
    global $conn;
  try {     
            $pattern=getPatternDB($raw["subCode"],$raw["term"]);
            $table="atn_".$pattern['id'];
            $sql="DELETE FROM {$table} WHERE student_id=:id";
            $statement=$conn->prepare($sql);
            $statement->bindParam(":id",$raw['student_id']);
            $statement->execute();
        if ($statement){
            $table="ptn_".$pattern['id']."_std_".$raw['student_id'];
            $sql="DROP TABLE {$table}";
            $statement=$conn->prepare($sql);
            $statement->execute();
          return $statement;
        }
    } catch (Exception $e) {
      echo $e;
    }
    return false;
  }
?>
