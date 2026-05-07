<?php
session_start();
require_once 'config.php';
require_once 'database.php';

$db = new Database($conn);

// Fetch all treatments
$treatments = $db->select('treatments');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Treatments</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include 'sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'navbar.php'; ?>
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 text-gray-800">Treatments </h1>
                         <?php if ($_SESSION['user_type'] == 'doctor') { ?>
                        <a href="treatment-add.php" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add Treatment
                        </a>
                        <?php } ?>
                    </div>


                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- Search & Show Entries Controls -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <label for="entriesSelect">Show
                                            <select id="entriesSelect"
                                                class="custom-select custom-select-sm form-control form-control-sm"
                                                style="width: auto;">
                                                <option value="2">2</option>
                                                <option value="5">5</option>
                                                <option value="10" selected>10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                            </select> entries
                                        </label>
                                    </div>
                                    <div>
                                        <label for="searchBox">Search:
                                            <input id="searchBox" type="text" class="form-control form-control-sm"
                                                style="width: auto; display: inline-block;">
                                        </label>
                                    </div>
                                </div>
                                <!-- End Controls -->
                                <table id="dataTable" class="table table-bordered table-sm text-center">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Price (JD)</th>
                                             <?php if ($_SESSION['user_type'] == 'doctor') { ?><th>Actions</th><?php }?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $loo = 1;foreach ($treatments as $treatment): ?>
                                            <tr>
                                                <td><?= $loo; ?></td>
                                                <td><?= htmlspecialchars($treatment['name']) ?></td>
                                                <td><?= htmlspecialchars($treatment['description']) ?></td>
                                                <td><?= number_format($treatment['price'], 2) ?></td>
                                                 <?php if ($_SESSION['user_type'] == 'doctor') { ?><td>
                                                    <a href="treatment-delete.php?id=<?= $treatment['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this treatment?')">Delete</a>
                                                </td><?php }?>
                                            </tr>
                                        <?php $loo++;endforeach; ?>
                                        <?php if (empty($treatments)): ?>
                                            <tr><td colspan="5">No treatments found.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <!-- Pagination Controls -->
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button id="prevPage" class="btn btn-primary btn-sm">Previous</button>
                                    <span id="currentPage" class="mx-2">1</span>
                                    <button id="nextPage" class="btn btn-primary btn-sm">Next</button>
                                </div>
                            </div>
                        </div>
                        <footer class="sticky-footer bg-white">
                            <div class="container my-auto">
                                <div class="text-center my-auto">
                                    <span>Copyright &copy; Developed by Ali Albanna 2025</span>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        // Search and Pagination logic
        const rows = Array.from(document.querySelectorAll('#dataTable tbody tr'));
        const entriesSelect = document.getElementById('entriesSelect');
        const prevPageButton = document.getElementById('prevPage');
        const nextPageButton = document.getElementById('nextPage');
        const currentPageDisplay = document.getElementById('currentPage');
        const searchBox = document.getElementById('searchBox');
        let currentPage = 1;
        let rowsPerPage = parseInt(entriesSelect.value);

        function getVisibleRows() {
            return rows.filter(row => !row.hasAttribute('data-hidden'));
        }

        function updateTable() {
            const visibleRows = getVisibleRows();
            const totalPages = Math.ceil(visibleRows.length / rowsPerPage) || 1;
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;
            rows.forEach(row => row.style.display = 'none');
            visibleRows.forEach((row, index) => {
                if (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) {
                    row.style.display = '';
                }
            });
            currentPageDisplay.textContent = totalPages === 0 ? 0 : currentPage;
            prevPageButton.disabled = (currentPage <= 1);
            nextPageButton.disabled = (currentPage >= totalPages);
        }

        searchBox.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let match = false;
                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchTerm)) {
                        match = true;
                    }
                });
                if (match) {
                    row.removeAttribute('data-hidden');
                } else {
                    row.setAttribute('data-hidden', 'true');
                }
            });
            currentPage = 1;
            updateTable();
        });

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
            const visibleRows = getVisibleRows();
            const totalPages = Math.ceil(visibleRows.length / rowsPerPage) || 1;
            if (currentPage < totalPages) {
                currentPage++;
                updateTable();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            updateTable();
        });
    </script>
</body>
</html>
