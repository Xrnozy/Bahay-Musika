<?php
// news_list.php - Displays the list of news (extracted from news_management.php)
include 'db-connection.php';
?>
<div class="company-name">
    <h1 class="company-name-title">Bahay Musika Admin Panel</h1>
</div>
<h3 class="dashboard-title">News List</h3>
<div class="events-list">
    <h2 class="member-title">Recent Uploaded News List</h2>
    <div class="list">
        <?php
        if ($conn->connect_error) {
            echo "<span style='color:red;'>❌ Database Connection Failed: " . $conn->connect_error . "</span>";
        } else {
            $result = $conn->query("SELECT id, title, location, date, time, fb_link, image, image_type FROM news ORDER BY id DESC");
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imageData = base64_encode($row['image']);
                    $imageType = $row['image_type'];
        ?>
                    <div class="news-input">
                        <div class="img-news-cont">
                            <img src="data:<?php echo $imageType; ?>;base64,<?php echo $imageData; ?>" alt="" class="">
                        </div>
                        <div class="member-details">
                            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                            <h4><?php echo htmlspecialchars($row['location']); ?></h4>
                            <div class="category-edit-cont">
                                <h5><?php echo htmlspecialchars($row['date']); ?></h5>
                                <h5><?php echo htmlspecialchars($row['time']); ?></h5>
                            </div>
                            <p><a href="<?php echo htmlspecialchars($row['fb_link']); ?>" target="_blank">View on Facebook</a></p>
                            <h5 class="edit-button" onclick="loadContent('content-manager/edit_news.php?id=<?= $row['id'] ?>')">
                                Edit News
                            </h5>
                        </div>
                    </div>
        <?php
                }
            } else {
                echo "<p>No news available.</p>";
            }
        }
        ?>
    </div>
</div>