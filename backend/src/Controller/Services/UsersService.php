<?php

  namespace Src\Controller\Services;

  use Src\Model\User;

  //classe de serviço de envio de dados, referente a tabela de usuários denominada 'users'

  class UsersService {
    //método responsável por fazer buscas de usuário na tabela, se receber o id retorna o usuário correspondente, se não retorna todos
    public function getUsers(int $id = null) {
      if($id == null)
        //rota: http://localhost/blegon/backend/api/users método de requisição GET
        return User::selectAll();
      else
        //rota: http://localhost/blegon/backend/api/users/(id) método de requisição GET
        return User::select($id);
    }

    //rota: http://localhost/blegon/backend/api/users método POST, podendo receber arquivos JSON pelo body
    //método responsável por inserir um usuário na tabela por meio do método de requisição POST, podendo ser por meio de um envio de form ou de um arquivo do tipo JSON pelo body
    public function postUsers() {
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
        return User::insert($data);
      else
        throw new \Exception("Dados insuficientes para inserção de usuário.");
    }

    //rota: http://localhost/blegon/backend/api/users/(id) método POST com a chave '_method' = 'delete'
    //método responsável por remover um usuário da tabela por meio do método de requisição POST
    public function deleteUsers(int $id) {
      //continua somente executa se o parâmetro $id existir e for um número
      if ($id === null || !is_numeric($id))
        throw new \Exception("ID inválido.");
        
      //continua somente se o usuário de id correspondente existir
      $user = User::select($id);
      if ($user === null) 
        throw new \Exception("Usuário(a) não encontrado(a).");
        
      //faz a deleção do usuário correspondente
      return User::delete($id);
    }

    //http://localhost/blegon/backend/api/users/(id) método POST com a chave '_method' = 'put'
    //método responsável por atualizar os dados de um usuário da tabela, por meio do método de requisição POST
    public function putUsers(int $id) {
      //caso receba dados por envio de form
      $data = $_POST;

      //consulta primeiramente se o usuário existe no banco de dados
      $user = User::select($id);

      //se a variável do tipo array $data possuir 4 elementos (junto com o _method), faz a inserção dos dados no banco de dados
      if($data != null)
        return User::update($id, $data);
      else
        throw new \Exception("Dados insuficientes para atualização de usuário.");
    }
  }