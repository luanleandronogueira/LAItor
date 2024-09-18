<?php
require 'vendor/autoload.php';

use Smalot\PdfParser\Parser;

// Carrega o PDF
$parser = new Parser();
$pdf = $parser->parseFile('https://cloud.it-solucoes.inf.br/transparenciaMunicipal/download/34-202407181835.pdf');

// Extrai o texto
$text = $pdf->getText();

// Exemplo: Busca por palavras-chave no texto
$keywords = 'OBJETO'; // Palavra ou expressão chave

$numero_contrato = 'Nº';


// Usa strpos para buscar onde está a frase ou trecho de interesse
$position = strpos($text, $keywords);
$n = strpos($text, $numero_contrato);

if ($position !== false) {
    // Extrai parte do texto próximo ao termo encontrado
    $extracted_part = substr($text, $n, 300); // 300 caracteres após a palavra-chave
    echo $extracted_part;
} else {
    
    echo "Palavra-chave não encontrada no documento.";
}
?>
