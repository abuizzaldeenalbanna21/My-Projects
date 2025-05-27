<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dental Clinic - Profile</title>

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


            <div id="content">
                
                <!-- Profile Edit Section -->

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <!-- Page Heading -->
                            <div class="d-flex justify-content-between align-items-center">
                                <h1 class="h3 mb-4 text-gray-800">Profile</h1>
                                    <a href="index_admin.php" class="btn btn-circle btn-secondary">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                            </div>
                            <div class="row">
                                <!-- Profile Image Section -->
                                <div class="col-lg-4 text-center">
                                    <div class="card shadow mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title">Your Image</h5>
                                            <label for="profileImageUpload">
                                                <img src="img/undraw_profile.svg" alt="Profile Image"
                                                class="img-fluid rounded-circle mb-3"
                                                 style="width: 150px; height: 150px; cursor: pointer;">
                                            </label>
                                            <input type="file" id="profileImageUpload" accept="image/*" style="display: none;">
                                            <p class="text-muted">Click on the image to upload a new one</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Section -->
                                <form class="card Shadow modal-body col-lg-8"> 
                                    <h5 class="card-title">Edit Your Information</h5>

                                        <div  class="row">
                                            <!-- Name -->
                                            <div class="form-group col-md-6">
                                                <label for="userName">User Name</label>
                                                <input type="text" class="form-control" id="userName" placeholder="Enter your user name">
                                            </div>
                                            <!-- Email -->
                                            <div class="form-group col-md-6">
                                                <label for="userEmail">Email</label>
                                                <input type="email" class="form-control" id="userEmail" placeholder="Enter your email">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- Birthday -->
                                            <div class="form-group col-md-6">
                                                <label for="userBirthday">Birthday</label>
                                                <input type="date" class="form-control" id="userBirthday">
                                            </div>
                                            <!-- Phone Number -->
                                            <div class="form-group col-md-6">
                                                <label for="userPhone">Phone Number</label>
                                                <input type="tel" class="form-control" id="userPhone" placeholder="Enter your phone number">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- Current Password -->
                                            <div class="form-group col-md-6">
                                                <label for="userPassword">Current Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="currentPassword" placeholder="Enter current password">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#currentPassword">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Change Password -->
                                            <div class="form-group col-md-6">
                                                <label for="newPassword">Change Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="newPassword" placeholder="Enter new password">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#newPassword">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- Confirm Password -->
                                            <div class="form-group col-md-6">
                                                <label for="confirmPassword">Confirm Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#confirmPassword">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </form>
                                
                            </div>
                            <!-- Centered Save Changes Button -->
                            <div class="text-center mt-4">
                                <button type="submit" class="btn bg-primary btn-primary">
                                    Save Changes
                                </button>
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
                <!-- End of Profile Edit Section -->

            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                const target = document.querySelector(this.getAttribute('data-target'));
                if (target.type === 'password') {
                    target.type = 'text';
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    target.type = 'password';
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        });
    </script>
        
</body>
</html>