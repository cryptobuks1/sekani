<?php
$output = '';
include("../functions/connect.php");
session_start();
?>
<?php
  $intname = $_SESSION['int_name'];
  $branch_id = $_SESSION["branch_id"];
  $sint_id =$_SESSION['int_id'];
  $date = date('d/m/Y');
  // $staff = $_POST["staff"];
  $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
    if (count([$branchquery]) == 1) {
      $ans = mysqli_fetch_array($branchquery);
      $branch = $ans['name'];
      $branch_email = $ans['email'];
      $branch_location = $ans['location'];
      $branch_phone = $ans['phone'];
    }
    function branch_opt($connection)
  {  
      $br_id = $_SESSION["branch_id"];
      $sint_id = $_SESSION["int_id"];
      $dff = "SELECT * FROM branch WHERE int_id ='$sint_id' AND id = '$br_id' || parent_id = '$br_id'";
      $dof = mysqli_query($connection, $dff);
      $out = '';
      while ($row = mysqli_fetch_array($dof))
      {
        $do = $row['id'];
      $out .= " OR client.branch_id ='$do'";
      }
      return $out;
  }
  $br_id = $_SESSION["branch_id"];
  $sessint_id =$_SESSION['int_id'];
  $branches = branch_opt($connection);
  $dd = "SELECT client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && (client.branch_id ='$branch_id' $branches)";
  $redsult = mysqli_query($connection, $dd);
    $ssd = mysqli_num_rows($redsult);
  function fill_report($connection, $branch_id, $branches)
        {
            $out = '';
            $sessint_id =$_SESSION['int_id'];
          // import
        //   $glcode = $_POST['glcode'];
        $query = "SELECT client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && (client.branch_id ='$branch_id' $branches)";
        $result = mysqli_query($connection, $query);
        while ($q = mysqli_fetch_array($result, MYSQLI_ASSOC))
          {
            $cid = $q["id"];
          $firstname = $q["firstname"];
          $lastname = $q["lastname"];
          $account = strtoupper($q["first_name"]." ".$q["last_name"]);
            $q["account_type"];
            $cid= $q["id"];
            $atype = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$cid'");
            if (count([$atype]) == 1) {
                $yxx = mysqli_fetch_array($atype);
                if(isset($yxx['product_id'])){
                $actype = $yxx['product_id'];
                }
              $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
            if (count([$spn])) {
              $d = mysqli_fetch_array($spn);
              if(isset($d["name"])){
              $savingp = $d["name"];
              }
            }
            }
            $acc = $q["account_no"];
            $don = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$cid'");
            $ew = mysqli_fetch_array($don);
            if(isset($ew['account_balance_derived'])){
            $accountb = $ew['account_balance_derived'];
            }
            $out .= '
            <tr>
            <th style="font-size: 30px;" class="column1">'.$firstname.'</th>
            <th style="font-size: 30px;" class="column1">'.$lastname.'</th>
            <th style="font-size: 30px;" class="column1">'.$account.'</th>
            <th style="font-size: 30px;" class="column1">'.$savingp.'</th>
            <th style="font-size: 30px;" class="column1">'.$acc.'</th>
            <th style="font-size: 30px;" class="column1">'.$accountb.'</th>
            </tr>
          ';
          }
        // }
          return $out;
        }
  require_once __DIR__ . '/vendor/autoload.php';
  $mpdf = new \Mpdf\Mpdf();
  $mpdf->SetWatermarkImage(''.$_SESSION["int_logo"].'');
  $mpdf->showWatermarkImage = true;
  $mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
  <header class="clearfix">
<div id="logo">
  <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
</div>
<h1>'.$_SESSION["int_full"].' <br/> Client Balance Report</h1>
<div id="company" class="clearfix">
  <div>'.$branch.'</div>
  <div>'.$branch_location.'</div>
  <div>(+234) '.$branch_phone.'</div>
  <div><a href="mailto:'.$branch_email.'">'.$branch_email.'</a></div>
</div>
<div id="project">
  <div><span>BRANCH</span> '.$branch.' </div>
  <div><span>TOTAL</span> '.$ssd.' </div>
</div>
</header>
  <main>
  <table>
  <thead class=" text-primary">
  <tr>
      <th style="font-size: 30px;" class="column1">
      First Name
    </th>
    <th style="font-size: 30px;" class="column1">
      Last Name
    </th>
    <th style="font-size: 30px;" class="column1">
      Account officer
    </th>
    <th style="font-size: 30px;" class="column1">
      Account Type
    </th>
    <th style="font-size: 30px;" class="column1">
      Account Number
    </th>
    <th style="font-size: 30px;" class="column1">
      Account Balances
    </th>
      </tr>
    </thead>
  <tbody>
  "'.fill_report($connection, $branch_id, $branches).'"
  </tbody>
  </table>
  </main>
  ');
  $file_name = 'Client Balance Report for '.$intname.'-'.$date.'.pdf';
  $mpdf->Output($file_name, 'D');
?>