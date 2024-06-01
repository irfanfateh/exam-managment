<?php
require_once("subjectDB.php");
$conn = new PDO("mysql:host=localhost;dbname=exm_db","root","");
	function getHomeForDB($user_name){
	global $conn;
	try {
          $homeData=array();

					$sql="SELECT COUNT(*)
                    FROM user
                    WHERE user_type='TEACHER';";
					$statement=$conn->prepare($sql);
					$statement->execute();
					$dataRow=$statement->fetch();
					if (!empty($dataRow)){
            $homeData['totalTeacher']=$dataRow['COUNT(*)'];
					}
          $sql="SELECT COUNT(*)
                    FROM user
                    WHERE user_type='STUDENT';";
					$statement=$conn->prepare($sql);
					$statement->execute();
					$dataRow=$statement->fetch();
					if (!empty($dataRow)){
            $homeData['totalStudents']=$dataRow['COUNT(*)'];
					}

          $sql="SELECT COUNT(*)
                    FROM user
                    WHERE user_type='NOT APPROVED';";
					$statement=$conn->prepare($sql);
					$statement->execute();
					$dataRow=$statement->fetch();
					if (!empty($dataRow)){
            $homeData['unApprovedStudents']=$dataRow['COUNT(*)'];
					}
          $sql="SELECT COUNT(*)
                    FROM subjects;";
					$statement=$conn->prepare($sql);
					$statement->execute();
					$dataRow=$statement->fetch();
					if (!empty($dataRow)){
            $homeData['totalSubjects']=$dataRow['COUNT(*)'];
					}
          $sql="SELECT COUNT(*)
                    FROM subjects
                    WHERE assigned_to='NILL';";
					$statement=$conn->prepare($sql);
					$statement->execute();
					$dataRow=$statement->fetch();
					if (!empty($dataRow)){
            $homeData['unAssignSubjects']=$dataRow['COUNT(*)'];
					}
          $sql="SELECT COUNT(*)
                    FROM subjects
                    WHERE assigned_to!='NILL';";
					$statement=$conn->prepare($sql);
					$statement->execute();
					$dataRow=$statement->fetch();
					if (!empty($dataRow)){
            $homeData['assignSubjects']=$dataRow['COUNT(*)'];
					}
          $teachers=getTeacherArrayDB();
          $freeTchrs=0;
          $havingSubjectTchrs=0;
          if(!empty($teachers)){
            for($i=0;$i<count($teachers);$i++){
                        if(!empty(getAssignSubjectFor($teachers[$i]['user_name']))){
                          $havingSubjectTchrs++;
                        } else { $freeTchrs++;}
            }
          }
          $homeData['freeTeachers']=$freeTchrs;
          $homeData['havingSubjectTchrs']=$havingSubjectTchrs;
          return $homeData;

		} catch (Exception $e) {
			echo $e;
		}
		return false;
	}
?>
