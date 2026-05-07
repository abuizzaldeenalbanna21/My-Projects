<?php
session_start();
require_once 'config.php';
require_once 'database.php';

$db = new Database($conn);

$userType = $_SESSION['user_type'] ?? '';
if($_GET['appointment_id']){

    $appointment_id = $_GET['appointment_id'] ?? 0;


    ////////////////////////////////////////////////////
    
    // جلب بيانات التقرير إن وُجد
    $query = "SELECT * FROM appointments_report WHERE appointment_id = :appointment_id";
    $stmt = $conn->prepare($query);
    $stmt->execute(['appointment_id' => $appointment_id]);
    $report = $stmt->fetch(PDO::FETCH_ASSOC);
    /////////////////////////////////////////////////////////


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // استقبال البيانات من الفورم
    $treatment_plan     = $_POST['treatment_plan'] ?? '';
    $session_reports    = $_POST['session_reports'] ?? '';
    $x_rays_note        = $_POST['x_rays_note'] ?? '';
    $treatment_written  = $_POST['treatment_written'] ?? '';
    $medications        = $_POST['medications'] ?? '';
    $x_rays_file        = null;

    // معالجة رفع ملف الأشعة
    if (isset($_FILES['xrayUpload']) && $_FILES['xrayUpload']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $fileName = basename($_FILES['xrayUpload']['name']);
        $filePath = $uploadDir . time() . '_' . $fileName;
        if (move_uploaded_file($_FILES['xrayUpload']['tmp_name'], $filePath)) {
            $x_rays_file = $filePath;
        }
    }

    // تحقق إذا كان السجل موجودًا
    $stmt = $conn->prepare("SELECT id FROM appointments_report WHERE appointment_id = ?");
    $stmt->execute([$appointment_id]);
    $exists = $stmt->fetchColumn();

    if ($exists) {
        // تحديث
        $stmt = $conn->prepare("UPDATE appointments_report SET treatment_plan=?, session_reports=?, x_rays_file=?, x_rays_note=?, treatment_written=?, medications=? WHERE appointment_id=?");
        $stmt->execute([$treatment_plan, $session_reports, $x_rays_file, $x_rays_note, $treatment_written, $medications, $appointment_id]);
    } else {
        // إدخال جديد
        $stmt = $conn->prepare("INSERT INTO appointments_report (appointment_id, treatment_plan, session_reports, x_rays_file, x_rays_note, treatment_written, medications) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$appointment_id, $treatment_plan, $session_reports, $x_rays_file, $x_rays_note, $treatment_written, $medications]);
    }
    $saved = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Users</title>

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

                <?php include 'navbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <form action="reports.php?appointment_id=<?= $appointment_id ?>" method="post" enctype="multipart/form-data">
                    <div class="container-fluid">
                        <?php if (!empty($saved)) { ?>
                            <div class="alert alert-success text-center" role="alert" id="savedAlert">
                               Saved successfully
                            </div>
                        <?php } ?>
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3 mb-4 text-gray-800">Reports</h1>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-gray-800" style="font-size: x-small;">
                                Last Upload Date: 
                                <span class="text-primary"><?= htmlspecialchars($report['updated_at'] ?? '') ?></span>
                            </h6>
                        </div>
                        <?php if ($userType === 'doctor') { ?>
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <span>Treatment Plan</span>
                                        <div class="mt-2">
                                            <input type="text" class="form-control" name="treatment_plan" value="<?= htmlspecialchars($report['treatment_plan'] ?? '') ?>" placeholder="Enter details about Treatment Plan">
                                        </div>
                                    </li>

                                    <li class="list-group-item">
                                        <span>Session Reports</span>
                                        <div class="mt-2">
                                            <input type="text" class="form-control" name="session_reports" value="<?= htmlspecialchars($report['session_reports'] ?? '') ?>" placeholder="Enter details about Session Reports">
                                        </div>
                                    </li>

                                    <li class="list-group-item">
                                        <span>X-Rays</span>
                                        <div class="mt-2 d-flex align-items-center">
                                            <input type="file" class="form-control-file mr-3" name="xrayUpload" id="xrayUpload" accept="image/*">
                                            <?php if (!empty($report['x_rays_file'])): ?>
                                                <a href="<?= $report['x_rays_file'] ?>" download class="btn btn-primary btn-sm">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-2">
                                            <input type="text" class="form-control" name="x_rays_note" value="<?= htmlspecialchars($report['x_rays_note'] ?? '') ?>" placeholder="Enter details about existing reports">
                                        </div>
                                    </li>

                                  <!--  <li class="list-group-item">
                                        <span>Treatment Written</span>
                                        <div class="mt-2">
                                            <input type="text" class="form-control" name="treatment_written" value="<?= htmlspecialchars($report['treatment_written'] ?? '') ?>" placeholder="Enter details about Treatment Written">
                                        </div>
                                    </li> -->

                                    <li class="list-group-item">
                                        <span>Medications</span>
                                        <div class="mt-2">
                                            <input type="text" class="form-control" name="medications" value="<?= htmlspecialchars($report['medications'] ?? '') ?>" placeholder="Enter details about Medications">
                                        </div>
                                    </li>

                                    <div class="mt-3 text-center">
                                        <button type="submit" class="btn btn-success btn-sm" id="saveButton">
                                            <i class="fas fa-save"></i> Save
                                        </button>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <?php }else{?>
                                <div class="card shadow mb-4">
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <span>Treatment Plan</span>
                                        <div class="mt-2">
                                            <input type="text" class="form-control" name="treatment_plan" value="<?= htmlspecialchars($report['treatment_plan'] ?? '') ?>" placeholder="Enter details about Treatment Plan" disabled>
                                        </div>
                                    </li>

                                    <li class="list-group-item">
                                        <span>Session Reports</span>
                                        <div class="mt-2">
                                            <input type="text" class="form-control" name="session_reports" value="<?= htmlspecialchars($report['session_reports'] ?? '') ?>" placeholder="Enter details about Session Reports" disabled>
                                        </div>
                                    </li>

                                    <li class="list-group-item">
                                        <span>X-Rays</span>
                                        <div class="mt-2 d-flex align-items-center">
                                            <!-- <input type="file" class="form-control-file mr-3" name="xrayUpload" id="xrayUpload" accept="image/*"> -->
                                            <?php if (!empty($report['x_rays_file'])): ?>
                                                <a href="<?= $report['x_rays_file'] ?>" download class="btn btn-primary btn-sm">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-2">
                                            <input type="text" class="form-control" name="x_rays_note" value="<?= htmlspecialchars($report['x_rays_note'] ?? '') ?>" placeholder="Enter details about existing reports" disabled>
                                        </div>
                                    </li>

                                    <!--<li class="list-group-item">
                                        <span>Treatment Written</span>
                                        <div class="mt-2">
                                            <input type="text" class="form-control" name="treatment_written" value="<?= htmlspecialchars($report['treatment_written'] ?? '') ?>" placeholder="Enter details about Treatment Written" disabled>
                                        </div>
                                    </li> -->

                                    <li class="list-group-item">
                                        <span>Medications</span>
                                        <div class="mt-2">
                                            <input type="text" class="form-control" name="medications" value="<?= htmlspecialchars($report['medications'] ?? '') ?>" placeholder="Enter details about Medications" disabled>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </form>


                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

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
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

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
  
      <!-- Page level custom scripts -->
      <script src="js/demo/datatables-demo.js"></script>

      <script>
    // Hide the saved alert after 3 seconds
    $(document).ready(function() {
        setTimeout(function() {
            $('#savedAlert').fadeOut(500);
        }, 3000);
    });
</script>

</body>

</html>
<?php
}else{
    header('Location: invoice_items.php');
    exit;
}
?>