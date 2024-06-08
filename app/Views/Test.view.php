<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }

    th, td {
        padding: 10px;
    }

    th {
        background-color: #f2f2f2;
    }
</style>
<body>
    <table border="1" style="text-align: center;">
        <thead>
            <tr>
                <th>Daily ID</th>
                <th>Date</th>
                <th>Clock In</th>
                <th>Clock Out</th>
                <th>Meeting Status</th>
                <th>Hours Worked</th>
                <th>Employee ID</th>
                <th>Break Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($results) && !empty($results)): ?>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <?php foreach ($row as $cell): ?>
                            <td><?php echo htmlspecialchars($cell); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="COLUMN_COUNT">No data available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php

    if (isset($results) && !empty($results)) {
        echo "<pre>";
        print_r($results);
        echo "</pre>";
    } else {
        echo "No data available";
    }



    ?>
</body>

</html>