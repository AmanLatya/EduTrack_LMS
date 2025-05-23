<?php
if (!isset($_SESSION)) {
    session_start();
}

include '../layout/htmlHeadLinks.php';
include '../layout/htmlFooterLinks.php';
include './Header.php';
?>
<h1>Welcome Instructor</h1>
<?php
include '../layout/adminFooter.php';
?>