<?php

class ViewinstituteController extends Controller
{
    public function index()
    {
        $this->view('TeacherView/Options/ViewInstitute/ViewInstitute');
    }

    //institute for spesific class
    public function viewmyinstitute($Class_id)
    {
        $model = new Myclassmodel();
        header('Content-Type: application/json');
        try {
        
        $tables = ['instituteteacher_class', 'user'];

        $joinConditions = [
        'instituteteacher_class.inst_id = user.User_id'
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
}