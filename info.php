<?php
ob_start();
session_start();
include "database.php";

$db = new Database($conn);

if(isset($_GET['patient_id'])){

    $patient_id = $_GET['patient_id'];

    // تجهيز الاستعلام باستخدام PDO
    $stmt = $conn->prepare("SELECT * FROM patients WHERE id = ?");
    $stmt->execute([$patient_id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $email = $row['email'];
    $patient_name = $row['first_name'] . " " . $row['last_name'];

    $stmt1 = $conn->prepare("SELECT * FROM medical_history WHERE patient_email = ?");
    $stmt1->execute([$email]);

    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

 
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Patients</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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

                    <!-- Page Heading -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 text-gray-800">Patient Information (<?php  echo $patient_name; ?>)</h1>
                        <div>
                            <a href="user.php" class="btn btn-circle btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                        </a>

                        </div>
                    </div>

                    
                    <!-- <div class="container"> -->
                        <div class="card o-hidden border-0 shadow-lg my-5">
                                <div class="p-5">
                                        <div class="form-group">
                                            <label>Do you have any allergies?</label>
                                            <input class="form-control" name="allergies" rows="2" value="<?php echo $row1['allergies'];?>"  readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Do you have any chronic diseases?</label>
                                            <input class="form-control" name="chronic_diseases" rows="2" value="<?php echo $row1['chronic_diseases'];?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Allergic to medications or substances?</label>
                                            <input class="form-control" name="medication_allergies" rows="2" value="<?php echo $row1['medication_allergies'];?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Undergone any surgeries recently?</label>
                                            <input class="form-control" name="recent_surgeries" rows="2" value="<?php echo $row1['surgeries'];?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>How often do you brush your teeth?</label>
                                            <input type="text" class="form-control" name="brushing_frequency" value="<?php echo $row1['brushing_frequency'];?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Do you smoke or use tobacco?</label>
                                            <input class="form-control" name="smoking" rows="2" value="<?php echo $row1['tobacco_use'];?>" readonly>
                                        </div>
                                </div>
                        </div>
                    <!-- </div> -->
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Developer By . Ali . Albanna . 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

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
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <script>
            // JavaScript for Search Box
            document.getElementById('searchBox').addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('#dataTable tbody tr');

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let match = false;

                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(searchTerm)) {
                            match = true;
                        }
                    });

                    if (match) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // JavaScript for Entries Select and Pagination
            const rows = document.querySelectorAll('#dataTable tbody tr');
            const entriesSelect = document.getElementById('entriesSelect');
            const prevPageButton = document.getElementById('prevPage');
            const nextPageButton = document.getElementById('nextPage');
            const currentPageDisplay = document.getElementById('currentPage');
            let currentPage = 1;
            let rowsPerPage = parseInt(entriesSelect.value);

            function updateTable() {
                const totalPages = Math.ceil(rows.length / rowsPerPage);
                rows.forEach((row, index) => {
                    row.style.display = index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage ? '' : 'none';
                });
                currentPageDisplay.textContent = currentPage;
                prevPageButton.disabled = currentPage === 1;
                nextPageButton.disabled = currentPage === totalPages;
            }

            entriesSelect.addEventListener('change', function () {
                rowsPerPage = parseInt(this.value);
                currentPage = 1;
                updateTable();
            });

            prevPageButton.addEventListener('click', function () {
                if (currentPage > 1) {
                    currentPage--;
                    updateTable();
                }
            });

            nextPageButton.addEventListener('click', function () {
                const totalPages = Math.ceil(rows.length / rowsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    updateTable();
                }
            });

            // Initialize the table on page load
            document.addEventListener('DOMContentLoaded', function () {
                updateTable();
            });


        </script>

</body>

</html>
<?php }else{}?>