<?php

// rota geral: http://localhost/blegon/backend/api

//conteúdo retornado pelas páginas é do tipo json
header('Content-Type: application/json');

require_once __DIR__.'/vendor/autoload.php';

// Obter o tipo de solicitação HTTP
$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

if ($requestMethod !== 'post' && $requestMethod !== 'get' && $requestMethod !== 'delete' && $requestMethod !== 'update') {
  // Se a solicitação não for GET, POST, DELETE ou UPDATE, retorne um erro 405 - Método não permitido
  http_response_code(405);
  echo json_encode(array('status' => 'error', 'data' => 'Método de requisição não permitido.'), JSON_UNESCAPED_UNICODE);
  exit;
}

//"explode" a url do site a cada barra encontrada, recebida por $url, ou seja, um array com os paths para o site, passando a ser ['api', 'cars']
$url = explode('/', $_GET['url']);

//remove o primeiro elemento do array $url
array_shift($url);

//definição de qual serviço será utilizado por meio do path da URL
$service = 'Src\Controller\Services\\'.ucfirst($url[0]).'Service';

//define que o método será o tipo de requisição + o path usado para acessar, como getCars para  um GET de 'http://localhost/blegon/backend/api/cars', ou postUsers para um POST de'http://localhost/blegon/backend/api/users'
if(isset($_POST['_method']))//se tiver uma chave '_method' no body, ele assume que o método requerido no Service será o definido por ela
  $method = $_POST['_method'].ucfirst($url[0]);
else
  $method = strtolower($_SERVER['REQUEST_METHOD']).ucfirst($url[0]); //method contrói um nome de requisição de serviço, ex: getCars

//caso tenha mais paths após o inicial, ele constrói até 2 adições ao serviço inicial
if(isset($url[1]) && !is_numeric($url[1]) && !ctype_digit(substr($url[1], 0, 1))){
  $method = $method.ucfirst($url[1]);
  if(isset($url[2]) && !is_numeric($url[2]) && !ctype_digit(substr($url[2], 0, 1))){
    $method = $method.ucfirst($url[2]);
  }
}

//remove o primeiro elemento do array $url, passando a ser um array vazio
array_shift($url);

//primeiro checa se a variável está setada (para garantir que não haverão avisos), depois checa se a variável não é do tipo numeric (ou seja, id)
if(isset($url[0]) && !is_numeric($url[0]))
  array_shift($url);

// var_dump("SERVICE ENVIADO: ".$service); //debugação das variáveis
// var_dump("METODO ENVIADO: ".$method);

try {
  //variável $feedback recebe o conteúdo retornado pela chamada de função baseada na URL
  $feedback = call_user_func_array(array(new $service, $method), $url);

  //se der certo, o código de retorno é "OK" e o conteúdo é retornado
  http_response_code(200);
  echo json_encode(array('status' => 'success', 'data' => $feedback), JSON_UNESCAPED_UNICODE);
} catch(\Exception $e) {
  //se não, o código de retorno é "NOT FOUND" e o conteúdo retornado é a mensagem de erro
  http_response_code(400);
  echo json_encode(array('status' => 'error', 'data' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
}