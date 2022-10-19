<?php
include_once 'config/dbh.php';
include_once 'config/cors.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $data = json_decode(file_get_contents("php://input"));

	$id = $data->id;

    if(isset($id)){
        $id = $conn->real_escape_string($data->id);        
        $sql = $conn->query("SELECT * FROM pulseras WHERE id = '$id'");
        $data = $sql->fetch_assoc();
        if($data==null){
            exit(json_encode(array('status' => 'pulcera no registrada')));
        }
    }else{
        exit(json_encode(array('status' => 'introdusca un valor')));
        
    }

    exit(json_encode($data));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $sql = $conn->query("INSERT INTO pulseras (id) VALUES ('".$data->id."')");
    if ($sql){
        $data->id = $conn->insert_id;
        exit(json_encode($data));
    }else{
        exit(json_encode(array('status' => 'error')));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;
 if(isset($id)){    
    $sql = $conn->query("UPDATE pulseras SET pagado = '".$data->pagado."' WHERE id = '$id'");
    if ($sql){
        exit(json_encode(array('status' => 'success')));
    }else{
        exit(json_encode(array('status' => 'error')));
    }
 }   
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;

    if(isset($id)){
        
        $sql = $conn->query("DELETE FROM pulseras WHERE id = '$id'");

        if($sql) {
            exit(json_encode(array('status' => 'success')));
        } else{
            exit(json_encode(array('status' => 'error')));
        }
    }
}