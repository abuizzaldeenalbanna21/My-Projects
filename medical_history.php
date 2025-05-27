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

    <title>Dental Clinic - Medical History</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="side&navbars.html" rel="stylesheet">

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
                <!-- Topbar -->
                <?php include 'navbar.php'; ?>
                <!-- End of Topbar -->

                
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-4 text-gray-800">Medical History</h1>
                    <div>
                        <a href="medical_history-add.php" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> 
                        </a>
                    
                        </button>
                    </div>
                    
                </div>  
              <!-- Medical History Table -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <!-- Controls Above Table -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <label>
                                    Show 
                                    <select id="entriesSelect" class="custom-select custom-select-sm form-control form-control-sm" style="width: auto; display: inline-block;">
                                        <option value="2">2</option>
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                    entries
                                </label>
                            </div>
                            <div>
                                <label>
                                    Search: 
                                    <input id="tableSearch" type="search" class="form-control form-control-sm" placeholder="" style="width: auto; display: inline-block;">
                                </label>
                            </div>
                        </div>
                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Patient ID</th>
                                        <th>Patient Name</th>
                                        <th>Treatment</th>
                                        <th>Doctor</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Ahmed Yousef</td>
                                        <td>Teeth Cleaning</td> <!-- Updated treatment -->
                                        <td>Dr. Ahmed Al-Khatib</td>
                                        <td>2023-10-02</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div>
                                                    <a href="reports.php" class="text-left">
                                                        <i class="fas fa-eye" style="color: rgb(134, 134, 125);"></i> 
                                                    </a>
                                                    <span class="mx-2"></span> <!-- Add spacing -->
                                                    <a href="medical_history-edit.php" class="text-center">
                                                        <i class="fas fa-edit"></i> 
                                                    </a>
                                                    <span class="mx-2"></span> <!-- Add spacing -->
                                                    <a class="text-right">
                                                        <i class="fas fa-trash" style="color: red;"></i> 
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Khaled Ali</td>
                                        <td>Dental Filling</td> <!-- Updated treatment -->
                                        <td>Dr. Lina Al-Majali</td>
                                        <td>2023-10-03</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div>
                                                    <a href="reports.php" class="text-left">
                                                        <i class="fas fa-eye" style="color: rgb(134, 134, 125);"></i> 
                                                    </a>
                                                    <span class="mx-2"></span> <!-- Add spacing -->
                                                    <a href="medical_history-edit.php" class="text-center">
                                                        <i class="fas fa-edit"></i> 
                                                    </a>
                                                    <span class="mx-2"></span> <!-- Add spacing -->
                                                    <a class="text-right">
                                                        <i class="fas fa-trash" style="color: red;"></i> 
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Majed Ali</td>
                                        <td>Root Canal Therapy</td> <!-- Updated treatment -->
                                        <td>Dr. Omar Al-Tamimi</td>
                                        <td>2023-10-04</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div>
                                                    <a href="reports.php" class="text-left">
                                                        <i class="fas fa-eye" style="color: rgb(134, 134, 125);"></i> 
                                                    </a>
                                                    <span class="mx-2"></span> <!-- Add spacing -->
                                                    <a href="medical_history-edit.php" class="text-center">
                                                        <i class="fas fa-edit"></i> 
                                                    </a>
                                                    <span class="mx-2"></span> <!-- Add spacing -->
                                                    <a class="text-right">
                                                        <i class="fas fa-trash" style="color: red;"></i> 
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Rana Ali</td> <!-- Replace with patient names from appointment.php -->
                                        <td>Tooth Extraction</td> <!-- Replace with treatment names from appointment.php -->
                                        <td>Dr. Sara Al-Hassan</td>
                                        <td>2025-02-01</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div>
                                                    <a href="reports.php" class="text-left">
                                                        <i class="fas fa-eye" style="color: rgb(134, 134, 125);"></i> 
                                                    </a>
                                                    <span class="mx-2"></span>
                                                    <a href="medical_history-edit.php" class="text-center">
                                                        <i class="fas fa-edit"></i> 
                                                    </a>
                                                    <span class="mx-2"></span>
                                                    <a class="text-right">
                                                        <i class="fas fa-trash" style="color: red;"></i> 
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Fares Yousef</td> <!-- Replace with patient names from appointment.php -->
                                        <td>Teeth Whitening</td> <!-- Replace with treatment names from appointment.php -->
                                        <td>Dr. Yazan Al-Haddad</td>
                                        <td>2023-10-06</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div>
                                                    <a href="reports.php" class="text-left">
                                                        <i class="fas fa-eye" style="color: rgb(134, 134, 125);"></i> 
                                                    </a>
                                                    <span class="mx-2"></span>
                                                    <a href="medical_history-edit.php" class="text-center">
                                                        <i class="fas fa-edit"></i> 
                                                    </a>
                                                    <span class="mx-2"></span>
                                                    <a class="text-right">
                                                        <i class="fas fa-trash" style="color: red;"></i> 
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Hend Khaled</td> <!-- Replace with patient names from appointment.php -->
                                        <td>Orthodontic Braces</td>
                                        <td>Dr. Yazan Al-Taher</td>
                                        <td>2023-10-07</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div>
                                                    <a href="reports.php" class="text-left">
                                                        <i class="fas fa-eye" style="color: rgb(134, 134, 125);"></i> 
                                                    </a>
                                                    <span class="mx-2"></span>
                                                    <a href="medical_history-edit.php" class="text-center">
                                                        <i class="fas fa-edit"></i> 
                                                    </a>
                                                    <span class="mx-2"></span>
                                                    <a class="text-right">
                                                        <i class="fas fa-trash" style="color: red;"></i> 
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Ziad Ahmed</td> <!-- Replace with patient names from appointment.php -->
                                        <td>Dental Implants</td>
                                        <td>Dr. Omar Al-Kurdi</td>
                                        <td>2023-10-08</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div>
                                                    <a href="reports.php" class="text-left">
                                                        <i class="fas fa-eye" style="color: rgb(134, 134, 125);"></i> 
                                                    </a>
                                                    <span class="mx-2"></span>
                                                    <a href="medical_history-edit.php" class="text-center">
                                                        <i class="fas fa-edit"></i> 
                                                    </a>
                                                    <span class="mx-2"></span>
                                                    <a class="text-right">
                                                        <i class="fas fa-trash" style="color: red;"></i> 
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>Noor Ali</td> <!-- Replace with patient names from appointment.php -->
                                        <td>Teeth Cleaning</td>
                                        <td>Dr. Zaid Dorschner</td>
                                        <td>2023-10-09</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div>
                                                    <a href="reports.php" class="text-left">
                                                        <i class="fas fa-eye" style="color: rgb(134, 134, 125);"></i> 
                                                    </a>
                                                    <span class="mx-2"></span>
                                                    <a href="medical_history-edit.php" class="text-center">
                                                        <i class="fas fa-edit"></i> 
                                                    </a>
                                                    <span class="mx-2"></span>
                                                    <a class="text-right">
                                                        <i class="fas fa-trash" style="color: red;"></i> 
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                     <!-- Additional rows can be added here -->
                                </tbody>
                            </table>

                            <!-- Pagination Controls -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button  class="btn btn-primary btn-sm">Previous</button>
                            <span  class="mx-2">1</span>
                            <button  class="btn btn-primary btn-sm">Next</button>
                        </div>
                        <!-- Footer -->
                        <footer class="sticky-footer bg-white">
                            <div class="container my-auto">
                                <div class="copyright text-center my-auto">
                                    <span>Copyright &copy; Developer. Ali Albanna. 2025</span>
                                </div>
                            </div>
                        </footer>
                        <!-- End of Footer -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
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
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/chart-bar-demo.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>


    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>




    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/chart-bar-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script>
      
    // Delete Action
    document.querySelectorAll('.fa-trash').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            if (confirm('Are you sure you want to delete this entry?')) {
                row.remove();
                updatePagination(parseInt(entriesSelect.value));
            }
        });
    });

    // Search Box
    document.getElementById('tableSearch').addEventListener('keyup', function () {
        const filter = this.value.toLowerCase();
        rows.forEach(row => {
            const match = Array.from(row.querySelectorAll('td')).some(cell => cell.textContent.toLowerCase().includes(filter));
            row.style.display = match ? '' : 'none';
        });
    });

    const entriesSelect = document.getElementById('entriesSelect');
    const rows = Array.from(document.querySelectorAll('#dataTable tbody tr'));
    const prevButton = document.querySelector('.btn-primary.btn-sm:first-child');
    const nextButton = document.querySelector('.btn-primary.btn-sm:last-child');
    const pageIndicator = prevButton.nextElementSibling;

    let currentPage = 1;
    let rowsPerPage = parseInt(entriesSelect.value);

    function updateTable() {
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        rows.forEach((row, index) => {
            row.style.display = index >= start && index < end ? '' : 'none';
        });

        prevButton.disabled = currentPage === 1;
        nextButton.disabled = end >= rows.length;
        pageIndicator.textContent = currentPage;
    }

    entriesSelect.addEventListener('change', function () {
        rowsPerPage = parseInt(this.value);
        currentPage = 1;
        updateTable();
    });

    prevButton.addEventListener('click', function () {
        if (currentPage > 1) {
            currentPage--;
            updateTable();
        }
    });

    nextButton.addEventListener('click', function () {
        if (currentPage * rowsPerPage < rows.length) {
            currentPage++;
            updateTable();
        }
    });

    // Initialize table on page load
    updateTable();
    </script>


     <!-- Core plugin JavaScript-->
     <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
 
     <!-- Custom scripts for all pages-->
     <script src="js/sb-admin-2.min.js"></script>

     <!-- Initialize DataTables -->
     

    </script>
        
     
        
</body>
</html>