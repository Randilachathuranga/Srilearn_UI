<?php
class Classannmodel{
    use Model;
    public $table = "classann";
    public $allowedColumns = ['annid', 'classid', 'date', 'time', 'description'];
}
