<?php
require_once("database/paperDB.php");
require_once("database/topicDB.php");
require_once("database/subjectDB.php");
require_once("business/utilities.php");
?>
<?php
  function addPaper(){
    $raw = array(
      'subCode' => $_POST['subCode'],
      'paperTerm' =>strtoupper($_POST['paperTerm']),
      'paperOpDate' =>strtoupper($_POST['paperOpDate']),
      'paperLDate' =>strtoupper($_POST['paperLDate']),
      'paperTMarks' =>strtoupper($_POST['paperTMarks']),
      'paperNMcq' =>strtoupper($_POST['paperNMcq']),
      'paperNShort' =>strtoupper($_POST['paperNShort']),
      'paperNLong' =>strtoupper($_POST['paperNLong']),
      'result' =>"false",
      'paperTime' =>strtoupper($_POST['paperTime'])
      );

    if(checkPattern($raw)){
	    		if (!isExistPaperPattern($raw) && addPaperDB($raw)){
	  					printErrorMsg("added new paper pattern.",true);
			  		}else{
			  			printErrorMsg("system failed to add new paper pattern.",false);
			  		}
    	}
    	
      
  }
?>

<?php
  function checkPattern($raw){

		$subject=getSubject($raw['subCode']);
  		$topics=getTopicsDB($raw['subCode']);
    	$nMcq=0; $nShort=0; $nLong=0;
    	for ($i=0; $i<count($topics); $i++) {
    		$questionTable='sub_'.$subject['id'].'_tp_'.$topics[$i]['id'];
    		$counts=getQuestionsCount($questionTable);
    		$nMcq+=$counts["mcq"];
    		$nShort+=$counts["short"];
    		$nLong+=$counts["long"];
    	}
    	if ($raw["paperNMcq"] > $nMcq) {
    		printErrorMsg("There is not enough mcqs questions in database.",false);
    	}else if ($raw["paperNShort"]>$nShort) {
    		printErrorMsg("There is not enough short questions in database.",false);
    	}else if ($raw["paperNLong"]>$nLong) {
    		printErrorMsg("There is not enough long questions in database.",false);
    	}else{
	    		return true;
    	}
  	}
?>

<?php
  function getPattern(){

       $data=getPatternDB($_POST['patternSearchSubCode'],$_POST['patternSearchTerm']);
      if (!empty($data)){
        return $data;
		}else{
			printErrorMsg("record not found.",false);
		}
  }
?>
<?php
  function updatePattern(){
    $raw = array(
    	'id' => $_POST['updatePatternID'],
      'subCode' => $_POST['patternUpdateSubCode'],
      'paperTerm' =>strtoupper($_POST['updateTerm']),
      'paperOpDate' =>strtoupper($_POST['updatePatternOpDate']),
      'paperLDate' =>strtoupper($_POST['updatePatternLDate']),
      'paperTMarks' =>strtoupper($_POST['updatePatternTMarks']),
      'paperNMcq' =>strtoupper($_POST['updatePatternNMcq']),
      'paperNShort' =>strtoupper($_POST['updatePatternNShort']),
      'paperNLong' =>strtoupper($_POST['updatePatternNLong']),
      'paperTime' =>strtoupper($_POST['updatePatternTime'])
      );
    if(checkPattern($raw)){
			      if (updatePatternDB($raw)){
			        printErrorMsg("updated pattern to ".$_POST['updateTerm'],true);
			      }else{
			        printErrorMsg("system failed to update paper pattern.",false);
			      }
  		}
  }
?>
<?php
  function deletePattern(){
      if (deletePatternDB($_POST['updatePatternID'])){
        printErrorMsg("deleted paper pattern ",true);
      }else{
        printErrorMsg("system failed to delete paper pattern.",false);
      }
  }
?>
<?php
  function createPaper(){
  	$raw=array(
  		'subCode'=>$_POST['subCode'],
  		'term'=>$_POST['term'],
  		'student_id'=>$_SESSION['actorData']["id"],
  		'date'=> date("Y-m-d")
  	);

  	$pattern=getPatternDB($raw["subCode"],$raw["term"]);
  	$paper=array();
      if (!empty($pattern)){
				$subject=getSubject($raw['subCode']);
        		$topics=getTopicsDB($raw['subCode']);
		    	$nMcq=array(); $nShort=array(); $nLong=array();
		    	for ($i=0; $i<count($topics); $i++) {
    				$queTable='sub_'.$subject['id'].'_tp_'.$topics[$i]['id'];
		    		$counts=getQuestionsCount($queTable);
		    		if($counts["mcq"]!=0) {
		    			$nMcq[$i]=array("table"=>$queTable,"count"=>$counts["mcq"]);
		    		}
		    		if($counts["short"]!=0) {
		    			$nShort[$i]=array("table"=>$queTable,"count"=>$counts["short"]);
		    		}
		    		if($counts["long"]!=0) {
		    			$nLong[$i]=array("table"=>$queTable,"count"=>$counts["long"]);
		    		}
		    	}
		    	$remaining=$pattern['n_mcq'];
		    	while ($remaining!=0) {
		    		$remaining=questionSelection($remaining,$nMcq,'MCQ',$paper);
		    	}
		    	$remaining=$pattern['n_short'];
		    	while ($remaining!=0) {
		    		$remaining=questionSelection($remaining,$nShort,'3',$paper);
		    	}
		    	$remaining=$pattern['n_long'];
		    	while ($remaining!=0) {
		    		$remaining=questionSelection($remaining,$nLong,'5',$paper);
		    	}

		    	
		    	if (!isAttempted($raw,'submitted')) {
		    		if(makeStudentPaper($raw,$paper) && makePaperAttendence($raw,"started")){
		    			getQuestionsInfo($paper);
		    			$raw['total_marks']=$pattern['total_marks'];
		    			$raw['time']=$pattern['time'];
		    			$data[0]=$raw;
		    			$data[1]=$paper;
		    			return $data;
			    	}else{
							printErrorMsg("paper not found please contact with your subject teacher.",false);
					}
		    	}else {
		    		printErrorMsg("You have attempted your paper of this term of particular subject.",false);	
		    		return false;
		    	}
		    	
		    	
		    	
		}else{
			printErrorMsg("paper not found please contact with your subject teacher.",false);
		}
  }
?>
<?php
  function questionSelection($patternNoQuiz,$dbTopics,$dbType,&$paper){
  		$topics=count($dbTopics);
		if ($topics>$patternNoQuiz) {
			$num=array();
			while (count($num)!=$patternNoQuiz) {
				$num[]=rand(0,$topics-1);
			}
			for($i=0; $i<count($num); $i++) { 
				$questionsId=getQuesFromTable($dbTopics[$num[$i]]["table"],1,$dbType);
		    	$paper[]=array("q_id"=>$questionsId[0],"q_table"=>$dbTopics[$num[$i]]["table"],"q_type"=>$dbType);
		    	$patternNoQuiz--;
			}
			return $patternNoQuiz;
		}else if ($topics<=$patternNoQuiz) {
			$remaining=$patternNoQuiz%$topics;
		    $ratio=ceil(($patternNoQuiz-$remaining)/$topics);
		    if($ratio!=0) { // when pattern have less ques than topics
		    			for ($i=0; $i<$topics;$i++) {
				    				if($dbTopics[$i]["count"]<=$ratio){
				    					$remaining+=$ratio-$dbTopics[$i]["count"];
				    					$questionsId=getQuesFromTable($dbTopics[$i]["table"],$dbTopics[$i]["count"],$dbType);
				    				}else if($dbTopics[$i]["count"]>$ratio){
				    					$questionsId=getQuesFromTable($dbTopics[$i]["table"],$ratio,$dbType);
				    				}
	    					$questionTable=$dbTopics[$i]["table"];
	    					for($x=0; $x<count($questionsId); $x++) { 
	    						$paper[]=array("q_id"=>$questionsId[$x],"q_table"=>$questionTable,"q_type"=>$dbType);
	    					}
		    				
		    			}
		    }
		    return $remaining;
		}
		
  	}
?>

<?php
  function savePaper(){
  	$raw=array(
  		'subCode'=>$_POST['subCode'],
  		'term'=>$_POST['term'],
  		'student_id'=>$_SESSION['actorData']["id"],
  		'date'=> date("Y-m-d")
  	);
  	// var_dump($raw);
  	$paper=getPaperDb($raw);
  	for ($i=0; $i<count($paper); $i++) {
  		if (isset($_POST[$paper[$i]['id']])) {
  			$paper[$i]['answer']=$_POST[$paper[$i]['id']];
  		}
  	}
  	if (makePaperAttendence($raw,'submitted') && checkMCQ($raw,$paper)) {
  		return true;
  	}
  	return false;
}
?>
<?php
  function getAttendance(){
  	$raw=array(
  		'subCode'=>$_POST['subCode'],
  		'term'=>$_POST['term']
  	);
  	$data[0]=getAttendanceDb($raw);
  	if (empty($data[0])) {
		printErrorMsg("there is no student.",false);
  		return false;
  	}
  	$temp['subCode']=$raw['subCode'];
  	$temp['term']=$raw['term'];
  	$data[1]=$temp;
  	return $data;
}
?>
<?php
  function getPaperForChecks(){
  	$raw=array(
  		'subCode'=>$_POST['subCode'],
  		'term'=>$_POST['term'],
  		'student_id'=>$_POST['stdId']
  	);
  	if (isAttempted($raw,'submitted')) {
		  	$paper=getPaperDb($raw);
		  	$obtain_marks=0;
		  	$indexes=array();
		  	for ($i=0; $i<count($paper); $i++) { 
		  			if($paper[$i]['q_type']=='MCQ'){
		  				$obtain_marks+=$paper[$i]['obtain_marks'];
		  				$indexes[]=$i;
		  			}
		  	}
		  	for ($i=0; $i<count($indexes); $i++) { 
		  		unset($paper[$indexes[$i]]);
		  	}
		  	$paper=array_values($paper);
		  	getQuestionsInfo($paper);
		  	$pattern=getPatternDB($raw['subCode'],$raw['term']);
		  	$student=getStudent($raw['student_id']);
		  	$pattern['obtain_marks']=$obtain_marks;
		  	$pattern['name']=$student['name'];
		  	$pattern['last_name']=$student['last_name'];
		  	$pattern['student_id']=$student['id'];
		  	$data[]=$pattern;
			$data[]=$paper;
		  	
		  	return $data;
  	}else{
				printErrorMsg("there is no such student.",false);
  	}
}
?>
<?php
  function checkedPaper(){
  	$raw=array(
  		'subCode'=>$_POST['subCode'],
  		'term'=>$_POST['term'],
  		'student_id'=>$_POST['student_id']
  	);
  	$paper=getPaperDb($raw);
  	for ($i=0; $i<count($paper); $i++) {
  		if ($paper[$i]['q_type']!='MCQ') {
  			$paper[$i]['obtain_marks']=$_POST[$paper[$i]['id']];
  		}
  	}
  	if (savePaperDb($paper,$raw) && makePaperAttendence($raw,'checked')) {
				printErrorMsg("paper checked & saved into database.",true);
				return true;
  	}
				printErrorMsg("system failed to save checked paper into database.",false);
}
?>
<?php
  function getResult(){
  	$raw=array(
  		'subCode'=>$_POST['subCode'],
  		'term'=>$_POST['term'],
  		'student_id'=>$_SESSION['actorData']["id"]
  	);
  	$pattern=getPatternDB($raw['subCode'],$raw['term']);
	  	if($pattern['result']=='true'){
	  	$paper=getPaperDb($raw);
	  	if (empty($paper)) {
					printErrorMsg("system failed to show you result try again later!",false);
					return false;
	  	}
	  	$obtain_marks=0;
	  	for ($i=0; $i<count($paper); $i++) {
	  		$obtain_marks+=$paper[$i]['obtain_marks'];
	  	}
	  	$data['obtain_marks']=$obtain_marks;
	  	$data['total_marks']=$pattern['total_marks'];
	  	$data['subject']=$raw['subCode'];
	  	$data['term']=$raw['term'];
	  	return $data;
	  }else{
					printErrorMsg("The result of selected term is not declared yet!",false);
					return false;
	  }
}
?>
<?php
  function deleteAttendance(){
  	$raw=array(
  		'subCode'=>$_POST['subCode'],
  		'term'=>$_POST['term'],
  		'student_id'=>$_POST['id']
  	);
  	if (deletePaperDB($raw)){
        printErrorMsg("deleted student paper and attendance.",true);
      }else{
        printErrorMsg("system failed to delete paper.",false);
      }
}
?>