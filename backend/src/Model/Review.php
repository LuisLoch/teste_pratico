<?php

  namespace Src\Model;

  use PDO;
  use Exception;
  use PDOException;

  //classe responsável por ser o modelo interno para reviews do banco de dados 
  class Review {
    //nome da tabela
    private static $table = 'reviews';
    //alvos padrão para requisições
    private static $queryTargets = 'id AS id, date_review AS data_review, car_id AS carro_id, description AS descricao, price AS preco';

    //função para retornar uma review da tabela por meio do id
    public static function select($id) {
      try{
        //definição dos parâmetros de conexão
        $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //montagem e execução da estrutura da consulta
        $sql = 'SELECT '.self::$queryTargets.
        ' FROM '.self::$table.
        ' WHERE id = :id';
        $query = $conn->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();

        //se a query tiver algum resultado
        if($query->rowCount() > 0)
          return $query->fetch(\PDO::FETCH_ASSOC);
        else
          throw new \Exception("Revisão não encontrada.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }

    //função para retornar todos os dados da tabela
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
        if($query->rowCount() > 0)
          return $query->fetchAll(\PDO::FETCH_ASSOC);
        else
          throw new \Exception("Nenhuma revisão foi encontrada.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }

    //função para retornar as reviews que ocorreram entre duas datas em forma de string recebidas por parâmetro
    public static function selectReviewsInPeriod(string $inicialDate, string $finalDate) {
      try{
        //definição dos parâmetros de conexão
        $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //montagem e execução da estrutura da consulta
        $sql = 'SELECT '.self::$queryTargets.
        ' FROM '.self::$table.
        ' WHERE date_review >= \''.$inicialDate.
        '\' AND date_review <= \''.$finalDate.'\'';
        $query = $conn->prepare($sql);
        $query->execute();

        //se a query tiver algum resultado
        if($query->rowCount() > 0)
          return $query->fetchAll(\PDO::FETCH_ASSOC);
        else
          throw new \Exception("Revisões não encontradas no período correspondente.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }

    //função para retornar todas as marcas, em ordem decrescente, das marcas que mais possuem revisões registradas
    public static function selectBrandsWithMostReviews() {
      try{
        //definição dos parâmetros de conexão
        $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //montagem e execução da estrutura da consulta
        $sql = 'SELECT cars.brand AS marca, COUNT(reviews.id) AS quantidade_revisoes'.
        ' FROM '.self::$table.
        ' JOIN cars ON cars.id = reviews.car_id'.
        ' GROUP BY cars.brand'.
        ' ORDER BY quantidade_revisoes DESC';
        $query = $conn->prepare($sql);
        $query->execute();

        //se a query tiver algum resultado
        if($query->rowCount() > 0)
          return $query->fetchAll(\PDO::FETCH_ASSOC);
        else
          throw new \Exception("Carros e revisões não encontradas.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }
    
    //função para retornar os clientes que mais possuem revisões efetuadas, em ordem decrescente
    public static function selectCustomersWithMostReviews() {
      try{
        //definição dos parâmetros de conexão
        $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //montagem e execução da estrutura da consulta
        $sql = 'SELECT customers.name AS nome, COUNT(reviews.id) AS quantidade_revisoes'.
        ' FROM '.self::$table.
        ' JOIN cars ON cars.id = reviews.car_id'.
        ' JOIN customers ON customers.id = cars.owner_id'.
        ' GROUP BY customers.name'.
        ' ORDER BY quantidade_revisoes DESC';
        $query = $conn->prepare($sql);
        $query->execute();

        //se a query tiver algum resultado
        if($query->rowCount() > 0)
          return $query->fetchAll(\PDO::FETCH_ASSOC);
        else
          throw new \Exception("Pessoas e revisões não encontradas.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }

    //função para retornar o tempo médio de cada cliente para fazer revisões (em dias)
    public static function selectCustomersReviewAverageTime() {
      try{
        //definição dos parâmetros de conexão
        $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //montagem e execução da estrutura da consulta
        $sql =
        'SELECT media.name, AVG(diff) AS average_time'.
        ' FROM ('.
            ' SELECT customers.name, DATEDIFF(date_review,LAG(date_review) OVER (PARTITION BY customers.name ORDER BY reviews.date_review)) AS diff'.
            ' FROM reviews'.
            ' INNER JOIN cars ON cars.id = reviews.car_id'.
            ' INNER JOIN customers ON customers.id = cars.owner_id'.
            ' ORDER BY customers.id, reviews.date_review'.
        ' ) AS media'.
        ' WHERE diff IS NOT NULL'.
        ' GROUP BY media.name';
        
        $query = $conn->prepare($sql);
        $query->execute();

        //se a query tiver algum resultado
        if($query->rowCount() > 0)
          return $query->fetchAll(\PDO::FETCH_ASSOC);
        else
          throw new \Exception("Pessoas e revisões não encontradas.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }

    //função para retornar as próximas revisões estimadas de cada cliente
    public static function selectCustomersListNextReviewDate() {
      try{
        //definição dos parâmetros de conexão
        $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //montagem e execução da estrutura da consulta
        $sql =
        'SELECT media.name AS nome, DATE_ADD(MAX(date_review), INTERVAL AVG(diff) DAY) AS proxima_review'.
        ' FROM ('.
          ' SELECT customers.name, DATEDIFF(date_review,LAG(date_review) OVER (PARTITION BY customers.name ORDER BY reviews.date_review)) AS diff, date_review'.
          ' FROM reviews'.
          ' INNER JOIN cars ON cars.id = reviews.car_id'.
          ' INNER JOIN customers ON customers.id = cars.owner_id'.
          ' ORDER BY customers.id, reviews.date_review'.
        ') AS media'.
        ' WHERE diff IS NOT NULL'.
        ' GROUP BY media.name';
        
        $query = $conn->prepare($sql);
        $query->execute();

        //se a query tiver algum resultado
        if($query->rowCount() > 0)
          return $query->fetchAll(\PDO::FETCH_ASSOC);
        else
          throw new \Exception("Pessoas e revisões não encontradas.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }

    //função para inserir um dado na tabela por meio do array $data
    public static function insert($data) {
      try{
        if($data['date_review'] && $data['car_id'] && $data['description'] && $data['price']){
          //definição dos parâmetros de conexão
          $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          //montagem e execução da estrutura da consulta
          $sql = 'INSERT INTO '.self::$table.' (date_review, car_id, description, price) VALUES (:date_review, :car_id, :description, :price)';
          $query = $conn->prepare($sql);
          //bind dos valores para o conteúdo de $data
          $query->bindValue(':date_review', $data['date_review']);
          $query->bindValue(':car_id', $data['car_id']);
          $query->bindValue(':description', $data['description']);
          $query->bindValue(':price', $data['price']);
          $query->execute();

          if($query->rowCount() > 0) {
            return "Review inserida com sucesso.";
          } else
            throw new \Exception("Falha na inserção.");
        } else
          throw new \Exception("Campos insuficientes para inserir.");
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro na requisição.", $e->getCode());
      }
    }

    //função para remover um registro da tabela por meio do campo de id
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
          return "Revisão removida com sucesso";
        else
          throw new \Exception("Review não encontrada.");
        //caso ocorra algum erro na requisição
      } catch(\PDOException $e){
        throw new \PDOException("Houve um erro com a consulta. Código: ".$e->getCode());
      }
    }

    //função para atualizar os dados de um registro da tabela por meio do campo de id, e do conteúdo recebido pelo array $data
    public static function update($id, $data) {
      try{
        //verificação de campos
        $requiredFields = ['date_review', 'car_id', 'description', 'price'];
        foreach ($requiredFields as $field) {
          if (empty($data[$field])) {
            throw new \Exception("Todos os campos são obrigatórios. Preencha-os corretamente");
          }
        }

        //caso a função receba todos os parâmetros necessários para inserção de dados
        if($data['date_review'] && $data['car_id'] && $data['description'] && $data['price']){
          //definição dos parâmetros de conexão
          $conn = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          //montagem e execução da estrutura da consulta
          $sql =
          'UPDATE '.self::$table.
          ' SET date_review = :date_review, car_id = :car_id, description = :description, price = :price'.
          ' WHERE id = :id';
          $query = $conn->prepare($sql);
          //bind dos valores para o conteúdo de $data
          $query->bindValue(':date_review', $data['date_review']);
          $query->bindValue(':car_id', $data['car_id']);
          $query->bindValue(':description', $data['description']);
          $query->bindValue(':price', $data['price']);
          $query->bindValue(':id', $id);
          $query->execute();

          //se a query tiver algum resultado
          if($query->rowCount() > 0) {
            return "Revisão atualizada com sucesso.";
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