<?php
include './StudentData.php';
include './StudentNavBar.php';
$stuId = $id;

if (isset($_GET['assignmentCourse_id'])) {
    $assignmentCourseId = $_GET['assignmentCourse_id'];
} else {
    echo "<script> location.href='./StudentDashboard.php'; </script>";
    exit();
}
?>

<div class="container mt-5 shadow p-5">
    <h3 class="fw-bold">Course Assignments</h3>

    <!-- Assignment List -->
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Assignment Number</th>
                <th>Upload Date</th>
                <th>Submission Date</th>
                <th>Download</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../ConnectDataBase.php'; // Database Connection File

            $sql = "SELECT * FROM assignment WHERE course_id = '$assignmentCourseId'";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $ass_num = $row['ass_num'];

                    // Check if the student has already submitted this assignment
                    $checkSubmission = "SELECT * FROM assignmentsSubmission WHERE course_id='$assignmentCourseId' AND ass_num='$ass_num' AND Stu_id = '$stuId'";
                    $submissionResult = $connection->query($checkSubmission);

                    echo "<tr>
                                    <td>{$row['ass_num']}</td>
                                    <td>{$row['ass_uploadDate']}</td>
                                    <td>{$row['ass_subDate']}</td>
                                    <td><a href='{$row['ass_file']}' target='_blank' class='btn btn-info btn-sm'>View</a></td>";

                    if ($submissionResult->num_rows > 0) {
                        $submissionRow = $submissionResult->fetch_assoc();
                        $submittedFile = $submissionRow['ass_file']; // File path from DB

                        echo "<td>
                                        <span class='text-success fw-bold'> Submitted</span>
                                        <a href='$submittedFile' target='_blank' class='btn btn-primary btn-sm ms-2'>View Submission</a>
                                      </td>";
                    } else {
                        echo "<td><button class='btn btn-success btn-sm' onclick='showUploadSection({$row['ass_num']})'>Submit</button></td>";
                    }

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No assignments found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Upload Assignment Section (Initially Hidden) -->
    <div id="uploadSection" class="mt-4" style="display: none;">
        <h4 class="fw-bold">Upload Your Submission</h4>
        <p><strong>Assignment Number:</strong> <span id="selectedAssNum"></span></p>
        <form id="uploadForm" action="uploadAssignment.php" method="POST" enctype="multipart/form-data">
            <div id="drop-area" class="border p-4 text-center bg-light rounded">
                <p>Drag & Drop your file here or click to select</p>
                <input type="file" name="assignmentFile" id="fileInput" hidden>
                <input type="hidden" name="assignmentCourseId" value="<?php echo $assignmentCourseId; ?>">
                <input type="hidden" name="assignmentNumber" id="assignmentNumber">
                <button type="button" class="btn btn-info btn-sm" onclick="document.getElementById('fileInput').click();">Select File</button>
                <p id="file-name" class="mt-2 text-success">
                    <a href="#" id="file-preview-link" target="_blank" style="display:none;">Preview Selected File</a>
                </p>
            </div>
            <button type="submit" class="btn btn-success mt-3">Submit Assignment</button>
        </form>
    </div>
</div>

<script>
    function showUploadSection(assignmentNum) {
        document.getElementById('uploadSection').style.display = 'block';
        document.getElementById('selectedAssNum').innerText = assignmentNum;
        document.getElementById('assignmentNumber').value = assignmentNum;
    }

    const fileInput = document.getElementById("fileInput");
    const filePreviewLink = document.getElementById("file-preview-link");
    const dropArea = document.getElementById("drop-area");

    // Open file dialog on click
    dropArea.addEventListener("click", () => {
        fileInput.click();
    });

    // File selection change event
    fileInput.addEventListener("change", (event) => {
        handleFile(event.target.files[0]);
    });

    // Drag & Drop functionality
    dropArea.addEventListener("dragover", (event) => {
        event.preventDefault();
        dropArea.classList.add("border-primary");
    });

    dropArea.addEventListener("dragleave", () => {
        dropArea.classList.remove("border-primary");
    });

    dropArea.addEventListener("drop", (event) => {
        event.preventDefault();
        dropArea.classList.remove("border-primary");

        if (event.dataTransfer.files.length > 0) {
            fileInput.files = event.dataTransfer.files;
            handleFile(event.dataTransfer.files[0]);
        }
    });

    function handleFile(file) {
        if (file) {
            const fileURL = URL.createObjectURL(file);
            filePreviewLink.href = fileURL;
            filePreviewLink.innerText = file.name;
            filePreviewLink.style.display = "inline-block";
        }
    }
</script>

<?php include '../layout/adminFooter.php' ?>