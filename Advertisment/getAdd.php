<?php
header('Content-Type: application/json');

// Sample array of blogs with title and creator data
$blogs = [
    [
        "title" => "Introduction to Web Development",
        "creator" => "John Doe"
    ],
    [
        "title" => "Understanding JavaScript",
        "creator" => "Jane Smith"
    ],
    [
        "title" => "ReactJS for Beginners",
        "creator" => "Emily Johnson"
    ],
    [
        "title" => "PHP and MySQL Integration",
        "creator" => "Michael Brown"
    ],
    [
        "title" => "CSS Tips and Tricks",
        "creator" => "Lisa White"
    ]
];

// Output the array as JSON
echo json_encode($Add);
?>
