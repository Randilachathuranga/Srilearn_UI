<?php 
class Chat extends Controller{
    public function index($id) {
        $model = new Messegemodel();
    
      
        $received = $model->where(["sender_id" => $id, "reciever_id" => $_SESSION['User_id']]);
        $sent = $model->where(["sender_id" => $_SESSION['User_id'], "reciever_id" => $id]);
    
        
        $allMessages = array_merge($received, $sent);
    
       
        usort($allMessages, function ($a, $b) {
            return $a->msg_id <=> $b->msg_id;
        });
    
       
        header('Content-Type: application/json');
        echo json_encode($allMessages);
    }

    public function mychat($id) {
        $this->view('General/Chat/mychat',['id'=>$id]);
    }

    public function post() {
        $model = new Messegemodel();
    
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $input = json_decode(file_get_contents("php://input"), true);
    
            if ($model->validate($input)) {
                $model->insert($input);
    
               
                $senderId = $input['sender_id'];
                header("Location: http://localhost/group_project_1.0/public/Chat/{$senderId}");
                exit;
            } else {
                
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'errors' => $model->errors
                ]);
                return;
            }
        }  
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Method Not Allowed'
        ]);
    }


    public function edit($id) {
        $model = new Messegemodel();
    
       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $input = json_decode(file_get_contents("php://input"), true);
            $senderId = $input['reciever_id'];
           

            unset($input['reciever_id']);
            if ($model->validate($input)) {
                $model->update($id,$input,'msg_id');
    
               
                
                header("Location: http://localhost/group_project_1.0/public/Chat/{$senderId}");
                exit;
            } else {
                
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'errors' => $model->errors
                ]);
                return;
            }
        } 
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Method Not Allowed'
        ]);
    }
       

    
    

    
    
}