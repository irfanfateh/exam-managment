<?php
require_once("database/announcementDB.php");
require_once("business/utilities.php");

  function addAnnouncement(){
    $raw = array(
      'title' => ucwords($_POST['announcementTitle']),
      'detail' => ucfirst($_POST['announcementDetail']),
      'date' =>$_POST['announcementDate'],
      'enteredBy' => $_SESSION['actorData']["user_name"]
      );
      if (addAnnouncementDB($raw)){
  			printErrorMsg("added new announcement ",true);
  		}else{
  			printErrorMsg("system failed to add announcement.",false);
  		}
  }
?>
<?php
  function getAnnouncementOf(){
    $data=getAnnouncementOfDB(ucwords($_POST['searchAnnouncementTitle']));
    if (!empty($data)){
        return $data;
		}else{
			printErrorMsg("record not found.",false);
		}
  }
?>
<?php
  function updateAnnouncement(){
    $raw = array(
      'title' => ucwords($_POST['updateAnnouncementTitle']),
      'id' => ucwords($_POST['announcementId']),
      'detail' => ucfirst($_POST['updateAnnouncementDetail']),
      'date' =>$_POST['updateAnnouncementDate'],
      'enteredBy' => $_SESSION['actorData']["user_name"]
      );
      if (updateAnnouncementDB($raw)){
        printErrorMsg("updated new announcement ",true);
      }else{
        printErrorMsg("system failed to add announcement.",false);
      }
  }
?>
<?php
  function deleteAnnouncement(){
    $id=$_POST['announcementId'];
      if (deleteAnnouncementDB($raw)){
        printErrorMsg("deleted announcement.",true);
      }else{
        printErrorMsg("system failed to delete announcement.",false);
      }
  }
?>
<?php
  function updateResult($result){
    $raw=array(
    'subCode'=>$_POST['resultSubCode'],
    'term'=>$_POST['resultTerm'],
    'result'=>$result
    );
      if (updateResultDB($raw)){
        printErrorMsg("result declaration updated .",true);
      }else{
        printErrorMsg("system failed to update result declaration.",false);
      }
  }
?>

