<?php
require "vendor/autoload.php";

use GuzzleHttp\Client;

function getBooks() {
    $token = '710eb13c3897072bc29d169f7c4c388153f7b94257ec2098df60b4f17f4d943a1d5fb86f541a51bd92feee79ebb6283477c0ba5c949e4bb1d51b8b9c89ec7bc1163f773c3d6f116fe3a1e093d8ac08b422eca8249c963129781428367d32b4edd74e88c8575899240b6e6ee6b74da03852570aed6086860fde84762d8c2f26bf';

    try {
        $client = new Client([
            'base_uri' => 'http://localhost:1337/api/'
        ]);
    
        $headers = [
          'Authorization' => 'Bearer ' . $token,        
          'Accept'        => 'application/json',
      ];
  
      $response = $client->request('GET', 'books?pagination[pageSize]=66', [
          'headers' => $headers
      ]);
    
        $body = $response->getBody();
        $decoded_response = json_decode($body);
        return $decoded_response;
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo '<pre>';
        var_dump($e);
    }
    return null; 
}

$books = getBooks();
?>

<html>
    <head>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <title>BOOKS IN THE BIBLE</title>
    </head>
    <body style="background-color:white">
        <div class = "container">
            <h1 style = "padding-bottom: 20px; color:black">SCRIPTURE BOOK LIST</h1> 
            <div class = "row">
                <div class = "col-10">
                    <table class="table table-border table-striped">
                        <tr class="table-info">
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Author</th>
                            <th scope="col">Category</th>
                        </tr>
                        <?php
                            foreach($books->data as $bookData) {
                            $book = $bookData->attributes;
                        ?>
                        <tr>
                            <th scope="row"><?php echo $bookData->id; ?></td>
                            <td><?php echo $book->name; ?></td>
                            <td><?php echo $book->author; ?></td>
                            <td><?php echo $book->category; ?></td>
                        </tr>
                        
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>