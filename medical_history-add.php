<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Medical History_Add of Dental Clinic</title>

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
            margin-left: 250px; /* Adjust based on sidebar width */
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
                <!-- Main Content -->
                <div id="content">
                    <!-- Topbar -->
                    <?php include 'navbar.php'; ?>
                    <!-- End of Topbar -->
                </div>
                <div class="container mt-4">
                    <!-- Page Heading -->
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="h3 mb-4 text-gray-800">Add Medical History</h1>
                        <div>
                            <a href="medical_history.php" class="btn btn-circle btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
    
                    <!-- Card Wrapper -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <table class="table table-bordered" id="medicalHistoryTable">
                                <thead>
                                    <tr>
                                        <th>Patient ID</th>
                                        <th>Name</th>
                                        <th>Condition</th>
                                        <th>Doctor</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <select class="form-control">
                                                <option value="John Doe" selected>John Doe</option>
                                                <option value="Ahmed Yousef">Ahmed Yousef</option>
                                                <option value="Khaled Ali">Khaled Ali</option>
                                                <option value="Rana Mahmoud">Rana Mahmoud</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control">
                                                <option value="Tooth Decay" selected>Tooth Decay</option>
                                                <option value="Gum Disease">Gum Disease</option>
                                                <option value="Root Canal">Root Canal</option>
                                                <option value="Teeth Whitening">Teeth Whitening</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control">
                                                <option value="Dr. Ahmed" selected>Dr. Ahmed</option>
                                                <option value="Dr. Mohammed">Dr. Mohammed</option>
                                                <option value="Dr. Ali">Dr. Ali</option>
                                                <option value="Dr. Fatima">Dr. Fatima</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control datepicker" value="2025-01-15">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center mt-4">
                                <button class="btn btn-success" id="addPersonForm">Add Patient History</button>
                            </div>
    
                            <!-- Footer -->
                            <footer class="sticky-footer bg-white">
                                <div class="container my-auto">
                                    <div class="copyright text-center my-auto">
                                        <span>Copyright &copy; Developer By . Ali . Albanna 2025</span>
                                    </div>
                                </div>
                            </footer>
                            <!-- End of Footer -->
                        </div>
                    </div>
                    <!-- End of Card Wrapper -->

                    
                </div>
            </div>
                <script>
                    $(document).ready(function () {
                        $(".datepicker").datepicker({
                            dateFormat: "yy-mm-dd", // Format the date as YYYY-MM-DD
                            changeMonth: true,
                            changeYear: true,
                            showButtonPanel: true // Matches functionality in medical_history_edit.php
                        });
                    });
                </script>
        </div>
    </div>
    

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
    <script src="vendor/jquery-ui/jquery-ui.min.js"></script>
    <script src="vendor/jquery-ui/jquery-ui.js"></script>
    <script src="vendor/jquery-ui/jquery-ui.css"></script>
    <script src="vendor/jquery-ui/jquery-ui.min.js"></script>


    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>



    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script src="js/sb-admin-2.js"></script>


    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>