<?php

  namespace Src\Model;

  use PDO;
  use Exception;
  use PDOException;

  //classe responsável por ser o modelo interno para o usuário do banco de dados 
  class User {
    //nome da tabela
    private static $table = 'users';
    //alvos padrão para requisições
    private static $queryTargets = 'users.id AS id, users.username AS nome, users.data_nasc AS data_nasc, users.sexo AS sexo';

    //função para fazer uma consulta específica de usuário
    public static function select(int $id) {
      try{
        //definição dos parâmetros de conexão
        $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //montagem e execução da estrutura da consulta
        $sql = 'SELECT '.self::$queryTargets.' FROM '.self::$table.' WHERE id = :id';
        $query = $conn->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();

        //se a query tiver algum resultado
        if($query->rowCount() > 0)
          return $query->fetch(\PDO::FETCH_ASSOC);
        else
          throw new \Exception("Usuário não encontrado.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
          throw new \PDOException("Houve um erro com a consulta.", $e->getCode());
      }
    }

    //função para fazer uma consulta de todos os usuários
    public static function selectAll() {
      try{
        //definição dos parâmetros de conexão
        $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //montagem e execução da estrutura da consulta
        $sql = 'SELECT '.self::$queryTargets.' FROM '.self::$table;
        $query = $conn->prepare($sql);
        $query->execute();

        //se a query tiver algum resultado
        if($query->rowCount() > 0) {
          return $query->fetchAll(\PDO::FETCH_ASSOC);
        } else
          throw new \Exception("Nenhum usuário encontrado.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta.", $e->getCode());
      }
    }

    //função para inserir um usuário na tabela por meio do array $data
    public static function insert($data) {
      try{
        //caso a função receba todos os parâmetros necessários para inserção de dados
        if($data['username'] && $data['password'] && $data['data_nasc'] && $data['sexo']){
          //definição dos parâmetros de conexão
          $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          //montagem e execução da estrutura da consulta
          $sql = 'INSERT INTO '.self::$table.' (username, password, data_nasc, sexo) VALUES (:username, :password, :data_nasc, :sexo)';
          $query = $conn->prepare($sql);
          $query->bindValue(':username', $data['username']);
          $query->bindValue(':password', $data['password']);
          $query->bindValue(':data_nasc', $data['data_nasc']);
          $query->bindValue(':sexo', $data['sexo']);
          $query->execute();

          //se a query tiver algum resultado
          if($query->rowCount() > 0) {
            return "Usuário(a) inserido(a) com sucesso.";
          } else
            throw new \Exception("Falha na inserção.");
        } else 
          throw new \Exception("Campos insuficientes para inserir.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro na requisição.", $e->getCode());
      }
    }

    //função para remover um usuário da tabela por meio do id
    public static function delete(int $id) {
      //caso o id recebido não seja inteiro ou esteja nulo, encerra a função com uma excessão
      if($id === null || !is_numeric($id))
        throw new \Exception("O id recebido não é válido.");
      
      try{
        //definição dos parâmetros de conexão
        $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
        //montagem e execução da estrutura do comando sql
        $sql =
        ' DELETE '.
        ' FROM '.self::$table.
        ' WHERE id = :id';
        $query = $conn->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();

        //se a query tiver algum resultado
        if($query->rowCount() > 0)
          return $query->fetchAll(\PDO::FETCH_ASSOC);
        else
          throw new \Exception("Usuário não encontrado.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }

    //função para atualizar os dados de um registro da tabela, por meio do campo de id e do conteúdo do array $data
    public static function update($id, $data) {
      try{
        //verificação de campos
        $requiredFields = ['username', 'password', 'data_nasc', 'sexo'];
        foreach ($requiredFields as $field) {
          if (empty($data[$field])) {
            throw new \Exception("Todos os campos são obrigatórios. Preencha-os corretamente");
          }
        }

        //caso a função receba todos os parâmetros necessários para inserção de dados
        if($data['username'] && $data['password'] && $data['data_nasc'] && $data['sexo']){
          //definição dos parâmetros de conexão
          $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          //montagem e execução da estrutura da consulta
          $sql =
          'UPDATE '.self::$table.
          ' SET username = :username, password = :password, data_nasc = :data_nasc, sexo = :sexo'.
          ' WHERE id = :id';
          $query = $conn->prepare($sql);
          //bind dos valores para o conteúdo de $data
          $query->bindValue(':username', $data['username']);
          $query->bindValue(':password', $data['password']);
          $query->bindValue(':data_nasc', $data['data_nasc']);
          $query->bindValue(':sexo', $data['sexo']);
          $query->bindValue(':id', $id);
          $query->execute();

          //se a query tiver algum resultado
          if($query->rowCount() > 0) {
            return "Usuário(a) atualizado(a) com sucesso.";
          } else
            throw new \Exception("Falha na atualização.");
        } else
            throw new \Exception("Campos insuficientes para atualizar.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro na requisição. Código: ".$e->getCode());
      }
    }
  }