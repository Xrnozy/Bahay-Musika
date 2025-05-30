<?php
// member_list.php - Displays the list of members (extracted from add_member.php)
include 'db-connection.php';
?>
<div class="company-name">
    <h1 class="company-name-title">Bahay Musika Admin Panel</h1>
</div>
<h3 class="dashboard-title">Members</h3>
</div>
<div class="events-list">
    <h2 class="member-title">Members List</h2>
    <div class="list">
        <?php
        if ($conn->connect_error) {
            echo "<span style='color:red;'>❌ Database Connection Failed: " . $conn->connect_error . "</span>";
        } else {
            $result = $conn->query("SELECT * FROM members");
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imageData = base64_encode($row['profile_image']);
                    $imageType = $row['profile_image_type'];
        ?>
                    <div class="news-input">
                        <div class="img-news-cont">
                            <img src="data:<?php echo $imageType; ?>;base64,<?php echo $imageData; ?>" alt="" class="">
                        </div>
                        <div class="member-details">
                            <h3><?= htmlspecialchars($row['firstName'] . ' ' . $row['lastName']) ?></h3>
                            <p><strong>Middle Name:</strong> <?= htmlspecialchars($row['middleName']) ?></p>
                            <p><strong>Facebook:</strong> <a href="<?= htmlspecialchars($row['fb_link']) ?>" target="_blank">View Profile</a></p>
                            <p><strong>Category:</strong> <?= ucfirst($row['category']) ?></p>
                            <p><strong>Date of Birth:</strong> <?= htmlspecialchars($row['dob']) ?></p>
                            <p><strong>Phone:</strong> <?= htmlspecialchars($row['phone']) ?></p>
                            <p><strong>Address:</strong> <?= htmlspecialchars($row['street'] . ', ' . $row['city'] . ', ' . $row['state'] . ', ' . $row['zip']) ?></p>
                        </div>
                        <h5 class="edit-button" onclick="loadContent('content-manager/update_member.php?id=<?= $row['id'] ?>')">
                            Edit Member Profile
                        </h5>
                    </div>
        <?php
                }
            } else {
                echo "<p>No members available.</p>";
            }
        }
        ?>
    </div>
</div>