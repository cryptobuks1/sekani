<?php

$page_title = "Branch";
$destination = "index.php";
    include("header.php");

?>
<?php
          if (isset($_GET["message"])) {
            $key = $_GET["message"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
              echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "success",
                            title: "Success",
                            text: "Teller Created Successfully",
                            showConfirmButton: false,
                            timer: 2000
                        })
                    });
                    </script>
                    ';
              $_SESSION["lack_of_intfund_$key"] = 0;
            }
          }else if (isset($_GET["message2"])) {
            $key = $_GET["message2"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
              echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Error",
                        text: "Error in Posting For Approval",
                        showConfirmButton: false,
                        timer: 2000
                    })
                });
                </script>
                ';
            $_SESSION["lack_of_intfund_$key"] = 0;
            }
          }
        ?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <!-- <span class="nav-tabs-title">Staff Management:</span> -->
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <!-- <li class="nav-item">
                          <a class="nav-link active" href="#profile" data-toggle="tab">
                            <i class="material-icons">bug_report</i> Password Settings
                            <div class="ripple-container"></div>
                          </a>
                        </li> -->
                        <li class="nav-item">
                          <a class="nav-link active" href="#messages" data-toggle="tab">
                            <i class="material-icons">people</i> Users
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#products" data-toggle="tab">
                            <i class="material-icons">visibility</i> Roles
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#per" data-toggle="tab">
                            <i class="material-icons">visibility_off</i> Access Permissions
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#teller" data-toggle="tab">
                            <i class="material-icons">account_balance_wallet</i> Teller
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="messages">
                    <a href="user.php" class="btn btn-primary"> Create new User</a>
                    <div class="table-responsive">
                    <table id="tabledat2" class="table" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT users.id, users.int_id, display_name, users.username, staff.int_name, staff.email, users.status, staff.employee_status FROM staff JOIN users ON users.id = staff.user_id WHERE users.int_id ='$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>
                          Display Name
                        </th>
                        <th>
                          Username
                        </th>
                        <th>
                          Insitution
                        </th>
                        <th>
                          E-mail
                        </th>
                        <th>Active</th>
                        <th>Employee Status</th>
                        <th>Action</th>
                        <th>Edit</th>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["display_name"]; ?></th>
                          <th><?php echo $row["username"]; ?></th>
                          <th><?php echo $row["int_name"]; ?></th>
                          <th><?php echo $row["email"]; ?></th>
                          <th><?php echo $row["status"]; ?></th>
                          <th><?php echo $row["employee_status"]; ?></th>
                          <th>
                          <label class="switch">
                                <input type="checkbox" name="employee_status[]" value="<?php echo $row["employee_status"]; ?>">
                                <span class="slider round"></span>
                              </label>
                              <script>
                                var button = new Ext.button({
                                  text: 'test',
                                  enableToggle: true,
                                  stateful: true
                              });
                              
                              button.getState = function() {
                                  if (this.enableToggle == true) {
                                      var config = {};
                                      config.pressed = this.pressed;
                                      return config;
                                  }
                                  return null;
                              }
                                </script>
                          </th>
                          <!-- <a href="update_user.php?edit=<?php echo $row["id"];?>"><form action="../functions/update_staff.php"><label class="switch">
                                <input type="checkbox" name="employee_status" value="<?php echo $row["employee_status"]; ?>">
                                <span class="slider round"></span>
                              </label>
                              </form>
                              </a> -->
                          <td><a href="update_user.php?edit=<?php echo $row["id"];?>" class="btn btn-info">Edit</a></td>
                        </tr>
                        <?php }
                          }
                        //   else {
                        //     echo "0 Staff";
                        //   }
                          ?>
                      </tbody>
                    </table>
                  </div>
                    </div>
                    <div class="tab-pane" id="products">
                      <!-- <a href="role.php" class="btn btn-primary"> Create New Role</a> -->
                      <?php
                    // we are gonna post to get the name of the button
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                      // check the button value
                      $role = $_POST['submit'];
                      $update_role = $_POST['update_role'];
                      if ($role == 'role') {
                        $r_n = $_POST["role_name"];
                        $r_d = $_POST["descript"];
                        // check if this role exists
                        $selectrole = mysqli_query($connection, "SELECT * FROM org_role WHERE int_id = '$sessint_id' && role = '$r_n'");
                        $cs = mysqli_num_rows($selectrole);
                        if ($cs == 0 || $cs == "0") {
                          $getrole = "INSERT INTO `org_role` (`int_id`, `role`, `description`) VALUES ('{$sessint_id}', '{$r_n}', '{$r_d}')";
                        $MIB = mysqli_query($connection, $getrole);
                        if ($MIB) {
                          // echo success
                          echo '<script type="text/javascript">
                     $(document).ready(function(){
                         swal({
                             type: "success",
                             title: "Role Created",
                             text: " Created Successfully",
                             showConfirmButton: false,
                             timer: 2000
                         })
                     });
                     </script>
                     ';
                        } else {
                          // echo error
                          echo '<script type="text/javascript">
                     $(document).ready(function(){
                         swal({
                             type: "error",
                             title: "Error During Creation",
                             text: "Couldnt Create",
                             showConfirmButton: false,
                             timer: 2000
                         })
                     });
                     </script>
                     ';
                        }
                        }
                        else {
                          // echo something
                          echo '<script type="text/javascript">
                     $(document).ready(function(){
                         swal({
                             type: "error",
                             title: "(*_*)",
                             text: "Role Exists Already",
                             showConfirmButton: false,
                             timer: 2000
                         })
                     });
                     </script>
                     ';
                        }
                      } else if ($update_role == 'update_role') {
                        // If its an update
                        // do something
                      } else {
                        // echo no add or update
                      }
                    } else {
                      echo "";
                    }
                    ?>
                      <div class="card-title">Create A Role</div>
                      <br>
                      <form method="POST">
                          <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Role Name</label>
                                <input type="text" name="role_name" id="" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">Description</label>
                                <input type="text" name="descript" id="" class="form-control">
                            </div> 
                          </div>
                          <!-- use if statements to print permission definitions -->
                        <button type="submit" value="role" name="submit" class="btn btn-primary pull-right">Create New Role</button>
                      </form>
                      <!-- A new stuff -->
                  <div class="table-responsive">
                  <script>
                  $(document).ready(function() {
                  $('#tabledat4').DataTable();
                  });
                  </script>
                  <br>
                  <div class="card-title">Role List</div>
                    <table id="tabledat4" class="table" style="width: 100%;">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM org_role WHERE int_id ='$sessint_id' ORDER BY id ASC";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>Name</th>
                        <th>
                          Description
                        </th>
                        <th>
                          Edit
                        </th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo strtoupper($row["role"]); ?></th>
                          <th><?php echo $row["description"]; ?></th>
                          <td><a href="update_product.php?edit=<?php echo $row["id"];?>" class="btn btn-info">Edit</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                    </table>
                  </div>
                    </div>
                    <!-- /roles -->
                    <div class="tab-pane" id="per">
                      <div class="card-title">Permissions</div>
                        <button data-toggle="modal" data-target="#exampleModal" class="btn btn-primary pull-left">Add Permission</button>
                      <!-- form of staff -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Permission to a Staff</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="../functions/client_update.php" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
               <label class="bmd-label-floating">Role</label>
               <input type="text" style="text-transform: uppercase;" class="form-control">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
               <label class="bmd-label-floating">Staff</label>
               <input type="text" style="text-transform: uppercase;" class="form-control">
              </div>
            </div>
           <!-- Next -->
           <div class="col-md-12">
           </div>
           <div class="col-md-12">
             <span>Permission</span>
           </div>
           <div class="col-md-12">
             <div>
               <p>
               <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="0" name="sms_active" id="all">
                Check All
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <br>
               </p>
             </div>
           </div>
           <!-- Javascript for the code -->
           <script>
             $(document).ready(function () {
               $('#all').change(function () {
                if ($(this).is(':checked')) {
                  document.getElementById('n1').checked = true;
                  document.getElementById('n2').checked = true;
                  document.getElementById('n3').checked = true;
                  document.getElementById('n4').checked = true;
                  document.getElementById('n5').checked = true;
                  document.getElementById('n6').checked = true;
                  document.getElementById('n7').checked = true;
                  document.getElementById('n8').checked = true;
                } else {
                  document.getElementById('n1').checked = false;
                  document.getElementById('n2').checked = false;
                  document.getElementById('n3').checked = false;
                  document.getElementById('n4').checked = false;
                  document.getElementById('n5').checked = false;
                  document.getElementById('n6').checked = false;
                  document.getElementById('n7').checked = false;
                  document.getElementById('n8').checked = false;
                }
               });
             })
           </script>
           <!-- End of Javascript for the codes -->
            <!-- for the permission -->
            <div class="col-md-5">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="sms_active" id="n1">
                Approve Transaction
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <!-- Next -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="sms_active" id="n2">
                Post Transaction
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <!-- Next -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="sms_active" id="n3">
                Access Configuration
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <!-- Last -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="sms_active" id="n4">
                Approve Loan
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
            </div>
            <!-- Another -->
            <div class="col-md-5">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="sms_active" id="n5">
                Approve Account
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <!-- Next -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="sms_active" id="n6">
                Vault Transaction
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <!-- Next -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="sms_active" id="n7">
                View Report
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <!-- Last -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="sms_active" id="n8">
                Dashboard
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
            </div>
            <!-- End for Permission -->
        </div>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
                      <!-- Table Below -->
                      <div class="table-responsive">
                  <script>
                  $(document).ready(function() {
                  $('#tabledat1').DataTable();
                  });
                  </script>
                  <br>
                  <div class="card-title">Create Permission to Staff</div>
                    <table id="tabledat1" class="table" style="width: 100%;">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT staff.id, permission.trans_appv, permission.trans_post, permission.loan_appv, permission.acct_appv, permission.valut, permission.view_report, permission.view_dashboard, permission.configuration, staff.first_name, staff.last_name, staff.org_role, staff.employee_status FROM staff JOIN permission ON staff.id = permission.staff_id WHERE staff.int_id = '$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>Fullname</th>
                        <th>Role</th>
                        <th>Approve Transaction</th>
                        <th>Post Transaction</th>
                        <th>Approve Loan</th>
                        <th>Approve Account</th>
                        <th>vault Transaction</th>
                        <th>View Report</th>
                        <th>Dashboard</th>
                        <th>Access Config.</th>
                        <th>Status</th>
                        <th>
                          Edit
                        </th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo strtoupper($row["first_name"] . ' ' . $row["last_name"]); ?></th>
                          <?php
                          // display role name
                          $role_id = $row["org_role"];
                          $getrole = mysqli_query($connection, "SELECT * FROM org_role WHERE id = '$role_id'");
                          $xm = mysqli_fetch_array($getrole);
                          // nexr
                          $role_name = $xm["name"];
                          ?>
                          <th><?php echo $role_name; ?></th>
                          <th>
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="<?php echo $sms_active;?>" name="sms_active" id="sms">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                          </th>
                          <th>
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="<?php echo $sms_active;?>" name="sms_active" id="sms">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                          </th>
                          <th>
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="<?php echo $sms_active;?>" name="sms_active" id="sms">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                          </th>
                          <th>
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="<?php echo $sms_active;?>" name="sms_active" id="sms">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                          </th>
                          <th>
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="<?php echo $sms_active;?>" name="sms_active" id="sms">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                          </th>
                          <th>
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="<?php echo $sms_active;?>" name="sms_active" id="sms">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                          </th>
                          <th>
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="<?php echo $sms_active;?>" name="sms_active" id="sms">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                          </th>
                          <th>
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="<?php echo $sms_active;?>" name="sms_active" id="sms">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                          </th>
                          <th><?php echo $row["employee_status"]; ?></th>
                          <td><button class="btn btn-info">Update</button></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                    </table>
                  </div>
                    </div>
                    <!-- /permission -->
                    <div class="tab-pane" id="teller">
                      <a href="create_teller.php" class="btn btn-primary"> Create New Teller</a>
                      <div class="table-responsive">
                  <script>
                  $(document).ready(function() {
                  $('#tabledat4').DataTable();
                  });
                  </script>
                    <table id="tabledat4" class="table" style="width: 100%;">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM tellers WHERE int_id ='$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          Branch
                        </th>
                        <th>
                          Staff
                        </th>
                        <th>
                          Description
                        </th>
                        <th>
                          Till Number
                        </th>
                        <th>Balance</th>
                        <th></th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                        <?php
                          // tellers
                          // end of tellers
                          // $nom = $row["till_no"];
                          // $cll = strlen($nom);
                          // $rest = substr("$nom", 0, -1);
                          $staff2 = $row["branch_id"];
                          $checking3 = "SELECT * FROM `branch` WHERE id ='$staff2'";
                          $done3 = mysqli_query($connection, $checking3);
                          $men3 = mysqli_fetch_array($done3);
                          $brc = $men3["name"];
                          ?>
                          <th><?php echo $brc; ?></th>
                          <?php
                          // tellers
                          // end of tellers
                          // $nom = $row["till_no"];
                          // $cll = strlen($nom);
                          // $rest = substr("$nom", 0, -1);
                          $staff= $row["name"];
                          $checking2 = "SELECT * FROM `staff` WHERE id ='$staff'";
                          $done2 = mysqli_query($connection, $checking2);
                          $men2 = mysqli_fetch_array($done2);
                          $name = $men2["display_name"];
                          ?>
                          <th><?php echo $name; ?></th>
                          <th><?php echo $row["description"]; ?></th>
                          <th><?php echo $row["till_no"]; ?></th>
                          <?php
                          // tellers
                          // end of tellers
                          // $nom = $row["till_no"];
                          // $cll = strlen($nom);
                          // $till = $row["till"];
                          // $checking = "SELECT * FROM `acc_gl_account` WHERE gl_code ='$till'";
                          // $done = mysqli_query($connection, $checking);
                          // $men = mysqli_fetch_array($done);
                          // $bal = $men["organization_running_balance_derived"];
                          // $rest = substr("$nom", 0, -1);
                          $till = $row["name"];
                          $checking = "SELECT * FROM `institution_account` WHERE teller_id ='$till' && int_id = '$sessint_id'";
                          $done = mysqli_query($connection, $checking);
                          $men = mysqli_fetch_array($done);
                          $bal = number_format($men["account_balance_derived"], 2);
                          ?>
                          <th><?php echo $bal; ?></th>
                          <th><button class="btn btn-success">View</button></th>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                    </table>
                  </div>
                    <!-- /teller -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- / -->
        </div>
      </div>

<?php

    include("footer.php");

?>