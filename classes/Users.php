<?php
include("conexao/conexao.php");

$db = new Database();

class User{

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function register($nome, $email, $senha, $confSenha)
    {
        if(strlen($senha)<8){
            print"<script>alert('A senha deve conter ao menos 8 caracteres')</script>";
        }
        if($senha == $confSenha){

            $emailExistente = $this->verifyEmail($email);
            $nomeExistente = $this->verifyName($nome);
            if($emailExistente){
                print "<script>alert('Email ja cadastrado')</script>";
                return false;
            }
            if($nomeExistente){
                print "<script>alert('Nome ja cadastrado')</script>";
                return false;
            }

        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
   
        $sql = "INSERT INTO trab2crud (nome, email, senha) VALUES (?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt -> bindValue(1, $nome);
        $stmt -> bindValue(2, $email);
        $stmt -> bindValue(3, $senhaCriptografada);
        $result = $stmt -> execute();

        return $result;

        }else{
            return false;
        }
    }

    private function verifyEmail($email){
        $sql = "SELECT COUNT(*) FROM trab2crud WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1,$email);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    private function verifyName($nome){
        $sql = "SELECT COUNT(*) FROM trab2crud WHERE nome = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1,$nome);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    public function login($nome, $senha){
        $sql = "SELECT * FROM trab2crud WHERE nome = :nome";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':nome',$nome);
        $stmt->execute();

        if($stmt->rowCount() ==1){
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($senha, $usuario['senha'])){
                return true;
            }
        }

    return false;
    }

    
    public function readOne($id){
        $sql = "SELECT * FROM trab2crud where id= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }

    public function IDVerify($nome){
        $sql = "SELECT id AS idverify FROM trab2crud WHERE nome = ? ";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindValue(1, $nome);   
        $stmt->execute();
        if(!$idzinho=$stmt->fetch(PDO::FETCH_ASSOC)){
            return null;
        }else{
        return $idzinho['idverify'];
        }
    }


    


    public function update($postValues){
        $id = $postValues['id'];
        $nome  = $postValues['nome'];
        $email = $postValues['email'];
        $senha = $postValues['senha'];
        if(empty($nome) || empty($email) || empty($senha)){
            return false;
        }
            
            if(strlen($senha)<8){
                print "<script>alert('Senha deve contar mais de 8 caracteres')</script>";
                return false;

            }
        

        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

        $query = "UPDATE trab2crud SET nome = ?, email = ?, senha = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$nome);
        $stmt->bindParam(2,$email);
        $stmt->bindParam(3,$senhaCriptografada);
        $stmt->bindParam(4,$id);
        
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    public function read(){
        $query = "SELECT * FROM trab2crud";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }





}