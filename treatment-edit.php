<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard of Dental Clinic</title>

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
                        <h1 class="h3 mb-4 text-gray-800">Edit Treatments</h1>
                        <div>
                            <a href="treatment.php" class="btn btn-circle btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Edit Treatment Form -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form id="editTreatmentForm">
                                <div id="treatmentFields">
                                    <div class="treatment-group">
                                        <div class="form-group">
                                            <label for="treatmentName1">Treatment Name</label>
                                            <input type="text" id="treatmentName1" class="form-control" placeholder="Enter treatment name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="treatmentDescription1">Treatment Description</label>
                                            <textarea id="treatmentDescription1" class="form-control" rows="4" placeholder="Enter treatment description" required></textarea>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <div class="text-center mb-4">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
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

    <!-- Include DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rowsPerPage = 5;
            const table = document.querySelector('#dataTable tbody');
            const rows = Array.from(table.querySelectorAll('tr'));
            const totalPages = Math.ceil(rows.length / rowsPerPage);
            let currentPage = 1;

            function renderTable(page) {
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                rows.forEach((row, index) => {
                    row.style.display = index >= start && index < end ? '' : 'none';
                });
            }

            function updatePaginationButtons() {
                document.querySelectorAll('#paginationNumbers button').forEach(button => {
                    button.classList.toggle('active', parseInt(button.dataset.page) === currentPage);
                });
            }

            document.querySelector('#prevPage').addEventListener('click', function () {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable(currentPage);
                    updatePaginationButtons();
                }
            });

            document.querySelector('#nextPage').addEventListener('click', function () {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable(currentPage);
                    updatePaginationButtons();
                }
            });

            document.querySelectorAll('#paginationNumbers button').forEach(button => {
                button.addEventListener('click', function () {
                    currentPage = parseInt(this.dataset.page);
                    renderTable(currentPage);
                    updatePaginationButtons();
                });
            });

            // Initialize table
            renderTable(currentPage);
            updatePaginationButtons();
        });

        document.getElementById('editTreatmentForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const treatments = [];
            document.querySelectorAll('.treatment-group').forEach((group, index) => {
                const name = group.querySelector(`#treatmentName${index + 1}`).value;
                const description = group.querySelector(`#treatmentDescription${index + 1}`).value;
                treatments.push({ name, description });
            });

            // Simulate saving the data (e.g., send to server or update table)
            console.log('Treatments:', treatments);

            alert('Treatment details updated successfully!');
        });

        document.querySelector('.dropdown-menu .dropdown-item[data-target="#logoutModal"]').addEventListener('click', function (event) {
            if (!confirm('Are you sure you want to logout?')) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>