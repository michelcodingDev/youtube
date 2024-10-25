<html>
    <head>
        <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-Q7Z65SZR8F"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-Q7Z65SZR8F');
</script>
        <title> API Youtube </title>
        <link rel="stylesheet" href="css/style.css">
        <meta charset="utf-8">
    </head>
    <body>
        <div class="container">
            <div class="col">
                <h1>Download MP3</h1>
                <form  method="post">
                    <input type="text" name="url" required>
                    <input type="submit" name="enviar" value="Faça download agora">
                    <?php

                    require 'vendor/autoload.php'; 

                    use GuzzleHttp\Client;

                    // Função para validar se a URL fornecida é um link do YouTube
                    function validarUrlYoutube($url) {
                        return preg_match('/^https:\/\/(www\.)?youtube\.com\/watch\?v=[\w-]+/', $url);
                    }

                    function baixarMp3($videoUrl) {
                        $client = new Client();

                        try {
                            // Fazer a requisição GET para a API
                            $response = $client->request('GET', 'https://youtube-mp3-downloader2.p.rapidapi.com/ytmp3/ytmp3/long_video.php', [
                                'query' => [
                                    'url' => $videoUrl
                                ],
                                'headers' => [
                                    'x-rapidapi-host' => 'youtube-mp3-downloader2.p.rapidapi.com',
                                    'x-rapidapi-key'  => '0a719a7cffmsh0059c33005ad54bp18e09cjsna9cdb1cfc100' // Substituir pela tua API key
                                ]
                            ]);

                            // Verificar o código de status da resposta
                            if ($response->getStatusCode() == 200) {
                                // Obter o corpo da resposta
                                $data = json_decode($response->getBody(), true);

                            
                                if (isset($data['dlink'])) {
                                    // Exibir o link de download
                                
                                    echo "Link para download do MP3: <a href='{$data['dlink']}'>Baixar MP3</a>";
                                } else {
                                    echo "Erro: Não foi possível obter o link do MP3.";
                                }
                            } else {
                                echo "Erro: Código HTTP " . $response->getStatusCode();
                            }
                        } catch (Exception $e) {
                            echo 'Erro ao fazer a requisição: ' . $e->getMessage();
                        }
                    }

                    if (isset($_POST['url']) && !empty($_POST['url'])) {
                        $videoUrl = $_POST['url'];

                        // Validar se a URL fornecida é do YouTube
                        if (validarUrlYoutube($videoUrl)) {
                            // Chamar a função para baixar o MP3
                            baixarMp3($videoUrl);
                        } else {
                            echo "Erro: Por favor, insira uma URL válida do YouTube.";
                        }
                    } else {
                        echo "Preencha o campo URL.";
                    }

                    ?>

                </form>
            </div>
        </div>
        <footer>Desenvolvido por: Michel</footer>
    </body>
</html>
