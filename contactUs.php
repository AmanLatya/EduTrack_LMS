<style>
    /* Custom CSS */
    .contact-card {
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        margin-bottom: 20px;
    }
    
    .contact-card:hover {
        transform: translateY(-5px);
    }
    
    .contact-title {
        color: #2c3e50;
        font-weight: 700;
        border-bottom: 2px solid #3498db;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    
    .contact-info li {
        margin-bottom: 15px;
        color: #555;
        line-height: 1.6;
    }
    
    .contact-info i {
        color: #3498db;
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }
    
    body {
        background-color: #f5f7fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .contact-card {
            margin-bottom: 20px;
        }
    }
</style>

<div class="container-fluid p-3">
    <div class="row d-flex justify-content-around">
        <!-- About Us Section -->
        <div class="col-lg-4 col-md-6 contact-card p-4 mb-4">
            <h2 class="contact-title">ABOUT US</h2>
            <ul class="contact-info list-unstyled mt-3">
                <li><i class="fas fa-graduation-cap"></i> EduTrack provides a user-friendly platform for students and admins.</li>
                <li><i class="fas fa-video"></i> Access courses, view recorded lectures, and join live weekend classes.</li>
                <li><i class="fas fa-chart-line"></i> Dashboard to track your learning progress and performance.</li>
            </ul>
        </div>
        
        <!-- Category Section -->
        <div class="col-lg-3 col-md-6 contact-card p-4 mb-4">
            <h2 class="contact-title">CATEGORY</h2>
            <ul class="contact-info list-unstyled mt-3">
                <li><i class="fas fa-laptop-code"></i> Programming Courses</li>
                <li><i class="fas fa-chart-bar"></i> Data Science</li>
                <li><i class="fas fa-paint-brush"></i> Design & Arts</li>
                <li><i class="fas fa-business-time"></i> Business Studies</li>
            </ul>
        </div>
        
        <!-- Contact Us Section -->
        <div class="col-lg-3 col-md-6 contact-card p-4 mb-4">
            <h2 class="contact-title">CONTACT US</h2>
            <ul class="contact-info list-unstyled mt-3">
                <li><i class="fas fa-phone"></i> +123-456-7890</li>
                <li><i class="fas fa-globe"></i> www.edutrack.com</li>
                <li><i class="fas fa-envelope"></i> contact@edutrack.com</li>
                <li><i class="fas fa-map-marker-alt"></i> 123 Education St., Learning City</li>
            </ul>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">