<?php
// get_subcategories.php

// Include your database connection code here
$conn = new mysqli("localhost", "root", "", "sale");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the category ID from the AJAX request
$categoryID = $_GET['category_id'];

// Always start with the default option
echo '<option value="" selected>ជ្រើសរើសប្រភេទរង</option>';

// Fetch sub-categories based on the selected category
$stmt = $conn->prepare("SELECT id, sub_cate FROM sub_categories WHERE category_id = ?");
$stmt->bind_param("i", $categoryID);
$stmt->execute();
$result = $stmt->get_result();

// Add other sub-category options
while ($subCategory = $result->fetch_assoc()) {
    echo "<option value='" . $subCategory['id'] . "'>" . $subCategory['sub_cate'] . "</option>";
}

$stmt->close();
$conn->close();
