<?php

class Advertisements extends Controller {

  
    public function index(){
        $this->view('General/Advertisements/advertisements');
    }

    public function viewall() {
        header('Content-Type: application/json');

        $model = new AdvertisementModel();
        $allads = $model->findall();

        echo json_encode($allads);
    }



    // API: Delete specific ad
    public function deleteapi($id) {
        // $this->requireTeacherOrInstitute();

        $model = new AdvertisementModel;

        $deleteadd = $model->delete($id,'Ad_id');
        echo json_encode($deleteadd);
    }

    // Update existing ad
    public function updateapi($id) {
        $this->requireTeacherOrInstitute();

        $model = new AdvertisementModel;
        $ad = $model->first(['addid' => $id]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($model->validate($_POST)) {
                if ($model->update($id, $_POST, 'addid')) {
                    redirect('Advertisements/viewadd');
                } else {
                    $data['errors'] = ['Failed to update advertisement.'];
                }
            } else {
                $data['errors'] = $model->errors;
            }

            $data['add'] = $ad;
            $this->view('General/Advertisements/adform', $data);
            return;
        }

        $this->view('General/Advertisements/adform', ['add' => $ad]);
    }

    // 🔐 Reusable access control for teacher/institute
    private function requireTeacherOrInstitute() {
        checkAccess(['teacher', 'institute']);
    }

    public function createadd(){
        
    }

  
}
