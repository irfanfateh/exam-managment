<?php
require_once("business/student_handler.php");
  if(isset($_POST["submit"])){
      if($_POST["submit"]=="approve"){
        approveStudent();
      }else if($_POST["submit"]=="delete"){
        deleteStudent();
      }
  }
?>
<div class="container shadow-lg p-0">
  <h3 class="p-4 bg-purple text-white"><i class="fad fa-check-circle"></i> Approve Students</h3>
  <div class="bg-white container pb-3">
    <h4 class="p-4">Pending student's request's of registration :</h4>
      <table class="table table-hover table-striped text-center table-bordered text-wrap">
        <thead>
          <tr class="text-white bg-purple">
            <th>Sr#</th>
            <th>Name</th>
            <th>ID</th>
            <th>View</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
      <?php

        $students=getUnApproveSt();
        if(!empty($students)){
            for($i=0;$i<count($students);$i++){
              $row=$students[$i]; ?>
              <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo $row["name"]." ".$row["last_name"]; ?></td>
                <td><?php echo $row["user_name"]; ?></td>
                <td><?php echo '<img src="data:image/jpeg;base64,'.base64_encode($row['image']).'"  style="width:100px; height:inherit;" />';  ?></td>
                <td>
                  <form class="" action="?pageName=approvals" method="post">
                    <input type="hidden" name="id" value="<?php echo $row["user_name"];  ?>"/>
                    <button type="submit" class="btn btn-success" name="submit" value="approve" >Approve</button>
                    <button type="submit" class="btn btn-danger"  name="submit" value="delete">Delete</button>
                  </form>
                </td>
              </tr>
          <?php	}} else{
            echo '</tbody></table> <div class="text-center bg-light">
                <span>Record not found</span>
              </div>';
          }
           ?>
          </tbody>
          </table>
  </div>

</div>
