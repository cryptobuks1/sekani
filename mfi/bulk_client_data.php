<?php

$page_title = "Client data";
$destination = "bulk_update";
include("header.php");

if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "success",
        title: "Success",
        text: "Client was Updated successfully!",
        showConfirmButton: false,
        timer: 2000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
}
?>


    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <!-- Begining of Charge Row !-->
            <div class="row">

                <div class="col-md-12">


                    <!-- Client Data Begins -->
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Client Data</h4>
                            <p class="category"></p>
                        </div>

                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h4 class="card-title"><i class="material-icons">info</i> Requirements </h4>

                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>Files must be in <b>.csv</b></li>
                                                <li>CSV files should contain all the columns as stated on the Data
                                                    Sample
                                                </li>
                                                <li>The order of the columns should be the same as stated on the Data
                                                    Sample with the first rows as header
                                                </li>
                                                <li>You can upload a maximum of 4,000 rows in 1 file. If you have more
                                                    rows, please split them into multiple files.
                                                </li>
                                                <li>
                                                    <STRONG style="color: red">
                                                        IMPORTANT: Before upLoading your excel file please always
                                                        remember
                                                        to remove
                                                        the default table header (i.e row 1) completely.
                                                    </STRONG>
                                                </li>
                                            </ul>
                                            <div class="card-body text-center">
                                                <a href='bulkWork/getFile.php?name=clientData&loc=2'
                                                   class="btn btn-primary btn-lg">Download Data Sample</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Upload CSV File(.csv)</h4>
                                            <p class="category"></p>
                                        </div>
                                        <div class="card-body">
                                            <form action="bulkWork/upload/client.php" method="post" enctype="multipart/form-data">
                                                <div class="input-group">
                                                    <input type="file" name="clientData"
                                                           class="form-control inputFileVisible">
                                                    <span class="input-group-btn">
                                                        <button type="submit" name="submitClient"
                                                                class="btn btn-fab btn-round btn-primary">
                                                            <i class="material-icons">send</i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Client Card Data Ends -->

                    <!-- Account Card Data Begins -->
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Account Data</h4>
                            <p class="category"></p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h4 class="card-title"><i class="material-icons">info</i> Requirements </h4>

                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>Files must be in <b>.csv</b></li>
                                                <li>CSV files should contain all the columns as stated on the Data
                                                    Sample
                                                </li>
                                                <li>The order of the columns should be the same as stated on the Data
                                                    Sample with the first rows as header
                                                </li>
                                                <li>You can upload a maximum of 4,000 rows in 1 file. If you have more
                                                    rows, please split them into multiple files.
                                                </li>
                                            </ul>
                                            <div class="card-body text-center">
                                                <button class="btn btn-primary btn-lg ">
                                                    Download Data Sample
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Upload CSV File(.csv)</h4>
                                            <p class="category"></p>
                                        </div>
                                        <div class="card-body">


                                            <div class="input-group">
                                                <input type="file" class="form-control inputFileVisible"
                                                       placeholder="Single File">
                                                <span class="input-group-btn">
                                        <button type="button" class="btn btn-fab btn-round btn-primary">
                                            <i class="material-icons">attach_file</i>
                                        </button>
                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- Account Card Data Ends -->

                    <!-- Accont Transaction Card Data Begins -->
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Account Transaction</h4>
                            <p class="category"></p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h4 class="card-title"><i class="material-icons">info</i> Requirements </h4>

                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>Files must be in <b>.csv</b></li>
                                                <li>CSV files should contain all the columns as stated on the Data
                                                    Sample
                                                </li>
                                                <li>The order of the columns should be the same as stated on the Data
                                                    Sample with the first rows as header
                                                </li>
                                                <li>You can upload a maximum of 4,000 rows in 1 file. If you have more
                                                    rows, please split them into multiple files.
                                                </li>
                                            </ul>
                                            <div class="card-body text-center">
                                                <button class="btn btn-primary btn-lg ">
                                                    Download Data Sample
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Upload CSV File(.csv)</h4>
                                            <p class="category"></p>
                                        </div>
                                        <div class="card-body">


                                            <div class="input-group">
                                                <input type="file" class="form-control inputFileVisible"
                                                       placeholder="Single File">
                                                <span class="input-group-btn">
                                        <button type="button" class="btn btn-fab btn-round btn-primary">
                                            <i class="material-icons">attach_file</i>
                                        </button>
                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- Account Transaction Card Data Ends -->


                    <!-- Client Charge Card Data Begins -->
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Client Charge</h4>
                            <p class="category"></p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h4 class="card-title"><i class="material-icons">info</i> Requirements </h4>

                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>Files must be in <b>.csv</b></li>
                                                <li>CSV files should contain all the columns as stated on the Data
                                                    Sample
                                                </li>
                                                <li>The order of the columns should be the same as stated on the Data
                                                    Sample with the first rows as header
                                                </li>
                                                <li>You can upload a maximum of 4,000 rows in 1 file. If you have more
                                                    rows, please split them into multiple files.
                                                </li>
                                            </ul>
                                            <div class="card-body text-center">
                                                <button class="btn btn-primary btn-lg ">
                                                    Download Data Sample
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Upload CSV File(.csv)</h4>
                                            <p class="category"></p>
                                        </div>
                                        <div class="card-body">


                                            <div class="input-group">
                                                <input type="file" class="form-control inputFileVisible"
                                                       placeholder="Single File">
                                                <span class="input-group-btn">
                                        <button type="button" class="btn btn-fab btn-round btn-primary">
                                            <i class="material-icons">attach_file</i>
                                        </button>
                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- Client Charge Card Data Ends -->


                    <!-- Dormancy Card Data Begins -->
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Dormancy Counter</h4>
                            <p class="category"></p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h4 class="card-title"><i class="material-icons">info</i> Requirements </h4>

                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>Files must be in <b>.csv</b></li>
                                                <li>CSV files should contain all the columns as stated on the Data
                                                    Sample
                                                </li>
                                                <li>The order of the columns should be the same as stated on the Data
                                                    Sample with the first rows as header
                                                </li>
                                                <li>You can upload a maximum of 4,000 rows in 1 file. If you have more
                                                    rows, please split them into multiple files.
                                                </li>
                                            </ul>
                                            <div class="card-body text-center">
                                                <button class="btn btn-primary btn-lg ">
                                                    Download Data Sample
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Upload CSV File(.csv)</h4>
                                            <p class="category"></p>
                                        </div>
                                        <div class="card-body">


                                            <div class="input-group">
                                                <input type="file" class="form-control inputFileVisible"
                                                       placeholder="Single File">
                                                <span class="input-group-btn">
                                        <button type="button" class="btn btn-fab btn-round btn-primary">
                                            <i class="material-icons">attach_file</i>
                                        </button>
                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- Dormancy Card Data Ends -->

                    <!-- Transact Cache Card Data Begins -->
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Transact Cache</h4>
                            <p class="category"></p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h4 class="card-title"><i class="material-icons">info</i> Requirements </h4>

                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>Files must be in <b>.csv</b></li>
                                                <li>CSV files should contain all the columns as stated on the Data
                                                    Sample
                                                </li>
                                                <li>The order of the columns should be the same as stated on the Data
                                                    Sample with the first rows as header
                                                </li>
                                                <li>You can upload a maximum of 4,000 rows in 1 file. If you have more
                                                    rows, please split them into multiple files.
                                                </li>
                                            </ul>
                                            <div class="card-body text-center">
                                                <button class="btn btn-primary btn-lg ">
                                                    Download Data Sample
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Upload CSV File(.csv)</h4>
                                            <p class="category"></p>
                                        </div>
                                        <div class="card-body">


                                            <div class="input-group">
                                                <input type="file" class="form-control inputFileVisible"
                                                       placeholder="Single File">
                                                <span class="input-group-btn">
                                        <button type="button" class="btn btn-fab btn-round btn-primary">
                                            <i class="material-icons">attach_file</i>
                                        </button>
                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <!-- Transact Cache Card Data Ends -->


                </div>


                <!-- End of Charge Row -->

            </div>
        </div>


    </div>


<?php

include("footer.php");

?>