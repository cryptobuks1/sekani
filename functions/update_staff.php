<?php 
include("connect.php")
?>
<?php
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
if (isset($_POST['int_name']) && isset($_POST['usertype'])) {
    $user_id = $_POST['user_id'];
    $staff_id = $_POST['staff_id'];
    $int_name = $_POST['int_name'];
    $username = $_POST['username'];
    $display_name = $_POST['display_name'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $status = $_POST['employee_status'];
    $phone = $_POST['phone'];
    $branch_id = $_POST['branch_id'];
    $address = $_POST['address'];
    $date_joined = $_POST['date_joined'];
    $org_role = $_POST['org_role'];
    $usertype = $_POST['usertype'];

if($_FILES['imagefile']['name']) {
  $temp = explode(".", $_FILES['imagefile']['name']);
  $randmst = str_pad(rand(0, pow(10, 7)-1), 10, '0', STR_PAD_LEFT);
  $img = $randmst. '.' .end($temp);
  if (move_uploaded_file($_FILES['imagefile']['tmp_name'], "staff/" . $img)) {
      $msg = "Image uploaded successfully";
  } else {
      $msg = "Image Failed";
  }  
} else {
  $img = $_POST['imagefileL'];
}

    $query = "UPDATE users SET username = '$username', usertype = '$usertype', branch_id = '$branch_id' WHERE id = '$user_id'";
    $result = mysqli_query($connection, $query);
    if($result) {
        $sec = "UPDATE staff SET int_name = '$int_name', username = '$username', branch_id = '$branch_id', display_name = '$display_name', email = '$email',
        first_name = '$first_name', last_name = '$last_name', phone = '$phone', employee_status = '$status', address = '$address', date_joined = '$date_joined',
        org_role = '$org_role', img = '$img' WHERE id = '$staff_id'";
        $res = mysqli_query($connection, $sec);
        if ($res) {
          // mamkemove
          if (isset($_POST["mon"])) {
            $mon = "1";
          } else {
            $mon = "0";
          }
          if (isset($_POST["tue"])) {
            $tue = "1";
          } else {
            $tue = "0";
          }
          if (isset($_POST["wed"])) {
            $wed = "1";
          } else {
            $wed = "0";
          }
          if (isset($_POST["thur"])) {
            $thur = "1";
          } else {
            $thur = "0";
          }
          if (isset($_POST["fri"])) {
            $fri = "1";
          } else {
            $fri = "0";
          }
          if (isset($_POST["sat"])) {
            $sat = "1";
          } else {
            $sat = "0";
          }
          if (isset($_POST["sun"])) {
            $sun = "1";
          } else {
            $sun = "0";
          }
        
          $start_time = $_POST["start_time"];
          $end_time = $_POST["end_time"];
          // done
          $query_restric = mysqli_query($connection, "UPDATE `staff_restriction` SET `start_time` = '$start_time', `end_time` = '$end_time', `mon` = '$mon', `tue` = '$tue', `wed` = '$wed', `thurs` = '$thur', `fri` = '$fri', `sat` = '$sat' WHERE staff_id = '$user_id'");
          // END DATE
          if ($query_restric) {
            $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
          echo header ("Location: ../mfi/staff_mgmt.php?message3=$randms");
          } else {
            $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
            echo "error";
           echo header ("Location: ../mfi/staff_mgmt.php?message4=$randms");
             // echo header("location: ../mfi/client.php");
          }
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/staff_mgmt.php?message4=$randms");
            // echo header("location: ../mfi/client.php");
        }
    } else {
    //   if ($connection->error) {
    //     try {   
    //         throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $mysqli->error);   
    //     } catch(Exception $e ) {
    //         echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
    //         echo nl2br($e->getTraceAsString());
    //     }
    // }
      echo header ("Location: ../mfi/staff_mgmt.php?message2=$randms");
    }
}
?>