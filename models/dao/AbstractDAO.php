<?php

abstract class AbstractDAO {
    protected $connection;
    protected $table;
    
    public function __construct ($table) {
        $this->table = $table;
        $this->connection = new PDO('mysql:host=localhost;dbname=pacom', 'root', '');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

   

    public function fetchAll () {
        try {
            $statement = $this->connection->prepare("SELECT * FROM {$this->table}");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $this->createAllDeep($result);
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }
    
    public function fetchWhere ($ref, $value) {
        try {
            $statement = $this->connection->prepare("SELECT * FROM {$this->table} WHERE {$ref} = ?");
            $statement->execute([$value]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $this->createAllDeep($result);
            
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }

    //chercher 1
    public function fetch ($id, $ref, $deep = true) {
        try {
            $statement = $this->connection->prepare("SELECT * FROM {$this->table} WHERE {$ref} = ?");
            $statement->execute([$id]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if($deep) {
               return $this->deepcreate($result); 
            }
            return $this->create($result);
            
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }
    


    public function fetchIntermediate ($table, $id, $key, $foreign) {
        try {
            $statement = $this->connection->prepare("SELECT * FROM {$table} WHERE {$key} = ?");
            $statement->execute([$id]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $list = [];
           
            foreach($result as $item) {
              
                array_push($list, $this->fetch($item[$foreign], false));
            
            }
          
            return $list;
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }
    public function fetchIntermediateDAO ($table, $id, $key, $foreign,$dao) {
        try {
            $statement = $this->connection->prepare("SELECT * FROM {$table} WHERE {$key} = ?");
            $statement->execute([$id]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $list = [];
            
            foreach($result as $item) {
              
                array_push($list, $dao->fetch($item[$foreign], false));
            
            }
    
            return $list;
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }

    public function fetchIdWhere($id, $table, $ref, $value,$fetchAll=false){
        try {
            $statement = $this->connection->prepare("SELECT {$id} FROM {$table} WHERE {$ref} = ?");
            $statement->execute([$value]);
            if($fetchAll){
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            }
            else{
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            }
            return ($result);
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }


    public function createAllDeep ($results) {
        $list = array();
        foreach ($results as $result) {
            array_push($list, $this->deepCreate($result));
        }
        return $list;
    }


    //Many to One
    public function belongsTo ($dao,$ref, $id) {
        return $dao->fetch($id,$ref, false);
    }
    
    //One to Many
    public function hasMany ($dao, $col, $key) {
        return $dao->fetchWhere($col, $key);
    }
    
    //Many to Many
    public function belongsToMany ($dao, $table, $id, $key, $foreign) {
        return $dao->fetchIntermediate($table, $id, $key, $foreign);
    }


    public function associate ($table, $id, $key, $ref, $value) {
        try {
            $statement = $this->connection->prepare(
                "INSERT INTO {$table} ({$key}, {$ref}) VALUES (?, ?)"
            );
            $statement->execute([
                htmlspecialchars ($id),
                htmlspecialchars ($value)
            ]);
            return true;
        } catch(PDOException $e) {
            print $e->getMessage();
            return false;
        }
 
    }
    
    public function dissociate ($table, $id, $key, $ref, $value) {
        try {
            $statement = $this->connection->prepare(
                "DELETE FROM {$table} WHERE {$key} = ? AND ${ref} = ?"
            );
            $statement->execute([
                htmlspecialchars ($id),
                htmlspecialchars ($value)
            ]);
            return true;
        } catch(PDOException $e) {
            print $e->getMessage();
            return false;
        }
    }
}