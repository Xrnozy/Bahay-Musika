<?php
include 'db-connection.php'; // Include database connection

// Fetch total donation amount
$totalDonationQuery = $conn->query("SELECT SUM(amount) as total FROM donations");
$totalDonation = $totalDonationQuery->fetch_assoc()['total'] ?? 0;

// Fetch all donation records
$donations = $conn->query("SELECT * FROM donations");
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
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Donation Count</h1>

        <div class="alert alert-success text-center" role="alert">
            <h4>Total Donations: PHP <?= number_format($totalDonation, 2) ?></h4>
        </div>

        <h2>Donations Table</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Donor Name</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Reference Number</th>
                    <th>Image</th> <!-- New Image column -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $donations->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['donor_name'] ?></td>
                        <td>PHP <?= number_format($row['amount'], 2) ?></td>
                        <td><?= $row['date'] ?></td>
                        <td><?= $row['reference_number'] ?></td>
                        <td>
                            <?php if (!empty($row['image'])): ?>
                                <img src="<?= $row['image'] ?>" alt="Donation Image" style="width: 100px; height: auto;">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>