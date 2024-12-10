<?php
include '../connection.php';
$id = $_POST['id'];

// Prepare and execute the query
$sql = "SELECT * FROM employee WHERE emp_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $DATA = $result->fetch_assoc();

    echo json_encode($DATA);
} else {
    echo json_encode(['error' => 'Employee not found']);
}

?>