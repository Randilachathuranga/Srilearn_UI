<?php

class Requestpayroll_forteacher extends Controller
{
    public function mydetails($Class_id)
    {
        $model = new Myclassmodel();
        header('Content-Type: application/json');
        try {
        
        $tables = ['instituteteacher_class', 'normal_teacher', 'user'];

        $joinConditions = [
        'instituteteacher_class.N_id = normal_teacher.N_id',
        'normal_teacher.N_id = user.User_id'
        ];

    $data = [
    'instituteteacher_class.InstClass_id' => $Class_id
    ];

    $data_not = []; // if you have any != conditions

    $result = $model->InnerJoinwhereMultiple($tables, $joinConditions, $data, $data_not);

            if ($result) {
                echo json_encode($result);
            } else {
                echo json_encode(['message' => 'No institute found for this class ID.']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'An error occurred while fetching materials.', 'details' => $e->getMessage()]);
        }
   }

   //insert payroll request data for payroll_request table
   public function insertpayrollrequest($classId)
{
    $model = new payroll_request();
    header('Content-Type: application/json');
    
    // Get raw POST data and decode it
    $data = json_decode(file_get_contents('php://input'), true); 

    // Check if JSON data is valid
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['error' => 'Invalid JSON data.']);
        return;
    }

    try {
        // Prepare the data to insert
        $query = "INSERT INTO {$model->table} (Institute_ID, N_id, InstClass_id, currentdate, bankdetails, Amount, stateis) 
                  VALUES (:Institute_ID, :N_id, :InstClass_id, :currentdate, :bankdetails, :Amount,:stateis)";

        $dataToInsert = [
            'Institute_ID' => $data['Institute_ID'],
            'N_id' => $data['N_id'],
            'InstClass_id' => $classId,
            'currentdate' => $data['current_date'],
            'bankdetails' => $data['bankdetails'],
            'Amount' => $data['Amount'],
            'stateis' => 1 // Set the default state value as 1
        ];

        // Execute the query using the duiquery method
        $result = $model->duiquery($query, $dataToInsert);

        // Check if the result was successful
        if ($result) {
            echo json_encode(['message' => 'Payroll request submitted successfully.']);
        } else {
            echo json_encode(['error' => 'Failed to submit payroll request.']);
        }

    } catch (Exception $e) {
        echo json_encode(['error' => 'An error occurred while submitting the payroll request.', 'details' => $e->getMessage()]);
    }
}

    public function checkmyrequest($N_id)
    {
        $model = new payroll_request();
        header('Content-Type: application/json');
        try {
        
        $result = $model->where(['N_id' => $N_id , 'stateis' => 1]);

            if ($result) {
                echo json_encode($result);
            } else {
                echo json_encode(['message' => 'No payroll request found for this teacher.']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'An error occurred while fetching materials.', 'details' => $e->getMessage()]);
        }

    }

}