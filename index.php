<?php 
session_start();
error_reporting(0);

// Include database configuration
include 'include/config.php';

// Check if user is logged in
$uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : null;

// Handle form submission for booking
if (isset($_POST['submit'])) { 
    $pid = $_POST['pid'];

    // Insert booking record
    $sql = "INSERT INTO tblbooking (package_id, userid) VALUES (:pid, :uid)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':pid', $pid, PDO::PARAM_STR);
    $query->bindParam(':uid', $uid, PDO::PARAM_STR);
    $query->execute();

    echo "<script>alert('Package has been booked.');</script>";
    echo "<script>window.location.href='booking-history.php';</script>";
    exit(); // Ensure script stops after redirection
}
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Gym Management System</title>
    <meta charset="UTF-8">
    <meta name="description" content="Gym Management System">
    <meta name="keywords" content="gym, fitness, package booking">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="css/nice-select.css"/>
    <link rel="stylesheet" href="css/magnific-popup.css"/>
    <link rel="stylesheet" href="css/slicknav.min.css"/>
    <link rel="stylesheet" href="css/animate.css"/>
    <link rel="stylesheet" href="css/style.css"/>

</head>
<body>

<!-- Header Section -->
<?php include 'include/header.php'; ?>

<!-- Page top Section -->
<section class="page-top-section set-bg" data-setbg="img/page-top-bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 m-auto text-white">
                <h2>Home</h2>
                <p>Physical Activity Can Improve Your Health</p>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section class="pricing-section spad">
    <div class="container">
        <div class="section-title text-center">
            <img src="img/icons/logo-icon.png" alt="">
            <h2>Pricing Plans</h2>
            <p>Practice fitness to perfect physical beauty, care for your soul, and enjoy life more fully!</p>
        </div>
        <div class="row">
            <?php 
            // Fetch available packages
            $sql = "SELECT id, category, titlename, PackageType, PackageDuratiobn, Price, uploadphoto, Description, create_date FROM tbladdpackage";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if ($query->rowCount() > 0) {
                foreach ($results as $result) {
            ?>
            <div class="col-lg-3 col-sm-6">
                <div class="pricing-item begginer">
                    <div class="pi-top">
                        <h4><?php echo htmlentities($result->titlename); ?></h4>
                    </div>
                    <div class="pi-price">
                        <h3><?php echo htmlentities($result->Price); ?></h3>
                        <p><?php echo htmlentities($result->PackageDuratiobn); ?></p>
                    </div>
                    <ul>
                        <li><?php echo htmlentities($result->Description); ?></li>
                    </ul>

                    <?php if (empty($uid)) : ?>
                        <a href="login.php" class="site-btn sb-line-gradient">Booking Now</a>
                    <?php else : ?>
                        <form method="post">
                            <input type="hidden" name="pid" value="<?php echo htmlentities($result->id); ?>">
                            <input class="site-btn sb-line-gradient" type="submit" name="submit" value="Booking Now" onclick="return confirm('Do you really want to book this package?');">
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php 
                }
            } 
            ?>
        </div>
    </div>
</section>

<!-- Footer Section -->
<?php include 'include/footer.php'; ?>

<!-- Back to Top -->
<div class="back-to-top"><img src="img/icons/up-arrow.png" alt=""></div>

<!--====== Javascripts & Jquery ======-->
<script src="js/vendor/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.slicknav.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.nice-select.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
