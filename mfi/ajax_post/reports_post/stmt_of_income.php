<?php
 include("../../../functions/connect.php");
 session_start();
 $out= '';
 $logo = $_SESSION['int_logo'];
$name = $_SESSION['int_full'];
$sessint_id = $_SESSION['int_id'];
$current = date('d/m/Y');
if(isset($_POST['start'])){
    $start = $_POST['start'];
    $end = $_POST['end'];
    $branch_id = $_POST['branch'];
    $starttime = strtotime($start);
    $endtime = strtotime($end);
    $curren = date("F d, Y", $endtime);
    $onemonth = date("F d, Y", strtotime("-1 month", $endtime));
    $onemonthly = date("Y-m-d", strtotime("-1 month", $endtime));
    $osdnd = strtotime($onemonthly);

    if($starttime > $osdnd){
      $onemontstart = date("Y-m-d", strtotime("-1 month", $starttime));
    }
    else{
      $onemontstart = $start;
    }

// Interest on loans data
$jfjf = mysqli_query($connection, "SELECT * FROM acct_rule WHERE int_id = '$sessint_id'");
  while($dsdsd = mysqli_fetch_array($jfjf)){
    $acct_rule_id =$dsdsd['id'];
    $interest_income = $dsdsd['inc_interest'];
    $fdof = mysqli_query($connection, "SELECT * FROM acct_rule WHERE int_id = '$sessint_id' AND inc_interest = '$interest_income'");
    $dfds = mysqli_num_rows($fdof);
    if($dfds > 1){
      // interest on loans current month
      $fdfi = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id ='$sessint_id' AND gl_code = '$interest_income' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
      $dov = mysqli_query($connection, $fdfi);
      $oof = mysqli_fetch_array($dov);
      $gl = $oof['credit'];
      $int_on_loans = $gl;
    
      // interest on loans previous month
      $fkdlf = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id ='$sessint_id' AND gl_code = '$interest_income' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
      $dff = mysqli_query($connection, $fkdlf);
      $df = mysqli_fetch_array($dff);
      $gfl = $df['credit'];
      $last_int_on_loans = $gfl;
    }
    else{
      while($er = mysqli_fetch_array($fdof)){
        // interest on loans current month
      $fdfi = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id ='$sessint_id' AND gl_code = '$interest_income' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
      $dov = mysqli_query($connection, $fdfi);
      $oof = mysqli_fetch_array($dov);
      $gl = $oof['credit'];
      $int_on_loans += $gl;
    
      // interest on loans previous month
      $fkdlf = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id ='$sessint_id' AND gl_code = '$interest_income' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
      $dff = mysqli_query($connection, $fkdlf);
      $df = mysqli_fetch_array($dff);
      $gfl = $df['credit'];
      $last_int_on_loans += $gfl;
      }
    }
    }

// Fines and Fees gl
$dfmldk = mysqli_query($connection, "SELECT * FROM charge WHERE int_id = '$sessint_id'");
while($jjc = mysqli_fetch_array($dfmldk)){
$jsk = $jjc['gl_code'];

$fdfi = "SELECT * FROM gl_account_transaction WHERE int_id ='$sessint_id' AND gl_code = '$jsk' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
$jssbi = mysqli_query($connection, $fdfi);
$d = mysqli_fetch_array($jssbi);
if(isset($d)){
$gl = $d['gl_account_balance_derived'];
}else{
  $gl = "0.00";
}
$curren_charge += $gl;

$dfke = "SELECT * FROM gl_account_transaction WHERE int_id ='$sessint_id' AND gl_code = '$jsk' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
$ddf = mysqli_query($connection, $dfke);
$ofs = mysqli_fetch_array($ddf);
if(isset($ofs)){
$gfl = $ofs['gl_account_balance_derived'];
}
else{
  $gfl = "0.00";
}
$last_mon_charge += $gfl;
}
// Liabilities Report
$liab = "SELECT * FROM acc_gl_account WHERE int_id='$sessint_id' AND classification_enum = '2'";
$iod = mysqli_query($connection, $liab);
while($re = mysqli_fetch_array($iod)){
  $dofs = $re['gl_code'];
  $dops = "SELECT * FROM gl_account_transaction WHERE int_id ='$sessint_id' AND gl_code = '$dofs' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
$sklsd = mysqli_query($connection, $dops);
$ui = mysqli_fetch_array($sklsd);
if(isset($ui)){
$rer = $ui['gl_account_balance_derived'];
}else{
  $rer = "0.00";
}
$liabilities += $rer;

$kldfk = "SELECT * FROM gl_account_transaction WHERE int_id ='$sessint_id' AND gl_code = '$dofs' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
$odf = mysqli_query($connection, $kldfk);
$pdfo = mysqli_fetch_array($odf);
if(isset($pdfo)){
$pso = $pdfo['gl_account_balance_derived'];
}
else{
  $pso = "0.00";
}
$otgerliabi += $pso;
}
// NET INTEREST INCOME
$net_interest_income =$int_on_loans - $liabilities;
$net_interest_income_last = $last_int_on_loans - $otgerliabi;
// Total Revenue Income
$ttl_revenue_curren = $net_interest_income + $curren_charge;
$ttl_revenue_last = $net_interest_income_last + $last_mon_charge;
// Operating Expenses
function fill_operation($connection, $sessint_id, $start, $onemontstart, $end, $onemonthly)
{
  $stateg = "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND parent_id !='0' AND classification_enum ='5' ORDER BY name ASC";
  $state1 = mysqli_query($connection, $stateg);
  $outxx = '';
  while ($row = mysqli_fetch_array($state1))
  {
    $namde = $row['name'];

    $glcode = $row['gl_code'];

    $opbalance = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$glcode' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
    $fodf = mysqli_query($connection, $opbalance);
      $n = mysqli_fetch_array($fodf);
      if(isset($n)){
      $endbal = number_format($n['credit'], 2);
      }else{
        $endbal = "0.00";
      }
    
    $fdf = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$glcode' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
    $ss = mysqli_query($connection, $fdf);
      $u = mysqli_fetch_array($ss);
      if(isset($u)){
      $lastmon = number_format($u['credit'], 2);
      }
      else{
        $lastmon = "0.00";
      }
if($endbal == '0.00' && $lastmon == '0.00'){
  $outxx .= '';
}
else{
  $outxx .= '
  <tr>
  <td>'.$namde.'</td>
  <td style="text-align: center">'.$endbal.'</td>
  <td style="text-align: center">'.$lastmon.'</td>
</tr>';
}
  }
return $outxx;
}

// While loop for total operating expense
$xccfdg = "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND parent_id !='0' AND classification_enum ='5' ORDER BY name ASC";
$fdff = mysqli_query($connection, $xccfdg);
while ($q = mysqli_fetch_array($fdff))
  {
    $gllcode = $q['gl_code'];
// current month
    $kutty = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$gllcode' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
    $cxcxfd = mysqli_query($connection, $kutty);
    $j = mysqli_fetch_array($cxcxfd);
    if(isset($j)){
    $endbal = $j['credit'];
    }else{
      $endbal = "0.00";
    }
    // previous month
    $kuoo = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$gllcode' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
    $po = mysqli_query($connection, $kuoo);
      $o = mysqli_fetch_array($po);
      if(isset($o)){
      $lastmon = $o['credit'];
      }
      else{
        $lastmon = "0.00";
      }
      $ttlcurrenmonth +=$endbal;
      $ttlastmonth +=$lastmon;
  }
  // Depreciation Amount
  $fdkfm = "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND parent_id !='0' AND classification_enum ='5' AND name LIKE '%depreciation%' ORDER BY name ASC";
$fdfs = mysqli_query($connection, $fdkfm);
while ($t = mysqli_fetch_array($fdfs))
  {
    $gllcode = $t['gl_code'];
// current month
    $dfdfso = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$gllcode' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
    $erte = mysqli_query($connection, $dfdfso);
    $i = mysqli_fetch_array($erte);
    if(isset($i)){
    $ferd = $i['credit'];
    }else{
      $ferd = "0.00";
    }
    // previous month
    $uiyr = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$gllcode' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
    $ererw = mysqli_query($connection, $uiyr);
      $a = mysqli_fetch_array($ererw);
      if(isset($a)){
      $dsdada = $a['credit'];
      }
      else{
        $dsdada = "0.00";
      }
      $depreciation_current +=$ferd;
      $depreciation_last +=$dsdada;
  }

  // Depreciation and income tax hasnt been coded yet. Values = 0 for now

  $income_tax_current = 0.00;

  $income_tax_last = 0.00;
  $net_prof_from_op = $ttl_revenue_curren - $ttlcurrenmonth;
  $net_prof_last_op = $ttl_revenue_last - $ttlastmonth;
  $profit_for_year = $net_prof_from_op - ($depreciation_current + $income_tax_current);
  $profit_for_year_last = $net_prof_last_op - ($depreciation_last + $income_tax_last);
$out = '';
$out = '
<div class="card">
<div class="card-header card-header-primary">
  <h4 class="card-title">Operating Revenue</h4>
</div>
<div class="card-body">
  <table class="table">
    <thead>
      <th style="font-weight:bold;">GL Account</th>
      <th style="text-align: center; font-weight:bold;">'.$curren.'<br/>(NGN)</th>
      <th style="text-align: center; font-weight:bold;">'.$onemonth.'<br/>(NGN)</th>
    </thead>
    <tbody>
      <tr>
        <td>Interest on Loans:</td>
        <td style="text-align: center">'.number_format($int_on_loans).'</td>
        <td style="text-align: center">'.number_format($last_int_on_loans).'</td>
      </tr>
      <tr>
        <td>Less interest on borrowings and deposit liabilities:</td>
        <td style="text-align: center">'.number_format($liabilities).'</td>
        <td style="text-align: center">'.number_format($otgerliabi).'</td>
      </tr>
      <tr>
        <td style="font-weight:bold;"><b>Net Interest Income</b></td>
        <td style="text-align: center; font-weight:bold;"><b>'.number_format($net_interest_income).'</b></td>
        <td style="text-align: center; font-weight:bold;"><b>'.number_format($net_interest_income_last).'</b></td>
      </tr>
      <tr>
        <td>Services fees, fines and penalties</td>
        <td style="text-align: center">'.number_format($curren_charge).'</td>
        <td style="text-align: center">'.number_format($last_mon_charge).'</td>
      </tr>
      <tr>
        <td>Other services and other income</td>
        <td style="text-align: center">'.number_format($other).'</td>
        <td style="text-align: center">0.00</td>
      </tr>
      <tr>
        <td style="font-weight:bold;"><b>Total Income</b></td>
        <td style="text-align: center; font-weight:bold;"><b>'.number_format($ttl_revenue_curren).'</b></td>
        <td style="text-align: center; font-weight:bold;"><b>'.number_format($ttl_revenue_last).'</b></td>
      </tr>
    </tbody>
  </table>
</div>
</div>
<div class="card">
<div class="card-header card-header-primary">
  <h4 class="card-title">Operating Expenses</h4>
</div>
<div class="card-body">
  <table class="table">
    <thead>
      <th style="font-weight:bold;">GL Account</th>
      <th style="text-align: center; font-weight:bold;">'.$curren.' <br/>(NGN)</th>
      <th style="text-align: center; font-weight:bold;">'.$onemonth.' <br/>(NGN)</th>
    </thead>
    <tbody>
    '.fill_operation($connection, $sessint_id, $start, $onemontstart, $end, $onemonthly).'
      <tr>
        <td style="font-weight:bold;">TOTAL</td>
        <td style="text-align: center; font-weight:bold;"><b>'.number_format($ttlcurrenmonth).'</b></td>
        <td style="text-align: center; font-weight:bold;"><b>'.number_format($ttlastmonth).'</b></td>
      </tr>
      <tr>
        <td style="font-weight:bold;">NET PROFIT FROM OPERATIONS</td>
        <td style="font-weight:bold; text-align: center">'.number_format($net_prof_from_op).'</td>
        <td style="font-weight:bold; text-align: center">'.number_format($net_prof_last_op).'</td>
      </tr>
      <tr>
        <td>Depreciation</td>
        <td style="text-align: center">'.number_format($depreciation_current).'</td>
        <td style="text-align: center">'.number_format($depreciation_last).'</td>
      </tr>
      <tr>
        <td>Income Tax</td>
        <td style="text-align: center">0.00</td> 
        <td style="text-align: center">0.00</td>
      </tr>
      <tr>
        <td style="font-weight:bold;">PROFIT FOR THE YEAR</td>
        <td style="font-weight:bold; text-align: center">'.number_format($profit_for_year).'</td>
        <td style="font-weight:bold; text-align: center">'.number_format($profit_for_year_last).'</td>
      </tr>
    </tbody>
  </table>
</div>
</div>
<!--//report ends here -->
<div class="card">
 <div class="card-body">
 <form method="POST" action="../composer/stmt_income.php">
 <input hidden type="text" name="start_date" value="'.$start.'"/>
 <input hidden type="text" name="end_date" value="'.$end.'"/>
 <input hidden type="text" name="branch_id" value="'.$branch_id.'"/>
 <input hidden type="text" name="int_id" value="'.$sessint_id.'"/>
 <input hidden type="text" name="previous_month_date" value="'.$onemonthly.'"/>
 <input hidden type="text" name="current_interest_on_loans" value="'.$int_on_loans.'"/>
 <input hidden type="text" name="previous_interest_on_loans" value="'.$last_int_on_loans.'"/>
 <input hidden type="text" name="current_liabilities" value="'.$liabilities.'"/>
 <input hidden type="text" name="previous_liabilities" value="'.$otgerliabi.'"/>
 <input hidden type="text" name="current_net_interest_on_income" value="'.$net_interest_income.'"/>
 <input hidden type="text" name="previous_net_interest_on_income" value="'.$net_interest_income_last.'"/>
 <input hidden type="text" name="current_charge_income" value="'.$curren_charge.'"/>
 <input hidden type="text" name="previous_charge_income" value="'.$last_mon_charge.'"/>
 <input hidden type="text" name="current_total_revenue" value="'.$ttl_revenue_curren.'"/>
 <input hidden type="text" name="previous_total_revenue" value="'.$ttl_revenue_last.'"/>
 <input hidden type="text" name="current_total_operating_expense" value="'.$ttlcurrenmonth.'"/>
 <input hidden type="text" name="previous_total_operating_expense" value="'.$ttlastmonth.'"/>
 <input hidden type="text" name="current_net_profit_from_operation" value="'.$net_prof_from_op.'"/>
 <input hidden type="text" name="previous_net_profit_from_operation" value="'.$net_prof_last_op.'"/>
 <input hidden type="text" name="profit_current_year" value="'.$profit_for_year.'"/>
 <input hidden type="text" name="profit_previous_year" value="'.$profit_for_year_last.'"/>
  <button class="btn btn-primary">Print</button>
  </form>
 </div>
</div>
</div>';
echo $out;
}
?>