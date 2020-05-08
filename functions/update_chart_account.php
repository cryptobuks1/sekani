<?php 
include("connect.php")
?>
<?php
if (isset($_POST['id'])) {
    $randms = str_pad(rand(0, pow(10, 8)-1), 10, '0', STR_PAD_LEFT);
    $id = $_POST['id'];
    $acct_name = $_POST['acct_name'];
    $gl_code = $_POST['gl_code'];
    $class_enum = $_POST['class_enum'];
    $ext_id = $_POST['ext_id'];
    $acct_use = $_POST['acct_use'];
    $man_acct = $_POST['man_allow'];
    $disable = $_POST['disable'];
    $descript = $_POST['descript'];

    $acct_type = 0;
    if($class_enum == 1){
        $acct_type = "ASSET";
    }
    else if($class_enum == 2) {
        $acct_type = "LIABILITY";
    }
    else if($class_enum == 3) {
        $acct_type = "EQUITY";
    }
    else if($class_enum == 4) {
        $acct_type = "INCOME";
    }
    else if($class_enum == 5) {
        $acct_type = "EXPENSE";
    }

        $sec = "UPDATE acc_gl_account SET name = '$acct_name', gl_code = '$gl_code', account_type = '$acct_type', external_id = '$ext_id',
        account_usage = '$acct_use', classification_enum='$class_enum', manual_journal_entries_allowed='$man_acct',
        description = '$descript' WHERE id = '$id'";
        $res = mysqli_query($connection, $sec);

        if ($res) {
          $_SESSION["Lack_of_intfund_$randms"] = " Account was updated successfully!";
          echo header ("Location: ../mfi/chart_account.php?message3=$randms");
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/chart_account.php?message4=$randms");
        }
}
?>