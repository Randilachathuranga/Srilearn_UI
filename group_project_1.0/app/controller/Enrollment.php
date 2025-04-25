<?php
class Enrollment extends Controller
{
    public function index()
    {
        $this->view('StudentView/MyEnrollements/Enrollment');
    }

    public function post($classid)
    {
        // Instantiate the models
        $model = new Enrollmodel();
        $paymentmodel = new Paymentmodel();
    
        // Set response header
        header('Content-Type: application/json');
    
        // Get user ID and fee from session safely
        $userId = $_SESSION['User_id'] ?? null;
        $fee = $_SESSION['fee'] ?? null;
    
        // Check if user is logged in
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'User not logged in. Please log in to enroll.']);
            return;
        }
    
        // Check if already enrolled
        if ($model->checkisEnrolled($userId, $classid)) {
            http_response_code(403);
            echo json_encode(['error' => 'You are already enrolled in this class.']);
            return;
        }
    
        // Prepare enrollment data
        $enrollData = [
            'Date' => date("Y-m-d"),
            'Stu_id' => $userId,
            'Class_id' => $classid,
            'Isdiscountavail' => 0
        ];
    
        // Prepare payment data (only if fee is available)
        $paymentData = [
            'User_id' => $userId,
            'Amount' => $fee,
            'Date' => date('Y-m-d'),
            'Type' => 'Enrollment',
            'classID' => $classid,
            'Sub_id' => null
        ];
    
        try {
            // Insert enrollment
            $enroll = $model->insert($enrollData);
    
            // Insert payment (only if fee is set)
            
                $paymentmodel->insert($paymentData);
            
    
            if ($enroll) {
                http_response_code(200);
                //echo json_encode(['message' => 'Enrolled successfully', 'data' => $enroll]);
                redirect('Enrollment');
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Enrollment failed. Please try again later.']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred while enrolling.', 'details' => $e->getMessage()]);
        }
    }
    public function postfree()
    {
        header('Content-Type: application/json');
        $model = new Enrollmodel();
    
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }
    
        // Read input
        $input = json_decode(file_get_contents("php://input"), true);
    
        if (!is_array($input)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input data.']);
            return;
        }
    
        $userId = $_SESSION['User_id'] ?? null;
        $classId = $input['classID'] ?? null;
    
        if (!$userId || !$classId) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required data.']);
            return;
        }
    
        // Check if already enrolled
        if ($model->checkisEnrolled($userId, $classId)) {
            http_response_code(403);
            echo json_encode(['error' => 'You are already enrolled in this class.']);
            return;
        }
    
        // Prepare enrollment data
        $enrollData = [
            'Date' => date("Y-m-d"),
            'Stu_id' => $userId,
            'Class_id' => $classId,
            'Isdiscountavail' => 0
        ];
    
        try {
            $enroll = $model->insert($enrollData);
    
            if ($enroll) {
                http_response_code(200);
                echo json_encode(['message' => 'Enrolled successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Enrollment failed.']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'error' => 'An error occurred during enrollment.',
                'details' => $e->getMessage()
            ]);
        }
    }
    
    

 public function api(){
    $model = new Enrollmodel();
    try {
        $classes = $model->InnerJoinwhere('enrollment','class','enrollment.Class_id=class.Class_id',['Stu_id' => $_SESSION['User_id']]);
        
        if ($classes) {
            // Return blogs as JSON
            echo json_encode($classes);
        } else {
            // Handle case where no blogs were found
            echo json_encode([]);
        }
    } catch (Exception $e) {
        // Error handling in case of an exception
        echo json_encode(['error' => 'An error occurred while fetching classes.', 'details' => $e->getMessage()]);
    }
 }

 public function allindividual(){
    $model= new StudentModel();
    header('Content-Type: application/json');
    try {
        $tables =['class','individual_class','user','enrollment'];
        $join_conditions = ['class.Class_id = individual_class.IndClass_id', 'individual_class.P_id = user.User_id',
        'enrollment.Class_id=class.Class_id'];

        $data =['enrollment.Stu_id' =>$_SESSION['User_id']];
        $datanot=[];
        $individual = $model->InnerJoinwhereMultiple($tables,$join_conditions,$data,$datanot);
        if ($individual) {
            echo json_encode($individual);
        } else {
            echo json_encode(['message' => 'No classes found .']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'An error occurred while fetching classes.', 'details' => $e->getMessage()]);
    }
}

public function allinstitute(){
    $model= new StudentModel();
    header('Content-Type: application/json');
    try {
        $tables2 =['enrollment','instituteteacher_class','class','user'];
        $join_conditions2 = ['enrollment.Class_id=instituteteacher_class.InstClass_id','instituteteacher_class.InstClass_id=class.Class_id','instituteteacher_class.N_id=user.User_id'];

        $data2 =['enrollment.Stu_id' =>$_SESSION['User_id'],'class.Type'=>'Institute'];
        $datanot=[];
        $institute = $model->InnerJoinwhereMultiple($tables2,$join_conditions2,$data2,$datanot);
        if ($institute) {
            echo json_encode($institute);
        } else {
            echo json_encode(['message' => 'No classes found .']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'An error occurred while fetching classes.', 'details' => $e->getMessage()]);
    }
}

public function mydeleteapi($id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Read raw JSON input
        $input = json_decode(file_get_contents("php://input"), true);

        show($input);
        $delusermodel = new Removedstdmodel();
        $model = new Enrollmodel();
        header('Content-Type: application/json');

        try {
            // Fetch the enrollment record
            $rec = $model->where(['Enrollment_id' => $id]);
            show($rec);
            if (!$rec) {
                echo json_encode(['error' => 'Enrollment record not found.']);
                return;
            }

            // Delete the enrollment
           

            
            // Prepare data for removed student log
            $data = [
                'past_std' => $id,   
                'Stu_id' => $rec[0]->Stu_id,
                'Class_id' => $rec[0]->Class_id,
                'Rem_Date' => $input['Rem_Date'],
                'Reason' => $input['Reason']
            ];
            show($data);
            $fetch = $delusermodel->insert($data);
            if ($fetch) {
            $enroll = $model->delete($id, 'Enrollment_id');
            } else {
                echo json_encode(['error' => 'Failed to log removed student.']);
                return;
            }
            if ($enroll) {
                echo json_encode(['status' => 'success', 'message' => 'Student removed successfully.']);
            } else {
                echo json_encode(['error' => 'Failed to delete student.']);
            }

        } catch (Exception $e) {
            echo json_encode([
                'error' => 'An error occurred while processing.',
                'details' => $e->getMessage()
            ]);
        }
    } else {
        echo json_encode(['error' => 'Invalid request method.']);
    }
}

public function getAlldeleted($id){
    $model = new Removedstdmodel();
    $data = $model->where(['Class_id' =>$id ]);
    echo json_encode($data);
}

public function deletedstudents($Class_id){
    $this->view('TeacherView/Options/ClassStudents/DeletedStudents',['Class_id' => $Class_id]);
}


public function payfee($classid)
{
    $model=new Classmodel();
    $paymentmodel = new Paymentmodel();
    $rec=$model->first(['Class_id'=>$classid]);

    // Set response header
    header('Content-Type: application/json');

    // Validate user session
    $userId = $_SESSION['User_id'] ?? null;
    if (!$userId) {
        http_response_code(401);
        echo json_encode(['error' => 'User not logged in. Please log in to subscribe.']);
        return;
    }

    // Prepare payment details
    $paymentData = [
        'User_id' => $userId,
        'Amount' => $rec->fee,
        'Date' => date('Y-m-d'),
        'Type' => 'Classfee',
        'classID' =>$classid,
        'Sub_id' => null,
    ];

    try {
        // Insert subscription
        $inserted = $paymentmodel->insert($paymentData);

        if ($inserted) {
            http_response_code(200);
            echo json_encode(['message' => 'Subscribed successfully', 'data' => $inserted]);
            redirect('Enrollment');
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