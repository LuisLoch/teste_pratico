<?php

  namespace Src\Controller\Services;

  use Src\Model\Car;

  //classe de serviço de envio de dados, referente a tabela de usuários denominada 'cars'

  class CarsService {
    //método responsável por fazer buscas de carros na tabela, se receber o id retorna o carro correspondente, se não retorna todos
    public function getCars(int $id = null) {
      if($id == null)
        //rota: http://localhost/blegon/backend/api/cars método de requisição GET
        return Car::selectAll();
      else
        //http://localhost/blegon/backend/api/cars/(id) método de requisição GET
        return Car::select($id);
    }

    //rota: http://localhost/blegon/backend/api/cars/orderbyownername método de requisição GET
    //função que retorna os carros por cliente em uma lista ordenada pelo nome do cliente
    public function getCarsOrderbyownername() {
      return Car::selectAll_OrderByOwnerName();
    }

    //rota: http://localhost/blegon/backend/api/cars/whatsexhasmorecars método de requisição GET
    //função para retornar, dos clientes, qual sexo tem mais carros, e quantos carros possui
    public function getCarsWhatsexhasmorecars() {
      return Car::selectCountCars_OrderByNumber_GroupBySex();
    }

    //rota: http://localhost/blegon/backend/api/cars/orderbrandsbycarnumber método de requisição GET
    //função que retorna todas as marcas de carros, ordenadas pelo número de carros de cada marca
    public function getCarsOrderbrandsbycarnumber() {
      return Car::selectBrands_SortByCarsNumber();
    }

    //rota: http://localhost/blegon/backend/api/cars/bybrandssortedbysex método de requisição GET
    //função que retorna o total de cada marca de carro, separado por sexo
    public function getCarsBybrandssortedbysex() {
      return Car::selectBrands_SortByCarsNumber_GroupBySex();
    }

    //rota: http://localhost/blegon/backend/api/cars método de requisição POST, podendo receber arquivos do tipo JSON pelo body
    //método responsável por inserir carros na tabela
    public function postCars() {
      //caso receba dados por envio de form
      if($_POST)
        $data = $_POST;
      //coleta os dados do tipo json (se houver)
      else{
        //leitura dos dados do body
        $json = file_get_contents('php://input');

        //conversão dos dados do body para json, sendo passados para a variável de dados
        $data = json_decode($json, true);
      }

      //execução da função de inserção com os dados do body se tiver os quatro elementos disponíveis
      if(count($data) === 4)
        return Car::insert($data);
    }

    //rota: http://localhost/blegon/backend/api/cars/(id) método de requisição POST, com a chave '_method' = 'delete'
    //método responsável por remover um carro da tabela por meio do método de requisição POST
    public function deleteCars(int $id) {
      //se o id existir e for um número
      if ($id === null || !is_numeric($id))
        throw new \Exception("ID inválido.");
        
      //testa se existe um carro com o id recebido antes de deletá-lo
      $car = Car::select($id);
        
      //faz a deleção do carro correspondente
      return Car::delete($id);
    }
    
    //rota: http://localhost/blegon/backend/api/cars método de requisição POST, com a chave '_method' = 'put'
    //função para atualizar o conteúdo de itens da tabela carros
    public function putCars(int $id) {
      $data = $_POST;

      //consulta primeiramente se o cliente existe no banco de dados
      $car = Car::select($id);

      //se a variável do tipo array $data possuir 3 elementos (mais com o _method), faz a inserção dos dados no banco de dados
      if($data != null)
        return Car::update($id, $data);
      else
        throw new \Exception("Dados insuficientes para atualização de cliente.");
    }
  }