<?php
$page_title = "Loan Reconciliation";
$destination = "configuration.php";
include("header.php");
$branch_id = $_SESSION["branch_id"];
?>
<!-- do your front end -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $manual_amount = $_POST["amount"];
  $manual_payment_date = $_POST["payment_date"];
  $manual_payment_type = $_POST["payment_type"];
  $manual_repayment_id = $_POST["out_id"];
  $manual_account_no = $_POST["account_no"];
  // OUTTA HERE
  if (isset($_POST["amount"]) && isset($_POST["payment_date"]) && isset($_POST["payment_type"]) && isset($_POST["out_id"]) && isset($_POST["account_no"])) {
    // CHECK THE LOAN
    $query_rep = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE int_id = '$sessint_id' AND id = '$manual_repayment_id'");
    if (mysqli_num_rows($query_rep) > 0) {
    $ro = mysqli_fetch_array($query_rep);
    $old_principal = $ro["principal_amount"];
    $old_interest = $ro["interest_amount"];
    $old_general = $old_principal + $old_interest;
    $charge_amount = 0;
    $charge_type = "";
    // missin
    // if its interest first
    if ($manual_payment_type == "1") {
      $charge_type = "Loan Manual Interest Repayment";
      // if the amont is greater than interest turn it to zero
      if ($manual_amount >= $old_interest) {
        $int_bal = 0;
        $prin_bal = $old_principal;
        // charge amount will be the interest amount
        $charge_amount = $old_interest;
      } else {
        // else take the amount out of interest, out put the balance
        $int_bal = $old_interest - $manual_amount;
        $prin_bal = $old_principal;
        // charge amount will be initail amount
        $charge_amount = $manual_amount;
      }
      // end
    } else if ($manual_payment_type == "2") {
      $charge_type = "Loan Manual Principal Repayment";

      if ($manual_amount >= $old_principal) {
        $prin_bal = 0;
        $int_bal = $old_interest;
        $charge_amount = $old_principal;
      } else {
        $prin_bal = $old_principal - $manual_amount;
        $int_bal = $old_interest;
        $charge_amount = $manual_amount;
      }
      // end
    } else if ($manual_payment_type == "3") {
      $charge_type = "Loan Manual Principal and Interest Repayment";

      if ($manual_amount >= $old_general) {
        $prin_bal = 0;
        $int_bal = 0;
        $charge_amount = $old_general;
      } else {
        $charge_amount = $manual_amount;
        // else if the general is bigger
        $old_check = $old_general - $manual_amount;
        $prin_bal = ($old_check / 2);
        $int_bal = ($old_check / 2);
        // divide the amount into two
      }
    }
      // check the account if the money exist
      $query_account = mysqli_query($connection, "SELECT * FROM `account` WHERE account_no = '$manual_account_no' AND int_id = '$sessint_id'");
      if (mysqli_num_rows($query_account) > 0) {
        $ad = mysqli_fetch_array($query_account);
        $account_id = $ad["id"];
        $client_id = $ad["client_id"];
        $branch_id = $ad["branch_id"];
        $old_account_balance = $ad["account_balance_derived"];
        $old_tot_withdrawal = $ad["total_withdrawals_derived"];
        // add the new account balance here
        $digits = 8;
        $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        $trans_id = $randms.$branch_id;
        $new_account_balance = $old_account_balance - $charge_amount;
        $new_tot_withdrawal = $old_account_balance + $charge_amount;
        // REMOTE
       if ($old_account_balance >= $charge_amount) {
        $update_account = mysqli_query($connection, "UPDATE `account` SET account_balance_derived = '$new_account_balance', total_withdrawals_derived = '$new_tot_withdrawal' WHERE id = '$account_id'");
        if ($update_account) {
          $insert_account_transaction = mysqli_query($connection, "INSERT INTO `account_transaction` (`int_id`, `branch_id`,
          `product_id`, `account_id`, `account_no`, `client_id`, `teller_id`, `transaction_id`,
          `description`, `transaction_type`, `is_reversed`, `transaction_date`, `amount`, `overdraft_amount_derived`,
          `balance_end_date_derived`, `balance_number_of_days_derived`, `running_balance_derived`,
          `cumulative_balance_derived`, `created_date`, `appuser_id`, `manually_adjusted_or_reversed`, `debit`, `credit`) 
          VALUES ('{$sessint_id}', '{$branch_id}', '0', '{$account_id}', '{$manual_account_no}', '{$client_id}', '0', '{$trans_id}',
          '{$charge_type}', 'loan_repayment', '0', '{$manual_payment_date}', '{$charge_amount}', '{$charge_amount}',
          '{$manual_payment_date}', '0', '{$new_account_balance}',
          '{$new_account_balance}', '{$manual_payment_date}', '0', '0', '{$charge_amount}', '0.00')");
          if ($insert_account_transaction) {
            if ($prin_bal < 1 && $int_bal < 1) {
              $install = "0";
            } else {
              $install = "1";
            }
            $update_repayment = mysqli_query($connection, "UPDATE `loan_repayment_schedule` SET principal_amount = '$prin_bal', interest_amount = '$int_bal', installment = '$install' WHERE id = '$manual_repayment_id' AND int_id = '$sessint_id'");
            if ($update_repayment) {
              echo '<script type="text/javascript">
              $(document).ready(function(){
               swal({
                type: "success",
                title: "Repayment Successful",
                text: "Thank you",
               showConfirmButton: false,
                timer: 2000
                })
                });
               </script>
              ';
            } else {
              echo '<script type="text/javascript">
            $(document).ready(function(){
             swal({
              type: "error",
              title: "Error Updating Repayment",
              text: "Please check User Account",
             showConfirmButton: false,
              timer: 2000
              })
              });
             </script>
            ';
            }
          } else {
            echo '<script type="text/javascript">
            $(document).ready(function(){
             swal({
              type: "error",
              title: "Error Posting Account Transaction",
              text: "Please check User Account",
             showConfirmButton: false,
              timer: 2000
              })
              });
             </script>
            ';
          }
        } else {
          echo '<script type="text/javascript">
    $(document).ready(function(){
     swal({
      type: "error",
      title: "Account Didnt update",
      text: "Please check User Account",
     showConfirmButton: false,
      timer: 2000
      })
      });
     </script>
    ';
        }
       } else {
        echo '<script type="text/javascript">
        $(document).ready(function(){
         swal({
          type: "error",
          title: "Insufficient Fund",
          text: "Please check User Account",
         showConfirmButton: false,
          timer: 2000
          })
          });
         </script>
        ';
       }
      } else {
        echo '<script type="text/javascript">
    $(document).ready(function(){
     swal({
      type: "error",
      title: "Account Not Found",
      text: "Please check User Account",
     showConfirmButton: false,
      timer: 2000
      })
      });
     </script>
    ';
      }
    
    } else {
      echo '<script type="text/javascript">
      $(document).ready(function(){
       swal({
        type: "error",
        title: "Payment Data is Missing",
        text: "Please check loan data",
       showConfirmButton: false,
        timer: 2000
        })
        });
       </script>
      ';
    }
  } else {
    echo '<script type="text/javascript">
    $(document).ready(function(){
     swal({
      type: "error",
      title: "Payment Data is Missing",
      text: "Please check loan data",
     showConfirmButton: false,
      timer: 2000
      })
      });
     </script>
    ';
  }
  // END OUTTA HERE
}
?>
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Loan Reconciliation</h4>
              
                  <!-- Insert number users institutions -->
                </div>
                <?php
                $query_loan = mysqli_query($connection, "SELECT * FROM `loan` WHERE int_id = '$sessint_id' AND total_outstanding_derived > 0");
                ?>
                <div class="card-body">
                  <div class="table-responsive">
                  <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                        <!-- <tr> -->
                       
                          <th>Account Name</th>
                          <th>Account Number</th>
                          <th>Loan Term</th>
                          <th>Interest Rate</th>
                          <th>Principal Amount</th>
                          <th>Loan Outstanding</th>
                          <th>Edit</th>
                        <!-- </tr> -->
                      </thead>
                      <tbody>
                      <?php
                      if (mysqli_num_rows($query_loan) > 0){
                          while ($row = mysqli_fetch_array($query_loan)) {
                      ?>
                        <tr>
                            <?php
                            $client_id = $row["client_id"];
                            $query_client = mysqli_query($connection, "SELECT * FROM client WHERE id ='$client_id' AND int_id = '$sessint_id'");
                            $cm = mysqli_fetch_array($query_client);
                            $firstname = strtoupper($cm["firstname"]." ".$cm["lastname"]);
                            ?>
                          <td><?php echo $firstname ?></td>
                          <td><?php echo $row["account_no"] ?></td>
                          <td><?php echo $row["loan_term"]." ".$row["repay_every"]."(s)"; ?></td>
                          <td><?php echo $row["interest_rate"]."%"; ?></td>
                          <td><?php echo "₦ ".number_format($row["principal_amount"], 2); ?></td>
                          <td><?php echo "₦ ".number_format($row["total_outstanding_derived"], 2); ?></td>
                          <td>
                          <div class="btn-group">
                            <button type="button" onclick="location.href='loan_report_view.php?edit=<?php echo $row['id'] ?>'" class="btn btn-success">View</button>
                            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" id="l_check_<?php echo $row["id"];?>" data-loan-id="<?php echo $row["id"]?>" data-toggle="modal" data-target=".bd-example-modal-lg">Pay Loan</a>
                                      
                                      <a class="dropdown-item" href="loan_repayment_view.php?id=<?php echo $row["id"]; ?>">Edit Loan Repayment</a>
                                    </div>
                                  </div> 
                          </td>                         
                        </tr>
                        <script>
 $(document).ready(function() {
    $('#l_check_<?php echo $row["id"] ?>').on("click", function(){
        var id = $(this).data("loan-id");
        $.ajax({
           url:"ajax_post/loan_rec_check.php",
           method:"POST",
           data:{id:id},
           success:function(data){
             $('#done_loan').html(data);
           }
      });
    });
 });
</script>
                        <!-- <tr> -->
                        <?php
                          }
                      } else {
                          ?>
                          <tr>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td> 
                          <td>
                          <div class="btn-group" disabled>
                            <button type="button" disabled class="btn btn-success">View</button>
                            <button type="button" disabled class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                               <a class="dropdown-item" disabled href="#">Pay Loan</a>
                               <a class="dropdown-item" disabled href="#">Edit Loan Repayment</a>
                            </div>
                           </div> 
                          </td>                         
                        </tr>
                        <tr>
                          <?php
                      }
                        ?>
                      </tbody>
                    </table>
                    <!-- popup -->
                       <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="card card-signup card-plain">
                                          <div class="modal-header">
                                          Repay Loan Manually
                                            </div>
                              </div>

               <div class="modal-body">
                   
                    <form class="form" method="POST">
                       
                        <div class="card-body">
                          <!-- creazy -->
                          <div id="done_loan"></div>
                        </div>
                    </form>
                    
                </div>
  </div>
  <!-- body -->

</div>
                    <!-- end -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<!-- end your front end -->
<?php
include("footer.php");
?>