<?php

  namespace Src\Model;

  //uso de classes de excessões e de PDO para comunicação com bancos de dados 
  use PDO;
  use Exception;
  use PDOException;

  class Car {
    //nome da tabela
    private static $table = 'cars';
    //os "targets" ou itens desejados por padrão nas buscas
    private static $queryTargets = 'cars.id AS id, cars.model AS modelo, cars.brand AS marca, cars.year AS ano, cars.owner_id AS dono';

    //função para selecionar um carro específico do banco de dados
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
          throw new \Exception("Carro não encontrado.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }

    //função para retornar todos os carros do banco de dados ordenados por id
    public static function selectAll() {
      try{
        //definição dos parâmetros de conexão
        $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //montagem e execução da estrutura da consulta
        $sql = 'SELECT '.self::$queryTargets.' FROM '.self::$table.' ORDER BY id';
        $query = $conn->prepare($sql);
        $query->execute();

        //se a query tiver algum resultado
        if($query->rowCount() > 0)
          return $query->fetchAll(\PDO::FETCH_ASSOC);
        else
          throw new \Exception("Nenhum carro encontrado.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }

    //função que retorna os carros por cliente em uma lista ordenada pelo nome do cliente
    public static function selectAll_OrderByOwnerName() {
      try{
        //definição dos parâmetros de conexão
        $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        //montagem e execução da estrutura da consulta
        $sql = 
        'SELECT customers.name AS "cliente", COUNT(*) AS qtd'.
        ' FROM '.self::$table.
        ' INNER JOIN customers ON cars.owner_id = customers.id'.
        ' GROUP BY customers.name'.
        ' ORDER BY customers.name DESC';
        $query = $conn->prepare($sql);
        $query->execute();

        //se a query tiver algum resultado
        if($query->rowCount() > 0)
          return $query->fetchAll(\PDO::FETCH_ASSOC);
        else
          throw new \Exception("Nenhum cliente ou carro encontrado.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }

    //função para retornar, dos clientes, qual sexo tem mais carros, e quantos carros possui
    public static function selectCountCars_OrderByNumber_GroupBySex() {
      try{
        //definição dos parâmetros de conexão
        $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //montagem e execução da estrutura da consulta
        $sql = 
        'SELECT customers.sex AS sexo, COUNT(cars.owner_id) AS numero_carros'.
        ' FROM customers'.
        ' INNER JOIN '.self::$table.' ON customers.id = cars.owner_id'.
        ' GROUP BY sexo'.
        ' ORDER BY numero_carros DESC'.
        ' LIMIT 2';
        $query = $conn->prepare($sql);
        $query->execute();

        //se a query tiver algum resultado
        if($query->rowCount() > 0)
          return $query->fetchAll(\PDO::FETCH_ASSOC);
        else
          throw new \Exception("Nenhum cliente ou carro encontrado.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }

    //função que retorna todas as marcas de carros, ordenadas pelo número de carros de cada marca
    public static function selectBrands_SortByCarsNumber() {
      try{
        //definição dos parâmetros de conexão
        $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //montagem e execução da estrutura da consulta
        $sql = 
        'SELECT cars.brand, COUNT(*) AS numero_carros'.
        ' FROM '.self::$table.
        ' GROUP BY cars.brand'.
        ' ORDER BY numero_carros DESC';
        $query = $conn->prepare($sql);
        $query->execute();

        //se a query tiver algum resultado
        if($query->rowCount() > 0)
          return $query->fetchAll(\PDO::FETCH_ASSOC);
        else
          throw new \Exception("Nenhum carro encontrado.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }

    //função que retorna o total de cada marca de carro, separado por sexo
    public static function selectBrands_SortByCarsNumber_GroupBySex() {
      try{
        //definição dos parâmetros de conexão
        $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //montagem e execução da estrutura da consulta
        $sql = 
        'SELECT cars.brand AS marca, customers.sex AS sexo, COUNT(*) AS count_cars'.
        ' FROM '.self::$table.
        ' INNER JOIN customers ON cars.owner_id = customers.id'.
        ' GROUP BY cars.brand, customers.sex'.
        ' ORDER BY count_cars DESC';
        $query = $conn->prepare($sql);
        $query->execute();

        //se a query tiver algum resultado
        if($query->rowCount() > 0)
          return $query->fetchAll(\PDO::FETCH_ASSOC);
        else
          throw new \Exception("Nenhum cliente ou carro encontrado.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }

    //função para inserir um registro na tabela, por meio do conteúdo do array $data
    public static function insert($data) {
      try{
        //caso a função receba todos os parâmetros necessários para inserção de dados
        if($data['model'] && $data['brand'] && $data['year'] && $data['owner_id']){
          //definição dos parâmetros de conexão
          $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          //montagem e execução da estrutura da consulta
          $sql = 'INSERT INTO '.self::$table.' (model, brand, year, owner_id) VALUES (:model, :brand, :year, :owner_id)';
          $query = $conn->prepare($sql);
          $query->bindValue(':model', $data['model']);
          $query->bindValue(':brand', $data['brand']);
          $query->bindValue(':year', $data['year']);
          $query->bindValue(':owner_id', $data['owner_id']);
          $query->execute();

          //se a query tiver algum resultado
          if($query->rowCount() > 0) {
            return "valores: ".$data['model'];
          } else
            throw new \Exception("Falha na inserção.");
        } else
          throw new \Exception("Campos insuficientes para inserir.");
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
          return "Carro removido com sucesso";
        else
          throw new \Exception("Carro não encontrado.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }

    //função para atualizar os valores de um registro da tabela por meio do id, com o conteúdo do array $data
    public static function update($id, $data) {
      try{
        //verificação de campos
        $requiredFields = ['model', 'brand', 'year', 'owner_id'];
        foreach ($requiredFields as $field) {
          if (empty($data[$field]))
            throw new \Exception("Todos os campos são obrigatórios. Preencha-os corretamente");
        }
        if (!is_numeric($data['year'])) {
          throw new \Exception("O campo de ano de fabricação deve ser um número.");
        }
        if (!is_numeric($data['owner_id'])) {
          throw new \Exception("O campo de proprietário do veículo deve ser um número.");
        }

        //caso a função receba todos os parâmetros necessários para inserção de dados
        if($data['model'] && $data['brand'] && $data['year'] && $data['owner_id']){
          //definição dos parâmetros de conexão
          $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          //montagem e execução da estrutura da consulta
          $sql =
          'UPDATE '.self::$table.
          ' SET model = :model, brand = :brand, year = :year, owner_id = :owner_id'.
          ' WHERE id = :id';
          $query = $conn->prepare($sql);
          //bind dos valores para o conteúdo de $data
          $query->bindValue(':model', $data['model']);
          $query->bindValue(':brand', $data['brand']);
          $query->bindValue(':year', $data['year']);
          $query->bindValue(':owner_id', $data['owner_id']);
          $query->bindValue(':id', $id);
          $query->execute();

          //se a query tiver algum resultado
          if($query->rowCount() > 0) {
            return "Carro atualizado com sucesso.";
          } else
            throw new \Exception("Falha na atualização.");
        } else
            throw new \Exception("Campos insuficientes para atualizar.");
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro na requisição. Código: ".$e->getCode());
      }
    }
  }
  