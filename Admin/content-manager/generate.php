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
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px #0001;
            padding: 32px;
        }

        .filter-row {
            margin-bottom: 18px;
        }

        .filter-label {
            font-weight: 500;
            margin-bottom: 6px;
        }
    </style>
</head>

<body>
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