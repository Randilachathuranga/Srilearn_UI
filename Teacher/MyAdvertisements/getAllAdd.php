<?php
header('Content-Type: application/json');

// Sample array of education-related advertisements with title, description, and image URL
$Adds = [
    [
        "title" => "Mastering Math Fundamentals",
        "description" => "Struggling with math? Join our interactive math classes where you’ll learn essential math skills in a fun and supportive environment. From basic arithmetic to algebra and geometry, we focus on building confidence and making math enjoyable. Each class is designed to help you understand concepts deeply and succeed in exams. Enroll now and unlock your potential in math!",
        "image_url" => "./Addimages/1.jpeg"
    ],
    [
        "title" => "Explore the World of Science!",
        "description" => "Curious about how the world works? Our science classes make learning about physics, chemistry, and biology exciting! Engage in hands-on experiments, participate in virtual labs, and explore fascinating topics from ecosystems to electricity. Perfect for students who love to ask ‘why’ and ‘how.’ Join us to discover the wonders of science!",
        "image_url" => "./Addimages/2.jpeg"
    ],
    [
        "title" => "Creative Writing Workshop",
        "description" => "Do you have stories to tell? Our creative writing class will help you bring your ideas to life! Learn the basics of storytelling, character development, and plot creation while developing your unique writing voice. Ideal for budding writers who want to improve their skills and gain confidence in expressing themselves. Sign up today and start your writing journey!",
        "image_url" => "./Addimages/3.jpeg"
    ],
    [
        "title" => "Ace Your Exams with Study Strategies",
        "description" => "Preparing for exams? Join our study strategies class and learn tips and techniques to study smarter, not harder. From time management to effective note-taking and memory techniques, we cover everything you need to succeed. Perfect for students looking to boost their grades and feel more confident in exams. Don't miss out on your chance to achieve academic success!",
        "image_url" => "./Addimages/4.jpeg"
    ],
    [
        "title" => "Public Speaking and Confidence Building",
        "description" => "Want to speak confidently in front of an audience? Our public speaking classes are designed to help students develop communication skills, boost confidence, and conquer stage fright. Through engaging exercises and feedback sessions, you’ll learn how to express yourself clearly and connect with your audience. Join us to become a confident speaker!",
        "image_url" => "./Addimages/5.jpeg"
    ],
    [
        "title" => "Introduction to Coding for Beginners",
        "description" => "Interested in technology? Learn the basics of coding in our beginner-friendly coding class! You’ll start with fundamental concepts and work your way up to creating simple programs. Great for students who are curious about computers and want to gain skills in problem-solving and logic. Begin your coding journey with us and see where it takes you!",
        "image_url" => "./Addimages/6.jpeg"
    ], [
        "title" => "Mastering Math Fundamentals",
        "description" => "Struggling with math? Join our interactive math classes where you’ll learn essential math skills in a fun and supportive environment. From basic arithmetic to algebra and geometry, we focus on building confidence and making math enjoyable. Each class is designed to help you understand concepts deeply and succeed in exams. Enroll now and unlock your potential in math!",
        "image_url" => "./Addimages/1.jpeg"
    ],
    [
        "title" => "Explore the World of Science!",
        "description" => "Curious about how the world works? Our science classes make learning about physics, chemistry, and biology exciting! Engage in hands-on experiments, participate in virtual labs, and explore fascinating topics from ecosystems to electricity. Perfect for students who love to ask ‘why’ and ‘how.’ Join us to discover the wonders of science!",
        "image_url" => "./Addimages/2.jpeg"
    ],
    [
        "title" => "Creative Writing Workshop",
        "description" => "Do you have stories to tell? Our creative writing class will help you bring your ideas to life! Learn the basics of storytelling, character development, and plot creation while developing your unique writing voice. Ideal for budding writers who want to improve their skills and gain confidence in expressing themselves. Sign up today and start your writing journey!",
        "image_url" => "./Addimages/3.jpeg"
    ],
    [
        "title" => "Ace Your Exams with Study Strategies",
        "description" => "Preparing for exams? Join our study strategies class and learn tips and techniques to study smarter, not harder. From time management to effective note-taking and memory techniques, we cover everything you need to succeed. Perfect for students looking to boost their grades and feel more confident in exams. Don't miss out on your chance to achieve academic success!",
        "image_url" => "./Addimages/4.jpeg"
    ],
    [
        "title" => "Public Speaking and Confidence Building",
        "description" => "Want to speak confidently in front of an audience? Our public speaking classes are designed to help students develop communication skills, boost confidence, and conquer stage fright. Through engaging exercises and feedback sessions, you’ll learn how to express yourself clearly and connect with your audience. Join us to become a confident speaker!",
        "image_url" => "./Addimages/5.jpeg"
    ],
    [
        "title" => "Introduction to Coding for Beginners",
        "description" => "Interested in technology? Learn the basics of coding in our beginner-friendly coding class! You’ll start with fundamental concepts and work your way up to creating simple programs. Great for students who are curious about computers and want to gain skills in problem-solving and logic. Begin your coding journey with us and see where it takes you!",
        "image_url" => "./Addimages/6.jpeg"
    ]
];

// Output the array as JSON
echo json_encode($Adds);
?>
