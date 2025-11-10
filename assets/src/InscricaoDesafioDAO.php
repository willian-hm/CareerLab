<?php
require_once "ConexaoBD.php";

class InscricaoDesafioDAO
{
    public static function cadastrar($dados)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "INSERT INTO inscricaodesafio (iddesafio, idusuario, linkgit) VALUES (?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$dados['iddesafio'], $dados['idusuario'], $dados['linkgit']]);
    }

    public static function jaInscrito($iddesafio, $idusuario)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT COUNT(*) FROM inscricaodesafio WHERE iddesafio = ? AND idusuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$iddesafio, $idusuario]);
        return $stmt->fetchColumn() > 0;
    }

    public static function listarPorUsuario($idusuario)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT d.*, i.linkgit, i.datainscricao 
                FROM inscricaodesafio i
                JOIN desafio d ON i.iddesafio = d.iddesafio
                WHERE i.idusuario = ?
                ORDER BY i.datainscricao DESC";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$idusuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function cancelar($iddesafio, $idusuario)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "DELETE FROM inscricaodesafio WHERE iddesafio = ? AND idusuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$iddesafio, $idusuario]);
    }
}
