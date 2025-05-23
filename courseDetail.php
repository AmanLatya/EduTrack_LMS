<?php

include('./layout/htmlHeadLinks.php');
include('./layout/header.php');
include './ConnectDataBase.php';

if (isset($_GET['course_id'])) {
    $courseId = $_GET['course_id'];
    $sql =  "SELECT * FROM courses WHERE course_id = '$courseId'";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
}

?>

<style>
    .banner {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
    }

    .banner img {
        width: 100%;
        display: block;
        transition: transform 0.3s ease;
    }

    .banner:hover img {
        transform: scale(1.05);
    }

    .banner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .banner:hover .banner-overlay {
        opacity: 1;
    }

    .price {
        font-size: 1.5rem;
        color: #dc3545;
        font-weight: bold;
    }

    .original-price {
        font-size: 1rem;
        text-decoration: line-through;
        color: #6c757d;
        margin-left: 10px;
    }

    .discount {
        font-size: 1rem;
        color: #28a745;
        margin-left: 10px;
    }

    #buyCourse {
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    #buyCourse:hover {
        background-color: #c82333;
        transform: scale(1.05);
    }
</style>

<div class="container-fluid">
    <div class="p-4">
        <div class="card shadow">
            <div class="banner">
                <img alt="Web Development Course Banner" src="<?php echo str_replace('..', '.', $row['course_img']) ?>" />
                <div class="banner-overlay">
                    <h2 class="text-white"><?php echo $row['course_name'] ?></h2>
                </div>
            </div>
            <div class="card-body">
                <div class="" id="description">
                    <h2 class="font-weight-bold mt-4">Course Description</h2>
                    <p class="text-muted">
                        <?php echo $row['course_description'] ?>
                    </p>
                </div>
                <div class="" id="teacher">
                    <h2 class="font-weight-bold mt-4">Teacher</h2>
                    <p class="text-muted">
                        Your instructor for this course is <b><?php echo $row['course_author'] ?></b>, a seasoned web developer with over 10 years of experience in the industry. John has worked with numerous clients and companies, building high-quality web applications and websites.
                    </p>
                </div>
                <div class="" id="reviews">
                    <h2 class="font-weight-bold mt-4">Reviews</h2>
                    <p class="text-muted">
                        "This course is amazing! I learned so much and now feel confident in my web development skills." - Jane Smith
                    </p>
                    <p class="text-muted">
                        "The instructor is very knowledgeable and explains concepts clearly. Highly recommend this course!" - Mark Johnson
                    </p>
                </div>
                <div class="" id="purchase-course">
                    <h2 class="font-weight-bold mt-4">Purchase Course</h2>
                    <div class="bg-light p-4 rounded">
                        <?php
                        $price = (float)$row['course_price'];
                        $originalPrice = (float)$row['course_original_price'];
                        $hasDiscount = $originalPrice > $price;
                        $discountPercent = $hasDiscount ? round((($originalPrice - $price) / $originalPrice) * 100) : 0;
                        ?>
                        <p class="text-muted">
                            <span class="price">Rs. <?php echo $price ?></span>
                            <?php if ($hasDiscount) { ?>
                                <span class="original-price">Rs. <?php echo $originalPrice ?></span>
                                <span class="discount">(<?php echo $discountPercent ?>% off)</span>
                            <?php } ?>
                        </p>
                        <p class="text-muted">
                            Get lifetime access to this course, including all future updates.
                        </p>
                        <?php if (isset($_SESSION['is_stuLogin'])) { ?>
                            <a href="./Payment/index.php?orderCourse_id=<?php echo $courseId ?>&StuEmail=<?php echo $_SESSION['stuLoginEmail'] ?>" class="text-light text-decoration-none">
                                <button class="btn btn-danger btn-lg" id="buyCourse">Buy Now</button>
                            </a>
                        <?php } else { ?>
                            <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#StudentLoginModal" id="buyCourse">
                                Buy Now
                            </button>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include('./layout/footer.php') ?>
<?php include('./layout/htmlFooterLinks.php') ?>