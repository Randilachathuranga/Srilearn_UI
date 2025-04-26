<?php
 
 class Subscriptions extends Controller{

    public function index(){
        if($_SESSION['Role'] === 'teacher' || $_SESSION['Role'] === 'institute'){
            $this->view('General/Subscriptions/Subscriptions');
        }
        else{
        $this->view('General/Errorpage/Error404');
        }
    }

    public function viewallsubdetails(){
        header('Content-Type: application/json'); // Set header for JSON response
        $model=new Subdetailsmodel();
 
        $result = $model->findAll();
        if ($result) {
            // Return blogs as JSON
            echo json_encode($result);
        } else {
            // Handle case where no blogs were found
            echo json_encode(['message' => 'no teachers found']);
        }
    }

    public function hassubbedinst($id){
          // Load the model
        $model=new Subscriptionmodel();
        $tables = ['instituteteacher_class', 'subscription','subdetails'];

        $joinConditions = [
        'instituteteacher_class.inst_id = subscription.P_id',
        'subscription.Type = subdetails.Type'
        ];

    $data = [
    'instituteteacher_class.InstClass_id' => $id
    ];

    $data_not = []; // if you have any != conditions

    $result = $model->InnerJoinwhereMultiple($tables, $joinConditions, $data, $data_not);
    $currentDate = date('Y-m-d');
    
    // Filter to find a valid subscription
    $validRecords = array_filter($result, function($record) use ($currentDate) {
        return isset($record->End_data) && $record->End_data > $currentDate;
    });
    if (!empty($validRecords)) {
        $activeRecord = reset($validRecords);
    }
        $ischatavail=$activeRecord->ischatavail;
    if($ischatavail===1){
        echo json_encode(true);
    }
    else{
        echo json_encode(false);
    }
    }
    public function hassubbedteach($id){
        // Load the model
        $model=new Subscriptionmodel();
        $tables = ['individual_class', 'subscription','subdetails'];

        $joinConditions = [
        'individual_class.P_id = subscription.P_id',
        'subscription.Type = subdetails.Type'
        ];

    $data = [
    'individual_class.IndClass_id' => $id
    ];

    $data_not = []; // if you have any != conditions

    $result = $model->InnerJoinwhereMultiple($tables, $joinConditions, $data, $data_not);
    $currentDate = date('Y-m-d');
    
    // Filter to find a valid subscription
    $validRecords = array_filter($result, function($record) use ($currentDate) {
        return isset($record->End_data) && $record->End_data > $currentDate;
    });
    if (!empty($validRecords)) {
        $activeRecord = reset($validRecords);
    }
        $ischatavail=$activeRecord->ischatavail;
    if($ischatavail===1){
        echo json_encode(true);
    }
    else{
        echo json_encode(false);
    }
}
public function hassubbedteachpayment($id){
    // Load the model
    $model=new Subscriptionmodel();
    $tables = ['individual_class', 'subscription','subdetails'];

    $joinConditions = [
    'individual_class.P_id = subscription.P_id',
    'subscription.Type = subdetails.Type'
    ];

$data = [
'individual_class.IndClass_id' => $id
];

$data_not = []; // if you have any != conditions

$result = $model->InnerJoinwhereMultiple($tables, $joinConditions, $data, $data_not);
$currentDate = date('Y-m-d');

// Filter to find a valid subscription
$validRecords = array_filter($result, function($record) use ($currentDate) {
    return isset($record->End_data) && $record->End_data > $currentDate;
});
if (!empty($validRecords)) {
    $activeRecord = reset($validRecords);
}
    $Ispayavail=$activeRecord->Ispayavail;
if($Ispayavail===1){
    echo json_encode(true);
}
else{
    echo json_encode(false);
}
}

    public function postsub($type)
{
    $model = new Subdetailsmodel();
    $sub = new Subscriptionmodel();
    $paymentmodel = new Paymentmodel();

    // Set response header
    header('Content-Type: application/json');

    // Validate user session
    $userId = $_SESSION['User_id'] ?? null;
    if (!$userId) {
        http_response_code(401);
        echo json_encode(['error' => 'User not logged in. Please log in to subscribe.']);
        return;
    }

    // Check for existing subscription
    $existingSubscription = $sub->first(['P_id' => $userId]);
    if ($existingSubscription) {
        http_response_code(403);
        echo json_encode(['error' => 'You are already subscribed.']);
        return;
    }

    // Get subscription plan details
    $plan = $model->first(['Type' => $type]);
    if (!$plan) {
        http_response_code(404);
        echo json_encode(['error' => 'Subscription plan not found.']);
        return;
    }

    // Extract plan duration (make sure it's numeric)
    $durationMonths = is_numeric($plan->Duration) ? (int)$plan->Duration : 0;
    if ($durationMonths <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid subscription duration.']);
        return;
    }

    // Prepare subscription details
    $subdetails = [
        'P_id' => $userId,
        'Type' => $type,
        'Star_data' => date("Y-m-d"),
        'End_data' => date("Y-m-d", strtotime("+{$durationMonths} months")),
    ];

    // Prepare payment details
    $paymentData = [
        'User_id' => $userId,
        'Amount' => $plan->Price*310,
        'Date' => date('Y-m-d'),
        'Type' => 'Subscription',
        'classID' => null,
        'Sub_id' => null,
    ];

    try {
        // Insert subscription
        $inserted = $sub->insert($subdetails);
        error_log("Inserting subscription: " . json_encode($subdetails));



        // Retrieve the newly created subscription to get its ID
        $newSub = $sub->first(['P_id' => $userId]);
        if ($newSub) {
            $paymentData['Sub_id'] = $newSub->ID;
        }
        

        // Insert payment record
        $paymentmodel->insert($paymentData);
        

        if ($inserted) {
            http_response_code(200);
            echo json_encode(['message' => 'Subscribed successfully', 'data' => $newSub]);
            redirect('profile');
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to subscribe.']);
        }

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => 'An error occurred while processing your subscription.',
            'details' => $e->getMessage()
        ]);
    }
}

}