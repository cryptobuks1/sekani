<?php

$page_title = "Pending Client";
$destination = "client.php";
    include("header.php");

?>
<?php
if(isset($_GET["edit"])) {
  $id = $_GET["edit"];
  $update = true;
  $person = mysqli_query($connection, "SELECT * FROM client WHERE id='$id' && int_id='$sessint_id'");

  if (count([$person]) == 1) {
    $n = mysqli_fetch_array($person);
    $vd = $n['id'];
    $ctype = $n['client_type'];
    $acct_type = $n['account_type'];
    $account_no = $n['account_no'];
    $display_name = $n['display_name'];
    $first_name = $n['firstname'];
    $middle_name = $n['middlename'];
    $account_officer = $n['loan_officer_id'];
    $checkl = "SELECT * FROM staff WHERE user_id = '$account_officer'";
    $resxx = mysqli_query($connection, $checkl);
    $xf = mysqli_fetch_array($resxx);
    $acctn = strtoupper($xf['first_name'] ." ". $xf['last_name']);
    $last_name = $n['lastname'];
    $phone = $n['mobile_no'];
    $phone2 = $n['mobile_no_2'];
    $email = $n['email_address'];
    $address = $n['ADDRESS'];
    $gender = $n['gender'];
    $date_of_birth = $n['date_of_birth'];
    $branch = $n['branch_id'];
    $checkli = "SELECT * FROM branch WHERE id = '$branch'";
    $resx = mysqli_query($connection, $checkli);
    $xfc = mysqli_fetch_array($resx);
    $bname = $xfc['name'];
    $country = $n['COUNTRY'];
    $state = $n['STATE_OF_ORIGIN'];
    $lga = $n['LGA'];
    $bvn = $n['BVN'];
    $sms_active = $n['SMS_ACTIVE'];
    $email_active = $n['EMAIL_ACTIVE'];
    $id_card = $n['id_card'];
    // These extra array is to put whatever is in DB but not being used
    $passport = $n['passport'];
    $signature = $n['signature'];
    $id_img_url = $n['id_img_url'];
    // These extra array is to put whatever is in DB
    $sign = $n['signature'];
    $passportbk = $n['passport'];
    $idimg = $n['id_img_url'];
  }
  function fill_state($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM states";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["name"].'">' .$row["name"]. '</option>';
                  }
                  return $out;
                  }
}
?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Update <?php echo $display_name; ?></h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/client_update.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                          <label class="bmd-label-floating">Client Type</label>
                          <input type="text" style="text-transform: uppercase;" class="form-control" hidden value="<?php echo $id; ?>" name="id">
                          <input type="text" style="text-transform: uppercase;" class="form-control" value="<?php echo $ctype; ?>" name="ctype" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                        <?php
                  function fill_savings($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM savings_product WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                  }
                  return $out;
                  }
                  ?>
                          <label class="">Account Type:</label>
                          <select name="account_type" class="form-control " id="collat">
                            <?php
                            $queryd = mysqli_query($connection, "SELECT * FROM account WHERE account_no ='$account_no' && int_id = '$sint_id'");
                            $resx = mysqli_fetch_array($queryd);
                            $prod = $resx['product_id'];
                            $sql2 = "SELECT * FROM savings_product WHERE id = '$prod'";
                            $res2 = mysqli_query($connection, $sql2);
                            $poi = mysqli_fetch_array($res2);
                            $accttypp = $poi["id"];
                            $accttname = $poi["name"];
                            if ($accttypp == "CURRENT" || $accttypp == "SAVINGS" || $accttypp == "") {
                              $accttname = "..choose a savings product";
                            }
                            ?>
                          <option value="<?php echo $accttypp; ?>"><?php echo $accttname; ?></option>
                          <?php echo fill_savings($connection); ?>
                        </select>
                        </div>
                      </div>
                      <!-- </div> -->
                      <div class="col-md-4">
                        <div class="form-group">
                        <?php
                  function fill_account($connection, $vd)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $orgs = "SELECT * FROM account WHERE int_id = '$sint_id' && client_id ='$vd'";
                  $resx = mysqli_query($connection, $orgs);
                  $out = '';
                  while ($row = mysqli_fetch_array($resx))
                  {
                    $out .= '<option value="'.$row["account_no"].'">'.$row["account_no"].'</option>';
                  }
                  return $out;
                  }
                  ?>
                          <label class="">Account No</label>
                          <select name="account_no" class="form-control " id="collat">
                          <option value="<?php echo $account_no; ?>"><?php echo $account_no; ?></option>
                          <?php echo fill_account($connection, $vd); ?>
                        </select>
                        </div>
                      </div>
                      <!-- acctnnnjni -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Display name</label>
                          <input type="text" style="text-transform: uppercase;" class="form-control" value="<?php echo $display_name; ?>" name="display_name">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">First Name</label>
                          <input type="text" class="form-control" value="<?php echo $first_name; ?>" name="first_name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Middle Name</label>
                          <input type="text" class="form-control" value="<?php echo $middle_name; ?>" name="middle_name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Last Name</label>
                          <input type="text" style="text-transform: uppercase;" class="form-control" value="<?php echo $last_name; ?>" name="last_name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone No</label>
                          <input type="tel" class="form-control" value="<?php echo $phone; ?>" name="phone">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone No2</label>
                          <input type="tel" class="form-control" value="<?php echo $phone2; ?>" name="phone2">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Email address</label>
                          <input type="email" class="form-control" value="<?php echo $email; ?>" name="email">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Address</label>
                          <input type="text" style="text-transform: uppercase;" class="form-control" value="<?php echo $address; ?>" name="address">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Gender:</label>
                          <select class="form-control " value="<?php echo $gender; ?>" name="gender" id="">
                            <option value="MALE">MALE</option>
                            <option value="FEMALE">FEMALE</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="">Date of Birth:</label>
                          <input type="date" class="form-control" value="<?php echo $date_of_birth; ?>" name="date_of_birth">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                        <?php
                  function fill_branch($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["name"]. '</option>';
                  }
                  return $out;
                  }
                  ?>
                          <label class="">Branch:</label>
                          <select name="branch" class="form-control" id="collat">
                          <option value="<?php echo $branch; ?>"><?php echo $bname; ?></option>
                          <?php echo fill_branch($connection); ?>
                        </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Country:</label>
                          <input type="text" style="text-transform: uppercase;" class="form-control" value="NIGERIA" name="country">
                        </div>
                      </div>
                      <div class="col-md-4">
                    <div class="form-group">
                      <label for="">State:</label>
                      <select id="tom" class="form-control" style="text-transform: uppercase;" name="state">
                      <option value="<?php echo $state;?>"><?php echo $state;?></option>
                      <?php echo fill_state($connection);?>
                      </select>
                    </div>
                  </div>
                  <script>
                    $(document).ready(function() {
                      $('#tom').on("change", function(){
                        var id = $(this).val();
                        $.ajax({
                          url:"ajax_post/lga.php",
                          method:"POST",
                          data:{id:id},
                          success:function(data){
                            $('#sholga').html(data);
                          }
                        })
                      });
                    });
                </script>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="">LGA:</label>
                      <select id="sholga" class="form-control" name="lga">
                      <option value="<?php echo $lga;?>"><?php echo $lga;?></option>
                      </select>
                    </div>
                  </div>
                      <div class="col-md-4">
                        <label for="">BVN:</label>
                        <input type="text" value="<?php echo $bvn; ?>" name="bvn" class="form-control" id="">
                      </div>
                      <div class="col-md-4">
                        <p><label for="">Active Alerts: </label></p>
                        <input type="text" hidden value="<?php echo $sms_active;?>" id="opo">
                        <input type="text" hidden value="<?php echo $email_active;?>" id="opo2">
                        <script>
                            $(document).ready(function() {
                              var xc = document.getElementById("opo").value;
                              var xc2 = document.getElementById("opo2").value;
                              if (xc == '1' && xc2 == '0') {
                                document.getElementById('sms').checked = true;
                                document.getElementById('eml').checked = false;
                                $('sms').click(function() {
                                 document.getElementById('sms').checked = true;
                                });
                                $('eml').click(function() {
                                 document.getElementById('eml').checked = true;
                                });
                              } else if (xc == '0' && xc2 == '1') {
                                document.getElementById('sms').checked = false;
                                document.getElementById('eml').checked = true;
                                $('sms').click(function() {
                                 document.getElementById('sms').checked = true;
                                });
                                $('eml').click(function() {
                                 document.getElementById('eml').checked = true;
                                });
                              } else if (xc == '1' && xc2 == '1') {
                                document.getElementById('sms').checked = true;
                                document.getElementById('eml').checked = true;
                                $('sms').click(function() {
                                 document.getElementById('sms').checked = true;
                                });
                                $('eml').click(function() {
                                 document.getElementById('eml').checked = true;
                                });
                              } else {
                                document.getElementById('sms').checked = false;
                                document.getElementById('eml').checked = false;
                                $('emp').click(function() {
                                 document.getElementById('sms').checked = true;
                                });
                                $('dec').click(function() {
                                 document.getElementById('eml').checked = true;
                                });
                              }
                            });
                          </script>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="<?php echo $sms_active;?>" name="sms_active" id="sms">
                              SMS
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="<?php echo $email_active;?>" name="email_active" id="eml">
                              Email
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-4">
                      <?php
                  function fill_officer($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM staff WHERE int_id = '$sint_id' ORDER BY staff.display_name ASC";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">' .$row["display_name"]. '</option>';
                  }
                  return $out;
                  }
                  ?>
                        <div class="form-group">
                          <label for="">Account Officer:</label>
                          <select name="acct_off" class="form-control " id="">
                            <option value="<?php echo $account_officer;?>">...</option>
                            <?php echo fill_officer($connection); ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <style>
                        input[type="file"]{
                          display: none;
                        }
                        .custom-file-upload{
                          border: 1px solid #ccc;
                          display: inline-block;
                          padding: 6px 12px;
                          cursor: pointer;
                        }
                      </style>
                      <div class="col-md-4">
                    <label for="file-upload" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-upload" name="passport" type="file" class="inputFileHidden"/>
                    <input type="text" hidden value="<?php echo $passportbk;?>" name="passportbk">
                    <label> Select Passport</label>
                    </div>
                    
                    <div class="col-md-4">
                    <label for="file-insert" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-insert" name="signature" type="file" class="inputFileHidden"/>
                    <input type="text" hidden value="<?php echo $sign;?>" name="sign">
                    <label> Select Signature</label>
                    </div>
                    
                    <div class="col-md-4">
                    <label for="file-enter" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-enter" type="file" name="id_img_url" class="inputFileHidden"/>
                    <input type="text" hidden value="<?php echo $idimg;?>" name="idimg">
                    <label> Select ID</label>
                    </div>
                      <div class="col-md-4">
                        <label for="">Select ID</label>
                         <select class="form-control" name="id_card">
                          <option value="<?php echo $id_card ?>"><?php echo $id_card ?></option>
                          <option value="National ID">National ID</option>
                          <option value="Voters ID">Voters ID</option>
                          <option value="International Passport">International Passport</option>
                        </select>
                      </div>
                    </div>
                    <a href="client.php" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary pull-right">Update Client</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <!-- Dialog box for signature -->
              <div id="sig" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title"><?php echo $first_name; ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <img  src="../functions/clients/sign/<?php echo $signature;?>"/>
                      </div>
                    </div>
                  </div>      
                </div>
                <!-- dialog ends -->
                <!-- Dialog box for passport -->
              <div id="pas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title"><?php echo $first_name; ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <img  src="../functions/clients/passport/<?php echo $passport;?>"/>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- dialog ends -->
                <!-- Dialog box for id img -->
              <div id="id" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title"><?php echo $first_name; ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <img  src="../functions/clients/id/<?php echo $id_img_url;?>"/>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- dialog ends -->
                <div class="card card-profile">
                <div class="card-avatar">
                  <a data-toggle="modal" data-target="#pas">
                    <img class="img" src="../functions/clients/passport/<?php echo $passport;?>" />
                  </a>
                </div>
                <!-- Get client data -->
                <div class="card-body">
                  <h6 class="card-category text-gray">Clients Profile Picture</h6>
                  <h4 class="card-title"><?php echo $display_name; ?></h4>
                  <p class="card-description">
                  <?php
                $inq = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$sessint_id'");
                if (count([$inq]) == 1) {
                  $n = mysqli_fetch_array($inq);
                  $int_name = $n['int_name'];
                }
              ?>
            <?php echo $int_name; ?>
                  </p>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
              <div class="card card-profile">
                <div class="card-avatar">
                  <a data-toggle="modal" data-target="#id">
                    <img class="img" src="../functions/clients/id/<?php echo $id_img_url;?>" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">ID Card</h6>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
                <!-- /id card -->
                <div class="card card-profile">
                <div class="card-avatar">
                  <a data-toggle="modal" data-target="#sig">
                    <img class="img" src="../functions/clients/sign/<?php echo $signature;?>" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">Signature</h6>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
                <!-- signature -->
            </div>
          </div>
          <!-- /content -->
        </div>
      </div>

<?php

    include("footer.php");

?>