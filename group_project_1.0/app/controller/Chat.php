<?php 
class Chat extends Controller{
    public function index($id) {
        $model = new Messegemodel();
    
        // Fetch messages sent and received
        $received = $model->where(["sender_id" => $id, "reciever_id" => $_SESSION['User_id']]);
        $sent = $model->where(["sender_id" => $_SESSION['User_id'], "reciever_id" => $id]);
    
        // Merge the two arrays of stdClass objects
        $allMessages = array_merge($received, $sent);
    
        // Sort using msg_id (object notation)
        usort($allMessages, function ($a, $b) {
            return $a->msg_id <=> $b->msg_id;
        });
    
        // Output or return $allMessages
        // For example:
        // print_r($allMessages); or pass it to a view
        header('Content-Type: application/json');
        echo json_encode($allMessages);
    }

    public function mychat($id) {
        $this->view('General/Chat/mychat',['id'=>$id]);
    }

    public function post() {
        $model = new Messegemodel();
    
        // Only handle POST requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Read raw JSON input
            $input = json_decode(file_get_contents("php://input"), true);
    
            if ($model->validate($input)) {
                $model->insert($input);
    
                // Redirect after successful insertion
                $senderId = $input['sender_id'];
                header("Location: http://localhost/group_project_1.0/public/Chat/{$senderId}");
                exit;
            } else {
                // Validation failed, return error response
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'errors' => $model->errors
                ]);
                return;
            }
        } // If not POST request
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Method Not Allowed'
        ]);
    }


    public function edit($id) {
        $model = new Messegemodel();
    
        // Only handle POST requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Read raw JSON input
            $input = json_decode(file_get_contents("php://input"), true);
            $senderId = $input['reciever_id'];
            $input['message'] .= " (edited)";

            unset($input['reciever_id']);
            if ($model->validate($input)) {
                $model->update($id,$input,'msg_id');
    
                // Redirect after successful insertion
                
                header("Location: http://localhost/group_project_1.0/public/Chat/{$senderId}");
                exit;
            } else {
                // Validation failed, return error response
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'errors' => $model->errors
                ]);
                return;
            }
        } // If not POST request
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Method Not Allowed'
        ]);
    }
       

    
    

    
    
}