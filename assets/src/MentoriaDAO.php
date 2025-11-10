<?php
require_once "ConexaoBD.php";

class MentoriaDAO
{
    public static function cadastrar($dados, $idmentor)
    {
        $conexao = ConexaoBD::conectar();

        // Validação básica
        if (empty($dados['titulo']) || empty($dados['descricao']) || empty($dados['idarea'])) {
            throw new Exception("Preencha todos os campos obrigatórios.");
        }

        $sql = "INSERT INTO mentoria 
                    (titulo, descricao, idarea, data, horario, mentor_id, vaga_limite, local, status)
                VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?, 'ativa')";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            $dados['titulo'],
            $dados['descricao'],
            $dados['idarea'],
            $dados['data'],
            $dados['horario'],
            $idmentor,
            $dados['vaga_limite'],
            $dados['local']
        ]);

        return true;
    }

    public static function listarPorMentor($idmentor)
    {
        $conexao = ConexaoBD::conectar();

        $sql = "SELECT m.*, a.nome_a AS nome_area 
                FROM mentoria m
                LEFT JOIN areaespecializacao a ON m.idarea = a.idarea
                WHERE m.mentor_id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$idmentor]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function editar($dados)
    {
        $conexao = ConexaoBD::conectar();

        $sql = "UPDATE mentoria 
            SET titulo = ?, descricao = ?, idarea = ?, data = ?, horario = ?, vaga_limite = ?, local = ?, status = ?
            WHERE idmentoria = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            $dados['titulo'],
            $dados['descricao'],
            $dados['idarea'],
            $dados['data'],
            $dados['horario'],
            $dados['vaga_limite'],
            $dados['local'],
            $dados['status'],
            $dados['idmentoria']
        ]);

        return true;
    }

    public static function buscarPorId($id)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT * FROM mentoria WHERE idmentoria = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function excluir($idmentoria)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "DELETE FROM mentoria WHERE idmentoria = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$idmentoria]);
        return true;
    }

    public static function listarInscritos($idmentoria)
    {
        $conexao = ConexaoBD::conectar();

        $sql = "SELECT u.idusuario, u.nome_u, u.email_u, u.exp
            FROM inscrevermentoria i
            JOIN usuario u ON u.idusuario = i.idusuario
            WHERE i.idmentoria = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$idmentoria]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }






}
