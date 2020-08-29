<?php

$page_title = "Alert";
$destination = "../index.php";
    include("header.php");
    // include("../../functions/connect.php");

?>

<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Alert</h4>
                  
                  <!-- Insert number users institutions -->
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                        <tr>
                          <th></th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th>E-mail</th>
                          <th>Manage E-mail Content</th>
                          <td><a href="#" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                        </tr>
                        <tr>
                          <th>SMS</th>
                          <th>Manage SMS</th>
                          <td><a href="alerts_sms.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php

    include("footer.php");

?>