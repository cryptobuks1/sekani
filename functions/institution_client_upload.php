<?php
// connection
include("connect.php");
session_start();
?>
<?php
$sessint_id = $_SESSION["int_id"];
$loan_officer_id = $_SESSION["user_id"];
$ctype = $_POST['ctype'];
$acct_type = $_POST['acct_type'];
$display_name = $_POST['display_name'];
// an account number generation
 $inttest = str_pad($sessint_id, 3, '0', STR_PAD_LEFT);
$usertest = str_pad($loan_officer_id, 3, '0', STR_PAD_LEFT);
$digits = 3;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$account_no = $inttest. "-" .$usertest. "-" .$randms;
// auto calculation for the account number generation
$first_name = $_POST['firstname'];
$last_name = $_POST['lastname'];
$middlename = $_POST['middlename'];
$phone = $_POST['phone'];
$phone2 = $_POST['phone2'];
$email = $_POST['email'];
$address = $_POST['address'];
$gender = $_POST['gender'];
$date_of_birth = $_POST['date_of_birth'];
$branch = $_POST['branch'];
$country = $_POST['country'];
$state = $_POST['state'];
$lga = $_POST['lga'];
$bvn = $_POST['bvn'];
$loan_status = "Not Active";
$activation_date = date("Y-m-d");
$submitted_on = date("Y-m-d");
// $sa = $_POST['sms_active'];
// $ea = $_POST['email_active'];
$id_card = $_POST['id_card'];
// an if statement to return uncheck value to 0
if ( isset($_POST['sms_active']) ) {
    $sms_active = 1;
} else {
    $sms_active = 0;
}

if ( isset($_POST['email_active']) ) {
    $email_active = 1;
} else { 
    $email_active = 0;
}

$image1 = $_FILES['signature']['name'];
$target1 = "clients/".basename($image1);

$image2 = $_FILES['idimg']['name'];
$target2 = "clients/".basename($image2);

$image3 = $_FILES['passport']['name'];
$target3 = "clients/".basename($image3);

if (move_uploaded_file($_FILES['signature']['tmp_name'], $target1)) {
    $msg = "Image uploaded successfully";
}else{
    $msg = "Failed to upload image";
}
if (move_uploaded_file($_FILES['idimg']['tmp_name'], $target2)) {
    $msg = "Image uploaded successfully";
}else{
    $msg = "Failed to upload image";
}
if (move_uploaded_file($_FILES['passport']['tmp_name'], $target3)) {
    $msg = "Image uploaded successfully";
}else{
    $msg = "Failed to upload image";
}
// gaurantors part
$query = "INSERT INTO client (int_id, loan_officer_id, client_type, account_type,
display_name, account_no,
firstname, lastname, middlename, mobile_no, mobile_no_2, email_address, address, gender, date_of_birth,
branch_id, country, state_of_origin, lga, bvn, sms_active, email_active, id_card,
passport, signature, id_img_url, loan_status, submittedon_date, activation_date) VALUES ('{$sessint_id}', '{$loan_officer_id}', '{$ctype}',
'{$acct_type}', '{$display_name}', '{$account_no}', '{$first_name}', '{$last_name}', '{$middlename}', '{$phone}', '{$phone2}',
'{$email}', '{$address}', '{$gender}', '{$date_of_birth}', '{$branch}',
'{$country}', '{$state}', '{$lga}', '{$bvn}', '{$sms_active}', '{$email_active}',
'{$id_card}', '{$image3}', '{$image1}', '{$image2}', '{$loan_status}',
'{$submitted_on}', '{$activation_date}')";

$res = mysqli_query($connection, $query);

 if ($res) {
    $acctquery = mysqli_query($connection, "SELECT * FROM client WHERE account_no = '$account_no'");
    if (count([$acctquery]) == 1) {
        $x = mysqli_fetch_array($acctquery);
        $int_id = $x['int_id'];
        $branch_id = $x['branch_id'];
        $account_no = $x['account_no'];
        $account_type = $x['account_type'];
        $client_id = $x['id'];
        $field_officer_id = $x['loan_officer_id'];
        $submittedon_date = $x['submittedon_date'];
        $submittedon_userid = $x['loan_officer_id'];
        $currency_code = "NGN";
        $activation_date = $x['activation_date'];
        $activation_userid = $x['loan_officer_id'];
        $account_balance_derived = 0;

        $accountins = "INSERT INTO account (int_id, branch_id, account_no, account_type,
        client_id, field_officer_id, submittedon_date, submittedon_userid,
        currency_code, activatedon_date, activatedon_userid,
        account_balance_derived) VALUES ('{$int_id}', '{$branch_id}', '{$account_no}',
        '{$account_type}', '{$client_id}', '{$field_officer_id}', '{$submittedon_date}',
        '{$submittedon_userid}', '{$currency_code}', '{$activation_date}', '{$activation_userid}',
        '{$account_balance_derived}')";

        $go = mysqli_query($connection, $accountins);
        if ($go) {
            echo header("location: ../mfi/client.php");
        } else {
            echo "error";
        }
    }

 } else {
     echo "<p>Error</p>";
 }
// if (move_uploaded_file($_FILES['image1']['tmp_name'], $target)) {
//     echo "Image uploaded successfully";
// }else{
//     echo "Failed to upload image";
// }
if ($connection->error) {
        try {   
            throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $mysqli->error);   
        } catch(Exception $e ) {
            echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
            echo nl2br($e->getTraceAsString());
        }
    }
?>
