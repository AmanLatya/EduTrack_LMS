<?php
include './StudentData.php';
include './StudentNavBar.php';

if (isset($_GET['assignmentCourse_id'])) {
    $assignmentCourseId = $_GET['assignmentCourse_id'];
} else {
    echo "<script> location.href='./StudentDashboard.php'; </script>";
    exit();
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-1">
            <?php include './StudentSideBar.php'; ?>
        </div>
        <div class="offset-md-6 col-md-5 p-4 mx-auto">
            <h3 class="fw-bold">Course Assignments</h3>

            <!-- Upload Assignment Section -->
            <div class="mt-4 ">
                <h4 class="fw-bold">Upload Your Submission</h4>
                <form id="uploadForm" action="uploadAssignment.php" method="POST" enctype="multipart/form-data">
                    <div id="drop-area" class="border p-4 text-center bg-light rounded">
                        <p>Drag & Drop your file here or click to select</p>
                        <input type="file" name="assignmentFile" id="fileInput" hidden>
                        <input type="hidden" name="assignmentCourseId" value="<?php echo $assignmentCourseId; ?>">
                        <button type="button" class="btn btn-info btn-sm" onclick="document.getElementById('fileInput').click();">Select File</button>
                        <p id="file-name" class="mt-2 text-success">
                            <a href="#" id="file-preview-link" target="_blank" style="display:none;">Preview Selected File</a>
                        </p>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Submit Assignment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const fileInput = document.getElementById("fileInput");
    const filePreviewLink = document.getElementById("file-preview-link");

    fileInput.addEventListener("change", (event) => {
        const file = event.target.files[0];
        if (file) {
            const fileURL = URL.createObjectURL(file);
            filePreviewLink.href = fileURL;
            filePreviewLink.innerText = file.name;
            filePreviewLink.style.display = "inline-block";
        }
    });
</script>

<?php include '../layout/adminFooter.php' ?>