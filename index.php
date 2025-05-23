<!-- Html Head Links -->
<?php
include('./layout/htmlHeadLinks.php');
include('./ConnectDataBase.php');
include('./API/APIConfig.php');

?>
<!-- End Nav Bar -->
<?php 
include('./layout/header.php');
 ?>

<!-- Start Body -->
<section>
    <div class="d-flex flex-column justify-content-center align-items-center text-center" id="bodyContainer">
        <div class="lms">
            <h1>Transform Your Learning Experience</h1>
            <p>Our Learning Management System provides a comprehensive platform for educators and learners to connect, collaborate, and achieve educational goals through innovative digital solutions.</p>

            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3 class="feature-title">Interactive Courses</h3>
                    <p>Engaging multimedia content with quizzes and assignments</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title">Progress Tracking</h3>
                    <p>Monitor your learning journey with detailed analytics</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Collaborative Learning</h3>
                    <p>Discussion forums and peer interaction features</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="feature-title">Mobile Friendly</h3>
                    <p>Access your courses anytime, anywhere</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Body -->

<!-- Start Free Courses -->
<?php
include('./freeCourses.php');
?>
<!-- End Free Courses -->


<!-- Feddback Section -->
<div class="container my-5 py-4" id="feedback">
    <h1 class="text-center mb-5">Students Feedback</h1>
    <div id="feedbackCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            <?php
            $sql = "SELECT s.Stu_Name, s.Stu_Profile, s.Stu_Proffesion, f.f_msg FROM student AS s JOIN feedback AS f ON s.Stu_id = f.Stu_id";
            $result = $connection->query($sql);
            $count = 0;
            $totalCards = 0;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $stuImg = str_replace('..', '.', $row['Stu_Profile']);
                    $stuName = $row['Stu_Name'];
                    $stuProffesion = $row['Stu_Proffesion'];
                    $f_msg = $row['f_msg'];

                    if ($count % 3 == 0) {
                        echo '<div class="carousel-item ' . ($totalCards == 0 ? 'active' : '') . '">';
                        echo '<div class="row justify-content-center">';
                    }
            ?>
                    <div class="col-lg-3 col-md-4 mb-4 px-3">
                        <div class="card feedback-card text-center p-4 h-100 shadow-sm">
                            <img src="<?php echo $stuImg ?>" class="rounded-circle mx-auto d-block" style="width: 100px; height: 100px;" alt="Profile">
                            <h5 class="mt-3"><?php echo $stuName ?></h5>
                            <span class="text-muted d-block mb-2"><?php echo $stuProffesion ?></span>
                            <div class="rating mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="px-2">"<?php echo $f_msg ?>"</p>
                        </div>
                    </div>
            <?php
                    $count++;
                    if ($count % 3 == 0 || $count == $result->num_rows) {
                        echo '</div></div>';
                        $totalCards++;
                    }
                }
            } else {
                echo '<div class="text-center py-5"><h4>No feedback available yet</h4></div>';
            }
            ?>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#feedbackCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#feedbackCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>
<!-- Start Contact -->
<?php include('./contactUs.php') ?>
<!-- End Contact -->
<br><br>

<!-- Start Footer Courses -->
<?php include('./layout/footer.php') ?>
<!-- End Footer Courses -->


<!-- Html Footer Links -->

<?php include('./layout/htmlFooterLinks.php') ?>