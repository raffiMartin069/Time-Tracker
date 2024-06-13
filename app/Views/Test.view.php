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
    <table>
        <thead>
            <tr>
                <th>Record ID</th>
                <th>Date</th>
                <th>Start Meeting</th>
                <th>End Meeting</th>
                <th>Employee ID</th>
                <th>Meeting ID</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($meeting_logs) && !empty($meeting_logs)): ?>
                <?php foreach ($meeting_logs as $log): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($log->record_id); ?></td>
                        <td><?php echo htmlspecialchars($log->date); ?></td>
                        <td><?php echo htmlspecialchars($log->start_meeting); ?></td>
                        <td><?php echo htmlspecialchars($log->end_meeting); ?></td>
                        <td><?php echo htmlspecialchars($log->emp_id); ?></td>
                        <td><?php echo htmlspecialchars($log->meeting_id); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No meeting logs available</td>
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