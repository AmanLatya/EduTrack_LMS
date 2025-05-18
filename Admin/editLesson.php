<!-- Header Links -->
<?php
include './AdminHeader.php';
include '../ConnectDataBase.php';

// ----------------------------------------Update Course------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_topic'])) {
    if (
        empty($_POST['lesson_id']) || empty($_POST['lessonNum']) || empty($_POST['topicName']) || empty($_POST['topicDesc']) || empty($_FILES['lectureLink']['name'])
    ) {
        $msg = '<div class="alert alert-warning text-center">Fill all details</div>';
    } else {
        $lesson_id = $_POST['lesson_id'];
        $lessonNum = $_POST['lessonNum'];
        $topicName = $_POST['topicName'];
        $topicDesc = $_POST['topicDesc'];

        $lectureLink = $_FILES['lectureLink']['name'];
        $lectureLinkTemp = $_FILES['lectureLink']['tmp_name'];
        $lectureFolder = '../lectureVedios/' . $lectureLink;

        move_uploaded_file($lectureLinkTemp, $lectureFolder);

        $sql = "UPDATE lesson SET lesson_id = '$lesson_id', lesson_num = '$lessonNum', lesson_name = '$topicName', lesson_desc = '$topicDesc' WHERE lesson_id = '$lesson_id'";

        if ($connection->query($sql) == TRUE) {
            $msg = '<div class="alert alert-success text-center">Course Updated !</div>';
        } else {
            $msg = '<div class="alert alert-danger text-center">Updation Falied !</div>';
        }
    }
}

?>


<title>EDUTRACK - Edit Lesson</title>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="form-container">
        <h3 class="text-center mb-4"><i class="fas fa-book"></i> Update Lesson Details <a href="./lessons.php" class="btn btn-primary">
                <i class="fas fa-times"></i>
            </a>
        </h3>

        <?php
        if (isset($_REQUEST['editLesson'])) {
            $sql = "SELECT * FROM lesson WHERE lesson_id = {$_REQUEST['l_id']}";
            $result = $connection->query($sql);
            $row = $result->fetch_assoc();
        }

        ?>
        <form method="POST" enctype="multipart/form-data">
    </div>
    <div class="mb-3">
        <label class="form-label">Lesson ID</label>
        <div class="input-group custom-input-group">
            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
            <input type="number" class="form-control" name="lesson_id" value="<?php
                                                                                if (isset($_REQUEST['l_id'])) {
                                                                                    echo $_REQUEST['l_id'];
                                                                                }
                                                                                ?>" placeholder="Enter Topic Number" required>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Lesson No.</label>
        <div class="input-group custom-input-group">
            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
            <input type="number" class="form-control" name="lessonNum" value="<?php if (isset($row['lesson_num'])) {
                                                                                    echo $row['lesson_num'];
                                                                                } ?>" placeholder="Enter Topic Number" required>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Topic Name</label>
        <div class="input-group custom-input-group">
            <span class="input-group-text"><i class="fas fa-align-left"></i></span>
            <textarea class="form-control" name="topicName" rows="3" placeholder="Enter Topic Name" required><?php if (isset($row['lesson_name'])) {
                                                                                                                    echo $row['lesson_name'];
                                                                                                                } ?></textarea>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Topic Description</label>
        <div class="input-group custom-input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" class="form-control" name="topicDesc" value="<?php if (isset($row['lesson_desc'])) {
                                                                                echo $row['lesson_desc'];
                                                                            } ?>" placeholder="Description" required>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Upload Lecture Link</label>
        <div class="input-group custom-input-group">
            <span class="input-group-text"><i class="fas fa-image"></i></span>
            <input type="file" class="form-control" name="lectureLink" accept="vedio/*" required>
        </div>
    </div>

    <div class="mb-3 text-center">
        <button type="submit" name="update_topic" id="update_topic" class="btn btn-primary custom-btn-primary">
            <i class="fas fa-plus-circle"></i> Update
        </button>
    </div>

    <?php if (isset($msg)) {
        echo $msg;
    } ?>
    </form>
</div>
</div>


<?php include '../layout/adminFooter.php'; ?>