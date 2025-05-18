<?php

include('./API/APIConfig.php');
session_start();

//Reset OAuth access token
$client->revokeToken();

session_destroy();
echo '<script>
    // Check if jQuery is loaded
    if (typeof jQuery == "undefined") {
        var script = document.createElement("script");
        script.src = "https://code.jquery.com/jquery-3.6.0.min.js"; // jQuery CDN
        script.type = "text/javascript";
        document.getElementsByTagName("head")[0].appendChild(script);
    }

    // Wait for jQuery to load
    setTimeout(function () {
        $("body").append(`
            <div id="loading-screen" class="loading-overlay" style="position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); display:flex; align-items:center; justify-content:center; color:white; z-index:9999;">
                <div>
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p style="text-align:center;">Redirecting...</p>
                </div>
            </div>
        `);

        setTimeout(function () {
            $("#loading-screen").fadeOut("slow", function () {
                window.location.href = "/EduTrack/"; // Redirect URL
                // window.location.href = "/EduTrack/Dashboards/AdminDashBoard.php"; // Uncomment if needed
            });
        }, 800); // 2 seconds delay
    }, 100); // Small delay to ensure jQuery is loaded
</script>';
?>
