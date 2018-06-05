<?php

/* if($_REQUEST){
    echo json_encode(["msg"=>"REQUEST"]);exit;
}*/

if($_GET){
    //var_dump($_GET);exit;
    //echo "<name>{$_GET['name']}</name>";
    //header("HTTP/1.0 404 Not Found");exit; //forçando o php a dar a msg de erro
    $data = listAll();
    echo json_encode($data);exit;
}
if($_POST){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $date = $_POST['date'];
    
    if($name == ""){
         echo json_encode(["status"=>false,"msg"=>"Preencha o campo nome"]);exit;
    }
    if($email == ""){
         echo json_encode(["status"=>false,"msg"=>"Preencha o campo e-mail"]);exit;
    }
    if($tel == ""){
         echo json_encode(["status"=>false,"msg"=>"Preencha o campo telefone"]);exit;
    }
     if($date == ""){
         echo json_encode(["status"=>false,"msg"=>"Preencha o campo Data"]);exit;
    }

    $id = save($_POST);
    if($id){
        $data = find($id);
          echo json_encode(["status"=>true,"msg"=>"Success! ID:{$id}","contatos"=>$data]);exit;
    }else{
          echo json_encode(["status"=>false,"msg"=>"Error Db!"]);exit;
    }

    echo json_encode(["status"=>true,"msg"=>"Success!"]);exit;
    //var_dump($_POST);exit;
}

function conn()
{
    $conn = new \PDO("mysql:host=localhost;dbname=curso_ajax","root","");
    return $conn;
}

function save($data)
{
    $db = conn();
    $query ="insert into `contatos` (`name`, `email`, `tel`, `date`) VALUES (:name, :email, :tel, :date)";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':name',$data['name']);
    $stmt->bindValue(':email',$data['email']);
    $stmt->bindValue(':tel',$data['tel']);
     $stmt->bindValue(':date',$data['date']);
    $stmt->execute();
    return $db->lastInsertId();
}


function listAll()
{
    $db = conn();
    $query ="select * from `contatos` order by id DESC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

function find($id){
    $db = conn();
    $query ="select * from `contatos` where id=:id";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':id',$id);
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}


?>