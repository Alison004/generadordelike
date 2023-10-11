<?php

// Importar el archivo de funciones
require_once "functions.php";

// Obtener los datos del usuario
$username = $_POST["username"];
$post_url = $_POST["post_url"];
$amount = $_POST["amount"];

// Generar los likes
$likes = get_likes($username, $post_url, $amount);

// Imprimir los resultados
echo "Se generaron {$likes} likes.";

?>


<?php

function get_likes($username, $post_url, $amount) {
  // Seguir al usuario que está interesado en el contenido de la publicación
  $url = "https://www.instagram.com/graphql/query/?query_id=12345678901234567890";
  $payload = [
    "variables" => [
      "id" => $username,
      "follow" => [
        "user_id" => $username
      ]
    ]
  ];
  $response = requests_post($url, json_encode($payload));
  if ($response->status_code == 200) {
    return 1;
  } else {
    return 0;
  }

  // Dejar un comentario positivo en la publicación
  $url = "https://www.instagram.com/graphql/query/?query_id=12345678901234567890";
  $payload = [
    "variables" => [
      "id" => $post_url,
      "text" => "¡Gran publicación!"
    ]
  ];
  $response = requests_post($url, json_encode($payload));
  if ($response->status_code == 200) {
    return 1;
  } else {
    return 0;
  }
}

// Función para realizar una solicitud HTTP POST
function requests_post($url, $data) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $response = curl_exec($ch);
  curl_close($ch);
  return json_decode($response);
}

?>
