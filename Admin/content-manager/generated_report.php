<?php
include 'db-connection.php';

// List of tables and their labels
$tables = [
    'members' => 'Members',
    'events' => 'Events',
    'news' => 'News',
    'donations' => 'Donations',
    'contacts' => 'Contacts',
    'comments' => 'Comments',
];

// Table columns and filterable fields (auto-mapped from schema)
$tableFilters = [
    'members' => [
        'category' => ['type' => 'select'],
        'city' => ['type' => 'select'],
        'state' => ['type' => 'select'],
        'country' => ['type' => 'select'],
        'created_at' => ['type' => 'date'],
    ],
    'events' => [
        'date' => ['type' => 'date'],
        'location' => ['type' => 'select'],
    ],
    'news' => [
        'date' => ['type' => 'date'],
        'location' => ['type' => 'select'],
    ],
    'donations' => [
        'payment_method' => ['type' => 'select', 'options' => ['gcash', 'paypal',]],
        'donation_type' => ['type' => 'select', 'options' => ['one_time', 'monthly']],
        'created_at' => ['type' => 'date'],
    ],
    'contacts' => [
        'created_at' => ['type' => 'date'],
    ],
    'comments' => [
        'page' => ['type' => 'select'],
        'created_at' => ['type' => 'date'],
    ],
];

// Helper: get unique values for a column
function getColumnValues($conn, $table, $column)
{
    $values = [];
    $result = $conn->query("SELECT DISTINCT `$column` FROM `$table` WHERE `$column` IS NOT NULL AND `$column` != ''");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $values[] = $row[$column];
        }
    }
    return $values;
}

// Get selected table and filters from query string
$table = $_GET['table'] ?? 'members';
$filters = $_GET;

// Build SQL WHERE clause based on filters
$where = [];
$params = [];
if (isset($tableFilters[$table])) {
    foreach ($tableFilters[$table] as $col => $info) {
        if ($info['type'] === 'select' && !empty($filters[$col])) {
            $where[] = "`$col` = '" . $conn->real_escape_string($filters[$col]) . "'";
        } elseif ($info['type'] === 'date') {
            if (!empty($filters[$col . '_from'])) {
                $where[] = "DATE(`$col`) >= '" . $conn->real_escape_string($filters[$col . '_from']) . "'";
            }
            if (!empty($filters[$col . '_to'])) {
                $where[] = "DATE(`$col`) <= '" . $conn->real_escape_string($filters[$col . '_to']) . "'";
            }
        }
    }
}
$whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Fetch data
$data = [];
if (array_key_exists($table, $tables)) {
    $result = $conn->query("SELECT * FROM `$table` $whereClause LIMIT 1000");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
}

// For filter dropdowns
$filterDropdowns = [];
foreach ($tableFilters[$table] ?? [] as $col => $info) {
    if ($info['type'] === 'select') {
        if (!empty($info['options'])) {
            $filterDropdowns[$col] = $info['options'];
        } else {
            $filterDropdowns[$col] = getColumnValues($conn, $table, $col);
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generated Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f4f4;
        }

        .report-container {
            width: 794px;
            /* A4 width */
            min-height: 1123px;
            /* A4 height */
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 16px #0002;
            padding: 40px 48px 48px 48px;
            position: relative;
        }

        .report-header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 18px;
            margin-bottom: 32px;
        }

        .report-header img {
            width: 70px;
            height: 70px;
            object-fit: contain;
            margin-right: 24px;
        }

        .report-header .church-info {
            flex: 1;
        }

        .report-header .church-info h2 {
            margin: 0;
            font-size: 2.1rem;
            font-weight: 700;
            color: #2d3a4a;
        }

        .report-header .church-info p {
            margin: 0;
            font-size: 1.1rem;
            color: #555;
        }

        .report-title {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 18px;
            color: #2d3a4a;
        }

        .report-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            margin-bottom: 18px;
            justify-content: center;
        }

        .report-filters select,
        .report-filters input[type=date] {
            min-width: 160px;
        }

        .table-responsive {
            margin-top: 18px;
        }

        .table th,
        .table td {
            font-size: 0.98rem;
        }
    </style>
</head>

<body>
    <div class="report-container">
        <div class="report-header">
            <img src="../generated/logo.png" alt="Logo">
            <div class="church-info">
                <h2>Minstrels Rhythm of Hope</h2>
                <p>1675 C. Merced St. Paco, Manila, Philippines</p>
            </div>
        </div>
        <div class="report-title">Report: <?php echo htmlspecialchars($tables[$table]); ?></div>
        <form method="get" class="report-filters">
            <input type="hidden" name="table" value="<?php echo htmlspecialchars($table); ?>">
            <?php foreach ($tableFilters[$table] ?? [] as $col => $info): ?>
                <?php if ($info['type'] === 'select'): ?>
                    <select name="<?php echo $col; ?>" class="form-select" onchange="this.form.submit()">
                        <option value="">All <?php echo ucfirst(str_replace('_', ' ', $col)); ?></option>
                        <?php foreach ($filterDropdowns[$col] as $val): ?>
                            <option value="<?php echo htmlspecialchars($val); ?>" <?php if (($filters[$col] ?? '') == $val) echo 'selected'; ?>><?php echo htmlspecialchars($val); ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php elseif ($info['type'] === 'date'): ?>
                    <input type="date" name="<?php echo $col; ?>_from" value="<?php echo htmlspecialchars($filters[$col . '_from'] ?? ''); ?>" class="form-control" onchange="this.form.submit()" placeholder="From">
                    <input type="date" name="<?php echo $col; ?>_to" value="<?php echo htmlspecialchars($filters[$col . '_to'] ?? ''); ?>" class="form-control" onchange="this.form.submit()" placeholder="To">
                <?php endif; ?>
            <?php endforeach; ?>
            <select name="table" class="form-select" onchange="this.form.submit()" style="max-width:200px;">
                <?php foreach ($tables as $key => $label): ?>
                    <option value="<?php echo $key; ?>" <?php if ($table == $key) echo 'selected'; ?>><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <?php if (!empty($data)): ?>
                            <?php foreach (array_keys($data[0]) as $col): ?>
                                <th><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $col))); ?></th>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <th>No data found</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <?php foreach ($row as $col => $val): ?>
                                <?php if (in_array($col, ['profile_image', 'image']) && !empty($val)): ?>
                                    <td><img src="data:image/jpeg;base64,<?php echo base64_encode($val); ?>" style="max-width:80px;max-height:80px;object-fit:contain;" alt="Image"></td>
                                <?php else: ?>
                                    <td><?php echo htmlspecialchars($val); ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>