<?php
require_once("database/questionDB.php");
require_once("business/utilities.php");
?>
<?php
  function addMcq(){
    $raw = array(
      'subCode' => $_POST['addMcqSubject'],
      'topicName' => $_POST['addMcqTopic'],
      'type' => "MCQ",
      'que' => $_POST['addMcqStatement'],
      'optA' => $_POST['addMcqOptA'],
      'optB' => $_POST['addMcqOptB'],
      'optC' => $_POST['addMcqOptC'],
      'optD' => $_POST['addMcqOptD'],
      'correct' => $_POST['addMcqOptCorrect']
      );
      if (addMcqDB($raw)){
  			printErrorMsg("added new question to ".$_POST['addMcqTopic'],true);
  		}else{
  			printErrorMsg("system failed to add new topic.",false);
  		}
  }
?>
<?php
  function addSubjective(){
    $raw = array(
      'subCode' => $_POST['addSubjectiveSub'],
      'topicName' => $_POST['addSubjectiveTopic'],
      'type' => $_POST['addSubjectiveMarks'],
      'que' => $_POST['addSubjectiveStatement']
      );
      if (addSubjectiveDB($raw)){
  			printErrorMsg("added new question to ".$_POST['addSubjectiveTopic'],true);
  		}else{
  			printErrorMsg("system failed to add new topic.",false);
  		}
  }
?>
<?php
  function getQuizOf(){
    $raw = array(
      'subCode' => $_POST['updateQuizSubject'],
      'topicName' => $_POST['updateQuizTopic'],
      'type' => $_POST['updateQuizType'],
      'que' => $_POST['updateQuizStatement']
      );
    $data=getQuizOfDB($raw);
		if (!empty($data)){
			$data["subCode"]=$_POST['updateQuizSubject'];
			$data["topicName"]=$_POST['updateQuizTopic'];
				return $data;
		}else{
			printErrorMsg("record not found.",false);
		}
  }
?>
<?php
  function getQuizesOf(){
    $raw = array(
      'subCode' => $_POST['viewQuizSubject'],
      'topicName' => $_POST['viewQuizTopic'],
      'type' => $_POST['viewQuizType']
      );
    $data=getQuizesOfDB($raw);
				return $data;
  }
?>
<?php
  function updateMcq(){
    $raw = array(
      'topicName' => $_POST['updateQuizOldTopic'],
      'subCode' => $_POST['updateQuizOldSub'],
      'id' => $_POST['quizId'],
      'quiz' => $_POST['updateMcqReStatement'],
      'optA' => $_POST['updateMcqReOptA'],
      'optB' => $_POST['updateMcqReOptB'],
      'optC' => $_POST['updateMcqReOptC'],
      'optD' => $_POST['updateMcqReOptD'],
      'correctOpt' => $_POST['updateQuizOptCorrect']
      );
      if (updateMcqDB($raw)){
        printErrorMsg("updated question to ".$_POST['updateQuizOldTopic'],true);
      }else{
        printErrorMsg("system failed to add new topic.",false);
      }
  }
?>
<?php
  function updateSubQuiz(){
    $raw = array(
      'topicName' => $_POST['updateQuizOldTopic'],
      'subCode' => $_POST['updateQuizOldSub'],
      'id' => $_POST['quizId'],
      'type' => $_POST['updateSubReMarks'],
      'quiz' => $_POST['updateSubReStatement']
      );
      if (updateSubqUizDB($raw)){
        printErrorMsg("updated question to ".$_POST['updateQuizOldTopic'],true);
      }else{
        printErrorMsg("system failed to add new topic.",false);
      }
  }
?>
<?php
  function deleteQuiz(){

    $raw = array(
      'topicName' => $_POST['updateQuizOldTopic'],
      'subCode' => $_POST['updateQuizOldSub'],
      'oldQuiz' => $_POST['updateQuizOldStatement']
      );
      if (deleteQuizDB($raw)){
        printErrorMsg("deleted question from ".$_POST['updateQuizOldTopic'],true);
      }else{
        printErrorMsg("system failed to add new topic.",false);
      }
  }
?>
