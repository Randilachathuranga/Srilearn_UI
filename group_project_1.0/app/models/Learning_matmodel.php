<?php

class Learning_matmodel{
    use Model;

    public $table = 'learning_mat';
    public $allowedcolumns = ['Mat_id','Class_id','topic','sub_topic','Description','Url','Date'];

    
    
}