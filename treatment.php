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

    <title>Dental Clinic - Treatment</title>

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

                <!-- Topbar -->
                <?php include 'navbar.php'; ?>
                <!-- End of Topbar -->

                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="h3 mb-4 text-gray-800">Treatments Management</h1>
                        <div>
                            <a href="treatment-add.php" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <!-- Show Entries and Search Box -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <label class="mr-2">Show</label>
                                    <select class="form-control form-control-sm" style="width: auto;">
                                        <option value="2">2</option>
                                        <option value="5" selected>5</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                    <label class="ml-2">entries</label>
                                </div>
                                <div>
                                    <input type="text" class="form-control form-control-sm" placeholder="Search" style="width: 200px;">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>ID</th>
                                            <th>Treatment Name</th>
                                            <th>Treatments Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr>
                                            <td>1</td>
                                            <td>Teeth Whitening</td>
                                            <td>Brightening teeth for a whiter, more confident smile using safe and effective whitening techniques in Amman, Jordan.</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="treatment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span>
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Teeth Cleaning</td>
                                            <td>Professional cleaning to remove plaque, tartar, and stains, ensuring healthy gums and teeth for Jordanian families.</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="treatment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span>
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Quality Brackets</td>
                                            <td>High-quality braces designed to align teeth and improve bite functionality with precision, available in Jordan.</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="treatment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span>
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Cavity Filling & Tooth Extraction</td>
                                            <td>Filling cavities to restore damaged teeth and Clinicfully extracting decayed or problematic teeth with Clinic in Jordan.</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="treatment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span>
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Modern Anesthetic</td>
                                            <td>Advanced anesthetic techniques to ensure pain-free dental procedures and patient comfort in clinics across Jordan.</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="treatment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span>
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>Dental Calculus</td>
                                            <td>Removal of hardened plaque (calculus) to prevent gum disease and maintain oral health for Jordanian patients.</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="treatment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span>
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>Paradontosis</td>
                                            <td>Comprehensive Clinic for gum disease, focusing on prevention, treatment, and maintenance in Jordanian clinics.</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="treatment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span>
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>Dental Implants</td>
                                            <td>Permanent solutions for missing teeth, providing natural-looking and durable replacements for patients in Jordan.</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="treatment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span>
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td>Tooth Braces</td>
                                            <td>Custom braces to correct misaligned teeth and improve overall dental aesthetics and function for patients in Jordan.</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="treatment-edit.php" class="fas fa-edit"></a>
                                                    <span class="mx-2"></span>
                                                    <i class="fas fa-trash" style="color: red;"></i>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination Controls -->
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
                                    <span>Copyright &copy; Developer By . Ali . Albanna 2025</span>
                                </div>
                            </div>
                        </footer>
                        <!-- End of Footer -->
                    </div>
                </div>
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

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

   
    <script>
        // JavaScript for Search Box
        document.addEventListener('DOMContentLoaded', function () {
            const searchBox = document.querySelector('input[type="text"]');
            const tableRows = document.querySelectorAll('#dataTable tbody tr');

            searchBox.addEventListener('keyup', function () {
                const filter = this.value.toLowerCase();
                tableRows.forEach(row => {
                    const cells = row.getElementsByTagName('td');
                    let found = false;
                    for (let i = 0; i < cells.length; i++) {
                        if (cells[i].textContent.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                    row.style.display = found ? '' : 'none';
                });
            });
        });

        // JavaScript for Show Entries
        document.addEventListener('DOMContentLoaded', function () {
            const showEntriesSelect = document.querySelector('select.form-control');
            const tableRows = document.querySelectorAll('#dataTable tbody tr');

            showEntriesSelect.addEventListener('change', function () {
                const rowsPerPage = parseInt(this.value, 10);
                tableRows.forEach((row, index) => {
                    row.style.display = (index < rowsPerPage) ? '' : 'none';
                });
            });
        });
        

        // JavaScript for Pagination
        document.addEventListener('DOMContentLoaded', function () {
            const rowsPerPage = 5; // Number of rows to show per page
            const tableRows = document.querySelectorAll('#dataTable tbody tr');
            const totalPages = Math.ceil(tableRows.length / rowsPerPage);
            let currentPage = 1;

            function updateTable() {
                tableRows.forEach((row, index) => {
                    row.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) ? '' : 'none';
                });
                document.getElementById('currentPage').textContent = currentPage;
            }

            document.getElementById('prevPage').addEventListener('click', function () {
                if (currentPage > 1) {
                    currentPage--;
                    updateTable();
                }
            });

            document.getElementById('nextPage').addEventListener('click', function () {
                if (currentPage < totalPages) {
                    currentPage++;
                    updateTable();
                }
            });

            updateTable(); // Initial call to display the first page
        });

        // JavaScript for Delete Action
        document.addEventListener('DOMContentLoaded', function () {
            const deleteIcons = document.querySelectorAll('.fa-trash');
            deleteIcons.forEach(icon => {
                icon.addEventListener('click', function () {
                    if (confirm('Are you sure you want to delete this treatment?')) {
                        const row = this.closest('tr');
                        row.remove();
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const tableRows = document.querySelectorAll('#dataTable tbody tr');
            const showEntriesSelect = document.querySelector('select.form-control');
            const prevPageButton = document.getElementById('prevPage');
            const nextPageButton = document.getElementById('nextPage');
            const currentPageDisplay = document.getElementById('currentPage');
            let currentPage = 1;
            let rowsPerPage = parseInt(showEntriesSelect.value);

            function updateTable() {
                const totalPages = Math.ceil(tableRows.length / rowsPerPage);
                tableRows.forEach((row, index) => {
                    row.style.display = index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage ? '' : 'none';
                });
                currentPageDisplay.textContent = currentPage;
                prevPageButton.disabled = currentPage === 1;
                nextPageButton.disabled = currentPage === totalPages;
            }

            showEntriesSelect.addEventListener('change', function () {
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
                const totalPages = Math.ceil(tableRows.length / rowsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    updateTable();
                }
            });

            // Initialize the table on page load
            updateTable();
        });

        // JavaScript for Logout Confirmation
        document.querySelector('.dropdown-menu .dropdown-item[data-target="#logoutModal"]').addEventListener('click', function (event) {
            if (!confirm('Are you sure you want to logout?')) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>