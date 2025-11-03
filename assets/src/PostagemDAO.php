<?php
require_once "ConexaoBD.php";

class PostagemDAO
{
    // Cadastrar nova postagem
    public static function cadastrarPost($idusuario, $idarea, $foto, $legenda)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "INSERT INTO postagem (idusuario, idarea, foto, legenda, data_p)
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$idusuario, $idarea, $foto, $legenda]);
    }

    // Listar todas as postagens (com filtro opcional por área)
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

    // Listar postagens de um usuário específico
    public static function listarPorUsuario($idusuario)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT p.*, 
                       u.nome_u AS nome_usuario, 
                       u.foto AS foto_usuario, 
                       a.nome_a AS area 
                FROM postagem p
                LEFT JOIN usuario u ON p.idusuario = u.idusuario
                LEFT JOIN areaespecializacao a ON p.idarea = a.idarea
                WHERE p.idusuario = ?
                ORDER BY p.data_p DESC";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$idusuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar postagem por ID (para modal ou detalhes)
    public static function buscarPostPorId($idpostagem)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT p.*, 
                       u.nome_u AS nome_usuario, 
                       u.foto AS foto_usuario,
                       a.nome_a AS area
                FROM postagem p
                LEFT JOIN usuario u ON p.idusuario = u.idusuario
                LEFT JOIN areaespecializacao a ON p.idarea = a.idarea
                WHERE p.idpostagem = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$idpostagem]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($post) {
            // Curtidas
            $stmtC = $conexao->prepare("SELECT COUNT(*) as total FROM curtida WHERE idpostagem = ?");
            $stmtC->execute([$idpostagem]);
            $post['curtidas'] = (int) $stmtC->fetch(PDO::FETCH_ASSOC)['total'];

            // Comentários
            $stmtCom = $conexao->prepare("
                SELECT c.*, u.nome_u AS nome_usuario 
                FROM comentario c
                LEFT JOIN usuario u ON c.idusuario = u.idusuario
                WHERE c.idpostagem = ? 
                ORDER BY c.data_c ASC
            ");
            $stmtCom->execute([$idpostagem]);
            $post['comentarios'] = $stmtCom->fetchAll(PDO::FETCH_ASSOC);
        }

        // Garantir valores padrão caso algo esteja nulo
        $post['foto_usuario'] = $post['foto_usuario'] ?? 'padrao.png';
        $post['nome_usuario'] = $post['nome_usuario'] ?? 'Usuário';
        $post['area'] = $post['area'] ?? 'Sem área';
        $post['curtidas'] = $post['curtidas'] ?? 0;
        $post['comentarios'] = $post['comentarios'] ?? [];

        return $post;
    }

    // Excluir postagem (apenas do usuário dono)
    public static function excluirPorUsuario($idUsuario, $idPostagem)
    {
        $conexao = ConexaoBD::conectar();
        $stmt = $conexao->prepare("DELETE FROM postagem WHERE idpostagem = :id AND idusuario = :idusuario");
        return $stmt->execute([':id' => $idPostagem, ':idusuario' => $idUsuario]);
    }
}
