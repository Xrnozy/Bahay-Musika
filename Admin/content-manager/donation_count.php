<?php
include 'db-connection.php'; // Include database connection

// Fetch total donation amount
$totalDonationQuery = $conn->query("SELECT SUM(amount) as total FROM donations");
$totalDonation = $totalDonationQuery->fetch_assoc()['total'] ?? 0;

// Fetch all donation records
$donations = $conn->query("SELECT * FROM donations");

// Helper: Decrypt sensitive data (reversible)
define('ENCRYPT_KEY', 'your-32-char-secret-key-here'); // Use the same key as in donation_submit.php
function decrypt_sensitive($data)
{
    if ($data === null || $data === '') return '';
    $c = base64_decode($data);
    $ivlen = openssl_cipher_iv_length($cipher = "AES-256-CBC");
    $iv = substr($c, 0, $ivlen);
    // Ensure IV is exactly $ivlen bytes (pad with null bytes if too short)
    if (strlen($iv) < $ivlen) {
        $iv = str_pad($iv, $ivlen, "\0");
    }
    $ciphertext = substr($c, $ivlen);
    return openssl_decrypt($ciphertext, $cipher, ENCRYPT_KEY, 0, $iv);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Count</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .container {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
        }

        .table {
            margin-top: 20px;
        }

        /* Image popup styles */
        .image-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .image-popup img {
            max-width: 90vw;
            max-height: 90vh;
            border: 8px solid #fff;
            border-radius: 12px;
            box-shadow: 0 4px 32px rgba(0, 0, 0, 0.4);
        }
    </style>
</head>

<body>
    <div class="company-name">
        <h1 class="company-name-title">Bahay Musika Admin Panel</h1>
    </div>
    <h3 class="dashboard-title">Donations Overview</h3>
    <div class="container">
        <h1 class="text-center">Donation Count</h1>

        <div class="alert alert-success text-center" role="alert">
            <h4>Total Donations: PHP <?= number_format($totalDonation, 2) ?></h4>
        </div>

        <h2>Donations Table <button id="showDecryptAll" onclick="decrypt()" class="btn btn-info btn-sm ms-2">Decrypt</button>
        </h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Donor Name</th>
                    <th>Amount</th>
                    <th>Created At</th>
                    <th>Reference Number</th>
                    <th>Image</th> <!-- New Image column -->
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Donation Type</th>
                    <th>Status</th> <!-- New Status column -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $donations->fetch_assoc()): ?>
                    <script>
                        const test = <?= htmlspecialchars(decrypt_sensitive($row['donor_name'])) ?>;
                        console.log(test);
                    </script>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td class="donor-name-masked" data-full="<?= htmlspecialchars(decrypt_sensitive($row['donor_name'])) ?>">
                            <?= substr(htmlspecialchars($row['donor_name']), 0, 10) . (strlen(
                                $row['donor_name']
                            ) > 10 ? '...' : '') ?>
                        </td>
                        <td>PHP <?= number_format($row['amount'], 2) ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td><?= $row['reference_number'] ?></td>
                        <td>
                            <?php if (!empty($row['image'])): ?>
                                <img src="data:<?= htmlspecialchars($row['image_type']) ?>;base64,<?= base64_encode($row['image']) ?>" alt="Donation Image" style="width: 100px; height: auto; cursor: pointer;" onclick="showImagePopup(this.src)" />
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td class="masked-data" data-type="email" data-id="<?= $row['id'] ?>" data-full="<?= htmlspecialchars(decrypt_sensitive($row['email'])) ?>">
                            <?= substr(htmlspecialchars($row['email']), 0, 10) . (strlen($row['email']) > 10 ? '...' : '') ?>
                        </td>
                        <td class="masked-data" data-type="phone" data-id="<?= $row['id'] ?>" data-full="<?= htmlspecialchars(decrypt_sensitive($row['phone'])) ?>">
                            <?= substr(htmlspecialchars($row['phone']), 0, 10) . (strlen($row['phone']) > 10 ? '...' : '') ?>
                        </td>
                        <td><?= htmlspecialchars($row['donation_type'] ?? '') ?></td>
                        <td>
                            <?php if ($row['status'] === 'verified'): ?>
                                <span class="badge bg-success">Verified</span>
                            <?php else: ?>
                                <form method="post" action="verify_donation.php" target="verifyWindow" style="display:inline;">
                                    <input type="hidden" name="verify_id" value="<?= $row['id'] ?>">
                                    <button type="submit" onclick="verify()" class="btn btn-success btn-sm">Verify</button>
                                </form>

                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function decrypt() {
            const password = prompt('Enter admin password to decrypt all donor details:');
            if (!password) return;
            const correctPassword = '123'; // Hardcoded password
            if (password !== correctPassword) {
                alert('Incorrect password.');
                return;
            }
            document.querySelectorAll('.masked-data, .donor-name-masked').forEach(function(cell) {
                cell.textContent = cell.getAttribute('data-full');
            });
        }

        function showImagePopup(src) {
            // Create overlay
            const overlay = document.createElement('div');
            overlay.classList.add('image-popup');
            overlay.onclick = function() {
                document.body.removeChild(overlay);
            };
            // Create image
            const img = document.createElement('img');
            img.src = src;
            overlay.appendChild(img);
            document.body.appendChild(overlay);
        }
    </script>

</body>

</html>

<?php
// Handle donation verification
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['verify_id'])) {
    $verify_id = intval($_POST['verify_id']);
    $admin_id = $_SESSION['admin_id'] ?? null;
    if ($admin_id && $verify_id) {
        $stmt = $conn->prepare("UPDATE donations SET status = 'verified', verified_by = ?, verified_at = NOW() WHERE id = ?");
        $stmt->bind_param("ii", $admin_id, $verify_id);
        $stmt->execute();
        $stmt->close();
        echo "<script>location.reload();</script>";
        exit;
    }
}
?>