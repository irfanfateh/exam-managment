<?php
require_once("database/topicDB.php");
require_once("business/utilities.php");

?>
<?php
  function addTopic(){
    $raw = array(
      'subCode' => $_POST['subCode'],
      'topicName' =>strtoupper($_POST['topicName']),
      'enteredBy' => $_SESSION['actorData']["user_name"],
      'date' => date("Y-m-d")
      );
      if (!isExistTopic($raw) && addTopicDB($raw)){
  			printErrorMsg("added new topic to ".$_POST['subCode'],true);
  		}else{
  			printErrorMsg("system failed to add new topic.",false);
  		}
  }
?>
<?php
  function getTopics(){
      return getTopicsDB(strtolower($_POST['subCode']));
  }
?>
<?php
  function getTopicOf(){
    $data=getTopicOfDB(strtolower($_POST['subCode']) , strtoupper($_POST['topicName']));
    if (!empty($data)){
      $data["subCode"]=$_POST['subCode'];
        return $data;
		}else{
			printErrorMsg("record not found.",false);
		}
  }
?>
<?php
  function updateTopic(){
    $raw = array(
      'oldTopic' => $_POST['updateTopicOldTopic'],
      'topicId' => $_POST['updateTopicID'],
      'subCode' => $_POST['updateTopicSubject'],
      'topicName' =>strtoupper($_POST['updateTopicName']),
      'enteredBy' => $_SESSION['actorData']["user_name"],
      'date' => date("Y-m-d")
      );
      if (updateTopicDB($raw)){
        printErrorMsg("updated topic to ".$_POST['updateTopicSubject'],true);
      }else{
        printErrorMsg("system failed to update topic.",false);
      }
  }
?>
<?php
  function deleteTopic(){
    $raw = array(
      'topicName' =>strtoupper($_POST['updateTopicOldTopic']),
      'topicId' => $_POST['updateTopicID'],
      'subCode' => $_POST['updateTopicSubject']
      );
      if (deleteTopicDB($raw)){
        printErrorMsg("deleted topic from ".$_POST['updateTopicSubject'],true);
      }else{
        printErrorMsg("system failed to add new topic.",false);
      }
  }
?>
