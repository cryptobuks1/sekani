<?php

$page_title = "Teller Report";
$destination = "report_institution.php";
    include("header.php");
?>

<?php
                  function fill_client($connection) {
                    $sint_id = $_SESSION["int_id"];
                    $guuy = $_SESSION['branch_id'];
                    $org = "SELECT * FROM branch WHERE int_id = '$sint_id' AND (id = '$guuy' OR parent_id = '$guuy')";
                    $res = mysqli_query($connection, $org);
                    $out = '';
                    while ($row = mysqli_fetch_array($res))
                    {
                      $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                    }
                    return $out;
                  }
?>
<?php

if ($view_report == 1 || $view_report == "1") {
?>
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Teller Report</h4>
                  <!-- <p class="card-category">Fill in all important data</p> -->
                </div>
                <div class="card-body">
                  <form>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Start Date</label>
                          <input type="date" value="" name="" class="form-control" id="start">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">End Date</label>
                          <input type="date" value="" name="" class="form-control" id="end">
                          <input type="text" id="int_id" hidden name="" value="<?php echo $sessint_id;?>" class="form-control" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                        <label class="bmd-label-floating">Branch</label>
                          <select name="branch" class="form-control" id="input" required>
                          <option value="">select an option</option>
                          <?php echo fill_client($connection); ?>
                          </select>
                          <script>
                              $(document).ready(function() {
                                $('#input').change(function(){
                                  var id = $(this).val();
                                  var int_id = $('#int_id').val();
                                  $.ajax({
                                    url:"ajax_post/create_teller_branch.php",
                                    method:"POST",
                                    data:{id:id, int_id:int_id},
                                    success:function(data) {
                                      $('#show_branchx').html(data);
                                    }
                                  })
                                });
                              })
                            </script>
                        </div>
                      </div>
                      <div class="col-md-4">
                          <!-- populate from db -->
                          <div class="form-group">
                          <div id="show_branchx"></div>
                          </div>
                      </div> 
                      <div class="clearfix"></div>
                    </div>
                  </form>
                  <button type="reset" class="btn btn-danger pull-left">Reset</button>
                  <button id="runi" class="btn btn-primary pull-right">Run Report</button>
                      </div>
                      <!-- <button type="reset" class="btn btn-danger pull-left">Reset</button> -->
                    <!-- <button class="btn btn-primary pull-right">Run Report</button> -->
                  <!-- writing a code to the run the reort at click -->
                  <script>
                    $(document).ready(function () {
                      $('#runi').on("change keyup paste click", function () {
                        var start = $('#start').val();
                        var end = $('#end').val();
                        var branch = $('#input').val();
                        var teller = $('#till').val();
                        var int_id = $('#int_id').val();
                        $.ajax({
                          url: "ajax_post/run_teller_report.php",
                          method: "POST",
                          data:{start:start, end:end, branch:branch, teller:teller, int_id:int_id},
                          success: function (data) {
                            $('#outjournal').html(data);
                          }
                        })
                      });
                    });
                  </script>
                  <!-- this section is the end of run report -->
                  
                </div>
              </div>
            </div>
            <!-- teller report -->
            <!-- populate for print with above data --> 
            <div id="outjournal"></div>
            <!-- end  -->
          </div>
          <!-- /content -->
        </div>
      </div>

<?php

    include("footer.php");

?>
<?php
} else {
  echo '<script type="text/javascript">
  $(document).ready(function(){
   swal({
    type: "error",
    title: "Authorization Denied",
    text: "You Dont Have permission to View this report",
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
  // $URL="transact.php";
  // echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}

?>