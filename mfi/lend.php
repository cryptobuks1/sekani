<?php

$page_title = "Loan Disbursement";
$destination = "transaction.php";
include("header.php");
include("ajaxcallx.php");

?>
<!-- Content added here -->
<div class="content">
    <div class="container-fluid">
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
                            text: "Loan Submitted Successfully, Awaiting Approval",
                            showConfirmButton: false,
                            timer: 2000
                        })
                    });
                    </script>
                    ';
                $_SESSION["lack_of_intfund_$key"] = 0;
            }
        } else if (isset($_GET["message2"])) {
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
        } else if (isset($_GET["message3"])) {
            $key = $_GET["message3"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
                echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Error",
                        text: "This Client Has Been Given Loan Before",
                        showConfirmButton: false,
                        timer: 2000
                    })
                });
                </script>
                ';
                $_SESSION["lack_of_intfund_$key"] = 0;
            }
        } else if (isset($_GET["message4"])) {
            $key = $_GET["message4"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
                echo '<script type="text/javascript">
                  $(document).ready(function(){
                      swal({
                      type: "error",
                      title: "Error",
                      text: "Insufficent Fund From Institution Account!",
                      showConfirmButton: false,
                      timer: 2000
                  })
              });
              </script>
              ';
                $_SESSION["lack_of_intfund_$key"] = 0;
            }
        } else if (isset($_GET["message5"])) {
            $key = $_GET["message5"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
                echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                    type: "error",
                    title: "Error",
                    text: "Error in Posting For Loan Gaurantor",
                    showConfirmButton: false,
                    timer: 2000
                })
            });
            </script>
            ';
                $_SESSION["lack_of_intfund_$key"] = 0;
            }
        } else if (isset($_GET["messfill"])) {
            $key = $_GET["messfill"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
                echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                    type: "error",
                    title: "MISSING ENTRY FIELD",
                    text: "Please fill loan data properly",
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
        <?php
        // right now we will program
        // first step - check if this person is authorized
        if ($loan_appv == 1 || $loan_appv == "1") {
        ?>
        <!-- your content here -->
        <script src='jquery-3.0.0.js' type='text/javascript'></script>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Disburse Loan</h4>
                        <p class="card-category">Fill in all important data</p>
                    </div>
                    <div class="card-body">
                        <form id="form" action="../functions/int_lend_upload.php" method="POST">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <!-- First Tab Begins -->
                                        <div class="tab"><h3> Terms:</h3>
                                            <?php
                                            // load user role data
                                            function fill_product($connection)
                                            {
                                                $sint_id = $_SESSION["int_id"];
                                                $org = "SELECT * FROM product WHERE int_id = '$sint_id' ORDER BY name ASC";
                                                $res = mysqli_query($connection, $org);
                                                $output = '';
                                                while ($row = mysqli_fetch_array($res)) {
                                                    $output .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                                                }
                                                return $output;
                                            }

                                            // a function for client data fill
                                            function fill_client($connection)
                                            {
                                                $sint_id = $_SESSION["int_id"];
                                                $branc = $_SESSION["branch_id"];
                                                $org = "SELECT client.id, client.firstname, client.lastname, client.middlename FROM client JOIN branch ON client.branch_id = branch.id WHERE client.int_id = '$sint_id' AND (branch.id = '$branc' OR branch.parent_id = '$branc') AND status = 'Approved' ORDER BY firstname ASC";
                                                $res = mysqli_query($connection, $org);
                                                $out = '';
                                                while ($row = mysqli_fetch_array($res)) {
                                                    $out .= '<option value="' . $row["id"] . '">' . strtoupper($row["firstname"]) . " " . strtoupper($row["middlename"]) . " " . strtoupper($row["lastname"]) . '</option>';
                                                }
                                                return $out;
                                            }

                                            // a function for collateral
                                            function fill_collateral($connection)
                                            {
                                                $sint_id = $_SESSION["int_id"];
                                                $org = "SELECT * FROM collateral WHERE int_id = '$sint_id'";
                                                $res = mysqli_query($connection, $org);
                                                $out = '';
                                                while ($row = mysqli_fetch_array($res)) {
                                                    $out .= '<option value="' . $row["id"] . '">' . $row["type"] . '</option>';
                                                }
                                                return $out;
                                            }

                                            // Function for charges
                                            function fill_charges($connection)
                                            {
                                                $sint_id = $_SESSION["int_id"];
                                                $org = "SELECT * FROM charge WHERE int_id = '$sint_id'";
                                                $res = mysqli_query($connection, $org);
                                                $out = '';
                                                while ($row = mysqli_fetch_array($res)) {
                                                    $out .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                                                }
                                                return $out;
                                            }

                                            $digit = 6;
                                            $rando = str_pad(rand(0, pow(10, $digit) - 1), $digit, '0', STR_PAD_LEFT);
                                            ?>
                                            <input hidden type="text" id="random" value="<?php echo $rando; ?>"/>
                                            <script>
                                                $(document).ready(function () {
                                                    $('#charges').change(function () {
                                                        var id = $(this).val();
                                                        var client_id = $('#client_name').val();
                                                        var rand = $('#random').val();
                                                        $.ajax({
                                                            url: "load_data_lend.php",
                                                            method: "POST",
                                                            data: {id: id, client_id: client_id},
                                                            success: function (data) {
                                                                $('#show_product').html(data);
                                                            }
                                                        });
                                                        $.ajax({
                                                            url: "ajax_post/lend_charge.php",
                                                            method: "POST",
                                                            data: {id: id, rand: rand, client_id: client_id},
                                                            success: function (data) {
                                                                $('#lend_charge').html(data);
                                                            }
                                                        })
                                                    });
                                                })
                                            </script>
                                            <script>
                                                $(document).ready(function () {
                                                    $('#client_name').change(function () {
                                                        var id = $(this).val();
                                                        var client_id = $('#client_name').val();
                                                        $.ajax({
                                                            url: "load_data_lend.php",
                                                            method: "POST",
                                                            data: {id: id, client_id: client_id},
                                                            success: function (data) {
                                                                $('#show_product').html(data);
                                                            }
                                                        })
                                                    });
                                                })
                                            </script>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="bmd-label-floating">Client Name *:</label>
                                                    <select name="client_id" class="form-control" id="client_name">
                                                        <option value="">select an option</option>
                                                        <?php echo fill_client($connection); ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="bmd-label-floating">Product *:</label>
                                                    <select name="product_id" class="form-control" id="charges">
                                                        <option value="">select an option</option>
                                                        <?php echo fill_product($connection); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12" id="show_product"></div>
                                        </div>
                                        <!-- charge -->
                                        <div class="tab"><h3> Charges:</h3>
                                            <div id="lend_charge">
                                            </div>
                                            <!-- <div class="col-md-6">
                        <label class = "bmd-label-floating" for="charge" class="form-align mr-3">Charges</label>
                          <select class="form-control" name="charge"> 
                            <option>select charge to add</option>
<?php echo fill_charges($connection); ?>
                          </select>
                          <button type="button" class="btn btn-primary" name="button" onclick="displayCharge()"> <i class="fa fa-plus"></i> Add To Product </button>
                      </div> -->
                                        </div>
                                        <!-- Third Tab Ends -->
                                        <!-- Fourth Tab Begins -->
                                        <div class="tab"><h3> Collateral:</h3>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary" name="button"
                                                        onclick="showDialog()"><i class="fa fa-plus"></i> Add
                                                </button>
                                            </div>
                                            <div class="form-group">
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#clickit').on("click", function () {
                                                            var id = $(this).val();
                                                            var client_id = $('#client_name').val();
                                                            var colname = $('#colname').val();
                                                            var colval = $('#col_val').val();
                                                            var coldes = $('#col_descr').val();
                                                            $.ajax({
                                                                url: "collateral_upload.php",
                                                                method: "POST",
                                                                data: {
                                                                    id: id,
                                                                    client_id: client_id,
                                                                    colval: colval,
                                                                    colname: colname,
                                                                    coldes: coldes
                                                                },
                                                                success: function (data) {
                                                                    $('#coll').html(data);
                                                                }
                                                            })
                                                        });
                                                    });
                                                    setInterval(function () {
                                                        // auto run the col.
                                                        var client_id = $('#client_name').val();
                                                        if (client_id != "") {
                                                            $.ajax({
                                                                url: "collateral_upload_check.php",
                                                                method: "POST",
                                                                data: {client_id: client_id},
                                                                success: function (data) {
                                                                    $('#collx').html(data);
                                                                }
                                                            })
                                                        }
                                                    }, 1000);
                                                </script>
                                                <!-- <button class="btn btn-primary pull-right" id="clickit">Add</button> -->
                                                <div id="off_me">
                                                    <table class="rtable display nowrap" style="width:100%"
                                                           id="checking_up">
                                                        <thead>
                                                        <tr>
                                                            <td>Name/Type</td>
                                                            <td>Value</td>
                                                            <td>Description</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="collx">
                                                        </tbody>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="coll"></div>
                                            </div>
                                            <!-- dialog box -->
                                            <div class="form-group">
                                                <div id="background">
                                                </div>
                                                <div id="diallbox">
                                                    <!-- <form method="POST" action="lend.php" > -->
                                                    <h3>Add Collateral</h3>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating" class="md-3 form-align "
                                                                   for=""> Name:</label>
                                                            <input type="text" name="col_name" id="colname"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating" for="">
                                                                Value(&#x20a6;):</label>
                                                            <input type="number" name="col_value" id="col_val"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"
                                                                   for="">Description:</label>
                                                            <input type="text" name="col_description" id="col_descr"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                    <div style="float:right;">
                                                        <span class="btn btn-primary pull-right" id="clickit"
                                                              onclick="AddDlg()">Add</span>
                                                        <span class="btn btn-primary pull-right" onclick="AddDlg()">Cancel</span>
                                                    </div>
                                                    <!-- </form> -->
                                                    <script>
                                                        function AddDlg() {
                                                            var bg = document.getElementById("background");
                                                            var dlg = document.getElementById("diallbox");
                                                            bg.style.display = "none";
                                                            dlg.style.display = "none";
                                                        }

                                                        function showDialog() {
                                                            var bg = document.getElementById("background");
                                                            var dlg = document.getElementById("diallbox");
                                                            bg.style.display = "block";
                                                            dlg.style.display = "block";

                                                            var winWidth = window.innerWidth;
                                                            var winHeight = window.innerHeight;

                                                            dlg.style.left = (winWidth / 2) - 480 / 2 + "px";
                                                            dlg.style.top = "150px";
                                                        }
                                                    </script>
                                                    <style>
                                                        #background {
                                                            display: none;
                                                            width: 100%;
                                                            height: 100%;
                                                            position: fixed;
                                                            top: 0px;
                                                            left: 0px;
                                                            background-color: black;
                                                            opacity: 0.7;
                                                            z-index: 9999;
                                                        }

                                                        #diallbox {
                                                            /*initially dialog box is hidden*/
                                                            display: none;
                                                            position: fixed;
                                                            width: 480px;
                                                            z-index: 9999;
                                                            border-radius: 10px;
                                                            padding: 20px;
                                                            background-color: #ffffff;
                                                        }
                                                    </style>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fourth Tab Ends -->
                                        <!-- Fifth Tab Begins -->
                                        <div class="tab"><h3> Guarantors:</h3>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary" name="button"
                                                        onclick="DisplayDialog()"><i class="fa fa-plus"></i> Add
                                                </button>
                                            </div>
                                            <div class="form-group">
                                                <table class="rtable display nowrap" style="width:100%" id="check_in">
                                                    <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Guarantor Phone</th>
                                                        <th>Email</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="disgau">
                                                    </tbody>
                                                    <div id="disgaux"></div>
                                                </table>
                                            </div>
                                            <!-- dialog box -->
                                            <div class="form-group">
                                                <div id="backg">
                                                </div>
                                                <div id="dlbox">
                                                    <h3>Add Guarantor</h3>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating"
                                                                       class="md-3 form-align " for=""> First
                                                                    Name:</label>
                                                                <input type="text" name="gau_first_name"
                                                                       id="gau_first_name" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating" for=""> Last
                                                                    Name:</label>
                                                                <input type="text" name="gau_last_name"
                                                                       id="gau_last_name" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating" for="">Phone:</label>
                                                                <input type="text" name="gau_phone" id="gau_phone"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating" for="">Phone
                                                                    2:</label>
                                                                <input type="text" name="gau_phone2" id="gau_phone2"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating" for="">Home
                                                                    Address:</label>
                                                                <input type="text" name="home_address" id="home_address"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating" for="">Office
                                                                    Address:</label>
                                                                <input type="text" name="office_address"
                                                                       id="office_address" class="form-control">
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-md-4">
                                                          <div class="form-group">
                                                              <label class = "bmd-label-floating" for="">Position Held:</label>
                                                              <input type="text" name="position_held" id="position_held" class="form-control">
                                                          </div>
                                                        </div> -->
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="bmd-label-floating"
                                                                       class="bmd-label-floating">Email:</label>
                                                                <input type="text" name="gau_email" id="gau_email"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="float:right;">
                                                        <span class="btn btn-primary pull-right" onclick="DlgAdd()"
                                                              type="button" id="gau">Add</span>
                                                        <button class="btn btn-primary pull-right" onclick="DlgAdd()"
                                                                type="button" id="">Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#gau').on("click", function () {
                                                            var id = $(this).val();
                                                            var client_id = $('#client_name').val();
                                                            var firstname = $('#gau_first_name').val();
                                                            var lastname = $('#gau_last_name').val();
                                                            var phone = $('#gau_phone').val();
                                                            var phone_b = $('#gau_phone2').val();
                                                            var h_address = $('#home_address').val();
                                                            var o_address = $('#office_address').val();
                                                            var position = $('#position_held').val();
                                                            var email = $('#gau_email').val();
                                                            $.ajax({
                                                                url: "guarantor_upload.php",
                                                                method: "POST",
                                                                data: {
                                                                    id: id,
                                                                    client_id: client_id,
                                                                    firstname: firstname,
                                                                    lastname: lastname,
                                                                    phone: phone,
                                                                    phone_b: phone_b,
                                                                    h_address: h_address,
                                                                    o_address: o_address,
                                                                    position: position,
                                                                    email: email
                                                                },
                                                                success: function (data) {
                                                                    $('#disgaux').html(data);
                                                                }
                                                            })
                                                        });
                                                    });
                                                    setInterval(function () {
                                                        // auto run the col.
                                                        var client_id = $('#client_name').val();
                                                        if (client_id != "") {
                                                            $.ajax({
                                                                url: "guarantor_upload_check.php",
                                                                method: "POST",
                                                                data: {client_id: client_id},
                                                                success: function (data) {
                                                                    $('#disgau').html(data);
                                                                }
                                                            })
                                                        }
                                                    }, 1000);
                                                </script>
                                                <script>
                                                    function DlgAdd() {
                                                        var bg = document.getElementById("backg");
                                                        var dlg = document.getElementById("dlbox");
                                                        bg.style.display = "none";
                                                        dlg.style.display = "none";
                                                    }

                                                    function DisplayDialog() {
                                                        var bg = document.getElementById("backg");
                                                        var dlg = document.getElementById("dlbox");
                                                        bg.style.display = "block";
                                                        dlg.style.display = "block";

                                                        var winWidth = window.innerWidth;
                                                        var winHeight = window.innerHeight;

                                                        dlg.style.left = (winWidth / 2) - 480 / 2 + "px";
                                                        dlg.style.top = "150px";
                                                    }
                                                </script>
                                                <style>
                                                    #backg {
                                                        display: none;
                                                        width: 100%;
                                                        height: 100%;
                                                        position: fixed;
                                                        top: 0px;
                                                        left: 0px;
                                                        background-color: black;
                                                        opacity: 0.7;
                                                        z-index: 9999;
                                                    }

                                                    #dlbox {
                                                        /*initially dialog box is hidden*/
                                                        display: none;
                                                        position: fixed;
                                                        width: 480px;
                                                        z-index: 9999;
                                                        border-radius: 10px;
                                                        padding: 20px;
                                                        background-color: #ffffff;
                                                    }
                                                </style>
                                            </div>
                                        </div>
                                        <!-- Fifth Tab Ends -->
                                        <div class="tab"><h3>KYC:</h3>
                                            <p>Personal Information</p>
                                            <br>
                                            <div class="row">
                                                <div class=" col-md-6 form-group">
                                                    <label class="bmd-label-floating">Marital Status:</label>
                                                    <!-- <input type="number" value="" name="marital_status" class="form-control"> -->
                                                    <select class="form-control" name="marital_status">
                                                        <option value="1">Single</option>
                                                        <option value="2">Married</option>
                                                    </select>
                                                </div>
                                                <div class=" col-md-6 form-group">
                                                    <label class="bmd-label-floating">Number of
                                                        Dependants/Children:</label>
                                                    <!-- <input type="number" value="" name="no_of_dep" class="form-control" required> -->
                                                    <select class="form-control" name="no_of_dep">
                                                        <option value="0">Non</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7 or More</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <p>Education and Employment</p>
                                            <br>
                                            <div class="row">
                                                <div class=" col-md-6 form-group">
                                                    <label class="bmd-label-floating">Level of Education</label>
                                                    <!-- <input type="number" value="" name="" class="form-control" readonly> -->
                                                    <select class="form-control" name="ed_level">
                                                        <option value="Unknown">Non/ Unknown</option>
                                                        <option value="Secondary School">Secondary School</option>
                                                        <option value="College">College</option>
                                                        <option value="BSc">Bachelors (Bsc)</option>
                                                        <option value="Masters">Masters (Msc)</option>
                                                        <option value="PhD">Phd</option>
                                                    </select>
                                                </div>
                                                <div class=" col-md-6 form-group">
                                                    <label class="bmd-label-floating">Employment Status</label>
                                                    <!-- <input type="number" value="" name="" class="form-control" readonly> -->
                                                    <select class="form-control" name="emp_stat">
                                                        <option value="1">Self-Employed</option>
                                                        <option value="2">Employed</option>
                                                        <option value="3">Not Working</option>
                                                    </select>
                                                </div>
                                                <div class=" col-md-6 form-group">
                                                    <label class="bmd-label-floating">Employment
                                                        Category/Instiution</label>
                                                    <!-- <input type="number" value="" name="" class="form-control" readonly> -->
                                                    <select class="form-control" name="emp_category">
                                                        <option value="FEDERAL">FEDERAL</option>
                                                        <option value="STATE">STATE</option>
                                                        <option value="FINANCIAL INSTITUTION/INSURANCE">FINANCIAL
                                                            INSTITUTION/INSURANCE
                                                        </option>
                                                        <option value="GENERAL">GENERAL</option>
                                                        <option value="MANUFACTURING">MANUFACTURING</option>
                                                        <option value="INFORMATION AND COMMUNICATION">INFORMATION AND
                                                            COMMUNICATION
                                                        </option>
                                                        <option value="OIL AND GAS">OIL AND GAS</option>
                                                        <option value="OTHER">OTHER</option>
                                                    </select>
                                                </div>
                                                <div class=" col-md-6 form-group">
                                                    <label class="bmd-label-floating">Employer/Business name</label>
                                                    <input type="text" value="" name="emp_bus_name"
                                                           class="form-control">
                                                </div>
                                                <div class=" col-md-6 form-group">
                                                    <label class="bmd-label-floating">Monthly Income(&#x20a6;):</label>
                                                    <input type="number" value="" name="income" class="form-control"
                                                           required>
                                                </div>
                                                <!-- new -->
                                                <div class=" col-md-6 form-group">
                                                    <label class="bmd-label-floating">Years in current
                                                        Job/Business:</label>
                                                    <!-- <input type="number" value="" name="" class="form-control" required> -->
                                                    <select class="form-control" name="years_in_job">
                                                        <option value="1">1 - 2 years</option>
                                                        <option value="3">3 - 4 years</option>
                                                        <option value="5">4 - 5 years</option>
                                                        <option value="6">5 - 6 years</option>
                                                        <option value="7">6 - 7 years</option>
                                                        <option value="8">7 - 8 years</option>
                                                        <option value="9">8 - 9 years</option>
                                                        <option value="10">9 - 10 years</option>
                                                        <option value="12">11 - 12 years</option>
                                                        <option value="14">13 - 14 years</option>
                                                        <option value="15">14 - 15 years</option>
                                                        <option value="17">16 - 17 years</option>
                                                        <option value="19">18 - 19 years</option>
                                                        <option value="9">20 OR MORE</option>
                                                    </select>
                                                </div>
                                                <!-- new for years -->
                                            </div>
                                            <br>
                                            <p>Address Details</p>
                                            <br>
                                            <div class="row">
                                                <div class=" col-md-6 form-group">
                                                    <label class="bmd-label-floating">Residence Type:</label>
                                                    <!-- <input type="number" readonly value="" name="res_type" class="form-control" required> -->
                                                    <select class="form-control" name="res_type">
                                                        <option value="1">Rented</option>
                                                        <option value="2">Owner</option>
                                                    </select>
                                                </div>
                                                <!-- damn -->
                                                <!-- <div id="rent"> -->
                                                <div class=" col-md-6 form-group">
                                                    <label class="bmd-label-floating">Rent per Year (if rented):</label>
                                                    <input type="number" value="" name="rent_per_year"
                                                           class="form-control">
                                                </div>
                                                <!-- </div> -->
                                                <div class=" col-md-6 form-group">
                                                    <label class="bmd-label-floating">How long have you lived
                                                        there?:</label>
                                                    <!-- <input type="number" readonly value="" name="principal_amount" class="form-control" required> -->
                                                    <select class="form-control" name="years_in_res">
                                                        <option value="1">1 - 3 years</option>
                                                        <option value="2">3 - 5 years</option>
                                                        <option value="3">5 - 10 years</option>
                                                        <option value="4">10 - 20 years</option>
                                                        <option value="5">More than 20 years</option>
                                                    </select>
                                                </div>
                                                <!-- THE BANK -->
                                                <div class=" col-md-6 form-group">
                                                    <label class="bmd-label-floating">Other Bank</label>
                                                    <!-- <input type="number" readonly value="" name="principal_amount" class="form-control" required> -->
                                                    <select class="form-control" name="other_banks">
                                                        <option value="GUARANTY TRUST BANK">GUARANTY TRUST BANK</option>
                                                        <option value="FIRST CITY MONUMENT BANK">FIRST CITY MONUMENT
                                                            BANK
                                                        </option>
                                                        <option value="FIRST BANK">FIRST BANK</option>
                                                        <option value="UNION BANK">UNION BANK</option>
                                                        <option value="UNITED BANK FOR AFRICA">UNITED BANK FOR AFRICA
                                                        </option>
                                                        <option value="SKYE BANK">SKYE BANK</option>
                                                        <option value="STANBIC IBTC">STANBIC IBTC</option>
                                                        <option value="ACCESS BANK">ACCESS BANK</option>
                                                        <option value="ECOBANK">ECOBANK</option>
                                                        <option value="Other">OTHERs</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Sixth Tab Begins -->
                                        <div class="tab"><h3> Repayment Schedule:</h3>
                                            <div class="form-group">
                                                <script>
                                                    // $(document).ready(function() {
                                                    //   $('#charges').change(function(){
                                                    //     var id = $(this).val();
                                                    //     $.ajax({
                                                    //       url:"loan_calculation_table.php",
                                                    //       method:"POST",
                                                    //       data:{id:id},
                                                    //       success:function(data){
                                                    //         $('#show_table').html(data);
                                                    //       }
                                                    //     })
                                                    //   });
                                                    // })
                                                </script>
                                                <table id="accname" class="table table-bordered">

                                                </table>
                                            </div>
                                        </div>
                                        <!-- Sixth Tab Ends -->
                                        <!-- Seventh Tab Begins -->
                                        <div class="tab"><h3> Overview:</h3>
                                            <div class="row">
                                                <!-- <div class="my-3"> -->
                                                <!-- replace values with loan data -->
                                                <div class=" col-md-6 form-group">
                                                    <label class="bmd-label-floating">Loan size:</label>
                                                    <input type="number" readonly value="" name="principal_amount"
                                                           class="form-control" required id="ls">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="bmd-label-floating">Loan Term:</label>
                                                    <input readonly type="number" id="lt" name="loan_term"
                                                           class="form-control"/>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="bmd-label-floating">Interest Rate per:</label>
                                                    <input readonly type="text" value="" name="repay_every"
                                                           class="form-control" id="irp">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="bmd-label-floating">Interest Rate:</label>
                                                    <input readonly type="text" name="interest_rate"
                                                           class="form-control" id="ir">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="bmd-label-floating">Disbusrsement Date:</label>
                                                    <input readonly type="date" name="disbursement_date"
                                                           class="form-control" id="db">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="bmd-label-floating">Loan Officer:</label>
                                                    <input readonly type="text" name="loan_officer" class="form-control"
                                                           id="lo">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="bmd-label-floating">Loan Purpose:</label>
                                                    <input readonly type="text" name="loan_purpose" class="form-control"
                                                           id="lp">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="bmd-label-floating">Linked Savings account:</label>
                                                    <input readonly type="text" name="linked_savings_acct"
                                                           class="form-control" id="lsa">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="bmd-label-floating">Repayment Start Date:</label>
                                                    <input readonly type="date" name="repay" class="form-control"
                                                           id="rsd">
                                                </div>
                                                <!-- <div class="col-md-6 form-group">
                                <label class = "bmd-label-floating">Loan End Date:</label>
                                <input readonly type="sc" value="<?php $actualend_date ?>" name="repay_start" id="end" class="form-control">
                              </div> -->
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                        <!-- Seventh Tab Ends -->
                                        <!-- Buttons -->
                                        <div style="overflow:auto;">
                                            <div style="float:right;">
                                                <button class="btn btn-primary pull-right" type="button" id="nextBtn"
                                                        onclick="nextPrev(1)">Next
                                                </button>
                                                <button class="btn btn-primary pull-right" type="button" id="prevBtn"
                                                        onclick="nextPrev(-1)">Previous
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Steppers -->
                                        <!-- Circles which indicates the steps of the form: -->
                                        <div style="text-align:center;margin-top:40px;">
                                            <span class="step"></span>
                                            <span class="step"></span>
                                            <!-- <span class="step"></span> -->
                                            <span class="step"></span>
                                            <span class="step"></span>
                                            <span class="step"></span>
                                            <span class="step"></span>
                                            <span class="step"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                    <!-- /stepper  -->
                </div>
            </div>
        </div>
        <!-- <div class="col-md-4">
          <div class="card card-profile">
            <div class="card-avatar">
              <a href="#pablo">
                <img class="img" src="../assets/img/faces/marc.jpg" />
              </a>
            </div>
             Get session data and populate user profile
            <div class="card-body">
              <h6 class="card-category text-gray">CEO / Co-Founder</h6>
              <h4 class="card-title">Alec Thompson</h4>
              <p class="card-description">
                Sekani Systems
              </p>
               <a href="#pablo" class="btn btn-primary btn-round">Follow</a>
            </div>
          </div>
        </div> -->
    </div>
    <!-- /content -->
</div>
    </div>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #f1f1f1;
        }

        /* #regForm {
          background-color: #ffffff;
          margin: 100px auto;
          font-family: Raleway;
          padding: 40px;
          width: 70%;
          min-width: 300px;
        } */

        h1 {
            text-align: center;
        }

        input {
            padding: 10px;
            width: 100%;
            font-size: 17px;
            font-family: Raleway;
            border: 1px solid #aaaaaa;
        }

        /* Mark input boxes that gets an error on validation: */
        input.invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

        button {
            background-color: #a13cb6;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 17px;
            font-family: Raleway;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }

        #prevBtn {
            background-color: #bbbbbb;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #9e38b5;
        }
    </style>
    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("form").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = true;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>
<?php

include("footer.php");

?>
<?php
} else {
    echo '<script type="text/javascript">
  $(document).ready(function(){
   swal({
    type: "error",
    title: "Authorization Denied",
    text: "You Dont Have permission to Book a loan",
   showConfirmButton: false,
    timer: 2000
    }).then(
    function (result) {
      history.go(-1);
    }
    )
    });
   </script>
  ';
    // $URL="transact.php";
    // echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}

?>
