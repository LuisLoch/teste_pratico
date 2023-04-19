<?php

  namespace Src\Controller\Services;

  use Src\Model\Review;

  use DateTime;

  //classe de serviço de envio de dados, referente a tabela de usuários denominada 'reviews'

  class ReviewsService {
    //método responsável por fazer buscas de revisões na tabela, se receber o id retorna a revisão correspondente, se não retorna todas
    public function getReviews(int $id = null) {
      if($id == null)
        //rota: http://localhost/blegon/backend/api/reviews método de requisição GET
        return Review::selectAll();
      else
        //rota: http://localhost/blegon/backend/api/reviews/(id) método de requisição GET
        return Review::select($id);
    }

    //rota: http://localhost/blegon/backend/api/reviews/inperiod/(YYYY-mm-dd_YYYY-mm-dd) método de requisição GET
    //método responsável por fazer buscas de revisões na tabela, recebendo uma string de intervalo de datas pela URL, ex: '2000-01-01_2023-12-30'
    public function getReviewsInperiod(string $dateRange) {
      $dates = explode('_', $dateRange);

      if(count($dates) != 2 || !strtotime($dates[0]) || !strtotime($dates[1]))
        throw new \Exception("Datas informadas são inválidas");

      //transforma a inicialDate em uma string de data
      $aux = DateTime::createFromFormat('Y-m-d', $dates[0]);
      $inicialDate = $aux->format('Y-m-d');

      //transforma a finalDate em uma string de data
      $aux = DateTime::createFromFormat('Y-m-d', $dates[1]);
      $finalDate = $aux->format('Y-m-d');

      if (!$inicialDate || !$finalDate)
        throw new \Exception("Há algo de errado com o formato das datas.") ;
      else
        return Review::selectReviewsInPeriod($inicialDate, $finalDate); 
    }

    //rota: http://localhost/blegon/backend/api/reviews/brandswithmostreviews método de requisição GET
    //método responsável por fazer uma busca das marcas, onde cada marca tem o número de revisões já feitas
    public function getReviewsBrandswithmostreviews() {
      return Review::selectBrandsWithMostReviews();
    }

    //rota: http://localhost/blegon/backend/api/reviews/customerswithmostreviews método de requisição GET
    //método responsável por fazer uma busca dos clientes que possuem o maior número de revisões
    public function getReviewsCustomerswithmostreviews() {
      return Review::selectCustomersWithMostReviews();
    }

    //rota: http://localhost/blegon/backend/api/reviews/customersaveragetimetoreview método de requisição GET
    //método responsável por fazer uma busca de todos os clientes, com seus respectivos tempos médios de revisão (só funciona com clientes que possuem mais de uma revisão)
    public function getReviewsCustomersaveragetimetoreview() {
      return Review::selectCustomersReviewAverageTime();
    }

    //rota: http://localhost/blegon/backend/api/reviews/customersnextreviewdate método de requisição GET
    //método responsável por retornar todos os clientes, com suas próximas datas de revisão estimadas, desde que já tenham feito pelo menos duas revisões
    public function getReviewsCustomersnextreviewdate() {
      return Review::selectCustomersListNextReviewDate();
    }

    //rota: http://localhost/blegon/backend/api/reviews método de requisição POST
    //método responspavel por fazer uma inserção de revisão na tabela
    public function postReviews() {
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
        return Review::insert($data);
    }

    //rota http://localhost/blegon/backend/api/reviews/(id) método de requisição POST com a chave '_method' = 'delete'
    //método responsável por fazer uma deleção de uma revisão da tabela
    public function deleteReviews(int $id) {
      //se o id existir e for um número
      if ($id === null || !is_numeric($id))
        throw new \Exception("ID inválido.");
        
      //testa se existe uma review com o id recebido antes de deletá-la
      $review = Review::select($id);
        
      //faz a deleção da revisão correspondente
      return Review::delete($id);
    }

    //rota: http://localhost/blegon/backend/api/reviews/(id)
    //método responsável por atualizar as informações de uma review da tabela
    public function putReviews(int $id) {
      $data = $_POST;

      //consulta primeiramente se a revisão existe no banco de dados
      $review = Review::select($id);

      //se a variável do tipo array $data possuir 3 elementos (mais com o _method), faz a inserção dos dados no banco de dados
      if($data != null)
        return Review::update($id, $data);
      else
        throw new \Exception("Dados insuficientes para atualização de cliente.");
    }
  }