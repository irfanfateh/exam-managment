<div class="container shadow-lg p-0 mb-3">
  <h3 class="p-4 bg-purple text-white"><i class="fad fa-angel"></i> Quick access</h3>
  <div class="bg-white container pb-3">
    <a href="?pageName=addquiz&tab=addq" class="btn py-3 px-5"><i class="far fa-question-circle display-4"></i>
    <h5 class="pt-2">Add Quiz</h5>
    </a>
    <a href="?pageName=addquiz&tab=topic" class="btn"><i class="far fa-layer-group display-4"></i>
    <h5 class="pt-2">Add Topic</h5>
    </a>
    <a href="?pageName=notification&tab=anounce" class="btn"><i class="fas fa-bullhorn display-4"></i>
    <h5 class="pt-2">Make Announcement</h5>
    </a>
    <a href="?pageName=paper&tab=make" class="btn"><i class="fad fa-paste display-4"></i>
    <h5 class="pt-2">Create Paper</h5>
    </a>
    <a href="?pageName=notification&tab=result" class="btn"><i class="fas fa-poll display-4"></i>
    <h5 class="pt-2">Declare Result</h5>
    </a>
    <a href="?pageName=approvals" class="btn"><i class="fad fa-user-graduate display-4"></i>
    <h5 class="pt-2">Approve student</h5>
    </a>
    <h4 class="p-4">You have these courses :</h4>
      <table class="table table-hover table-striped text-center table-bordered text-wrap">
        <thead>
          <tr class="text-white bg-purple">
            <th>Sr#</th>
            <th>Subject Code</th>
            <th>Subject Name</th>
          </tr>
        </thead>
        <tbody>
      <?php
        $subject=getAssignSubjects();
        if(!empty($subject)){
            for($i=0;$i<count($subject);$i++){
              $row=$subject[$i]; ?>
              <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo $row["subject_code"]; ?></td>
                <td><?php echo $row["subject_name"]; ?></td>
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
