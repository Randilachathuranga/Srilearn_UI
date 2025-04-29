<?php

class Requestpayroll_forteacher extends Controller
{
//     public function mydetails($Class_id)
//     {
//         $model = new Myclassmodel();
//         header('Content-Type: application/json');
//         try {
        
//         $tables = ['instituteteacher_class', 'normal_teacher', 'user'];

//         $joinConditions = [
//         'instituteteacher_class.N_id = normal_teacher.N_id',
//         'normal_teacher.N_id = user.User_id'
//         ];

//     $data = [
//     'instituteteacher_class.InstClass_id' => $Class_id
//     ];

//     $data_not = []; // if you have any != conditions

//     $result = $model->InnerJoinwhereMultiple($tables, $joinConditions, $data, $data_not);

//             if ($result) {
//                 echo json_encode($result);
//             } else {
//                 echo json_encode(['message' => 'No institute found for this class ID.']);
//             }
//         } catch (Exception $e) {
//             echo json_encode(['error' => 'An error occurred while fetching materials.', 'details' => $e->getMessage()]);
//         }
//    }

   //insert payroll request data for payroll_request table

    /*public function checkmyrequest($N_id,$InstClass_id)
    {
        $model = new payroll_request();
        header('Content-Type: application/json');
        try {
        
        $result = $model->where(['N_id' => $N_id , 'InstClass_id' => $InstClass_id ,'stateis' => 1]);

            if ($result) {
                echo json_encode($result);
            } else {
                echo json_encode(['message' => 'No payroll request found for this teacher.']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'An error occurred while fetching materials.', 'details' => $e->getMessage()]);
        }

    }*/
    
    public function insertpayrollrequest()
{
    header('Content-Type: application/json');

    $data = json_decode(file_get_contents('php://input'), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['error' => 'Invalid JSON data.']);
        return;
    }

    try {
        $model = new Payroll_requestmodel();
        $paymentmodel = new Paymentmodel();

        $allrecs = $paymentmodel->findall(); 

        $totalAmount = 0;
        $currentMonth = date('m');
        $prevMonth = date('m', strtotime('first day of last month'));
        $currentYear = date('Y');

        $filteredRecs = array_filter($allrecs, function($rec) use ($data) {
            return isset($rec->classID) && $rec->classID == $data['InstClass_id'];
        });

        foreach ($filteredRecs as $record) {
            $recordMonth = date('m', strtotime($record->Date));
            $recordYear = date('Y', strtotime($record->Date));

            if ($recordMonth == $prevMonth && $recordYear == $currentYear) {
                $totalAmount += $record->Amount;
            }
        }

        if($totalAmount==0){
            http_response_code(400);
            echo json_encode(['error' => 'not enough to request a payment.']);
            return;
        } 

        $dataToInsert = [
            'Institute_ID'  => $data['Institute_ID'],
            'N_id'          => $data['N_id'],
            'InstClass_id'  => $data['InstClass_id'],
            'currentdate'   => $data['current_date'],
            'bankdetails'   => $data['bankdetails'],
            'Amount'        => $totalAmount,
            'stateis'       => 0
        ];

        $existingRecords = $model->where([
            'N_id'          => $data['N_id'],
            'InstClass_id'  => $data['InstClass_id'],
        ]);

        $alreadyExists = false;
        if (is_array($existingRecords) || is_object($existingRecords)) {
            foreach ($existingRecords as $record) {
                $recordDate = date('Y-m', strtotime($record->currentdate));
                if ($recordDate === "$currentYear-$currentMonth") {
                    $alreadyExists = true;
                    break;
                }
            }
        }

        if (!$alreadyExists) {
            $result = $model->insert($dataToInsert);
            if ($result) {
                echo json_encode(['message' => 'Payroll request submitted successfully.']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to insert payroll request.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'The payroll request already exists for this month.']);
        }

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => 'An error occurred while submitting the payroll request.',
            'details' => $e->getMessage()
        ]);
    }
}

    

    public function viewclassreq($id){
        $this->view('TeacherView/Options/ViewInstitute/Viewpayments',['id'=> $id]);
    }

    public function payments($classid){
        $model=new Payroll_requestmodel();
        header('Content-Type: application/json');

        try {
            $id=$_SESSION['User_id'];
            $result = $model->where(['InstClass_id' => $classid]);
            if ($result) {
                echo json_encode($result);
            } else {
                echo json_encode(['message' => 'No payroll request found for this class ID.']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'An error occurred while fetching payroll requests.', 'details' => $e->getMessage()]);
        }
    }
    
    
}