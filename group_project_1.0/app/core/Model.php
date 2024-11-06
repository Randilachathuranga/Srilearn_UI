<?php

Trait Model {
   
    use Database;


    protected $limit='10';
    protected $offset='0';
    protected $order_type="desc";
    protected $order_column="id";
    public $errors=[];
   
    
    public function where($data,$data_not=[]){
        $keys=array_keys($data);
        $keys_not=array_keys($data_not);
        $query="select * from $this->table where ";
        foreach($keys as $key){
                $query.=$key."=:".$key." && ";
        }
        foreach($keys_not as $key){
            $query.=$key."!=:".$key." && ";
        }
        $query=trim($query," && ");
        $query.=" limit $this->limit offset $this->offset";
        $data=array_merge($data,$data_not);
        return $this->query($query,$data);
        
    }

    public function findall(){
       
        $query="select * from $this->table ";
        return $this->query($query);
        
    }
    public function first($data,$data_not=[]){
        $keys=array_keys($data);
        $keys_not=array_keys($data_not);
        $query="select * from $this->table where ";
        foreach($keys as $key){
                $query.=$key."=:".$key." && ";
        }
        foreach($keys_not as $key){
            $query.=$key."!=:".$key." && ";
        }
        $query=trim($query," && ");
        $query.=" limit $this->limit offset $this->offset";
        $data=array_merge($data,$data_not);
        $result= $this->query($query,$data);
        if($result){
        return $result[0];
        }
        return false;
    }

    public function insert($data){
        if(!empty($this->allowedColumns)){
            foreach($data as $key=>$value){
                if(!in_array($key,$this->allowedColumns)){
                    unset($data[$key]);
                }
            }
        }
        $keys=array_keys($data);
        $query="insert into $this->table (".implode(",",$keys).") values (:".implode(",:",$keys).")";
        $result= $this->query($query,$data);
        return false;
    }

    public function update($id, $data, $id_column = 'id') {
        if(!empty($this->allowedColumns)){
            foreach($data as $key=>$value){
                if(!in_array($key,$this->allowedColumns)){
                    unset($data[$key]);
                }
            }
        }
        
        $keys = array_keys($data);
        $query = "UPDATE $this->table SET ";
        
        // Build the query string with placeholders
        foreach ($keys as $key) {
            $query .= "$key = :$key, ";
        }
        
        // Remove trailing comma
        $query = rtrim($query, ', ');
        
        // Add the WHERE clause
        $query .= " WHERE $id_column = :$id_column";
        
        // Bind the ID to the data array for the WHERE clause
        $data[$id_column] = $id;
        
        // Execute the query and return the result
        return $this->query($query, $data);
    }
    
    public function delete($id,$id_column='name'){

        $data[$id_column]=$id;
        $query="delete  from $this->table where $id_column = :$id_column ";
        echo $query;
        $this->query($query,$data);
    
    }   

}