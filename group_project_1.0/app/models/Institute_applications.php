<?php

class Institute_applications{
    use Model;

    public $table = 'institute_applications';
    public $allowedColumns = ['Jr_id','Teacher_id','Date','Full_name','Email',
                                'Subject','Phone_number','Qualifications','stateis'];

}