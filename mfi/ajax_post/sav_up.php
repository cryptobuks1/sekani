<?php
include("../../functions/connect.php");
$output = '';
session_start();
$sint_id = $_SESSION["savings_temp"];
if(isset($_POST["int_id"]))
{
    if($_POST["id"] !='')
    {
        $main_p = $_SESSION["savings_temp"];
        $sint_id = $_POST["int_id"];
?>
<?php
     function fill_charges2($connection, $sint_id)
     {
      // $org = "SELECT charge.id, charge.name, charges_cache.charge_id FROM charge WHERE int_id = '$sint_id' && charge.charge_applies_to_enum = '1' && charge.is_active = '1'";
     $org = "SELECT charge.id, charge.name, charges_cache.charge_id FROM charge JOIN charges_cache ON charge.id = charges_cache.charge_id WHERE charges_cache.charge_id IS NULL && charge.int_id = '$sint_id' && charge.is_active = '1'";
     $res = mysqli_query($connection, $org);
     $output = '';
     while ($row = mysqli_fetch_array($res))
     {
       $output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
     }
     return $output;
     }
     ?>
     <script>
     $('#chargesxx').change(function(){
                          var id = $(this).val();
                          var int_id = $('#int_id').val();
                          var branch_id = $('#branch_id').val();
                          var main_p = $('#main_p').val();
                          $.ajax({
                            url:"savings_charges.php",
                            method:"POST",
                            data:{id:id, int_id:int_id, branch_id:branch_id, main_p: main_p},
                            success:function(data){
                              $('#show_charges').html(data);
                              document.getElementById("takeme").setAttribute("hidden", "");
                              document.getElementById("damn_men").removeAttribute("hidden");
                            }
                          })
                        });</script>
     <select name="charge_id"class="form-control" id="chargesxx">
     <option value="">select an option</option>
     <?php echo fill_charges2($connection, $sint_id); ?>
     </select>
<?php
    }
}
?>