<?php
class Instteachclassmodel{
    use Model;
    public $table = 'instituteteacher_class';
    public $allowColumns = [
        'ID','InstClass_ID','N_ID','Location','Start_date','End_date','Hall_number','inst_id'
    ];

    
    
}