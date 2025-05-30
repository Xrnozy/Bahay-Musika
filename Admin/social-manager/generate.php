<?php
include '../lib/db_connection.php'; // Corrected the file path for database connection

// Fetch data from the database
$members = $conn->query("SELECT * FROM members");
$events = $conn->query("SELECT * FROM events");
$news = $conn->query("SELECT * FROM news");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Report</title>
    <link href="../lib/bootstrap.min.css" rel="stylesheet">
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


<div class="container">
    <h1 class="text-center">Generate Report</h1>

    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search...">
            </div>
            <div class="col-md-4">
                <select name="filter" class="form-control">
                    <option value="members">Members</option>
                    <option value="events">Events</option>
                    <option value="news">News</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <div>
        <h2>Donations</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Donor Name</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $donations = $conn->query("SELECT * FROM donations"); // Fetch donations from the database
                while ($row = $donations->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['donor_name'] ?></td>
                        <td><?= $row['amount'] ?></td>
                        <td><?= $row['date'] ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td><?= $row['updated_at'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="../lib/bootstrap.bundle.min.js"></script>


</html>