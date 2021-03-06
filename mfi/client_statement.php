<?php

$page_title = "Client Statement";
$destination = "client.php";
include('header.php');

$sessint_id = $_SESSION['int_id'];

if (isset($_SESSION["client_id"]) && isset($_SESSION["start"]) && isset($_SESSION["end"]) && isset($_SESSION["account_id"])) {
  $_POST["id"] = $_SESSION["client_id"];
  $_POST["start"] = $_SESSION["start"];
  $_POST["end"] = $_SESSION["end"];
  $_POST["account_id"] = $_SESSION["account_id"];
}


if(isset($_SESSION["reversal"]) && $_SESSION["reversal"] == 1) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Reversal Transaction",
          text: "Transaction Successful",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  unset($_SESSION["reversal"]);
}

if (isset($_POST["start"]) && isset($_POST["end"]) && isset($_POST["account_id"])) {
  $id = $_POST["id"];

  $std = $_POST["start"];

  $acc_id = $_POST["account_id"];

  $query_account_number = mysqli_query($connection, "SELECT * FROM account WHERE account_no ='$acc_id' && int_id = '$sessint_id'");
  $acx = mysqli_fetch_array($query_account_number);
  $acc_no = $acx["account_no"];
  //  echo $std;
  $endx = $_POST["end"];

  $person = mysqli_query($connection, "SELECT * FROM client WHERE id='$id' && int_id ='$sessint_id'");
  if (count([$person]) == 1) {
    $n = mysqli_fetch_array($person);
    $ctype = $n['client_type'];
    $branch = $n['branch_id'];
    $display_name = $n['display_name'];
    $first_name = $n['firstname'];
    $middle_name = $n['middlename'];
    $last_name = $n['lastname'];
    $actype = $n['account_type'];
    $phone = $n['mobile_no'];
    $phone2 = $n['mobile_no_2'];
    $email = $n['email_address'];
    $date_of_birth = $n['date_of_birth'];
    $sms_active = $n['SMS_ACTIVE'];
    $email_active = $n['EMAIL_ACTIVE'];
    $query2 = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$sessint_id'");

    if (count([$query2]) == 1) {
      $b = mysqli_fetch_array($query2);
      $intname = $b['int_name'];
      $logo = $b['int_name'];
      $full = $b['int_full'];
      $web = $b['website'];
    }

    $branchid = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch'");
    if (count([$branchid]) == 1) {
      $a = mysqli_fetch_array($branchid);
      $branch_name = strtoupper($a['name']);
      $branch_address = $a['location'];
    }

    $acount = mysqli_query($connection, "SELECT * FROM account WHERE client_id ='$id' && account_no='$acc_no'");
    if (count([$acount]) == 1) {
      $b = mysqli_fetch_array($acount);
      $currtype = $b['currency_code'];
      $acc_id = $b['id'];
    }

    $totald = mysqli_query($connection, "SELECT SUM(debit)  AS debit FROM account_transaction WHERE  (account_no = '$acc_no' && int_id = '$sessint_id' && branch_id = '$branch') && (transaction_date BETWEEN '$std' AND '$endx') ORDER BY transaction_date ASC");
    $deb = mysqli_fetch_array($totald);
    $tdp = $deb['debit'];
    $totaldb = number_format($tdp, 2);

    $totalc = mysqli_query($connection, "SELECT SUM(credit)  AS credit FROM account_transaction WHERE (account_no = '$acc_no' && int_id = '$sessint_id' && branch_id = '$branch') && (transaction_date BETWEEN '$std' AND '$endx') ORDER BY transaction_date ASC");
    $cred = mysqli_fetch_array($totalc);
    $tcp = $cred['credit'];
    $totalcd = number_format($tcp, 2);

    // Closing Balance
    $result = mysqli_query($connection, "SELECT * FROM account_transaction WHERE (account_no = '$acc_no' && int_id = '$sessint_id' && branch_id = '$branch') && (transaction_date BETWEEN '$std' AND '$endx') ORDER BY id DESC LIMIT 1");
    $rerc = mysqli_fetch_array($result);
    $closing_bal = $rerc['running_balance_derived'];
  }

  // session_start();
  // include("../functions/transactions/reversal.php");s
  //     // Store data in session variables
  //     session_regenerate_id();
  $_SESSION["loggedin"] = true;
  $_SESSION["client_id"] = $id;
?>
  <!-- Content added here -->
  <!-- print content -->
  <div class="content">
    <div class="container-fluid">
      <!-- your content here -->
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12">
            <div style="padding-left:20px;" class="card">
              <div class="row">
              </div>
              <div class="card">
                <!-- <div class="card-header card-header-primary">
              <h4 class="card-title">Account Statement Preview</h4>
            </div> -->
                <link rel="stylesheet" media="print" href="../composer/pdf/util.css">
                <div class="card-body">
                  <div class="form-group">
                    <form method="POST" action="client_statement">
                      <input hidden name="id" type="text" value="<?php echo $id; ?>" />
                      <input hidden name="start" type="text" value="<?php echo $std; ?>" />
                      <input hidden name="end" type="text" value="<?php echo $endx; ?>" />
                      <input hidden name="account_no" type="text" value="<?php echo $acc_no; ?>" />
                      <button type="submit" class="btn btn-primary pull-left">Download PDF</button>
                    </form>
                  </div>
                  <div>
                    <header class="clearfix">
                      <div id="logo">
                        <img src="<?php echo $_SESSION["int_logo"]; ?>" height="80" width="80">
                      </div>
                      <h1><?php echo $full; ?><br /> Client Statement</h1>
                      <div id="project">
                        <div class="row">
                          <div class="col-md-6">
                            <h4>Currency: <?php echo $currtype; ?></h4>
                            <h4>Account number: <?php echo $acc_no; ?></h4>
                            <h4>Statement period: <?php echo $std, ' - ', $endx; ?></h4>
                            <h4>Closing Balance: &#8358;<?php echo number_format($closing_bal, 2); ?></h4>
                          </div>
                          <div class="col-md-6">
                            <h4>Client name: <?php echo $first_name, " ", $last_name; ?></h4>
                            <h4>Total debit: &#8358;<?php echo $totaldb; ?></h4>
                            <h4>Total credit: &#8358;<?php echo $totalcd; ?></h4>
                          </div>
                        </div>
                      </div>
                  </div>
                  </header>

                  <div class="ody">
                    <div class="wrap-table100">
                      <div class="table100">

                        <table id="p" class="table table-bordered" style="width:100%">
                          <thead>
                            <!-- <input type='text' value='<?php echo $branch; ?>'/> -->
                            <?php
                            $que = "SELECT * FROM account WHERE account_no = '$acc_no' && client_id ='$id'";
                            $resui = mysqli_query($connection, $que);
                            $q = mysqli_fetch_array($resui);
                            $acc_id = $q['id'];
                            // $resultmm = mysqli_query($connection, "SELECT * FROM account_transaction WHERE ((account_id = '$acc_id' && int_id = $sessint_id) && branch_id = '$branch') && (transaction_date BETWEEN '$std' AND '$endx') ORDER BY transaction_date ASC");
                            // $kx = mysqli_fetch_array($resultmm);
                            // $querytoget = "SELECT * FROM account_transaction WHERE account_id = '65' && int_id = '5' && branch_id = '1' && transaction_date BETWEEN '2019-01-01' AND '2020-03-03' ORDER BY transaction_date ASC";
                            $result = mysqli_query($connection, "SELECT * FROM account_transaction WHERE (account_no = '$acc_no' && int_id = '$sessint_id') && (transaction_date BETWEEN '$std' AND '$endx') ORDER BY transaction_date ASC");
                            // $result = mysqli_query($connection, $querytoget);
                            // $v = 0;
                            ?>
                            <tr class="table100-head">
                              <!-- <th>sn</th> -->
                              <th class="column1">Transaction-Date</th>
                              <th class="column2">Value Date</th>
                              <th class="column3">Reference</th>
                              <th class="column4">Debits(&#8358;)</th>
                              <th class="column5">Credits(&#8358;)</th>
                              <th class="column6">Balance(&#8358;)</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if (mysqli_num_rows($result) > 0) {
                              while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $nxtbal = $row["running_balance_derived"];
                            ?>
                                <tr>
                                  <!-- <td></td> -->
                                  <td class="column1"><?php echo $row["transaction_date"]; ?></td>
                                  <td class="column2"><?php echo $row["created_date"]; ?></td>
                                  <!-- Review this Section -->
                                  <?php
                                  if ($row["transaction_type"] == "") {
                                    $desc = "Deposit";
                                  } else if ($row["transaction_type"] == "") {
                                    $desc = "Withdrawal";
                                  } else if ($row["transaction_type"] == "loan_disbursement") {
                                    $desc = "Loan Disbursment";
                                  } else if ($row["transaction_type"] == "percentage_charge") {
                                    $desc = $row["description"];
                                  } else if ($row["transaction_type"] == "flat_charge") {
                                    $desc = $row["description"];
                                  } else {
                                    $desc = $row["description"];
                                  }
                                  ?>
                                  <td class="column3"><?php echo $desc; ?></td>
                                  <td class="column4"><?php echo number_format($row["debit"], 2); ?></td>
                                  <td class="column5"><?php echo number_format($row["credit"], 2); ?></td>
                                  <?php
                                  // $newnext = mysqli_query($connection, "SELECT transaction_date, running_balance_derived, RunningTotal = SUM(running_balance_derived) AS OVER (ORDER BY transaction_date ROWS UNBOUNDED PRECEDING) FROM account_transaction WHERE account_id = '$acc_id' && (int_id = $sessint_id && branch_id = '$branch') && (transaction_date BETWEEN '$std' AND '$endx') ORDER BY transaction_date ASC");
                                  // $mink = mysqli_fetch_array($newnext);
                                  // $qwe = $mink["running_balance_derived"];
                                  ?>
                                  <td class="column6"><?php echo  number_format($nxtbal, 2); ?></td>
                                  <td>
                                    <!-- Button trigger modal -->
                                    <a href="" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $row["id"]; ?>">Edit</a>

                                    <!-- POP UP BEGINS -->
                                    <form action="../functions/transactions/reversal.php" method="POST">
                                      <div class="modal fade" id="exampleModal<?php echo $row["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h3 class="modal-title" id="exampleModalLabel">Reverse Transaction</h3>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">

                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label class="bmd-label-floating" for="">ID: </label>
                                                  <input class="form-control" type="number" name="id" placeholder="" readonly value="<?php echo $row["id"]; ?>">
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label class="bmd-label-floating" for="">Account_no: </label>
                                                  <input class="form-control" type="text" name="account_number" placeholder="" readonly value="<?php echo $row["account_no"]; ?>">
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label class="bmd-label-floating" for="">Date: </label>
                                                  <input class="form-control" type="date" name="transaction_date" placeholder="" readonly value="<?php echo $row["transaction_date"]; ?>">
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label class="bmd-label-floating" for="">Amount:</label>
                                                  <input class="form-control" type="number" name="amount" placeholder="" readonly value="<?php echo $row["amount"]; ?>">
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label class="bmd-label-floating" for="">Receipt Number</label>
                                                  <input class="form-control" type="number" placeholder="" readonly value="<?php echo $row["transaction_id"]; ?>">
                                                </div>
                                              </div>
                                            </div>

                                            <input type="hidden" name="start" value="<?php echo $std; ?>">
                                            <input type="hidden" name="end" value="<?php echo $endx; ?>">
                                            <input type="hidden" name="account_id" value="<?php echo $acc_no; ?>">

                                            <div class="modal-footer">
                                              <button type="submit" class="btn btn-primary">Reverse</button>
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </form>
                                    <!-- POP UP ENDS -->
                                  </td>
                                </tr>
                            <?php
                              }
                            }
                            ?>
                            <!-- <th></th> -->
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  </div>
  <style>
    .clearfix:after {
      content: "";
      display: table;
      clear: both;
      position: relative;
      margin: 0 auto;
      color: #001028;
      background: #FFFFFF;
      font-family: Arial, sans-serif;
      font-size: 12px;
      font-family: Arial;
    }

    a {
      color: #5D6975;
      text-decoration: underline;
    }

    .ody {
      position: relative;
      margin: 0 auto;
      color: #001028;
      background: #FFFFFF;
      font-family: Arial, sans-serif;
      font-size: 12px;
      font-family: Arial;
    }

    header {
      padding: 10px 0;
      margin-bottom: 30px;
    }

    #logo {
      clear: both;
      text-align: center;
      margin-bottom: 10px;
    }

    #logo img {
      width: 90px;
    }

    h1 {
      border-top: 1px solid #5D6975;
      border-bottom: 1px solid #5D6975;
      color: #5D6975;
      font-size: 2.4em;
      line-height: 1.4em;
      font-weight: normal;
      text-align: center;
      margin: 0 0 20px 0;
      background: url(dimension.png);
    }

    #project {
      font-weight: normal;
      color: #5D6975;
    }

    h4 {
      font-weight: normal;
      color: #5D6975;
      font-size: 1.4em;
    }

    #company {
      float: right;
      text-align: right;
    }

    #company div {
      white-space: nowrap;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-spacing: 0;
      margin-bottom: 20px;
    }

    table tr:nth-child(2n-1) td {
      background: #F5F5F5;
    }

    table th,
    table td {
      text-align: left;
    }

    table th {
      padding: 5px 20px;
      color: #5D6975;
      border-bottom: 1px solid #C1CED9;
      white-space: nowrap;
      font-weight: normal;
    }

    table .service,
    table .desc {
      text-align: left;
    }

    table td {
      padding: 20px;
      text-align: left;
    }

    table td.service,
    table td.desc {
      vertical-align: top;
    }

    table td.unit,
    table td.qty,
    table td.total {
      font-size: 1.2em;
    }

    table td.grand {
      border-top: 1px solid #5D6975;
      ;
    }

    #notices .notice {
      color: #5D6975;
      font-size: 1.2em;
    }
  </style>
<?php
} else {
  echo '<script type="text/javascript">
  $(document).ready(function(){
   swal({
    type: "error",
    title: "Client Statement Cant Read Form",
    text: "Please Verfiy Account Properly",
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
  
}
include('footer.php');

?>