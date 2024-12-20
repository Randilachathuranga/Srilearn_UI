<?php
header('Content-Type: application/json');

// Sample data array with image URLs for six teachers
$Byteacher = [
    [
        'Name' => 'Alice Johnson',
        'Subject' => 'Maths',
        'Phone number' => '+1122334455',
        'email' => 'johnson@sunshine.com',
        'ImageURL' => '../../../../../group_project_1.0/public/views/General/Byteacher/teachers_images/6.jpg'
    ],
    [
        'Name' => 'Brian Lee',
        'Subject' => 'Science',
        'Phone number' => '+2233445566',
        'email' => 'lee@brightminds.com',
        'ImageURL' => '../../../../../group_project_1.0/public/views/General/Byteacher/teachers_images/2.jpg'
    ],
    [
        'Name' => 'Catherine Davis',
        'Subject' => 'English',
        'Phone number' => '+3344556677',
        'email' => 'davis@knowledgehub.com',
        'ImageURL' => '../../../../../group_project_1.0/public/views/General/Byteacher/teachers_images/3.jpg'
    ],
    [
        'Name' => 'Daniel Thompson',
        'Subject' => 'History',
        'Phone number' => '+4455667788',
        'email' => 'thompson@exceled.com',
        'ImageURL' => '../../../../../group_project_1.0/public/views/General/Byteacher/teachers_images/4.jpg'
    ],
    [
        'Name' => 'Emma Wilson',
        'Subject' => 'Chemistry',
        'Phone number' => '+5566778899',
        'email' => 'wilson@futurestars.com',
        'ImageURL' => '../../../../../group_project_1.0/public/views/General/Byteacher/teachers_images/5.jpg'
    ],
    [
        'Name' => 'Franklin Moore',
        'Subject' => 'Physics',
        'Phone number' => '+6677889900',
        'email' => 'moore@inspiretutoring.com',
        'ImageURL' => '../../../../../group_project_1.0/public/views/General/Byteacher/teachers_images/6.jpg'
    ]
];

// Convert the data array to JSON format
echo json_encode($Byteacher);
?>
