<?php
include_once 'config/dbh.php';
include_once 'config/cors.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $data = json_decode(file_get_contents("php://input"));

	$id = $data->id;

    if(isset($id)){
        $id = $conn->real_escape_string($data->id);        
        $sql = $conn->query("SELECT * FROM ordenes WHERE id_purlcera = '$id'");
        $data = $sql->fetch_assoc();
        if($data==null){
            exit(json_encode(array('status' => 'Producto no registrado')));
        }
    }else{
        $data = array();
        $sql = $conn->query("SELECT * FROM ordenes");
        while ($d = $sql->fetch_assoc()){
            $data[] = $d;
        }
    }

    exit(json_encode($data));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $sql = $conn->query("INSERT INTO ordenes (id_purlcera, id_producto, cantidad, id_usuario) VALUES ('$data->id_purlcera','$data->id_producto','$data->cantidad','$data->id_usuario')");
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
    $sql = $conn->query("UPDATE productos SET nombre = '".$data->nombre."',  precio = '".$data->precio."',  disponible = '".$data->disponible."' WHERE id = '$id'");
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
        
        $sql = $conn->query("DELETE FROM ordenes WHERE id = '$id'");

        if($sql) {
            exit(json_encode(array('status' => 'success')));
        } else{
            exit(json_encode(array('status' => 'error')));
        }
    }
}