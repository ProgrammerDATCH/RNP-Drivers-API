<?php
header('Content-Type: application/json');
if (isset($_GET['license'])) {
    include_once 'db.php';
    $license = $_GET['license'];
    if (strlen($license) != 16) {
        echo json_encode(['ResultStatus' => false, 'ResultData' => 'Invalid License Number.']);
        exit();
    }
    $sql_check = "SELECT * FROM drivers WHERE license = '$license';";
    $result = mysqli_query($conn, $sql_check);
    if (mysqli_num_rows($result) < 1) {
        echo json_encode(['ResultStatus' => false, 'ResultData' => 'Your License is not registered.']);
        exit();
    }
    $user_details = mysqli_fetch_assoc($result);
    echo json_encode(['ResultStatus' => true, 'ResultData' => $user_details]);
} else {
    echo json_encode(['ResultStatus' => false, 'ResultData' => 'No License number given.']);
    exit();
}
