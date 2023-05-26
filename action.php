<?php
session_start();
include 'connection/connection.php';
function validate()
{
    header("location: index.php");
    die();
}
if (isset($_POST['submit'])) {
    // echo "<pre>";
    // print_r($_FILES);
    $csvFile = $_FILES['csvFile']['tmp_name'];
    $handle = fopen($csvFile, "r");
    if ($handle !== false) {
        $lineNumber = 0;
        while (($data = fgetcsv($handle)) !== false) {
            $lineNumber++;
            $first_name = trim($data[0]);
            $last_name = trim($data[1]);
            $email = trim($data[2]);
            $mobileno = trim($data[3]);
            $company_name = trim($data[4]);
            $address = trim($data[5]);
            $zip = trim($data[6]);

            if (empty($first_name)) {
                $_SESSION['error'] = "First name is empty in CSV file line number " . $lineNumber;
                validate();
            }

            if (!preg_match("/[a-z A-Z]/", $first_name)) {
                $_SESSION['error'] = "First name is not valid in CSV file line number " . $lineNumber;
                validate();
            }

            if (empty($last_name)) {
                $_SESSION['error'] = "Last name is empty in CSV file line number " . $lineNumber;
                validate();
            }

            if (!preg_match("/[a-z A-Z]/", $last_name)) {
                $_SESSION['error'] = "First name is not valid in CSV file line number " . $lineNumber;
                validate();
            }

            if (empty($mobileno)) {
                $_SESSION['error'] = "First name is empty in CSV file line number " . $lineNumber;
                validate();
            }
            if (!preg_match("/^[0-9]{10}+$/", $mobileno)) {
                $_SESSION['error'] = "First name is empty in CSV file line number " . $lineNumber;
                validate();
            }
            // V/^(\+\d{1,3}[- ]?)?\d{10}$/
            $dataArray[] = array($first_name, $last_names, $email, $mobileno, $company_name, $address, $zip);
        }
        foreach ($dataArray as $data) {
            $sql = "insert into csvdata (first_name,last_name,email,mobileno,company_name,address,zip) 
                VALUES (' $data[0]','$data[1]','$data[2]',$data[3],'$data[4]','$data[5]',$data[6])";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $_SESSION['success'] = "File Uploaded Successfully";
                header('location:index.php');
            }
        }
    } else {
        echo "File Not Opened.";
    }
}
