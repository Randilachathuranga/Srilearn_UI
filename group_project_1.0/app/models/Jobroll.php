<?php

class Jobroll{
    use Model;

    public $table = 'jobroll';
    public $allowedColumns = ['Jr_id','Inst_id','Status','Subject','application_date'];
}