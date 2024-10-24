<?php
include('config/constants.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nearby Veterinary Clinics in Penang</title>
    <link rel="stylesheet" href="css/vetStyle.css">
    <style>
        /* css/vetStyle.css */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f8f8;
    margin: 0;
    padding: 0;
}

.vet-container {
    max-width: 900px;
    margin: 50px auto;
    padding: 20px;
    background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

.vet-list {
    list-style: none;
    padding: 0;
}

.vet-list li {
    padding: 15px;
    margin-bottom: 10px;
    border-bottom: 1px solid #ddd;
}

.vet-list li:last-child {
    border-bottom: none;
}

.vet-list h3 {
    margin: 0;
    color: #009688; /* Theme color */
}

.vet-list p {
    margin: 5px 0;
    color: #666;
}

.back-home-btn {
    display: block;
    width: 200px;
    margin: 20px auto;
    padding: 10px;
    text-align: center;
    background-color: #009688;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.back-home-btn:hover {
    background-color: #00796b;
}

a {
    text-decoration: none;
}
</style>
</head>
<body>
    <div class="vet-container">
        <h1>Nearby Veterinary Clinics in Penang, Malaysia</h1>
        <p style="text-align: center; color:red;">The information provided is ONLY intended to serve as a general guide.</p>
        <p style="text-align: center; color:darkred;">Users are advised to exercise their own judgment and discretion when using this information and should not rely solely on it for decision-making. 
            It is important to seek professional advice or conduct further research to make informed, well-considered decisions.</p>

        <ul class="vet-list">
            <!-- Add nearby veterinary clinics here -->
            <li>
                <a href="https://maps.app.goo.gl/U2NuDWNtZCzpijRB9" target="_BLANK"><h3>Cuddles Vet Clinic</h3></a>
                <p>Address: 150 Jalan Kelawei, 10250 Pulau Pinang</p>
                <p>Phone: 04-218 9749</p>
                <p>Hours: 8 AM - 1 PM, 2 PM - 6 PM (daily)</p>
            </li>
            <li>
                <a href="https://maps.app.goo.gl/7URekNcVsSUugEg86" target="_BLANK"><h3>Peng Aun Veterinary Clinic</h3></a>
                <p>Address: 728 Jalan Sungai Dua, 11700 Penang</p>
                <p>Phone: 04-646 0137</p>
                <p>Hours: 9:30 AM - 6 PM (Monday - Saturday)</p>
            </li>
            <li>
                <a href="https://maps.app.goo.gl/G5ArndDjxjVEfCJ89" target="_BLANK"><h3>Venice Veterinary Clinic</h3></a>
                <p>Address: 43 Jalan Perniagaan Gemilang 1, 14000 Bukit Mertajam, Penang</p>
                <p>Phone: 010-391 2218</p>
                <p>Hours: 10 AM - 12:30 PM, 2 PM - 6:30 PM (Monday - Friday), 10 AM - 2:30 PM (Weekends)</p>
            </li>
            <li>
                <a href="https://maps.app.goo.gl/uknXHh5WjM9nkW2L8" target="_BLANK"><h3>AcuVet Veterinary Clinic</h3></a>
                <p>Address: 25E Jalan Gottlieb, 10350 George Town, Penang</p>
                <p>Phone: 04-226 4536</p>
                <p>Hours: 9 AM - 1 PM, 2 PM - 6 PM (Monday - Saturday), 9 AM - 1 PM, 2 PM - 5:30 PM (Sunday)</p>
            </li>
        </ul>
        <a href="index.php" class="back-home-btn">Back to Home</a>
    </div>
</body>
</html>
