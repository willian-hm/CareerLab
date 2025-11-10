<?php
require_once "ConexaoBD.php";

class DesafioDAO
{
    public static function cadastrar($dados, $idempresa)
    {
        $conexao = ConexaoBD::conectar();

        $sql = "INSERT INTO desafio (idempresa, nomedesafio, orientacaodesafio, vagaslimite)
                VALUES (?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            $idempresa,
            $dados['nomedesafio'],
            $dados['orientacaodesafio'],
            $dados['vagaslimite']
        ]);
    }

    public static function listarPorEmpresa($idempresa)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT * FROM desafio WHERE idempresa = ? ORDER BY datacriacao DESC";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$idempresa]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarTodos()
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT * FROM desafio ORDER BY datacriacao DESC";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarNaoInscritos($idusuario)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT d.* 
            FROM desafio d
            WHERE d.iddesafio NOT IN (
                SELECT iddesafio FROM inscricaodesafio WHERE idusuario = ?
            )
            ORDER BY d.datacriacao DESC";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$idusuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
