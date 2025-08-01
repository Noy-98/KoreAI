<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../../login.php');
    exit();
}
require_once __DIR__ . '/../../forms/db_con.php'; // Adjust the path if necessary

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, first_name, last_name, email, address, mobile_number, profile_picture FROM users WHERE id = ?";
$stmt = $db_con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();

$db_con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicons -->
    <link href="../../assets/img/main_logo.png" rel="icon">

	<title>A-CHOO'S KOREAN STORE</title>
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link href="../../assets/css/profile.css" rel="stylesheet">
</head>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-store'></i>
            <span class="text">AdminHub</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="../admin/home.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="../admin/controls.php">
                    <i class='bx bxs-group'></i>
                    <span class="text">User Control</span>
                </a>
            </li>
            <li class="active">
                <a href="../admin/profile.php">
                    <i class='bx bxs-user-circle'></i>
                    <span class="text">Profile</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="../../forms/logout_con.php" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link">A-CHOO'S KOREAN STORE</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="../admin/profile.php" class="profile">
                <img src="<?php echo htmlspecialchars($user_data['profile_picture']); ?>">
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Profile Dashboard</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Profile Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="../admin/home.php">Home</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="message">
                <!-- Validation message section -->
                <?php
                if (session_status() == PHP_SESSION_NONE) {
                    session_start(); // Start the session if it hasn't started
                }

                // Display error messages
                if (isset($_SESSION['error'])) {
                    echo '<div class="error_message">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']); // Clear the error message
                }

                // Display success messages
                if (isset($_SESSION['success'])) {
                    echo '<div class="success_message">' . $_SESSION['success'] . '</div>';
                    unset($_SESSION['success']); // Clear the success message
                }
                ?>
            </div>

            <!-- Page content -->
            <!-- View Profile -->
            <div class="row">
                <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                    <div class="card card-profile shadow">
                        <div class="row justify-content-center">
                            <div class="col-lg-3 order-lg-2">
                                <div class="card-profile-image">
                                    <a href="#">
                                        <img src="<?php echo htmlspecialchars($user_data['profile_picture']); ?>"
                                            class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0 pt-md-4">
                            <div class="text-center">
                                <h3>
                                    Username: <span class="font-weight-light"><?php echo htmlspecialchars($user_data['username']); ?></span>
                                </h3>
                                <hr class="my-4">
                                <div class="h5 font-weight-300">
                                    <h3>
                                        First Name: <span class="font-weight-light"><?php echo htmlspecialchars($user_data['first_name']); ?></span>
                                    </h3>
                                </div>
                                <hr class="my-4">
                                <div class="h5 font-weight-300">
                                    <h3>
                                        Last Name: <span class="font-weight-light"><?php echo htmlspecialchars($user_data['last_name']); ?></span>
                                    </h3>
                                </div>
                                <hr class="my-4">
                                <div class="h5 font-weight-300">
                                    <h3>
                                        Email: <span class="font-weight-light"><?php echo htmlspecialchars($user_data['email']); ?></span>
                                    </h3>
                                </div>
                                <hr class="my-4">
                                <div class="h5 font-weight-300">
                                    <h3>
                                        Mobile Number: <span class="font-weight-light"><?php echo htmlspecialchars($user_data['mobile_number']); ?></span>
                                    </h3>
                                </div>
                                <hr class="my-4">
                                <div class="h5 font-weight-300">
                                    <h3>
                                        Address: <span class="font-weight-light"><?php echo htmlspecialchars($user_data['address']); ?></span>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of View Profile -->

                <!-- Edit Profile-->
                <div class="col-xl-8 order-xl-1">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">My account</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <button type="button" class="btn btn-sm btn-primary" id="uploadButton">Upload Picture</button>
                                    <form id="uploadForm" method="post" action="../../forms/admin_upload_picture.php" enctype="multipart/form-data" style="display: none;">
                                        <input type="file" id="profilePictureInput" name="profile_picture" accept="image/*">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="../../forms/admin_profile.php">
                                <h6 class="heading-small text-muted mb-4">User information</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-username">Username</label>
                                                <input type="text" name="username" class="form-control form-control-alternative"
                                                    placeholder="Username" value="<?php echo htmlspecialchars($user_data['username']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-email">Email address</label>
                                                <input type="email" name="email" class="form-control form-control-alternative"
                                                    placeholder="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-first-name">First name</label>
                                                <input type="text" name="first_name"
                                                    class="form-control form-control-alternative" placeholder="First name"
                                                    value="<?php echo htmlspecialchars($user_data['first_name']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-last-name">Last name</label>
                                                <input type="text" name="last_name"
                                                    class="form-control form-control-alternative" placeholder="Last name"
                                                    value="<?php echo htmlspecialchars($user_data['last_name']); ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-password">New Password</label>
                                                <div class="password-wrapper">
                                                    <input type="password" name="password" class="form-control form-control-alternative" placeholder="New Password" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-confirm-password">Confirm Password</label>
                                                <div class="password-wrapper">
                                                    <input type="password" name="confirm_password" class="form-control form-control-alternative" placeholder="Confirm Password" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <!-- Address -->
                                <h6 class="heading-small text-muted mb-4">Contact information</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-address">Address</label>
                                                <input name="address" class="form-control form-control-alternative"
                                                    placeholder="Home Address" type="text" value="<?php echo htmlspecialchars($user_data['address']); ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-mobile-number">Mobile Number</label>
                                                <input type="number" name="mobile_number" class="form-control form-control-alternative"
                                                    placeholder="Mobile Number" value="<?php echo htmlspecialchars($user_data['mobile_number']); ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End of Edit Profile-->
            </div>
        </main>
        <!-- MAIN -->
    </section>

    <!-- Template Main JS File -->
    <script src="../../assets/js/dashboard.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('uploadButton').addEventListener('click', function() {
            document.getElementById('profilePictureInput').click();
        });

        document.getElementById('profilePictureInput').addEventListener('change', function() {
            document.getElementById('uploadForm').submit();
        });
    </script>
</body>
</html>
