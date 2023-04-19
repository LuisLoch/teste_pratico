<?php

  namespace Src\Model;

  use PDO;
  use Exception;
  use PDOException;

  //classe responsável por ser o modelo interno para o cliente do banco de dados 
  class Customer {
    //nome da tabela
    private static $table = 'customers';
    private static $queryTargets = 'customers.id AS id, customers.name AS nome, customers.birth_date AS data_nasc, customers.sex AS sexo';

    //função para fazer uma consulta específica de cliente
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
          throw new \Exception("Cliente não encontrado.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta.", $e->getCode());
      }
    }

    //função para fazer uma consulta de todos os clientes
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
          throw new \Exception("Nenhum cliente encontrado.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta.", $e->getCode());
      }
    }

    //função para fazer uma consulta de todos os clientes e ordenar o resultado por nome
    public static function selectAllBySex() {
      try{
        //definição dos parâmetros de conexão
        $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //montagem e execução da estrutura da consulta
        $sql =
        'SELECT c.name, c.sex, AVG(DATEDIFF(CURDATE(), c.birth_date) / 365) OVER (PARTITION BY c.sex) AS media_idade'.
        ' FROM '.self::$table.' c'.
        ' ORDER BY c.sex';
        $query = $conn->prepare($sql);
        $query->execute();

        //se a query tiver algum resultado
        if($query->rowCount() > 0) {
          return $query->fetchAll(\PDO::FETCH_ASSOC);
        } else
          throw new \Exception("Nenhum cliente encontrado.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta.", $e->getCode());
      }
    }

    //função para inserir um registro na tabela, por meio do conteúdo do array $data
    public static function insert($data) {
      try{
        if($data['name'] && $data['birth_date'] && $data['sex']){
          //definição dos parâmetros de conexão
          $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          //montagem e execução da estrutura da consulta
          $sql = 'INSERT INTO '.self::$table.' (name, birth_date, sex) VALUES (:name, :birth_date, :sex)';
          $query = $conn->prepare($sql);
          $query->bindValue(':name', $data['name']);
          $query->bindValue(':birth_date', $data['birth_date']);
          $query->bindValue(':sex', $data['sex']);
          $query->execute();

          //se a query tiver algum resultado
          if($query->rowCount() > 0) {
            return "Cliente inserido com sucesso.";
          } else
            throw new \Exception("Falha na inserção.");
        } else {
          throw new \Exception("Campos insuficientes para inserir.");
        }
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro na requisição.", $e->getCode());
      }
    }

    //função para remover um registro da tabela, por meio do id
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
          return "Cliente removido com sucesso";
        else
          throw new \Exception("Cliente não encontrado.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }

    //função para atualizar os valores de um registro da tabel correspondente ao id, por meio do conteúdo do array $data
    public static function update($id, $data) {
      try{
        //verificação de campos
        $requiredFields = ['name', 'birth_date', 'sex'];
        foreach ($requiredFields as $field) {
          if (empty($data[$field])) {
            throw new \Exception("Todos os campos são obrigatórios. Preencha-os corretamente");
          }
        }

        //caso a função receba todos os parâmetros necessários para inserção de dados
        if($data['name'] && $data['birth_date'] && $data['sex']){
          //definição dos parâmetros de conexão
          $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          //montagem e execução da estrutura da consulta
          $sql =
          'UPDATE '.self::$table.
          ' SET name = :name, birth_date = :birth_date, sex = :sex'.
          ' WHERE id = :id';
          $query = $conn->prepare($sql);
          //bind dos valores para o conteúdo de $data
          $query->bindValue(':name', $data['name']);
          $query->bindValue(':birth_date', $data['birth_date']);
          $query->bindValue(':sex', $data['sex']);
          $query->bindValue(':id', $id);
          $query->execute();

          //se a query tiver algum resultado
          if($query->rowCount() > 0) {
            return "Cliente atualizado com sucesso.";
          } else
            throw new \Exception("Falha na atualização.");
          //caso esteja faltando algum dado do body
        } else
          throw new \Exception("Campos insuficientes para atualizar.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro na requisição. Código: ".$e->getCode());
      }
    }
  }