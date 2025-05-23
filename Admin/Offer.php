<?php
$action = $_GET['action'] ?? 'all'; // Default action

if ($action == 'all') {
?>
    <h3>Apply Offer to All Courses</h3>
    <form id="ApplyOfferAtAllForm">
        <label for="OfferValue">Enter Offer Percentage:</label>
        <input type="number" id="OfferValue" placeholder="Enter % Offer" min="0" max="100" required>
        <button type="submit">Apply Offer</button>
    </form>

<?php
} elseif ($action == 'single') {
    $courseId = $_GET['course_id'] ?? ''; // Optional: pass course_id via URL
?>
    <h3>Apply Offer to One Course</h3>
    <form method="POST" id="ApplyOfferAtOneForm">
        <input type="hidden" id="course_id" name="course_id" value="<?= htmlspecialchars($courseId) ?>">
        <label for="OfferValue">Enter Offer Percentage:</label>
        <input type="number" id="OfferValue" name="Offer" placeholder="Enter % Offer" min="0" max="100" required>
        <button type="submit">Update Price</button>
    </form>

<?php
}
?>

<?php include '../layout/htmlFooterLinks.php'; ?>
