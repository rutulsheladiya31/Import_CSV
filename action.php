<?php
session_start();
include 'connection/connection.php';

if (isset($_POST['submit'])) {
    // echo "<pre>";
    // print_r($_FILES);
    $csvFile = $_FILES['csvFile']['tmp_name'];
    $handle = fopen($csvFile, "r");
    if ($handle !== false) {
        while (($data = fgetcsv($handle)) !== false) {
            $first_name = $data[0];
            $last_names = $data[1];
            $email = $data[2];
            $mobileno = $data[3];
            $company_name = $data[4];
            $address = $data[5];
            $zip = $data[6];

            $sql = "insert into csvdata (first_name,last_name,email,mobileno,company_name,address,zip) 
                VALUES ('$first_name','$last_names','$email',$mobileno,'$company_name','$address',$zip)";
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
