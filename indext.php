<?php
$URL = "https://data.gov.bh/api/explore/v2.1/catalog/datasets/01-statistics-of-students-nationalities_updated/records?where=colleges%20like%20%22IT%22%20AND%20the_programs%20like%20%22bachelor%22&limit=100";

try {
   
    $response = file_get_contents($URL);

    
    if ($response === false) {
        throw new Exception("Error fetching data from the API.");
    }

  
    $result = json_decode($response, true);

   
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Error decoding JSON: " . json_last_error_msg());
    }

 
    if (!isset($result['results']) || empty($result['results'])) {
        throw new Exception("No records found in the API response.");
    }

    
    $records = $result['results'];

} catch (Exception $e) {
    
    $records = [];
    $errorMessage = $e->getMessage();
    echo "<p>Error: $errorMessage</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data</title>
    <!-- Pico CSS for responsive design -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/picocss@1.6.0/dist/pico.min.css">
    <style>
      
      table {
    width: 100%;
    margin: 20px 0;
    border-collapse: collapse;
}
th, td {
    padding: 8px 12px;
    text-align: left;
    border: 1px solid lightgray; /
}
th {
    background-color: lightgray;
}
table tr:nth-child(even) {
    background-color: whitesmoke; 
}

.table-container {
    overflow-x: auto;
    margin: 20px;
}

    </style>
</head>
<body>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Semester</th>
                    <th>Nationality</th>
                    <th>College</th>
                    <th>Program</th>
                    <th>Number of Students</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($records)): ?>
                    <tr>
                        <td colspan="6">No data available to display</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($records as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['year']); ?></td>
                            <td><?php echo htmlspecialchars($record['semester']); ?></td>
                            <td><?php echo htmlspecialchars($record['nationality']); ?></td>
                            <td><?php echo htmlspecialchars($record['colleges']); ?></td>
                            <td><?php echo htmlspecialchars($record['the_programs']); ?></td>
                            <td><?php echo htmlspecialchars($record['number_of_students']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
