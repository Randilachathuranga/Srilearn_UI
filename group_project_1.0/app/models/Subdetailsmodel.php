<?php

class Subdetailsmodel{
    use Model;

    protected $table = 'subdetails';
    protected $allowedColumns = [
        'Type ','Isjobavail','Ispayavail','Isadavail','ischatavail','Duration','Price','UserType'
    ];

}