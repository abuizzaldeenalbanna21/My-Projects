<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Appointmenta</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
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

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 text-gray-800">Edit Appointment</h1>
                    <a href="appointment.php" class="btn btn-circle btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <!-- End of Page Heading -->
            </div>
        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->


    <!-- Appointment Edit Form -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form id="appointmentForm">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="patientName">Patient Name</label>
                        <input type="text" id="patientName" class="form-control" value="John Doe">
                    </div>
                    <div class="col-md-6">
                        <label for="day">Day</label>
                        <select id="day" class="form-control">
                            <option value="selected" selected>Select Day</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="date">Date</label>
                        <input type="date" id="date" class="form-control" value="2023-10-02">
                    </div>
                    <div class="col-md-6">
                        <label for="time">Time</label>
                        <select id="time" class="form-control">
                            <!-- Time options will be dynamically populated -->
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="doctor">Doctor</label>
                        <select id="doctor" class="form-control">
                            <option value="Dr. Smith" selected>Dr. Smith</option>
                            <option value="Dr. Brown">Dr. Brown</option>
                            <option value="Dr. Taylor">Dr. Taylor</option>
                            <option value="Dr. Davis">Dr. Davis</option>
                            <option value="Dr. Martinez">Dr. Martinez</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="treatment">Treatment</label>
                        <input type="text" id="treatment" class="form-control" value="Cleaning">
                    </div>
                </div>
                <br>
                <div class="text-center">
                    <button type="button" class="btn btn-primary " id="saveAppointment" style="width: 25%;">Save</button>
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
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('saveAppointment').addEventListener('click', function () {
        const appointmentData = {
            patientName: document.getElementById('patientName').value,
            day: document.getElementById('day').value,
            date: document.getElementById('date').value,
            time: document.getElementById('time').value,
            doctor: document.getElementById('doctor').value,
            treatment: document.getElementById('treatment').value
        };

        console.log('Appointment Saved:', appointmentData);
        alert('Appointment details have been saved successfully!');
        // Add logic to save the data to the backend or update the table
    });

    document.querySelector('.dropdown-menu .dropdown-item[href="index.html"]').addEventListener('click', function (event) {
        if (!confirm('Are you sure you want to logout?')) {
            event.preventDefault();
        }
    });

    document.getElementById('day').addEventListener('change', function () {
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


   
    

</body>

</html>