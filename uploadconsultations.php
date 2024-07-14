<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:3000'); // Specify the allowed origin
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "winnie";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(array("success" => false, "message" => "Connection failed: " . $conn->connect_error)));
}

// Check if file was uploaded
if (isset($_FILES['consultation_file']) && $_FILES['consultation_file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['consultation_file']['tmp_name'];
    $fileName = $_FILES['consultation_file']['name'];
    $fileSize = $_FILES['consultation_file']['size'];
    $fileType = $_FILES['consultation_file']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // Sanitize file name
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

    // Check if file type is allowed
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'txt', 'pdf', 'doc', 'docx');
    if (in_array($fileExtension, $allowedfileExtensions)) {
        // Directory where the file will be stored
        $uploadFileDir = './uploads/';
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $consultation_name = $_POST['consultation_name'];
            $description = $_POST['description'];
            $consultation_file = $newFileName;

            $sql = "INSERT INTO consultations (consultation_name, description, consultation_file) VALUES ('$consultation_name', '$description', '$consultation_file')";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(array("success" => true, "message" => "Consultation uploaded and saved successfully."));
            } else {
                echo json_encode(array("success" => false, "message" => "Error saving consultation: " . $conn->error));
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Error moving the uploaded file."));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions)));
    }
} else {
    echo json_encode(array("success" => false, "message" => "There was some error in the file upload."));
}

$conn->close();
?>
