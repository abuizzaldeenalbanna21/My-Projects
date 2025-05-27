<?php
session_start();

// For demo: you might want to get the current date formatted like this
$date = date('l, j F Y'); // e.g., Saturday, 9 May 2020

$userType = $_SESSION['user_type'] ?? '';
$name = $_SESSION['name'] ?? '';

// Placeholder for patient count today — you will replace this with a real query
$patientCount = 12;
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dental Clinic - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


    <style>
        /* Ensure the sidebar is fixed and content scrolls underneath */
        #accordionSidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
            z-index: 1030;
        }

        #content-wrapper {
            margin-left: 250px;
            /* Adjust based on sidebar width */
        }

        @media (max-width: 768px) {
            #accordionSidebar {
                position: relative;
                height: auto;
            }

            #content-wrapper {
                margin-left: 0;
            }
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'navbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Good Morning Section -->
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="card shadow"
                                style="background-color: #4285f4; color: white; border-radius: 5px;">
                                <div class="card-body">
                                    <?php

                                    if ($userType === 'doctor') {
                                        echo "<h5>$date</h5>";
                                        echo "<h2>Good Morning, Dr. $name</h2>";
                                        echo "<p>You Have <strong>$patientCount Patients</strong> Today</p>";
                                    } elseif ($userType === 'patient') {
                                        echo "<h5>$date</h5>";
                                        echo "<h2>Good Morning, $name</h2>";
                                        echo "<p>Welcome to your patient dashboard.</p>";
                                    } else {
                                        echo "<h5>$date</h5>";
                                        echo "<h2>Welcome!</h2>";
                                    }


                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($userType === 'doctor') { ?>
                    <!-- Requests Section -->
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Requests</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Request 1 -->
                                        <div class="col-md-4 mb-4">
                                            <div class="card border-left-primary shadow h-100 py-2">
                                                <div class="card-body">
                                                    <h6>Donia El Malky</h6>
                                                    <p>Emergency Case</p>
                                                    <p><i class="fas fa-calendar-alt"></i> 10 May 2020</p>
                                                    <p><i class="fas fa-clock"></i> 10:00 AM</p>
                                                    <a href="#" class="btn btn-primary btn-sm">See Details</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Request 2 -->
                                        <div class="col-md-4 mb-4">
                                            <div class="card border-left-success shadow h-100 py-2">
                                                <div class="card-body">
                                                    <h6>Mourad Ahmad</h6>
                                                    <p>Consultation Case</p>
                                                    <p><i class="fas fa-calendar-alt"></i> 10 May 2020</p>
                                                    <p><i class="fas fa-clock"></i> 10:00 AM</p>
                                                    <a href="#" class="btn btn-success btn-sm">See Details</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Request 3 -->
                                        <div class="col-md-4 mb-4">
                                            <div class="card border-left-warning shadow h-100 py-2">
                                                <div class="card-body">
                                                    <h6>Riham Osama</h6>
                                                    <p>Emergency Case</p>
                                                    <p><i class="fas fa-calendar-alt"></i> 10 May 2020</p>
                                                    <p><i class="fas fa-clock"></i> 10:00 AM</p>
                                                    <a href="#" class="btn btn-warning btn-sm">See Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-primary">Show All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dental Clinic Statistics -->
                    <div class="row">
                        <!-- Number of Patients Registered -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Patients Registered</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">1,200</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Number of Employees -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Employees</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">50</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Patients Fully Treated -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Fully Treated Patients</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">800</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Patients Under Treatment -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Patients Under Treatment</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">400</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-procedures fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Revenue Sources Section -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                                </div>
                                <div class="card-body">
                                    <p>The revenue sources are directly linked to the following statistics:</p>
                                    <ul>
                                        <li><strong>Patients Registered:</strong> 1,200</li>
                                        <li><strong>Employees:</strong> 50</li>
                                        <li><strong>Fully Treated Patients:</strong> 800</li>
                                        <li><strong>Patients Under Treatment:</strong> 400</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Patients and Visits Section -->
                    <div class="row">
                        <!-- Patients -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Patients</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="patientsChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- Visits -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Visits</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="visitsChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }  ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Developer By . Ali .Albanna 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="index.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/chart-bar-demo.js"></script>
    <script src="js/demo/chart-line-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!-- Add Chart.js for Patients and Visits Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Patients Chart
        const patientsCtx = document.getElementById('patientsChart').getContext('2d');
        new Chart(patientsCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [
                    { label: 'New', data: [30, 35, 40, 45, 50], backgroundColor: '#4e73df' },
                    { label: 'Old', data: [20, 25, 30, 35, 40], backgroundColor: '#1cc88a' }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // Visits Chart
        const visitsCtx = document.getElementById('visitsChart').getContext('2d');
        new Chart(visitsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [
                    { label: 'Appointment', data: [10, 15, 20, 25, 30], borderColor: '#4e73df', fill: false },
                    { label: 'Cancelled', data: [5, 10, 15, 20, 25], borderColor: '#e74a3b', fill: false }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    </script>

</body>

</html>