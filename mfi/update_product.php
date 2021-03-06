<?php

$page_title = "Edit Product";
$destination = "connect.php";
    include("header.php");

?>
<?php
 if (isset($_GET["edit"])) {
  $user_id = $_GET["edit"];
  $update = true;
  $value = mysqli_query($connection, "SELECT * FROM product WHERE id='$user_id' && int_id='$sessint_id'");

  if ($value) {
    $n = mysqli_fetch_array($value);
    $int_id = $n['int_id'];
    $charge_id = $n['charge_id'];
    $name = $n['name'];
    $short_name = $n['short_name'];
    $description = $n['description'];
    $fund_id = $n['fund_id'];
    $in_amt_multiples = $n['in_amt_multiples'];
    $principal_amount = $n['principal_amount'];
    $min_principal_amount = $n['min_principal_amount'];
    $max_principal_amount = $n['max_principal_amount'];
    $loan_term = $n['loan_term'];
    $min_loan_term = $n['min_loan_term'];
    $max_loan_term = $n['max_loan_term'];
    $repayment_frequency = $n['repayment_frequency'];
    $repayment_every = $n['repayment_every'];
    $interest_rate = $n['interest_rate'];
    $min_interest_rate = $n['min_interest_rate'];
    $max_interest_rate = $n['max_interest_rate'];
    $interest_rate_applied = $n['interest_rate_applied'];
    $interest_rate_methodoloy = $n['interest_rate_methodoloy'];
    $ammortization_method = $n['ammortization_method'];
    $cycle_count = $n['cycle_count'];
    $auto_allocate_overpayment = $n['auto_allocate_overpayment'];
    $additional_charge = $n['additional_charge'];
    $auto_disburse = $n['auto_disburse'];
    $linked_savings_acct = $n['linked_savings_acct'];
    $grace_on_princ_amt = $n['grace_on_principal_amount'];
    $grace_on_int_amt = $n['grace_on_interest_amount'];
    $grace_on_int_charged = $n['grace_on_interest_charged'];
  }
  if($repayment_every == "day"){
    $rpay_ever = "Days";
  }
  else if($repayment_every == "week"){
    $rpay_ever = "Weeks";
  }
  else if($repayment_every == "month"){
    $rpay_ever = "Months";
  }

  if($interest_rate_applied == "per_month"){
    $int_rate_app = "Per Month";
  }
  else if($interest_rate_applied == "per_year"){
    $int_rate_app = "Per Year";
  }

  if($interest_rate_methodoloy == "1"){
    $int_rate_my = "Flat";
  }
  else if($interest_rate_methodoloy == "2"){
    $int_rate_my = "Declining Balance";
  }

  if($ammortization_method == "equal_installment"){
    $ammort_mthd = "Equal Installment";
  }
  else if($ammortization_method == "equal_principal_payment"){
    $ammort_mthd = "Equal Principal Payment";
  }

  if($cycle_count == "no"){
    $cyc_ct = "No";
  }
  else if($cycle_count == "yes"){
    $cyc_ct = "Yes";
  }

  if($auto_allocate_overpayment == "no"){
    $au_allo_ovment = "No";
  }
  else if($auto_allocate_overpayment == "yes"){
    $au_allo_ovment = "Yes";
  }
  
  if($additional_charge == "no"){
    $addl_chg = "No";
  }
  else if($additional_charge == "yes"){
    $addl_chg = "Yes";
  }
  $dsopq = "SELECT * FROM acct_rule WHERE int_id = '$sessint_id' AND loan_product_id = '$user_id'";
  $fdq = mysqli_query($connection, $dsopq);
  $l = mysqli_fetch_array($fdq);
  $asst_fund_src = $l['asst_fund_src'];
  $asst_loan_port = $l['asst_loan_port']; 
  $li_overpayment = $l['li_overpayment'];
  $li_suspended_income = $l['li_suspended_income'];
  $inc_interest = $l['inc_interest'];
  $inc_fees = $l['inc_fees'];
  $inc_penalties = $l['inc_penalties']; 
  $inc_recovery = $l['inc_recovery']; 
  $exp_loss_written_off = $l['exp_loss_written_off']; 
  $exp_interest_written_off = $l['exp_interest_written_off'];
  $rule_type = $l['rule_type'];
  $insufficient_repayment = $l['insufficient_repayment'];

  $abc = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$asst_loan_port'");
  $a = mysqli_fetch_array($abc);
  $ast_ln_prt = $a['name'];

  $def = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$li_overpayment'");
  $b = mysqli_fetch_array($def);
  $li_overnt = $b['name'];

  $ghi = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$li_suspended_income'");
  $c = mysqli_fetch_array($ghi);
  $li_susd_ime = $c['name'];

  $jkl = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$inc_interest'");
  $d = mysqli_fetch_array($jkl);
  $inc_inst = $d['name'];

  $mno = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$inc_fees'");
  $e = mysqli_fetch_array($mno);
  $inc_fes = $e['name'];

  $pqr = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$inc_penalties'");
  $f = mysqli_fetch_array($pqr);
  $inc_pees = $f['name'];

  $stu = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$inc_recovery'");
  $g = mysqli_fetch_array($stu);
  $inc_reco = $g['name'];

  $vw = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$exp_loss_written_off'");
  $h = mysqli_fetch_array($vw);
  $exp_los_wttn_off = $h['name'];

  $xy = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$exp_interest_written_off'");
  $i = mysqli_fetch_array($xy);
  $exp_int_wttn_off = $i['name'];

  // $yz = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$rule_type'");
  // $j = mysqli_fetch_array($yz);
  // $rul_typ = $j['name'];

  $op = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$insufficient_repayment'");
  $k = mysqli_fetch_array($op);
  $insuf_rymnt = $k['name'];
}
?>
 <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Update Product</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <form id="form" action="../functions/product_update.php" method="POST">
                <div class="card-body">
                <div class = "row">
                    <div class = "col-md-12">
                      <div class = "form-group">
                        <!-- First tab -->
                        <div class="tab">
                        <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Name *:</label>
                        <input type="text" value="<?php echo $user_id;?>" hidden  name="prod_id" class="form-control"  id="prod_id" required>
                        <input type="text" value="<?php echo $name;?>"  name="name" class="form-control"  id="" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="shortLoanName" >Short Loan Name *</label>
                        <input type="text" class="form-control" name="short_name" value="<?php echo $short_name;?>" placeholder="Short Name..." required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="loanDescription" >Description *</label>
                        <input type="text" class="form-control" name="description" value="<?php echo $description;?>" placeholder="Description...." required>
                      </div>
                    </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="installmentAmount" >Installment Amount in Multiples</label>
                          <input type="text" class="form-control" name="in_amt_multiples" value="<?php echo $in_amt_multiples;?>" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="principal" >Principal</label>
                          <div class="row">
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="principal_amount" value="<?php echo $principal_amount;?>" placeholder="Default" required>
                            </div>
                            <div class="col-md-4">
                             <input type="text" class="form-control" name="min_principal_amount" value="<?php echo $min_principal_amount;?>" placeholder="Min" required>
                            </div>
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="max_principal_amount" value="<?php echo $max_principal_amount;?>" placeholder="Max" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="loanTerms" >Loan Term</label>
                          <div class="row">
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="loan_term" value="<?php echo $loan_term;?>" placeholder="Default" required>
                            </div>
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="min_loan_term" value="<?php echo $min_loan_term;?>" placeholder="Min" required>
                          </div>
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="max_loan_term" value="<?php echo $max_loan_term;?>" placeholder="Max" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                        <label for="repaymentFrequency" >Repayment Frequency *</label>
                        <div class="row">
                        <div class="col-md-8">
                          <input type="text" class="form-control " name="repayment_frequency" value="<?php echo $repayment_frequency;?>" required>
                        </div>
                        <div class="col-md-4">
                        <select class="form-control" name="repayment_every">
                          <option hidden value="<?php echo $repayment_every;?>"><?php echo $rpay_ever;?></option>
                          <option value="day">Days</option>
                          <option value="week">Weeks</option>
                          <option value="month">Months</option>
                        </select>
                        </div>
                        </div>
                        </div>
                      </div>                     
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="interestRate" >Interest Rate</label>
                          <div class="row">
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="interest_rate" value="<?php echo $interest_rate;?>" placeholder="Default" required>
                            </div>
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="min_interest_rate" value="<?php echo $min_interest_rate;?>" placeholder="Min" required>
                            </div>
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="max_interest_rate" value="<?php echo $max_interest_rate;?>" placeholder="Max" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="interestRateApplied" >Interest Rate Applied *</label>
                          <select class="form-control" name="interest_rate_applied" >
                          <option hidden value="<?php echo $interest_rate_applied;?>"><?php echo $int_rate_app;?></option>
                            <option value="per_month">Per Month</option>
                            <option value="per_year">Per Year</option>
                          </select>
                        </div>
                      </div>

                        <div class="col-md-6" hidden>
                        <div class="form-group">
                          <label for="interestRateApplied" >Enable Balloon repayment</label>
                          <select class="form-control" name="enable" >
                           <option value="no">No</option>
                            <option value="yes">Yes</option>
                          </select>
                        </div>
                      </div>
                    <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4">
                     
                      <div class="form-group">
                        <label for="loanDescription" >Grace on principal payment</label>
                        <input type="text" class="form-control" name="grace_on_principal" value="<?php echo $grace_on_princ_amt;?>" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="loanDescription" >Grace on interest payment</label>
                        <input type="text" class="form-control" name="grace_on_interest" value="<?php echo $grace_on_int_amt;?>" required>
                      </div>
                    </div>
                    <div class="col-md-4" hidden>
                      <div class="form-group">
                        <label for="loanDescription" >Grace on interest charged</label>
                        <input type="text" class="form-control" name="grace_on_interest_charged" value="<?php echo $grace_on_int_charged;?>" required>
                      </div>
                    </div>
                    </div>
                    </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="interestMethodology" >Interest Methodology *</label>
                          <select class="form-control" name="interest_rate_methodoloy" >
                            <option hidden value="<?php echo $interest_rate_methodoloy;?>"><?php echo $int_rate_my;?></option>
                            <option value ="1">Flat</option>
                            <option value ="2">Declining Balance</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="amortizatioMethody" >Amortization Method *</label>
                          <select class="form-control" name="ammortization_method" required>
                          <option hidden value="<?php echo $ammortization_method;?>"><?php echo $ammort_mthd;?></option>
                            <option value="equal_installment">Equal Installments</option>
                            <option value="equal_principal_payment">Equal Principal Payment</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="loanCycleCount" >Include In Loan Cycle Count </label>
                          <select class="form-control" name="cycle_count" required>
                          <option hidden value="<?php echo $cycle_count;?>"><?php echo $cyc_ct;?></option>
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6" hidden>
                        <div class="form-group">
                          <label for="overPayment" >Automatically Allocate Overpayment </label>
                          <select class="form-control" name="auto_allocate_overpayment" required>
                          <option hidden value="<?php echo $auto_allocate_overpayment;?>"><?php echo $au_allo_ovment;?></option>  
                          <option value="no">No</option>
                            <option value="yes">Yes</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6" hidden>
                       <div class="form-group">
                          <label for="additionalCharges" >Allow Additional Charges </label>
                          <select class="form-control" name="additional_charge" required>
                            <option hidden value="<?php echo $additional_charge;?>"><?php echo $addl_chg;?></option>    
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                          </select>
                        </div>
                      </div>
                  </div>
                        </div>
                        <!-- First tab -->
                         <!-- Second tab -->
                         <div class="tab">
                         <?php
                      // load user role data
                      function fill_charges($connection)
                      {
                      $sint_id = $_SESSION["int_id"];
                      $org = "SELECT * FROM charge WHERE int_id = '$sint_id' && charge_applies_to_enum = '1' && is_active = '1'";
                      $res = mysqli_query($connection, $org);
                      $output = '';
                      while ($row = mysqli_fetch_array($res))
                      {
                        $output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                      }
                      return $output;
                      }
                      ?>
                         <h3>Charges</h3>
                    <div class="form-group">
                      <div class="row">
                      <div class="col-md-4">
                      <label>Charges:</label>
                      <input id="sde" type="text" value="<?php echo $user_id;?>" hidden /> 
                      <select name="charge_id" class="form-control" id="charges">
                        <option value="">select an option</option>
                        <?php echo fill_charges($connection); ?>
                      </select>
                      </div>
                      <script>
                              $(document).ready(function() {
                                $('#charges').on("change", function(){
                                  var id = $(this).val();
                                  var user = $('#sde').val();
                                  $.ajax({
                                    url:"ajax_post/update_loan_product_table.php",
                                    method:"POST",
                                    data:{id:id, user:user},
                                    success:function(data){
                                      $('#idd').html(data);
                                    }
                                  })
                                });
                              });
                            </script>
                      <div id="idd" class="col-md-12">
                      <table id="tabledat4" class="table" style="width: 100%;">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM product_loan_charge WHERE int_id ='$sessint_id' AND product_loan_id = '$user_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                      <th>Name</th>
                      <th>Charge</th>
                      <th>Collected On</th>
                      <th>Delete</th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                          <?php
                            $did = $row['id'];
                            $charge_id = $row['charge_id'];
                            $fid = "SELECT * FROM charge WHERE int_id = '$sessint_id' AND id ='$charge_id'";
                            $dfdf = mysqli_query($connection, $fid);
                            $d = mysqli_fetch_array($dfdf);
                            $name = $d['name'];
                            $amt = $d['amount'];
                            $ds = $d['charge_calculation_enum'];
                            $values = $d["charge_time_enum"];
                            if ($ds == 1) {
                              $chg = $amt." Flat";
                            } else {
                              $chg = $amt. "% of Loan Principal";
                            }
                            if ($values == 1) {
                              $xs = "Disbursement";
                            } else if ($values == 2) {
                              $xs = "Manual Charge";
                            } else if ($values == 3) {
                              $xs = "Savings Activiation";
                            } else if ($values == 5) {
                              $xs = "Deposit Fee";
                            } else if ($values == 6) {
                              $xs = "Annual Fee";
                            } else if ($values == 8) {
                              $xs = "Installment Fees";
                            } else if ($values == 9) {
                              $xs = "Overdue Installment Fee";
                            } else if ($values == 12) {
                              $xs = "Disbursement - Paid With Repayment";
                            } else if ($values == 13) {
                              $xs = "Loan Rescheduling Fee";
                            } 
                          ?>
                          <th><?php echo $name; ?></th>
                          <th><?php echo $chg; ?></th>
                          <th><?php echo $xs; ?></th>
                          <td><div  data-id='<?= $did; ?>' class ="test"><a class="btn btn-danger">Delete</a></div></td>
                         </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                    </table>
                      </div>
                      </div>
                    </div>
                          </div>
                          <!-- Second tab -->
                           <!-- Third tab -->
                        <div class="tab">
                        <div class="row">
                          <!-- replace values with loan data -->
                          <div class="col-md-12">
                      <h5 class="card-title">Accounting Rules</h5>
                        <div class="position-relative form-group ">
                            <div>
                                <div class="custom-radio custom-control">
                                    <input type="radio" id="cashBased" checked name="acc" class="custom-control-input">
                                    <label class="custom-control-label" for="cashBased">Cash Based</label>
                                </div>
                                <div class="custom-radio custom-control">
                                    <input type="radio" id="accuralP" disabled name="acc" class="custom-control-input">
                                    <label class="custom-control-label" for="accuralP">Accural (Periodic)</label>
                                </div>
                                <div class="custom-radio custom-control">
                                    <input type="radio" id="accuralU" disabled name="acc" class="custom-control-input">
                                    <label class="custom-control-label" for="accuralU">Accural (Upfront)</label>
                                </div>
                            </div>
                        </div>
                          </div>
                          <div class="col-md-6">
                            <br>
                        <h5 class="card-title">Assets</h5>
                          <div class="position-relative form-group">
                            <div class="form-group">
                              <?php 
                              function fill_asset($connection)
                              {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && classification_enum = '1' AND parent_id != 0 ORDER BY name ASC";
                                $res = mysqli_query($connection, $org);
                                $output = '';
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.strtoupper($row["name"]).' </option>';
                                }
                                return $output;
                              }
                              ?>
                              <!-- <div class="col-md-8">
                              <label for="charge" class="form-align">Fund Source</label>
                              <select class="form-control form-control-sm" name="asst_fund_src">
                                <option value="">--</option>
                              </select>
                              </div> -->
                            </div>
                            <div class="form-group">
                            <div class="col-md-8">
                            <label for="charge" class="form-align ">Loan Portfolio</label>
                            <select class="form-control form-control-sm" name="asst_loan_port">
                              <option value="<?php echo $asst_loan_port;?>"><?php echo $ast_ln_prt;?></option>
                              <?php echo fill_asset($connection) ?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-8">
                            <label for="charge" class="form-align">Insufficient Repayment</label>
                            <select class="form-control form-control-sm" name="asst_insuff_rep">
                              <option value="<?php echo $insufficient_repayment;?>"><?php echo $insuf_rymnt;?></option>
                              <?php echo fill_asset($connection) ?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group">
                          <div class="col-md-8">
                            <label for="charge" class="form-align ">Suspended Income</label>
                            <select class="form-control form-control-sm" name="li_suspended_income">
                              <option value="<?php echo $li_suspended_income;?>"><?php echo $li_susd_ime;?></option>
                              <?php echo fill_asset($connection)?>
                            </select>
                          </div>
                          </div>
                          </div>
                      <!-- <h5 class="card-title">Liabilities</h5> -->
                      <?php
                              function fill_lia($connection)
                              {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && classification_enum = '2' AND parent_id !=0 ORDER BY name ASC";
                                $res = mysqli_query($connection, $org);
                                $output = '';
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.strtoupper($row["name"]).' </option>';
                                }
                                return $output;
                              }
                              ?>
                      <div hidden class="position-relative form-group">
                        <div class="form-group">
                        <div class="col-md-8">
                            <label for="charge" class="form-align ">Overpayments</label>
                            <select class="form-control form-control-sm" name="li_overpayment">
                              <option value="<?php echo $li_overpayment;?>"><?php echo $li_overnt;?></option>
                              <?php echo fill_lia($connection)?>
                            </select>
                        </div>
                            </div>
                      </div> 
                      <h5 class="card-title">Income</h5>
                      <div class="position-relative form-group">
                          <div class="form-group">
                          <?php
                              function fill_in($connection)
                              {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && classification_enum = '4' AND parent_id !=0 ORDER BY name ASC";
                                $res = mysqli_query($connection, $org);
                                $output = '';
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.strtoupper($row["name"]).' </option>';
                                }
                                return $output;
                              }
                              ?>
                          <div class="col-md-8">
                              <label for="charge" class="form-align ">Income for Interest</label>
                              <select class="form-control form-control-sm" name="inc_interest">
                                <option value="<?php echo $inc_interest;?>"><?php echo $inc_inst;?></option>
                                <?php echo fill_in($connection) ?>
                              </select>
                          </div>
                          </div>
                          <div class="form-group">
                          <div class="col-md-8">
                              <label for="charge" class="form-align ">Income from Fees</label>
                              <select class="form-control form-control-sm" name="inc_fees">
                                <option value="<?php echo $inc_fees;?>"><?php echo $inc_fes;?></option>
                                <?php echo fill_in($connection) ?>
                              </select>
                          </div>
                          </div>
                          <div class="form-group">
                          <div class="col-md-8">
                              <label for="charge" class="form-align ">Income from Penalties</label>
                              <select class="form-control form-control-sm" name="inc_penalties">
                                <option value="<?php echo $inc_penalties;?>"><?php echo $inc_pees;?></option>
                                <?php echo fill_in($connection) ?>
                              </select>
                          </div>
                          </div>
                          <div class="form-group">
                          <div class="col-md-8">
                              <label for="charge" class="form-align ">Income from Recovery</label>
                              <select class="form-control form-control-sm" name="inc_recovery">
                                <option value="<?php echo $inc_recovery;?>"><?php echo $inc_reco;?></option>
                                <?php echo fill_in($connection) ?>
                              </select>
                          </div>
                          </div>
                          <!-- <div class="form-group">
                          <div class="col-md-8">
                              <label for="charge" class="form-align ">Income from Recovery</label>
                              <select class="form-control form-control-sm" name="">
                                <option value="">--</option>
                              </select>
                          </div>
                          </div> -->
                        </div>
                        <!-- next -->
                        <h5 class="card-title">Expenses</h5>
                        <div class="position-relative form-group">
                        <?php 
                              function fill_exp($connection)
                              {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && classification_enum = '5' ORDER BY name ASC";
                                $res = mysqli_query($connection, $org);
                                $output = '';
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.$row["name"].' </option>';
                                }
                                return $output;
                              }
                              ?>
                          <div class="form-group">
                          <div class="col-md-8">
                              <label for="charge" class="form-align ">Losses Written Off</label>
                              <select class="form-control form-control-sm" name="exp_loss_written_off">
                                <option value="<?php echo $exp_loss_written_off;?>"><?php echo $exp_los_wttn_off;?></option>
                                <?php echo fill_exp($connection) ?>
                              </select> 
                          </div>
                          </div>
                          <div class="form-group">
                          <div class="col-md-8">
                              <label for="charge" class="form-align ">Interest Written Off</label>
                              <select class="form-control form-control-sm" name="exp_interest_written_off">
                                <option value="<?php echo $exp_interest_written_off;?>"><?php echo $exp_int_wttn_off;?></option>
                                <?php echo fill_exp($connection) ?>
                              </select>
                          </div>
                          </div>
                        </div>                
                          </div>
                      <div class="col-md-6">
                      <p>
                        <b style="font-size: 20px">
                        Accounting Instruction
                      </b>
                        </p>
                              <button class="btn btn-dark" type="button" data-toggle="modal" data-target="#exampleModal"><i class="material-icons">add</i></button>
                              <span>
                              Configure Fund sources for payment channels
                              </span>
                              <div id="fdof">
                              <div class="table-responsive">
                              <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM prod_acct WHERE int_id ='$sessint_id' AND prod_id = '$user_id' AND type ='pay'";
                        $result = mysqli_query($connection, $query);
                      ?>
                            <th> <b> Payment Type </b></th>
                            <th> <b>Assets Account <b></th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                          <th><?php echo $row['name']; ?></th>
                          <th><?php echo $row['acct']; ?></th>
                          <td><a class="btn btn-danger">Delete</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                    </table>
  </div>
  </div>
                            <!-- <span>
                            Map Fees to Specific Income accounts
                            </span> -->
                            <button class="btn btn-dark" type="button" data-toggle="modal" data-target="#exampleModal3"><i class="material-icons">add</i></button>
                            <span>
                            Map Penalties to Specific income accounts
                            </span>
                            <div id="qoem">
                              <div class="table-responsive">
                              <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM prod_acct WHERE int_id ='$sessint_id' AND prod_id = '$user_id' AND type ='pen'";
                        $result = mysqli_query($connection, $query);
                      ?>
                            <th> <b> Penalty </b></th>
                            <th> <b> Income Account <b></th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                          <th><?php echo $row['name']; ?></th>
                          <th><?php echo $row['acct']; ?></th>
                          <td><a class="btn btn-danger">Delete</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                    </table>
                              </div>
                            </div>
                          <!-- <div class="col-md-8"> -->
                          <!-- </div> -->
                        </div>
                        <!-- <div class="row"> -->
                          
<!-- Modal -->
<?php 
function fill_all($connection)
{
  $sint_id = $_SESSION["int_id"];
  $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' ORDER BY name ASC";
  $res = mysqli_query($connection, $org);
  $output = '';
  while ($row = mysqli_fetch_array($res))
  {
    $output .= '<option value = "'.$row["gl_code"].'"> '.$row["name"].' </option>';
  }
  return $output;
}
?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Accounting Instruction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
          <div class="form-group">
          <?php 
            function fill_payment($connection)
            {
              $sint_id = $_SESSION["int_id"];
              $getacct = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE name LIKE '%due from bank%' && int_id = '$sint_id'");
              $cx = mysqli_fetch_array($getacct);
              $dfb = $cx["id"];

              $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && classification_enum = '1' && parent_id = '$dfb' ORDER BY name ASC";
              $res = mysqli_query($connection, $org);
              $output = '';
              while ($row = mysqli_fetch_array($res))
              {
                $output .= '<option value = "'.$row["gl_code"].'"> '.$row["name"].' </option>';
              }
              return $output;
            }
          ?>
         <label for="charge" class="form-align ">Payment</label>
         <div id="ipayment_id">
              <select id="payment_gl" class="form-control form-control-sm" name="">
              <option value="">--</option>
              <?php echo fill_payment($connection)?>
            </select>
         </div>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
         <label for="charge" class="form-align">Asset Account</label>
              <select class="form-control form-control-sm" name="" id="account_gl">
              <option value="">--</option>
              <?php echo fill_asset($connection) ?>
            </select>
          </div>
          </div>
          <script>
                    $(document).ready(function() {
                      $('#run_pay').on("click", function(){
                        var paymentgl = $('#payment_gl').val();
                        var accountgl = $('#account_gl').val();
                        var prod_id = $('#prod_id').val();
                        $.ajax({
                          url:"ajax_post/update_loan_payment.php",
                          method:"POST",
                          data:{paymentgl:paymentgl, accountgl:accountgl, prod_id:prod_id},
                          success:function(data){
                            $('#fdof').html(data);
                          }
                        })
                      });
                    });

                    $(document).ready(function() {
                      $('#ediw').on("click", function(){
                        var penaltygl = $('#penaltygl').val();
                        var incomegl = $('#incomegl').val();
                        var prod_id = $('#prod_id').val();
                        $.ajax({
                          url:"ajax_post/update_loan_payment.php",
                          method:"POST",
                          data:{penaltygl:penaltygl, incomegl:incomegl, prod_id:prod_id},
                          success:function(data){
                            $('#qoem').html(data);
                          }
                        })
                      });
                    });
                </script>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="run_pay">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal2 -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel2">Add Fee To Income Account Rule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
          <div class="form-group">
          <?php 
              function fill_fee($connection)
                {
                                $sint_id = $_SESSION["int_id"];
                                $getacct = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE name LIKE '%FEE%' && parent_id = '0' && int_id = '$sint_id'");
                                $cx = mysqli_fetch_array($getacct);
                                $dfb = $cx["id"];

                                $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && parent_id = '$dfb' ORDER BY name ASC";
                                $res = mysqli_query($connection, $org);
                                $output = '';
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.$row["name"].' </option>';
                                }
                                return $output;
                              }
                              ?>
         <label for="charge" class="form-align ">Fee</label>
         <script>
           $(document).ready(function () {
             $('#run_pay3').on("change keyup paste click", function () {
               var id2 = $('#payment_id2').val();
               var int_id = $('#int_id').val();
               var main_p = $('#main_p').val();
               var idx2 = $('#payment_id_x2').val();
              //  new
               if (idx2 != '' && id2 !=  '') {
                $.ajax({
                 url: "ajax_post/payment_fee.php",
                 method: "POST",
                 data:{id2:id2, int_id:int_id, main_p:main_p, idx2:idx2},
                 success: function (data) {
                   $('#show_payment2').html(data);
                   document.getElementById("ipayment_id2").setAttribute("hidden", "");
                   document.getElementById("real_payment2").removeAttribute("hidden");
                 }
               })
               } else {
                //  poor the internet
               }
             });
           });
         </script>
         <div id="real_payment2" hidden></div>
         <div id="ipayment_id2">
         <select class="form-control form-control-sm" name="" id="payment_id2">
              <option value="">--</option>
              <?php echo fill_fee($connection) ?>
            </select>
         </div>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
         <label for="charge" class="form-align ">Income Account</label>
              <select class="form-control form-control-sm" name="" id="payment_id_x2">
              <option value="">--</option>
              <?php echo fill_in($connection) ?>
            </select> 
          </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="run_pay3">Save changes</button>
        <button type="button" class="btn btn-primary" id="run_pay4" hidden>Save changes</button>
      </div>
    </div>
  </div>
</div>
  <!-- Modal3 -->
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Penalty To Income Account Rule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
          <div class="form-group">
          <?php 
                              function fill_pen($connection)
                              {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && name LIKE '%penalty%' ORDER BY name ASC";
                                $res = mysqli_query($connection, $org);
                                $output = '';
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.$row["name"].' </option>';
                                }
                                return $output;
                              }
                              ?>
         <label for="charge" class="form-align ">Penalty</label>
         <div id="real_payment3"></div>
         <div id="ipayment_id3">
         <select class="form-control form-control-sm" name="" id="penaltygl">
              <option value="">--</option>
              <?php echo fill_pen($connection) ?>
            </select> 
         </div>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
         <label for="charge" class="form-align ">Income Account</label>
              <select class="form-control form-control-sm" name="" id="incomegl">
              <option value="">--</option>
              <?php echo fill_in($connection) ?>
            </select> 
          </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="ediw">Save changes</button>
      </div>
    </div>
  </div>
</div>
                          <!-- </div> -->
                      </div>
                          </div>
                          <!-- Third tab -->
                          <div style="overflow:auto;">
                          <div style="float:right;">
                            <button class="btn btn-primary pull-right" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                            <button class="btn btn-primary pull-right" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                          </div>
                        </div>
                      <!-- Steppers -->
                      <!-- Circles which indicates the steps of the form: -->
                      <div style="text-align:center;margin-top:40px;">
                          <span class="step"></span>
                          <span class="step"></span>
                          <span class="step"></span>
                        </div>
                      </div>
                    </div>
                </div>
                </div>
                </form>
              </div>
            </div>
          </div>
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
    document.getElementById("nextBtn").innerHTML = "Update";
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
      valid = true; // This was change to true to disable the validation function. Should be reverted to FALSE after testing is complete
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
<script>
  $(document).ready(function(){

// Delete 
$('.test').click(function(){
    var el = this;

    // Delete id
    var id = $(this).data('id');
    
    var confirmalert = confirm("Delete this charge?");
    if (confirmalert == true) {
        // AJAX Request
        $.ajax({
            url: 'ajax_post/ajax_delete/delete_charge.php',
            type: 'POST',
            data: { id:id },
            success: function(response){

                if(response == 1){
                    // Remove row from HTML Table
                    $(el).closest('tr').css('background','tomato');
                    $(el).closest('tr').fadeOut(700,function(){
                        $(this).remove();
                    });
                }else{
                    alert('Invalid ID.');
                }
            }
        });
    }
});
});
</script>