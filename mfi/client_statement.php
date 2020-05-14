<?php

$page_title = "Client Statement";
$destination = "client.php";
include('header.php');

if(isset($_GET["edit"])) {
  $id = $_GET["edit"];
  $person = mysqli_query($connection, "SELECT * FROM client WHERE id='$id' && int_id ='$sessint_id'");
  if (count([$person]) == 1) {
    $n = mysqli_fetch_array($person);
    $ctype = $n['client_type'];
    $branch = $n['branch_id'];
    $display_name = $n['display_name'];
    $first_name = $n['firstname'];
    $middle_name = $n['middlename'];
    $last_name = $n['lastname'];
    $acc_no = $n['account_no'];
    $actype = $n['account_type'];
    $phone = $n['mobile_no'];
    $phone2 = $n['mobile_no_2'];
    $email = $n['email_address'];
    $date_of_birth = $n['date_of_birth'];
    $sms_active = $n['SMS_ACTIVE'];
    $email_active = $n['EMAIL_ACTIVE'];
    $branchid = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch'");
    if (count([$branchid]) == 1) {
      $a = mysqli_fetch_array($branchid);
      $branch_name = strtoupper($a['name']);
      $branch_address = $a['location'];
    }
    $acount = mysqli_query($connection, "SELECT * FROM account WHERE account_no='$acc_no'");
    if (count([$acount]) == 1) {
      $b = mysqli_fetch_array($acount);
      $currtype = $b['currency_code'];
    }

      $totald = mysqli_query($connection,"SELECT SUM(debit)  AS debit FROM account_transaction WHERE client_id = '$id'");
      $deb = mysqli_fetch_array($totald);
      $tdp = $deb['debit'];
      $totaldb = number_format($tdp, 2);

      $totalc = mysqli_query($connection, "SELECT SUM(credit)  AS credit FROM account_transaction WHERE client_id = '$id'");
      $cred = mysqli_fetch_array($totalc);
      $tcp = $cred['credit'];
      $totalcd = number_format($tcp, 2);
  }
}
// session_start();
                            
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
                    <div class="col-md-12">
                    <h1>Client statement</h1>
                      <h1>Client statement</h1>
                    </div>
                      <div class="col-md-6">
                        <h6 class="card-category text-gray">Branch name</h6>
                          <h4><?php echo $branch_name;?></h4>
                        <h6 class="card-category text-gray">Client name</h6>
                          <h4><?php echo $first_name," ", $last_name;?></h4>
                        <h6 class="card-category text-gray">Currency</h6>
                          <h4><?php echo $currtype;?></h4>
                        <h6 class="card-category text-gray">Total debit</h6>
                          <h4>&#8358;<?php echo $totaldb;?></h4>
                        <h6 class="card-category text-gray">Total credit</h6>
                          <h4>&#8358;<?php echo $totalcd;?></h4>
                    </div>

                    <div class="col-md-6">
                      <h6 class="card-category text-gray">Branch address</h6>
                        <h4><?php echo $branch_address?></h4>
                      <h6 class="card-category text-gray">Account number</h6>
                        <h4><?php echo $acc_no;?></h4>
                      <h6 class="card-category text-gray">Opening balance</h6>
                        <!-- <h4><?php echo $actype;?></h4> -->
                        <h4>&#8358; 503965</h4>
                      <h6 class="card-category text-gray">Closing balance</h6>
                      <!-- <h4><?php echo $actype;?></h4> -->
                      <h4>&#8358; 493824</h4>
                      <h6 class="card-category text-gray">Statement period</h6>
                      <h4>01/01/2020 - 01/30/2020</h4>
                    </div>
                  </div>
                <!-- /account statement -->
                <br>
              </div>
          </div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Account Statement</h4>
                </div>
                <div class="card-body">
                <div class="form-group">
                  <form method="POST" action="../TCPDF/dbtable.php">                    
                  <a href="../composer/client_statement.php?edit=<?php echo $id;?>" class="btn btn-primary pull-left">Download PDF</a>
                  </form>
                    </div>
                    <div class="table-responsive">
                    <script>
                  $(document).ready(function() {
                  $('#tabledat2').DataTable();
                  });
                  </script>
                    <table id="tabledat2" class="table" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT transaction_date, created_date, transaction_id, debit, credit, running_balance_derived FROM account_transaction WHERE client_id ='$id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>Transaction Date</th>
                        <th>Value Date</th>
                        <th>Reference</th>
                        <th>Debits</th>
                        <th>Credits</th>
                        <th>Balance</th>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                        
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                          <th><?php echo $row["transaction_date"]; ?></th>
                          <th><?php echo $row["created_date"]; ?></th>
                          <th><?php echo $row["transaction_id"]; ?></th>
                          <th><?php echo $row["debit"]; ?></th>
                          <th><?php echo $row["credit"]; ?></th>
                          <th><?php echo $row["running_balance_derived"]; ?></th>
                        </tr>
                        <?php }
                          }
                          else {
                            echo "0 Staff";
                          }
                          ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            
        </div>
      </div>

<?php

include('footer.php');

?>