<?php
session_start();
require_once 'config.php';
require_once 'database.php';

$db = new Database($conn);
$userType = $_SESSION['user_type'] ?? '';
$name = $_SESSION['name'] ?? '';
$id = $_SESSION['id'] ?? '';
// جلب الأطباء والمرضى من قاعدة البيانات
$patients = $db->select("patients");
$doctors = $db->select("doctors");
$treatments = $db->select("treatments");

// حفظ الموعد الجديد
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'patient_id' => $userType == "doctor" ?  $_POST['patient_id'] : $id,
        'doctor_id' => $_POST['doctor_id'],
        'day' => $_POST['day'],
        'date' => $_POST['date'],
        'time' => $_POST['time'],
        'treatment_id' => $_POST['treatment']
    ];

    if ($db->insert("appointments", $data)) {
        header("Location: appointment.php");
        exit;
    } else {
        $error = "حدث خطأ أثناء إضافة الموعد.";
    }
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

    <title>Dashboard of Dental Clinic</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


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
            <?php include 'navbar.php'; ?>
            <!-- Main Content -->
            <div id="content">
                

                <!-- Input Table -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-2 text-gray-800">Add Appointment</h1>
                        <a href="appointment.php" class="btn btn-circle btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                    <div class="card shadow mb-4">

                        <div class="card-body">
                            <?php if (isset($error)) : ?>
                                <div class="alert alert-danger"><?= $error ?></div>
                            <?php endif; ?>

                            <form method="POST" action="">
                                <div class="row">
                                    <?php if ($userType === 'doctor') { ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Patient</label>
                                            <select name="patient_id" class="form-control" required>
                                                <option value="">Select Patient</option>
                                                <?php foreach ($patients as $patient): ?>
                                                    <option value="<?= $patient['id'] ?>"><?= htmlspecialchars($patient['first_name']) . " " . htmlspecialchars($patient['last_name'])  ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="text" name="date" class="form-control" id="appointment-date" required>
                                        </div>
                                    </div>

                                   <script>
                                    // الأيام بالترتيب حسب getDay()
                                    const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

                                    flatpickr("#appointment-date", {
                                        dateFormat: "Y-m-d",
                                        minDate: "today", // ✅ هذا يمنع اختيار أي تاريخ قبل اليوم الحالي
                                        disable: [
                                            function(date) {
                                                // منع الجمعة (5) والسبت (6)
                                                return (date.getDay() === 5 || date.getDay() === 6);
                                            }
                                        ],
                                        onChange: function(selectedDates, dateStr, instance) {
                                            if (selectedDates.length > 0) {
                                                const date = selectedDates[0];
                                                const dayName = days[date.getDay()];

                                                const daySelect = document.getElementById('appointment-day');
                                                // تعيين القيمة
                                                daySelect.value = dayName;
                                            }
                                        }
                                    });
                                </script>

                                </div>

                                <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Day</label>
                                        <input type="text" name="day" class="form-control" id="appointment-day" required readonly>
                                        <!-- <select name="day" class="form-control" id="appointment-day" required readonly >
                                            <option value="">Select Day</option>
                                            <option value="Sunday">Sunday</option>
                                            <option value="Monday">Monday</option>
                                            <option value="Tuesday">Tuesday</option>
                                            <option value="Wednesday">Wednesday</option>
                                            <option value="Thursday">Thursday</option>
                                            <option value="Saturday">Saturday</option>
                                        </select> -->
                                    </div>
                                </div>

                                   


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Time</label>
                                            <select name="time" class="form-control" id="appointment-time" required>
                                                <!-- سيتم تعبئته ديناميكياً -->
                                            </select>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('appointment-date').addEventListener('change', function () {
                                            const selectedDate = this.value;

                                            if (!selectedDate) return;

                                            fetch('get_available_times.php?date=' + selectedDate)
                                                .then(response => response.json())
                                                .then(data => {
                                                    const timeSelect = document.getElementById('appointment-time');
                                                    timeSelect.innerHTML = ''; // تصفير القائمة

                                                    if (data.length === 0) {
                                                        timeSelect.innerHTML = '<option value="">No available times</option>';
                                                        return;
                                                    }

                                                    data.forEach(time => {
                                                        const option = document.createElement('option');
                                                        option.value = time;
                                                        option.textContent = time;
                                                        timeSelect.appendChild(option);
                                                    });
                                                })
                                                .catch(error => {
                                                    console.error('Error fetching available times:', error);
                                                });
                                        });
                                        </script>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Doctor</label>
                                            <select name="doctor_id" class="form-control" required>
                                                <option value="">Select Doctor</option>
                                                <?php foreach ($doctors as $doctor): ?>
                                                    <option value="<?= $doctor['id'] ?>"><?= htmlspecialchars($doctor['full_name']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Treatment</label>
                                            <select name="treatment" class="form-control" required>
                                                <option value="">Select Treatment</option>
                                                <?php foreach ($treatments as $treatment): ?>
                                                    <option value="<?= $treatment['id'] ?>"><?= htmlspecialchars($treatment['name'])  ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Add Appointment</button>
                                </div>
                            </form>
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
                <!-- End of Input Table -->
            </div>

        </div>
    </div>
    <!-- End of Content Wrapper -->

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
    <script>
        document.getElementById('day').addEventListener('change', function() {
            const day = this.value;
            const timeSelect = document.getElementById('time');
            timeSelect.innerHTML = ''; // Clear existing options

            let startTime, endTime;
            if (day === 'Saturday') {
                startTime = 10; // 10:00 AM
                endTime = 16; // 4:00 PM
            } else {
                startTime = 9; // 9:00 AM
                endTime = 18; // 6:00 PM
            }

            for (let hour = startTime; hour < endTime; hour++) {
                const amPm = hour < 12 ? 'AM' : 'PM';
                const displayHour = hour % 12 === 0 ? 12 : hour % 12;
                timeSelect.innerHTML += `<option value="${hour}:00">${displayHour}:00 ${amPm}</option>`;
                timeSelect.innerHTML += `<option value="${hour}:30">${displayHour}:30 ${amPm}</option>`;
            }
        });

        // Trigger the change event to populate the time options on page load
        document.getElementById('day').dispatchEvent(new Event('change'));
    </script>
</body>

</html>