<?php
header('Content-Type: application/json');

// Sample data array with image URLs
$Institute = [
    [
        'Name' => 'Green Valley Institute',
        'Phone number' => '+1234567890',
        'District' => 'Greenland',
        'City' => 'Greenville',
        'ImageURL' => '../../../../../group_project_1.0//public//views//General//Byinstitute/Institute_images/1.png'
    ],
    [
        'Name' => 'Blue River Academy',
        'Phone number' => '+0987654321',
        'District' => 'Bluewater',
        'City' => 'Blue City',
        'ImageURL' => '../../../../../group_project_1.0//public//views//General//Byinstitute/Institute_images/2.jpg'
    ],
    [
        'Name' => 'Sunshine Learning Center',
        'Phone number' => '+1122334455',
        'District' => 'Sunnyvale',
        'City' => 'Sunshine City',
        'ImageURL' => '../../../../../group_project_1.0//public//views//General//Byinstitute/Institute_images/3.png'
    ],
    [
        'Name' => 'Sunshine Learning Center',
        'Phone number' => '+1122334455',
        'District' => 'Sunnyvale',
        'City' => 'Sunshine City',
        'ImageURL' => '../../../../../group_project_1.0//public//views//General//Byinstitute/Institute_images/4.png'
    ],
    [
        'Name' => 'Blue River Academy',
        'Phone number' => '+0987654321',
        'District' => 'Bluewater',
        'City' => 'Blue City',
        'ImageURL' => '../../../../../group_project_1.0//public//views//General//Byinstitute/Institute_images/2.jpg'
    ],
    [
        'Name' => 'Blue River Academy',
        'Phone number' => '+0987654321',
        'District' => 'Bluewater',
        'City' => 'Blue City',
        'ImageURL' => '../../../../../group_project_1.0//public//views//General//Byinstitute/Institute_images/2.jpg'
    ],
    [
        'Name' => 'Sunshine Learning Center',
        'Phone number' => '+1122334455',
        'District' => 'Sunnyvale',
        'City' => 'Sunshine City',
        'ImageURL' => '../../../../../group_project_1.0//public//views//General//Byinstitute/Institute_images/3.png'
    ]
];

// Convert the data array to JSON format
echo json_encode($Institute);
?>
