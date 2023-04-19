<?php

  namespace Src\Controller\Services;

  use Src\Model\Customer;

  //classe de serviço de envio de dados, referente a tabela de usuários denominada 'customers'

  class CustomersService {
    //método responsável por fazer buscas de clientes na tabela, se receber o id retorna o cliente correspondente, se não retorna todos
    public function getCustomers(int $id = null) {
      if($id == null)
        //rota: http://localhost/blegon/backend/api/customers método de requisição GET
        return Customer::selectAll();
      else
      //rota: http://localhost/blegon/backend/api/customers/(id) método de requisição GET
        return Customer::select($id);
    }

    //rota: http://localhost/blegon/backend/api/customers/orderbysex método de requisição GET
    //método responsável por consultar todos os clientes e agrupar por sexo, e mostrar a idade média de cada sexo
    public function getCustomersOrderbysex() {
      return Customer::selectAllBySex();
    }

    //rota: http://localhost/blegon/backend/api/customers método de requisição POST, podendo receber arquivos do tipo JSON pelo body
    //método responsável por inserir um cliente na tabela
    public function postCustomers() {
      if($_POST)
        $data = $_POST;
      else{
        //leitura dos dados do body
        $json = file_get_contents('php://input');

        //json encode dos dados do body, sendo passados para a variável de dados
        $data = json_decode($json, true);
      }

      //execução da função de inserção com os dados do body se tiver os quatro elementos disponíveis
      if(count($data) === 3)
        return Customer::insert($data);
      else
        throw new \Exception("Dados insuficientes para inserção de cliente.");
    }

    //rota: http://localhost/blegon/backend/api/customers/(id) método de requisição POST, com a chave 'method' = 'delete'
    //método responsável por remover um cliente da tabela
    public function deleteCustomers(int $id) {
      //se o id existir e for um número
      if ($id === null || !is_numeric($id))
        throw new \Exception("ID inválido.");
        
      //testa se existe um cliente com o id recebido antes de deletá-lo
      $customer = Customer::select($id);

      //faz a deleção do cliente correspondente
      return Customer::delete($id);
    }

    //rota: http://localhost/blegon/backend/api/customers/(id) método de requisição POST, com a chave 'method' = 'put'
    //método responsável por atualizar os dados de um cliente do bando de dados
    public function putCustomers(int $id) {
      $data = $_POST;

      //consulta primeiramente se o cliente existe no banco de dados
      $customer = Customer::select($id);

      //se a variável do tipo array $data possuir 3 elementos (mais com o _method), faz a inserção dos dados no banco de dados
      if($data != null)
        return Customer::update($id, $data);
      else
        throw new \Exception("Dados insuficientes para atualização de cliente.");
    }
  }