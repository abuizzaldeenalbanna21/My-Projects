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

    <title>Dental Clinic - Appointmenta</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


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

                    <!-- Page Heading -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 text-gray-800">Appointments</h1>
                        <div>
                            <a href="addAppointment.php" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i> 
                            </a>
                           
                            </button>
                        </div>
                    </div>

                    <!-- Appointments Table -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <label for="entriesSelect">Show</label>
                                    <select id="entriesSelect" class="form-control form-control-sm d-inline-block" style="width: auto;">
                                        <option value="2">2</option>
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                    </select>
                                    <span>entries</span>
                                </div>
                                <div>
                                    <input id="searchBox" type="text" class="form-control form-control-sm" placeholder="Search...">
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Patient Name</th>
                                            <th>Day</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Doctor</th>
                                            <th>Treatment</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Ahmed Yousef</td>
                                            <td>Monday</td>
                                            <td>2023-10-02</td>
                                            <td>10:00 AM</td>
                                            <td>Dr. Ahmed Al-Khatib</td>
                                            <td>Teeth Cleaning</td> <!-- Updated treatment -->
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="appointment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span> <!-- Add spacing -->
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Khaled Ali</td>
                                            <td>Tuesday</td>
                                            <td>2023-10-03</td>
                                            <td>11:30 AM</td>
                                            <td>Dr. Lina Al-Majali</td>
                                            <td>Dental Filling</td> <!-- Updated treatment -->
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="appointment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span> <!-- Add spacing -->
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Majed Ali</td>
                                            <td>Wednesday</td>
                                            <td>2023-10-04</td>
                                            <td>2:00 PM</td>
                                            <td>Dr. Omar Al-Tamimi</td>
                                            <td>Root Canal Therapy</td> <!-- Updated treatment -->
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="appointment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span> <!-- Add spacing -->
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Rana Ali</td>
                                            <td>Thursday</td>
                                            <td>2023-10-05</td>
                                            <td>9:00 AM</td>
                                            <td>Dr. Sara Al-Hassan</td>
                                            <td>Tooth Extraction</td> <!-- Updated treatment -->
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="appointment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span> <!-- Add spacing -->
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Fares Yousef</td>
                                            <td>Monday</td>
                                            <td>2023-10-06</td>
                                            <td>3:30 PM</td>
                                            <td>Dr. Yazan Al-Haddad</td>
                                            <td>Teeth Whitening</td> <!-- Updated treatment -->
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="appointment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span> <!-- Add spacing -->
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>Hend Khaled</td>
                                            <td>Saturday</td>
                                            <td>2023-10-07</td>
                                            <td>1:00 PM</td>
                                            <td>Dr. Yazan Al-Taher</td>
                                            <td>Orthodontic Braces</td> <!-- Updated treatment -->
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="appointment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span> <!-- Add spacing -->
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>Ziad Ahmed</td>
                                            <td>Sunday</td>
                                            <td>2023-10-08</td>
                                            <td>4:00 PM</td>
                                            <td>Dr. Omar Al-Kurdi</td>
                                            <td>Dental Implants</td> <!-- Updated treatment -->
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="appointment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span> <!-- Add spacing -->
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>Noor Ali</td>
                                            <td>Monday</td>
                                            <td>2023-10-09</td>
                                            <td>10:30 AM</td>
                                            <td>Dr. Zaid Dorschner</td>
                                            <td>Teeth Cleaning</td> <!-- Updated treatment -->
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="appointment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span> <!-- Add spacing -->
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div> 
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button id="prevPage" class="btn btn-primary btn-sm">Previous</button>
                                    <span id="currentPage" class="mx-2">1</span>
                                    <button id="nextPage" class="btn btn-primary btn-sm">Next</button>
                                </div>
                            </div>

                            <!-- Footer -->
                            <footer class="sticky-footer bg-white">
                                <div class="container my-auto">
                                    <div class="copyright text-center my-auto">
                                        <span>Copyright &copy; Developer By . Ali Albanna . 2025</span>
                                    </div>
                                </div>
                            </footer>
                            <!-- End of Footer -->
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
              

            </div>
            <!-- End of Main Content -->

            

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
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

   
    <script>
        // Pagination and search logic
        let currentPage = 1;
        let rowsPerPage = 2; // Default value
        const table = document.querySelector("#dataTable tbody");
        const rows = Array.from(table.rows);
        const totalPages = () => Math.ceil(filteredRows().length / rowsPerPage);

        function filteredRows() {
            const searchTerm = document.getElementById("searchBox").value.toLowerCase();
            return rows.filter(row => Array.from(row.cells).some(cell => cell.textContent.toLowerCase().includes(searchTerm)));
        }

        function renderTable() {
            table.innerHTML = "";
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            filteredRows().slice(start, end).forEach(row => table.appendChild(row));
            document.getElementById("currentPage").textContent = currentPage;
        }

        document.getElementById("prevPage").addEventListener("click", () => {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });

        document.getElementById("nextPage").addEventListener("click", () => {
            if (currentPage < totalPages()) {
                currentPage++;
                renderTable();
            }
        });

        document.getElementById("searchBox").addEventListener("input", () => {
            currentPage = 1;
            renderTable();
        });

        document.getElementById("entriesSelect").addEventListener("change", (e) => {
            rowsPerPage = parseInt(e.target.value, 10);
            currentPage = 1;
            renderTable();
        });

        // Initial render
        renderTable();

        // JavaScript for DataTable
        $(document).ready(function () {
            $('#dataTable').DataTable({
                "lengthChange": false,
                "pageLength": 2,
                "searching": false,
                "ordering": false,
                "info": false,
                "paging": false
            });
        }); 

        // JavaScript for deleting Actions
        const deleteIcons = document.querySelectorAll('.fa-trash');
        deleteIcons.forEach(icon => {
            icon.addEventListener('click', function () {
                const row = this.closest('tr');
                if (confirm('Are you sure you want to delete this appointment?')) {
                    row.remove();
                }
            });
        });
        
    </script>

</body>

</html>