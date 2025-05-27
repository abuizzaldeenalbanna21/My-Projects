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

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <!-- Page Heading -->
                        <h1 class="h3 mb-4 text-gray-800">Edit User</h1>
                        <div>
                            <a href="users.php" class="btn btn-secondary btn-circle">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Edit User Form -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label for="userName">First Name</label>
                                    <input type="text" class="form-control" id="userName" placeholder="Enter First Name" value="Saleh">
                                </div>
                                <div class="form-group">
                                    <label for="userName">Last Name</label>
                                    <input type="text" class="form-control" id="userName" placeholder="Enter Last Name" value="Al-qaq">
                                </div>
                                <div class="form-group">
                                    <label for="userEmail">Email</label>
                                    <input type="email" class="form-control" id="userEmail" placeholder="Enter Email" value="salehalqaq1995@gmail.com">
                                </div>
                                <div class="form-group">
                                    <label for="userType">Type of Work</label>
                                    <select class="form-control" id="userType">
                                        <option value="Doctor" selected>Doctor</option>
                                        <option value="Patient">Patient</option>
                                        <option value="Secretary">Secretary</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="userPhone">Phone Number</label>
                                    <input type="text" class="form-control" id="userPhone" placeholder="Enter Phone Number" value="+123456789">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End of Page Content -->
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
    
        
</body>
</html>