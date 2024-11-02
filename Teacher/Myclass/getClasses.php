<?php
header('Content-Type: application/json');

// Sample data array
$classes = [
    [
        'title' => 'Math',
        'subject' => 'Mathematics',
        'institute' => 'UCSC',
        'image' => './Maths.png'
    ],
    [
        'title' => 'Science',
        'subject' => 'Physics',
        'institute' => 'UCSC',
        'image' => './Maths.png'
    ],
    [
        'title' => 'History',
        'subject' => 'World History',
        'institute' => 'UCSC',
        'image' => './Maths.png'
    ],
    [
        'title' => 'English',
        'subject' => 'English Literature',
        'institute' => 'UCSC',
        'image' => './Maths.png'
    ], [
        'title' => 'History',
        'subject' => 'World History',
        'institute' => 'UCSC',
        'image' => './Maths.png'
    ],
    [
        'title' => 'English',
        'subject' => 'English Literature',
        'institute' => 'UCSC',
        'image' => './Maths.png'
    ],
];

// Convert the data array to JSON format
echo json_encode($classes);
?>
