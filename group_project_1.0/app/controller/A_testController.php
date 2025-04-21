<?php

class A_testController extends Controller{

    //render the view page
    public function index(){
        $this->view('A_test');
    }

    //all 
    public function viewall(){
        $model = new A_testModel();
        header('Content-Type: application/json');
        try {
            $all = $model->findall();
            if ($all) {
                echo json_encode($all);
            } else {
                echo json_encode(['message' => 'Not found data']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'An error occurred while fetching user.', 'details' => $e->getMessage()]);
        }
    }

    //view spesific
    public function viewspecific($id){
        $model = new A_testModel();
        header('Content-Type: application/json');
        try {
            $Specific = $model->where(['U_id' => $id]);
            
            if ($Specific) {
                echo json_encode($Specific);
            } else {
                echo json_encode(['message' => 'Not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'An error occurred while fetching user.', 'details' => $e->getMessage()]);
        }
    }

    //Delete spesific id
    public function del($id){
        $model = new A_testModel();
        header('Content-Type: application/json');
        try {
            $delid = $model->delete($id,'U_id');
            
            if ($delid) {
                echo json_encode($delid);
            } else {
                echo json_encode(['message' => 'Not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'An error occurred while fetching user.', 'details' => $e->getMessage()]);
        }
    }

    //insert data
    public function insertpayrollrequest()
    {
        $model = new A_testModel();
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true); 
        try {
            $dataToInsert = [
                'Name' => $data['Name'],
                'Age' => $data['Age'],
                'DOB' => $data['DOB']
            ];
            $result = $model->insert($dataToInsert);
            if ($result) {
                echo json_encode(['message' => 'Inserted successfully.']);
            } else {
                echo json_encode(['error' => 'Failed to insert']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'An error occurred while submitting the payroll request.', 'details' => $e->getMessage()]);
        }
    }

    //update data
    public function updatepayrollrequest($id)
    {
        $model = new A_testModel();
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true); 
        try {
            $dataToUpdate = [
                'Name' => $data['Name'],
                'Age' => $data['Age'],
                'DOB' => $data['DOB']
            ];
            $result = $model->update($id, $dataToUpdate, 'U_id');
            if ($result) {
                echo json_encode(['message' => 'Updated successfully.']);
            } else {
                echo json_encode(['error' => 'Failed to update']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'An error occurred while updating the payroll request.', 'details' => $e->getMessage()]);
        }
    }

}