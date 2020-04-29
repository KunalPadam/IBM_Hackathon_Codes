<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="assets/vendor/charts/chartist-bundle/chartist.css">
    <link rel="stylesheet" href="assets/vendor/charts/morris-bundle/morris.css">
    <link rel="stylesheet" href="assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendor/charts/c3charts/c3.css">
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <title>RARe</title>
	
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="index.php">Rapid Action Response</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
							<li class="nav-item ">
                                <a class="nav-link active" href="#"><i class="fa fa-fw fa-user-circle"></i>Dashboard <span class="badge badge-success">6</span></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Ticket List </h2>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
					
					<?php
					
								include_once 'php/connect.php';
								$showRecordPerPage = 10;
								if(isset($_GET['page']) && !empty($_GET['page'])){
								$currentPage = $_GET['page'];
								}else{
								$currentPage = 1;
								}
								$startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;
								$totalSQL = "SELECT * FROM requester";
								$allResult = mysqli_query($conn, $totalSQL);
								$totalRequest = mysqli_num_rows($allResult);
								$lastPage = ceil($totalRequest/$showRecordPerPage);
								$firstPage = 1;
								$nextPage = $currentPage + 1;
								$previousPage = $currentPage - 1;
								$SQL = "SELECT *
								FROM requester LIMIT $startFrom, $showRecordPerPage";
								$result = mysqli_query($conn, $SQL);
								$noOfRowsInPage = mysqli_num_rows($result);
								
								$p1_sql = "SELECT REQ_ID FROM REQUESTER WHERE REQ_TYPE='P1'";
								$p1_result = mysqli_query($conn, $p1_sql);
								$p1_noOfRows = mysqli_num_rows($p1_result);
								
								$p2_sql = "SELECT REQ_ID FROM REQUESTER WHERE REQ_TYPE='P2'";
								$p2_result = mysqli_query($conn, $p2_sql);
								$p2_noOfRows = mysqli_num_rows($p2_result);
								
								$p3_sql = "SELECT REQ_ID FROM REQUESTER WHERE REQ_TYPE='P3'";
								$p3_result = mysqli_query($conn, $p3_sql);
								$p3_noOfRows = mysqli_num_rows($p3_result);
					
                    echo    '<div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Emergency (P1)</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">'.$p1_noOfRows.'</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Request (P2)</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">'.$p2_noOfRows.'</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Volunteer (P3)</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">'.$p3_noOfRows.'</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';

								
		
                      echo  '<div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Ticket List</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-bordered first">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">Requester ID</th>
                                                        <th class="border-0">Requester Username</th>
                                                        <th class="border-0">Phone Number</th>
                                                        <th class="border-0">Request Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
												
												while($row = mysqli_fetch_assoc($result))
												{
													echo'<tr>'; 
													echo '<td> <a href="details.php?id='.$row["REQ_ID"].'">'.$row["REQ_ID"].'</a></td>';
													echo '<td>'.$row["USER_NAME"].'</td>';
													echo '<td>'.$row["PHONE"].'</td>';
													echo '<td>'.$row["REQ_TYPE"].'</td>';
													echo'<tr>';
												}   
                                                echo '</tbody>
											
                                            </table>
                                        </div>
                                    </div>
									
                                </div>';
								?>

												<nav aria-label="Page navigation">
												<ul class="pagination">
												<?php if($currentPage != $firstPage) { ?>
												<li class="page-item">
												<a class="page-link" href="?page=<?php echo $firstPage ?>" tabindex="-1" aria-label="Previous">
												<span aria-hidden="true">First</span>
												</a>
												</li>
												<?php } ?>
												<?php if($currentPage >= 2) { ?>
												<li class="page-item"><a class="page-link" href="?page=<?php echo $previousPage ?>"><?php echo $previousPage ?></a></li>
												<?php } ?>
												<li class="page-item active"><a class="page-link" href="?page=<?php echo $currentPage ?>"><?php echo $currentPage ?></a></li>
												<?php if($currentPage != $lastPage) { ?>
												<li class="page-item"><a class="page-link" href="?page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a></li>
												<li class="page-item">
												<a class="page-link" href="?page=<?php echo $lastPage ?>" aria-label="Next">
												<span aria-hidden="true">Last</span>
												</a>
												</li>
												<?php } ?>
												</ul>
												</nav>
												<?php
											echo'	<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">';
												echo'Showing '; echo $startFrom+1; echo' to '; echo $noOfRowsInPage+$startFrom; echo ' of '; echo $totalRequest; echo ' entries</div>
												</div>';
												?>
						
                            <!-- ============================================================== -->
                            <!-- end recent orders  -->
							
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
    <script src="assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- morris js -->
    <script src="assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="assets/vendor/charts/morris-bundle/morris.js"></script>
    <!-- chart c3 js -->
    <script src="assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="assets/libs/js/dashboard-ecommerce.js"></script>
	
	
	
	<script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="../assets/vendor/multi-select/js/jquery.multi-select.js"></script>
    <script src="../assets/libs/js/main-js.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="../assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="../assets/vendor/datatables/js/data-table.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
	
	
	
</body>
 
</html>