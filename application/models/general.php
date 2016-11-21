<?php 
class General extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }   
    
    public function getItems($select = "" , $table_name , $join  = array() , $where = array() , $or_where = array() , $order_by = array() ,$limit = array(), $where_in = array() , $or_where_in = array(), $distinct = '0', $where_not_in = array()){
        //select
        if(!empty($select)){
            $this->db->select( $select );   
        }
        //from
        $this->db->from( $table_name );  
        //join
        if(!empty($join)){
            foreach($join as $key => $value){
                $this->db->join( $key , $value );    
            }
            
        }
        //where
        if(!empty($where)){
            foreach( $where as $key => $value ){
                $this->db->where($key , $value);
            }
        } 
        //or_where
        if(!empty($or_where)){
             foreach( $or_where as $key => $value ){
                $this->db->or_where($key , $value);
            }
        }
        
        //where in
        if(!empty($where_in)){
            foreach( $where_in as $key => $value ){
                $this->db->where_in( $key , $value ); 
            }
        }
        
		 //where not in
        if(!empty($where_not_in)){
            foreach( $where_not_in as $key => $value ){
                $this->db->where_not_in( $key , $value ); 
            }
        }
		
        //or where in
        if(!empty($or_where_in)){
            foreach( $or_where_in as $key => $value ){
                $this->db->or_where_in( $key , $value ); 
            }
        }
        
        //order by
        if(!empty($order_by)){
            $this->db->order_by($order_by['order'], $order_by['type']);
        }
		//distinct
		if($distinct == '1'){
			$this->db->distinct();
		}
        //limit
        if(!empty($limit)){
            $this->db->limit( $limit['num_record'] , $limit['start'] );
        }
        //get
        $query = $this->db->get();
        //return array rows
        return $query->result_array();
    }       
	public function getItems2($select = "" , $table_name , $join  = array() , $where = array() , $or_where = array() , $order_by = array() ,$limit = array(), $where_in = array() , $or_where_in = array(), $distinct = '0'){
        //select
        if(!empty($select)){
            $this->db->select( $select );   
        }
        //from
        $this->db->from( $table_name );  
        //join
        if(!empty($join)){
            foreach($join as $key => $value){
                $this->db->join( $key , $value );    
            }
            
        }
        //where
        if(!empty($where)){
            foreach( $where as $key => $value ){
                $this->db->where($key , $value);
            }
        } 
        //or_where
        if(!empty($or_where)){
             foreach( $or_where as $key => $value ){
                $this->db->or_where($key , $value);
            }
        }
        
        //where in
        if(!empty($where_in)){
            foreach( $where_in as $key => $value ){
                $this->db->where_in( $key , $value ); 
            }
        }
        
        //or where in
        if(!empty($or_where_in)){
            foreach( $or_where_in as $key => $value ){
                $this->db->or_where_in( $key , $value ); 
            }
        }
        
        //order by
        if(!empty($order_by)){
            $this->db->order_by($order_by['order'], $order_by['type']);
        }
		//distinct
		if($distinct == '1'){
			$this->db->distinct();
		}
        //limit
        if(!empty($limit)){
            $this->db->limit( $limit['num_record'] , $limit['start'] );
        }
        //get
        $query = $this->db->get();
		$this->db->last_query();
        //return array rows
        return $query->result_array();
    }       
    
    public function countItems($select = "" , $table_name , $join  = array() , $where = array() , $or_where = array()){
        //select
        if(!empty($select)){
            $this->db->select( $select );   
        }
        //from
        $this->db->from( $table_name );  
        //join
        if(!empty($join)){
            $this->db->join( $join['table_join'] , $join['condition'] );
        }
        //where
        if(!empty($where)){
            foreach( $where as $key => $value ){
                $this->db->where($key , $value);
            }
        } 
        //or_where
        if(!empty($or_where)){
             foreach( $or_where as $key => $value ){
                $this->db->or_where($key , $value);
            }
        }      
        //get
        $query = $this->db->get();
        //return array rows
        return $query->num_rows();
    }   
    
    public function insertItem( $table_name , $data ){        
		try{
			$this->db->insert($table_name, $data);  
			return true;
		}catch(Exception $e){
			return false;
		}		
    }  
	
    
    public function updateItem( $table_name , $data , $where ){
        if(!empty($where)){
			try{
				foreach( $where as $key => $value ){
					$this->db->where($key , $value);
				}    
				$this->db->update( $table_name , $data );
				return true;
			}catch(Exception $e) {
				return false;
			}			
        }else{
            return false;     
        }
    }
    
    public function deleteItem( $table_name , $where ){
        if(!empty($where)){
			try{
				foreach( $where as $key => $value ){
					$this->db->where($key , $value);   
				}
				$this->db->delete($table_name);
				return true;
			}catch(Exception $e) {
				return false;
			}	
        }else{
			return false;
		}
    }		
	
	public function QuerySQL( $table, $data, $key, $value ){        
		$this->db->set("$data", "$data+1", FALSE);		
		$this->db->where($key, $value);		
		$this->db->update($table);    
	}
	
	public function getItemsNoneActiveRecord($sql){       
        $query = $this->db->query($sql);
        return  $query->result_array();
    } 
	
	public function updateNoneActiveRecord($sql){
		return $this->db->query($sql);
	}
}


/*
//lay nhieu dong
    function getItems($sql){       
        $query = $this->db->query($sql);
        return  $query->result_array();
    } 
    //lay 1 dong
    function getItem($sql){            
        $query = $this->db->query($sql);
        return  $query->row_array();
    }   
*/