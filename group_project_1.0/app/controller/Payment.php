<?php

require_once '../vendor/autoload.php';

$secretkey = 'sk_test_51RCnSJ2Ktn6PclayNmLuTjaGOIO5fQ0gDldxrnfOT5b6lfv1lKYffZmaDAH3kv0ofgqSYksDW2DEnyTQeJcXd28q00jmauDIKD';

\Stripe\Stripe::setApiKey($secretkey);

class Payment extends Controller
{

    public function checkSubscription($Type) {
        $subdetailmodel = new Subdetailsmodel();
        $sub = new Subscriptionmodel();
        $userId = $_SESSION['User_id'];
    
        $result = $subdetailmodel->query("SELECT * FROM subdetails WHERE Type = ?", [$Type]);
        $row = $result[0] ?? null;
    
        if (!$row) {
            http_response_code(404);
            echo json_encode(['error' => 'Subscription type not found.']);
            return;
        }
    
        $existingSubscription = $sub->first(['P_id' => $userId]);
        if ($existingSubscription && $existingSubscription->End_data > date('Y-m-d')) {
            http_response_code(403);
            echo json_encode(['error' => 'You are already subscribed.']);
            return;
        }
    
        echo json_encode(['status' => 'ok']);
    }
    

    public function subscibe($Type) {
       
        $subdetailmodel = new Subdetailsmodel();
        $sub=new Subscriptionmodel();
        $userId=$_SESSION['User_id'];
    
        // Assuming this returns an object, not an associative array
        $result = $subdetailmodel->query("SELECT * FROM subdetails WHERE Type = ?", [$Type]);
        $row = $result[0] ?? null;
    
        if (!$row) {
            echo "Subscription type not found.";
            return;
        }
        $existingSubscription = $sub->first(['P_id' => $userId]);
        if ($existingSubscription && $existingSubscription->End_data > date('Y-m-d')) {
            http_response_code(403);
            echo json_encode(['error' => 'You are already subscribed.']);
            return;
        }
    
     
    
        try {
            $checkout = \Stripe\Checkout\Session::create([
                'mode' => 'payment',
                'success_url' => "http://localhost/group_project_1.0/public/Subscriptions/postsub/$Type",
                'cancel_url' => "http://localhost/group_project_1.0/public/Error404",
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => $row->Price* 100, // Amount in cents, as integer
                        'product_data' => [
                            'name' => "Buy Subscription",
                            'metadata' => [
                                'Type' => $Type,
                                'UserType' => $row->UserType,
                                'Job Option' => $row->Isjobavail == 1 ? 'Yes' : 'No',
                                'Payment Option' => $row->Ispayavail == 1 ? 'Yes' : 'No',
                                'Post Advertisements' => $row->Isadavail == 1 ? 'Yes' : 'No',
                                'Date' => date('Y-m-d')
                            ]
                        ]
                    ],
                    'quantity' => 1
                ]]
            ]);
    
            header("Location: " . $checkout->url);
            exit(); // Stop execution after redirect
    
        } catch (Exception $e) {
            http_response_code(500);
            echo 'Stripe error: ' . $e->getMessage();
            exit();
        }
    }

    public function checkClassFee($classid) {
        $paymentmodel = new Paymentmodel();
        $enrollmodel = new Enrollmodel();
        $userId = $_SESSION['User_id'] ?? null;
    
        header('Content-Type: application/json');
    
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'User not logged in.']);
            return;
        }
    
        // Check enrollment date
        $enrollment = $enrollmodel->first(['Stu_id' => $userId, 'Class_id' => $classid]);
        if (!$enrollment) {
            http_response_code(404);
            echo json_encode(['error' => 'Enrollment not found.']);
            return;
        }
    
        $enrollDate = new DateTime($enrollment->Date);
        $currentDate = new DateTime();
        $previousMonthDate = (clone $currentDate)->modify('-1 month');
        $twoMonthsAgoDate = (clone $currentDate)->modify('-2 months');
    
        // Fetch payments
        $payments = $paymentmodel->where([
            'User_id' => $userId,
            'classID' => $classid,
            'Type' => 'Classfee'
        ]);
    
        $paidMonths = [];
        foreach ($payments as $payment) {
            $paidMonth = date('Y-m', strtotime($payment->Date));
            $paidMonths[] = $paidMonth;
        }
    
        $currentMonth = $currentDate->format('Y-m');
        $previousMonth = $previousMonthDate->format('Y-m');
        $twoMonthsAgo = $twoMonthsAgoDate->format('Y-m');
    
        $enrolledBeforePrevMonth = $enrollDate < $previousMonthDate;
    
        // Logic
        if (in_array($currentMonth, $paidMonths)) {
            echo json_encode(['message' => 'You have already paid the class fee for this month.']);
            return;
        }
    
        if ($enrolledBeforePrevMonth && !in_array($previousMonth, $paidMonths)) {
            if (!in_array($twoMonthsAgo, $paidMonths)) {
                echo json_encode(['error' => 'You have missed more than one month of payment. Please contact your institute or teacher.']);
                return;
            } else {
                echo json_encode(['warning' => 'Previous month fee is also due. You need to pay for both months.']);
                return;
            }
        }
    
        echo json_encode(['status' => 'ok']); // Eligible to proceed with payment
    }
    

    
    public function classfee($classid) {
        $class = new Classmodel();
        $paymentmodel = new Paymentmodel();
        $userId = $_SESSION['User_id'] ?? null;
    
        header('Content-Type: application/json');
    
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'User not logged in.']);
            return;
        }
    
        // Check if fee already paid this month
        $payments = $paymentmodel->where([
            'User_id' => $userId,
            'classID' => $classid,
            'Type' => 'Classfee'
        ]);
    
        $alreadyPaidThisMonth = false;
        $currentMonth = date('Y-m');
    
        if ($payments) {
            foreach ($payments as $payment) {
                if (strpos($payment->Date, $currentMonth) === 0) {
                    $alreadyPaidThisMonth = true;
                    break;
                }
            }
        }
    
        if ($alreadyPaidThisMonth) {
            echo json_encode(['message' => 'Class fee already paid this month.']);
            return;
        }
    
        // Fetch class details
        $classInfo = $class->first(['Class_id' => $classid]);
    
        if (!$classInfo) {
            http_response_code(404);
            echo json_encode(['error' => 'Class not found.']);
            return;
        }
    
        try {
            $checkout = \Stripe\Checkout\Session::create([
                'mode' => 'payment',
                'success_url' => "http://localhost/group_project_1.0/public/Enrollment/payfee/$classid",
                'cancel_url' => "http://localhost/group_project_1.0/public/Profile",
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => round(($classInfo->fee / 310) * 100), // Convert to cents
                        'product_data' => [
                            'name' => "Pay Class Fee",
                            'metadata' => [
                                'ClassID' => $classInfo->Class_id,
                                'Subject' => $classInfo->Subject,
                                'Grade' => $classInfo->Grade,
                                'Fee_LKR' => $classInfo->fee,
                                'Date' => date('Y-m-d')
                            ]
                        ]
                    ],
                    'quantity' => 1
                ]]
            ]);
    
            header("Location: " . $checkout->url);
            exit();
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Stripe error: ' . $e->getMessage()]);
            return;
        }
    }
    
    public function enrollpayment()
    {

        $enrollmodel=new Enrollmodel;
        $classID = $_GET['classID'] ?? null;
        $subject = $_GET['subject'] ?? null;
        $teacher = $_GET['teacher'] ?? null;
        $fee = $_GET['fee'] ?? null;

        $_SESSION['classID'] = $classID;
        $_SESSION['subject'] = $subject;
        $_SESSION['teacher'] = $teacher;
        $_SESSION['fee'] = $fee;

        if ($enrollmodel->checkisEnrolled($_SESSION['User_id'], $classID)) {
            http_response_code(403);
            echo json_encode(['error' => 'You are already enrolled in this class.']);
            return;
        }
        

        try {
            $checkout = \Stripe\Checkout\Session::create([
                'mode' => 'payment',
                'success_url' => "http://localhost/group_project_1.0/public/Enrollment/post/$classID",
                'cancel_url' => 'http://localhost/group_project_1.0/public/Enrollment/cancel',
                'line_items' => [[
                    'price_data' => [
                'currency' => 'usd',
                'unit_amount' => round(($fee / 310) * 100), // Amount in cents, as integer
                 'product_data' => [
                    'name' => "Class: $subject by $teacher",
                    'metadata' => [
                        'ClassID' => $classID,
                        'Subject' => $subject,
                        'Teacher' => $teacher,
                        'Fee_LKR' => $fee,
                        'Date' => date('Y-m-d')
                    ]
    ],
],

                    'quantity' => 1,
                ]],
            ]);
        
            header("Location: " . $checkout->url);
            exit(); // make sure to stop script after redirect
        } catch (Exception $e) {
            http_response_code(500);
            echo 'Stripe error: ' . $e->getMessage();
            exit();
        }
        
    }

    public function checkinstpayreq() {
        $model = new Reqinstpaymodel();
        $id = $_SESSION['User_id'];
        
        $prevMonth = date('m');
        $prevYear = date('Y');
        
        // Get previous month and year correctly
        $prevDate = strtotime('-1 month');
        $prevMonth = date('m', $prevDate);
        $prevYear = date('Y', $prevDate);
        
        $data = [
            'inst_id' => $id
        ];
        
        $results = $model->where($data); // fetch records
        
        $prevMonthRecord = null;
        $foundprevMonth = false;
    
        if ($results) {
            foreach ($results as $record) {
                $recordDate = strtotime($record->date);
                $recordMonth = date('m', $recordDate);
                $recordYear = date('Y', $recordDate);
                
                if ($recordMonth == $prevMonth && $recordYear == $prevYear) {
                    $foundprevMonth = true;
                    $prevMonthRecord = $record;
                    break;
                }
            }
        }
    
        if ($foundprevMonth) {
            echo json_encode([
                'status' => 'success', 
                'message' => 'Payment request already exists for the previous month.',
                'data' => $prevMonthRecord 
            ]);
        } else {
            echo json_encode([
                'status' => 'error', 
                'message' => 'No payment request found for the previous month for this instructor.'
            ]);
        }
    }
    



    public function requestMonthlyPayment() {
        $model = new Reqinstpaymodel();
    $paymentmodel = new Paymentmodel();
    $id = $_SESSION['User_id'] ?? null;

    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
        return;
    }

    $currentMonth = date('Y-m');

   

    // Prepare for data fetch
    $tables = ['all_payments', 'instituteteacher_class'];
    $join_conditions = ['all_payments.ClassID = instituteteacher_class.InstClass_id'];
    $datanot = [];

    // Fetch both Enrollment and Classfee payments
    $conditions = [
        ['all_payments.Type' => 'Enrollment', 'instituteteacher_class.inst_id' => $id],
        ['all_payments.Type' => 'Classfee',   'instituteteacher_class.inst_id' => $id]
    ];

    $allResults = [];

    foreach ($conditions as $cond) {
        $result = $paymentmodel->InnerJoinwhereMultiple($tables, $join_conditions, $cond, $datanot);
        if (!empty($result)) {
            $allResults = array_merge($allResults, $result);
        }
    }
    ;
   

    // Filter results for the current month
    $prevDate = strtotime('-1 month');
$prevMonth = date('Y-m', $prevDate); // Full Year-Month format (e.g., 2025-03)

$filteredPayments = array_filter($allResults, function ($record) use ($prevMonth) {
    if (!isset($record->Date)) return false;

    // Format the record's Date to YYYY-MM (e.g., 2025-03)
    $recordMonth = date('Y-m', strtotime($record->Date));

    // Check if the record's month matches the previous month
    return $recordMonth === $prevMonth;
});




    $totalAmount = array_reduce($filteredPayments, function ($carry, $record) {
        return $carry + (float)($record->Amount ?? 0);
    }, 0);

    if ($totalAmount <= 0) {
        echo json_encode(['success' => false, 'message' => 'No payments to request for this month.']);
        return;
    }

    // Insert payment request
    $insertData = [
        'inst_id' => $id,
        'date' => date('Y-m-d', strtotime('-1 month')),
        'time' => date('H:i:s'),
        'amount' => $totalAmount,
        'status' => 0
    ];

    $res = $model->insert($insertData);

    if ($res === true) {
        echo json_encode([
            'success' => true,
            'message' => 'Payment request sent successfully.',
            'total_amount' => $totalAmount
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to send payment request.',
            'total_amount' => $totalAmount
        ]);
    }
    }
    


     public function reqpaymentind()
{
    $model = new Reqinstpaymodel();
    $paymentmodel = new Paymentmodel();
    $id = $_SESSION['User_id'] ?? null;

    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
        return;
    }

    $currentMonth = date('Y-m');

   

    // Prepare for data fetch
    $tables = ['all_payments', 'individual_class'];
    $join_conditions = ['all_payments.ClassID = individual_class.IndClass_id'];
    $datanot = [];

    // Fetch both Enrollment and Classfee payments
    $conditions = [
        ['all_payments.Type' => 'Enrollment', 'individual_class.P_id' => $id],
        ['all_payments.Type' => 'Classfee',   'individual_class.P_id' => $id]
    ];

    $allResults = [];

    foreach ($conditions as $cond) {
        $result = $paymentmodel->InnerJoinwhereMultiple($tables, $join_conditions, $cond, $datanot);
        if (!empty($result)) {
            $allResults = array_merge($allResults, $result);
        }
    }
    ;

    // Filter results for the current month
    $prevDate = strtotime('-1 month');
$prevMonth = date('Y-m', $prevDate); // Full Year-Month format (e.g., 2025-03)

$filteredPayments = array_filter($allResults, function ($record) use ($prevMonth) {
    if (!isset($record->Date)) return false;

    // Format the record's Date to YYYY-MM (e.g., 2025-03)
    $recordMonth = date('Y-m', strtotime($record->Date));

    // Check if the record's month matches the previous month
    return $recordMonth === $prevMonth;
});




    $totalAmount = array_reduce($filteredPayments, function ($carry, $record) {
        return $carry + (float)($record->Amount ?? 0);
    }, 0);

    if ($totalAmount <= 0) {
        echo json_encode(['success' => false, 'message' => 'No payments to request for this month.']);
        return;
    }

    // Insert payment request
    $insertData = [
        'inst_id' => $id,
        'date' => date('Y-m-d', strtotime('-1 month')),
        'time' => date('H:i:s'),
        'amount' => $totalAmount,
        'status' => 0
    ];

    $res = $model->insert($insertData);

    if ($res === true) {
        echo json_encode([
            'success' => true,
            'message' => 'Payment request sent successfully.',
            'total_amount' => $totalAmount
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to send payment request.',
            'total_amount' => $totalAmount
        ]);
    }
}


public function checkpayment($id) {
    // Load the model
    $model = new Paymentmodel();

    // Get the current user ID from the session
    $userId = $_SESSION['User_id'];
$dat=[
    'ClassID' => $id,
    'User_id' => $userId,
    'Type' => 'Classfee'
];

    // Fetch all payments of type 'Classfee' for the current class and user
    $payments = $model->where($dat);
    

    // Get the current month and year
    $currentMonth = date('m'); // e.g., "04"
    $currentYear = date('Y');  // e.g., "2025"
    $currentDateFormatted = "$currentYear-$currentMonth";

    // Check if any payment matches the current month and year
    foreach ($payments as $payment) {
        $paymentDate = date('Y-m', strtotime($payment->Date));
        if ($paymentDate === $currentDateFormatted) {
            // User has paid this month
            echo json_encode(true);
            return;
        }
    }

    // If no payment was made this month
    echo json_encode(false);


    
}
    
    
}
