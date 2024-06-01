<?php
if(isset($_POST['subject'])){
  require_once("../database/topicDB.php");
  $topicTable=$_POST['subject'];
  $rawArray=getTopicsDB($topicTable);
  $data='<option value="select">select</option>';
  for($i=0;$i<count($rawArray);$i++){
    $topic=$rawArray[$i]["topic_name"];
    $data=$data.'<option value="'.$topic.'">'.$topic.'</option>';
  }
  echo $data;
}
if (isset($_POST['subCode'])) {
	 require_once("../database/paperDB.php");
	 $rawArray=getTermsDB($_POST['subCode']);
	 $data='<option value="select">select</option>';
  	for($i=0;$i<count($rawArray);$i++){
    $term=$rawArray[$i]["term"];
    $data=$data.'<option value="'.$term.'">'.$term.'</option>';
  }
  echo $data;
}
?>
