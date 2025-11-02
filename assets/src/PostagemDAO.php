<?php
require_once "ConexaoBD.php";

class PostagemDAO
{
    public static function cadastrarPost($idusuario, $idarea, $foto, $legenda)
    {
        $conexao = ConexaoBD::conectar();

        $sql = "INSERT INTO postagem (idusuario, idarea, foto, legenda, data_p)
                VALUES (?, ?, ?, ?, NOW())";

        $stmt = $conexao->prepare($sql);
        $stmt->execute([$idusuario, $idarea, $foto, $legenda]);
    }

      public static function listarPosts($filtroArea = null)
    {
        $conexao = ConexaoBD::conectar();

        $sql = "SELECT p.*, u.nome_u, a.nome_a 
                FROM postagem p
                LEFT JOIN usuario u ON p.idusuario = u.idusuario
                LEFT JOIN areaespecializacao a ON p.idarea = a.idarea";

        if ($filtroArea) {
            $sql .= " WHERE p.idarea = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->execute([$filtroArea]);
        } else {
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
