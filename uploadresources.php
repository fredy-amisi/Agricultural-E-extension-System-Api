<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

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
if (isset($_FILES['resource_file']) && $_FILES['resource_file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['resource_file']['tmp_name'];
    $fileName = $_FILES['resource_file']['name'];
    $fileSize = $_FILES['resource_file']['size'];
    $fileType = $_FILES['resource_file']['type'];
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
            $resource_name = $_POST['resource_name'];
            $description = $_POST['description'];
            $resource_image = $newFileName;

            $sql = "INSERT INTO resources (resource_name, description, resource_image) VALUES ('$resource_name', '$description', '$resource_image')";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(array("success" => true, "message" => "Resource uploaded and saved successfully."));
            } else {
                echo json_encode(array("success" => false, "message" => "Error saving resource: " . $conn->error));
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
