<?php
include_once 'config/dbh.php';
include_once 'config/cors.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['id'])){
        $id =$conn->real_escape_string($_GET['id']);
        $sql = $conn->query("SELECT * FROM productos WHERE id = '$id");
        $data = $sql->fetch_assoc();
    }else{
        $data = array();
        $sql = $conn->query("SELECT * FROM productos");
        while ($d = $sql->fetch_assoc()){
            $data[] = $d;
        }
    }

    exit(json_encode($data));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $sql = $conn->query("INSERT INTO productos (nombre, precio) VALUES ('".$data->nombre."','".$data->precio."')");
    if ($sql){
        $data->id = $conn->insert_id;
        exit(json_encode($data));
    }else{
        exit(json_encode(array('status' => 'error')));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
 if(isset($_GET['id'])){
    $id = $conn->real_escape_string($_GET['id']);
    $data = json_decode(file_get_contents("php://input"));
    $sql = $conn->query("UPDATE productos SET nombre = '".$data->nombre."', precio = '".$data->precio."', disponible = '".$data->disponible."' WHERE id = '$id'");
    if ($sql){
        exit(json_encode(array('status' => 'success')));
    }else{
        exit(json_encode(array('status' => 'error')));
    }
 }   
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if(isset($_GET['id'])){
        $id = $conn->real_escape_string($_GET['id']);
        $sql = $conn->query("DELETE FROM productos WHERE id = '$id");

        if($sql) {
            exit(json_encode(array('status' => 'success')));
        } else{
            exit(json_encode(array('status' => 'error')));
        }
    }
}