<?php

class Advertisements extends Controller {

    // Load advertisements page, handle form submission
    public function index() {
        $this->requireTeacherOrInstitute();

        $Ads = new AdvertisementModel; // ✅ Fixed class name

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($Ads->validate($_POST)) {
                $Ads->insert($_POST);
                redirect('Advertisements/viewadd');
            } else {
                $data['errors'] = $Ads->errors;
                $this->view('General/Advertisements/advertisements', $data);
                return;
            }
        }

        $data['errors'] = [];
        $this->view('General/Advertisements/advertisements', $data);
    }

    // Show form to add new ad
    public function form() {
        $this->requireTeacherOrInstitute();
        $this->view('General/Advertisements/adform');
    }

    // View all ads (list)
    public function viewadd() {
        checkloginstatus();
        $this->view('General/Advertisements/advertisements', []);
    }

    // API: Return all ads in JSON
    public function api() {
        $model = new AdvertisementModel;
        $ads = $model->findAll();

        $this->jsonResponse($ads);
    }

    // API: Delete specific ad
    public function deleteapi($id) {
        $this->requireTeacherOrInstitute();

        $model = new AdvertisementModel;

        try {
            if ($model->delete($id, 'addid')) {
                $this->jsonResponse(['status' => 'success', 'message' => 'Ad deleted successfully']);
            } else {
                $this->jsonResponse(['status' => 'error', 'message' => 'Failed to delete ad']);
            }
        } catch (Exception $e) {
            $this->jsonResponse(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
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

    // 📦 Standardized JSON response
    private function jsonResponse($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
