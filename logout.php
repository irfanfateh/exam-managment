<?php
  session_start();
  session_destroy();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Logout</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  </head>
  <body>
      <div class="container">
        <div class="row justify-content-center mt-5">
          <div class="col-lg-6 shadow-lg mt-5 p-0">
                <h4 class="p-4 text-white pl-5" style="background-color: #9a57f2;"><i class="fad fa-exclamation-triangle display-4"></i> <span class="ml-4">Sign out</span> </h4>
                <div class="p-3">
                  <p >You have signed out from your current EMS session. All session data has been securely stored and removed from public view, preventing unauthorized access to your information .
                  </p>
                  <p>To complete the sign out process, it is recommended that you please close your Browser Window.</p>
                      <p>Click <a href="login.php" style="color: #9a57f2;font-weight:bold;">Here</a> to Sign In again.</p>
                </div>
                <div class="text-center mb-2">
                  <small>Exam Management System Powered by CodeSolution</small>
                </div>
          </div>
        </div>
      </div>
  </body>
</html>
