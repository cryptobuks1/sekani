<?php
// called database connection
include("connect.php");
// user management
session_start();

?>
<?php
if(isset($_GET['approve'])){
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sessint_id = $_SESSION["int_id"];
$branch_id = $_SESSION["branch_id"];
$users = $_SESSION["user_id"];
$e = mysqli_query($connection, "SELECT * FROM staff WHERE user_id ='$users'");
$r = mysqli_fetch_array($e);
$staff_id = $r['id'];

$wee = $_GET['approve'];
$query = "SELECT * FROM savings_acct_charge WHERE id ='$wee'";
$don = mysqli_query($connection, $query);
$som = mysqli_fetch_array($don);
$charges = $som['charge_id'];
$client = $som['client_id'];
$transid = $som['transact_id'];
$descrip = $som['description'];
$acct_id = $som['acct_id'];
$date = $som['date'];

// credit checks and accounting rules
$don = mysqli_query($connection, "SELECT * FROM charge WHERE id = '$charges'");
$s = mysqli_fetch_array($don);
$amount = $s['amount'];
$pay_type = $s['gl_code'];
// insertion query for product
$query4 = "SELECT account.id, client.firstname, client.lastname, account.product_id, account.account_no, account.id, account.total_withdrawals_derived, account.account_balance_derived FROM client JOIN account ON client.account_no = account.account_no WHERE client.int_id = '$sessint_id' AND client.id ='$client'";
$queryexec = mysqli_query($connection, $query4);
$b = mysqli_fetch_array($queryexec);
$accbal = $b['account_balance_derived'];
$ttl = $b['total_withdrawals_derived'];
$acct_no = $b['account_no'];
$sproduct_id = $b['product_id'];
$clientname = $b['firstname']." ".$b['lastname'];

$reor = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code='$pay_type'");
$ron = mysqli_fetch_array($reor);
$glbalance = $ron['organization_running_balance_derived'];

$newglball = $glbalance + $amount;
$ttlwith = $ttl + $amount;
$newbal = $accbal - $amount;
$iupq = "UPDATE account SET account_balance_derived = '$newbal', last_withdrawal = '$amount', total_withdrawals_derived = '$ttlwith' WHERE id = '$acct_id' AND account_no = '$acct_no' && int_id = '$sessint_id'";
        $iupqres = mysqli_query($connection, $iupq);
        if ($iupqres) {
        // update the clients transaction
        $description = "Fee on charges";
        $trans_type ="debit";
        $irvs = "0";
        $iat = "INSERT INTO account_transaction (int_id, branch_id,
        account_no, product_id, teller_id, account_id,
        client_id, transaction_id, description, transaction_type, is_reversed,
        transaction_date, amount, running_balance_derived, overdraft_amount_derived,
        created_date, appuser_id, debit) VALUES ('{$sessint_id}', '{$branch_id}',
        '{$acct_no}', '{$sproduct_id}', '{$staff_id}', '{$acct_id}', '{$client}', '{$transid}', '{$descrip}', '{$trans_type}', '{$irvs}',
        '{$date}', '{$amount}', '{$newbal}', '{$amount}',
        '{$date}', '{$users}', {$amount})";
        $res3 = mysqli_query($connection, $iat);

        $upglacct = "UPDATE `acc_gl_account` SET `organization_running_balance_derived` = '$newglball' WHERE int_id = '$sessint_id' && gl_code = '$pay_type'";
        $dbgl = mysqli_query($connection, $upglacct);
              if($dbgl){
                $deiption = "credit";
                $gl_acc = "INSERT INTO gl_account_transaction (int_id, branch_id, gl_code, transaction_id, description,
                transaction_type, teller_id, transaction_date, amount, gl_account_balance_derived, overdraft_amount_derived,
                  created_date, credit) VALUES ('{$sessint_id}', '{$branch_id}', '{$pay_type}', '{$transid}', '{$descrip}', '{$deiption}', '{$staff_id}',
                   '{$date}', '{$amount}', '{$newglball}', '{$amount}', '{$date}', '{$amount}')";
                   $res4 = mysqli_query($connection, $gl_acc);
                   if ($res4) {
                    $iacxt = "DELETE FROM `savings_acct_charge` WHERE id = '$wee'";
                   $rsdes3 = mysqli_query($connection, $iacxt);
                   if($rsdes3){
                    $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
                    echo header ("Location: ../mfi/charge_approval.php?message1=$randms");
                  } else {
                     $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                     echo "error";
                    echo header ("Location: ../mfi/charge_approval.php?message2=$randms");
                      // echo header("location: ../mfi/client.php");
                  }
                        }
              }
            }
// if ($connection->error) {
//   try {   
//       throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $mysqli->error);   
//   } catch(Exception $e ) {
//       echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
//       echo nl2br($e->getTraceAsString());
//   }
// }
}
else if(isset($_GET['delete'])){
  $id = $_GET['delete'];

  $dod = mysqli_query($connection, "DELETE FROM savings_acct_charge WHERE id = '$id'");
  if($dod){
    $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
    echo header ("Location: ../mfi/charge_approval.php?message5=$randms");
  } else {
     $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
     echo "error";
    echo header ("Location: ../mfi/charge_approval.php?message6=$randms");
      // echo header("location: ../mfi/client.php");
  }
}
?>