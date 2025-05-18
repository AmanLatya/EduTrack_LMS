<?php
include './StudentData.php';
include './StudentNavBar.php';

if (isset($_GET['enrolledCourse_id'])) {
    $enrolledCourseId = $_GET['enrolledCourse_id'];

    $lessonSql = "SELECT * FROM lesson WHERE course_id = '$enrolledCourseId' ORDER BY lesson_num ASC";
    $lessonResult = $connection->query($lessonSql);
} else {
    echo "<script> location.href='./StudentDashboard.php'; </script>";
    exit();
}
?>

<style>
    .course-lesson-card {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .lesson-item {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-bottom: 25px;
        padding: 20px;
        position: relative;
    }

    .lesson-item h5 {
        color: #343a40;
        margin-bottom: 10px;
    }

    .lesson-item p {
        color: #6c757d;
        margin-bottom: 15px;
    }

    .lesson-video {
        display: none;
        margin-top: 20px;
    }

    #video {
        width: 35vw;
    }

    .play-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background-color: #007bff;
        border: none;
        color: white;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.3s ease;
    }

    .play-btn:hover {
        background-color: #0056b3;
    }

    .no-lessons {
        text-align: center;
        color: #dc3545;
        padding: 20px;
    }
</style>

<div class="container mt-5 shadow p-5">
    <div class="card course-lesson-card">
        <div class="card-body">
            <h2 class="fs-4 fw-bold mb-4">Course Lessons</h2>

            <?php
            if ($lessonResult->num_rows > 0) {
                $videoIndex = 1;
                while ($lessonRow = $lessonResult->fetch_assoc()) {
                    $videoId = "lessonVideo_" . $videoIndex;
                    $btnId = "btn_" . $videoIndex;
            ?>
                    <div class="lesson-item">
                        <h5 class="fw-bold"><?php echo "Lesson " . $lessonRow['lesson_num'] . ": " . $lessonRow['lesson_name']; ?></h5>
                        <p class="text-secondary"><?php echo $lessonRow['lesson_desc']; ?></p>

                        <button class="play-btn" id="<?php echo $btnId; ?>"
                            onclick="toggleVideo('<?php echo $videoId; ?>', '<?php echo $btnId; ?>', '<?php echo $lessonRow['lesson_id']; ?>', '<?php echo $enrolledCourseId; ?>')">
                            <i class="fas fa-play-circle"></i> Play Video
                        </button>

                        <center>
                            <div class="lesson-video" id="<?php echo $videoId; ?>">
                                <video controls id="video">
                                    <source src="<?php echo $lessonRow['lesson_link']; ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </center>
                    </div>
            <?php
                    $videoIndex++;
                }
            } else {
                echo "<p class='no-lessons'>No lessons available for this course.</p>";
            }
            ?>
        </div>
    </div>
</div>

<!-- <script>
    function toggleVideo(videoId, buttonId) {
        const videoDiv = document.getElementById(videoId);
        const button = document.getElementById(buttonId);
        const video = videoDiv.querySelector("video");

        if (videoDiv.style.display === "none" || videoDiv.style.display === "") {
            videoDiv.style.display = "block";
            video.play();
            button.innerHTML = `<i class="fas fa-eye-slash"></i> Hide Video`;
        } else {
            videoDiv.style.display = "none";
            video.pause();
            button.innerHTML = `<i class="fas fa-play-circle"></i> Play Video`;
        }
    }
</script> -->

<script>
    function toggleVideo(videoId, buttonId, lessonId, courseId) {
        const videoDiv = document.getElementById(videoId);
        const button = document.getElementById(buttonId);
        const video = videoDiv.querySelector("video");

        if (videoDiv.style.display === "none" || videoDiv.style.display === "") {
            videoDiv.style.display = "block";
            video.play();
            button.innerHTML = `<i class="fas fa-eye-slash"></i> Hide Video`;

            //  Record the video view
            fetch(`./recordLessonView.php?lesson_id=${lessonId}&course_id=${courseId}`, {
                method: 'GET'
            });
        } else {
            videoDiv.style.display = "none";
            video.pause();
            button.innerHTML = `<i class="fas fa-play-circle"></i> Play Video`;
        }
    }
</script>


<?php include '../layout/adminFooter.php' ?>