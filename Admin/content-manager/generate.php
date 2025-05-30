<?php
include 'db-connection.php';

// List of tables to allow report generation for
$tables = [
    'members' => 'Members',
    'events' => 'Events',
    'news' => 'News',
    'donations' => 'Donations',
    'contacts' => 'Contacts',
    'comments' => 'Comments',
];

// Table columns and filterable fields (manually mapped for best UX)


// Handle form submission and redirect
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST['table'] ?? '';
    $filters = $_POST['filters'] ?? [];
    $query = http_build_query(['table' => $table] + $filters);
    header("Location: generate_report.php?$query");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 480px;
            margin: 40px auto 0 auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px #0002;
            padding: 40px 36px 32px 36px;
        }

        h2.mb-4 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2d3a4b;
            margin-bottom: 28px !important;
        }

        .mb-3 {
            width: 100%;
            margin-bottom: 22px !important;
        }

        .form-label {
            font-weight: 500;
            color: #3b4252;
            margin-bottom: 8px;
        }

        .form-select {
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            font-size: 1rem;
        }

        #filtersContainer {
            width: 100%;
            margin-bottom: 10px;
        }

        .btn-primary {
            width: 100%;
            padding: 12px 0;
            font-size: 1.1rem;
            border-radius: 8px;
            background: linear-gradient(90deg, #4f8cff 0%, #2356c7 100%);
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #2356c7 0%, #4f8cff 100%);
        }
    </style>
</head>

<body>
    <div class="company-name">
        <h1 class="company-name-title">Bahay Musika Admin Panel</h1>
    </div>
    <h3 class="dashboard-title">Report & Analytics</h3>
    <div class="container">

        <h2 class="mb-4">Generate Report</h2>
        <form id="reportForm" onsubmit="return false;">
            <div class="mb-3">
                <label class="form-label">Select Table</label>
                <select class="form-select" name="table" id="tableSelect" required>
                    <option value="" disabled selected>Select table...</option>
                    <?php foreach ($tables as $key => $label): ?>
                        <option value="<?= $key ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div id="filtersContainer"></div>
            <button type="button" class="btn btn-primary mt-3" onclick="openReportTab()">Generate</button>
        </form>

    </div>
</body>

</html>