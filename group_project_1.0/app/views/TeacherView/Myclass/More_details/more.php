<?php
header('Content-Type: application/json');

// Sample data array (replace with actual database query)
$details = [
    [
        'title' => 'Math',
        'subject' => 'Mathematics',
        'institute' => 'UCSC',
        'image' => '../Class_images/English.png',
        'grade' => 'Grade 10',
        'fee' => 'Rs. 5000',
        'start_time' => '10:00 AM',
        'end_time' => '12:00 PM'
    ],
    // Add more classes as needed
];

echo json_encode($details);
?>