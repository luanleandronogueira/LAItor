<?php

function getResponseFromHuggingFace($text) {
    $apiKey = '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'; // Substitua pela sua chave de API
    $url = 'https://api-inference.huggingface.co/models/gpt2';
    

    // Prepare os dados para a requisição
    $data = json_encode(['inputs' => $text]);

    // Configure as opções do contexto para a requisição HTTP
    $options = [
        'http' => [
            'header'  => [
                "Content-Type: application/json",
                "Authorization: Bearer $apiKey"
            ],
            'method'  => 'POST',
            'content' => $data,
        ],
    ];
    $context  = stream_context_create($options);

    // Envie a requisição e obtenha a resposta
    $result = file_get_contents($url, false, $context);

    // Verifique se houve erro na requisição
    if ($result === FALSE) {
        return 'Erro ao acessar a API.';
    }

    // Retorne a resposta decodificada
    $response = json_decode($result, true);
    return $response[0]['generated_text'] ?? 'Sem resposta.';
}

// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['texto'])) {
    $texto = trim($_POST['texto']);
    $resultado = getResponseFromHuggingFace($texto);
} else {
    $resultado = 'Nenhum texto enviado.';
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resposta da API</title>
</head>
<body>
    <h1>Resposta da API</h1>
    <strong>Texto enviado:</strong><br>
    <p><?php echo nl2br(htmlspecialchars($texto)); ?></p>
    <strong>Resposta:</strong><br>
    <p><?php echo nl2br(htmlspecialchars($resultado)); ?></p>
    <a href="index.php">Voltar</a>
</body>
</html>