<?php
header('Content-Type: application/json');

// Sample data array
$classes = [
    [
        'title' => 'Math',
        'subject' => 'Mathematics',
        'institute' => 'UCSC',
        'image' => './Class_images/Maths.png'
    ],
    [
        'title' => 'Science',
        'subject' => 'Physics',
        'institute' => 'UCSC',
        'image' => './Class_images/science.png'
    ],
    [
        'title' => 'History',
        'subject' => 'World History',
        'institute' => 'UCSC',
        'image' => './Class_images/History.png'
    ],
    [
        'title' => 'English',
        'subject' => 'English Literature',
        'institute' => 'UCSC',
        'image' => './Class_images/English.png'
    ], [
        'title' => 'History',
        'subject' => 'World History',
        'institute' => 'UCSC',
        'image' => './Class_images/It.png'
    ],
    [
        'title' => 'English',
        'subject' => 'English Literature',
        'institute' => 'UCSC',
        'image' => './Class_images/English.png'
    ],[
        'title' => 'History',
        'subject' => 'World History',
        'institute' => 'UCSC',
        'image' => './Class_images/It.png'
    ],
    [
        'title' => 'English',
        'subject' => 'English Literature',
        'institute' => 'UCSC',
        'image' => './Class_images/English.png'
    ]
];

// Convert the data array to JSON format
echo json_encode($classes);
?>
