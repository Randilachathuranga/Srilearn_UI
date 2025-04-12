<?php

class Subdetailsmodel{
    use Model;

    protected $table = 'subdetails';
    protected $allowedColumns = [
        'subid','type ','isjobavail','ispayavail','isadavail','	duration'
    ];

}