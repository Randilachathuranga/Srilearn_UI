<?php

class User_subjectmodel{
        
        use Model;
    
        public $table='user_subjects';
        public $allowedColumns=[
            'User_id','Subject'
        ];

}