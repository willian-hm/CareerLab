<?php
class Util
{
    public static function salvarFoto($arquivoFoto)
    {
        $diretorioUpload = __DIR__ . "/../../uploads/"; // Caminho relativo ao projeto

        // Cria o diretório se não existir
        if (!is_dir($diretorioUpload)) {
            mkdir($diretorioUpload, 0755, true);
        }

        if ($arquivoFoto && $arquivoFoto['error'] === UPLOAD_ERR_OK) {
            $arquivoTmp = $arquivoFoto['tmp_name'];
            $nomeOriginal = basename($arquivoFoto['name']);
            $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

            // Gera um nome único
            $nomeUnico = uniqid("img_", true) . "." . $extensao;
            $caminhoFinal = $diretorioUpload . $nomeUnico;

            if (move_uploaded_file($arquivoTmp, $caminhoFinal)) {
                return $nomeUnico; // retorna só o nome do arquivo
            }
        }

        return null; // se não houver arquivo enviado
    }
}
