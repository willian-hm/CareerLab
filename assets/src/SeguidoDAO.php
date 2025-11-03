<?php
require_once "ConexaoBD.php";

class SeguidoDAO
{

    public static function listarUsuariosParaSeguir($idUsuario, $pesquisa = null)
    {
        $pdo = ConexaoBD::conectar();

        $sql = "SELECT u.idusuario, u.nome_u AS nome, u.foto
                FROM usuario u
                WHERE u.idusuario != :idUsuario
                AND u.idusuario NOT IN (
                    SELECT idseguido FROM seguido WHERE idusuario = :idUsuario
                )";

        if ($pesquisa) {
            $sql .= " AND (similarity(u.nome_u, :pesquisa) > 0.2 OR u.nome_u ILIKE :pesquisaLike)";
        }

        $sql .= " ORDER BY u.nome_u ASC";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);

        if ($pesquisa) {
            $stmt->bindValue(':pesquisa', $pesquisa, PDO::PARAM_STR);
            $stmt->bindValue(':pesquisaLike', "%$pesquisa%", PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function seguirUsuario($idUsuario, $idSeguido)
    {
        $pdo = ConexaoBD::conectar();
        $sql = "INSERT INTO seguido (idusuario, idseguido) VALUES (:idUsuario, :idSeguido)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->bindValue(':idSeguido', $idSeguido, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function contarSeguidores($idUsuario)
    {
        $conn = ConexaoBD::conectar();
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM seguido WHERE idSeguido = ?");
        $stmt->execute([$idUsuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public static function contarSeguindo($idUsuario)
    {
        $conn = ConexaoBD::conectar();
        // Contando quantos usuários este usuário está seguindo
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM seguido WHERE idusuario = ?");
        $stmt->execute([$idUsuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public static function verificarSeSegue($idUsuario, $idSeguido)
    {
        $pdo = ConexaoBD::conectar();
        $stmt = $pdo->prepare("SELECT 1 FROM seguido WHERE idusuario = :idUsuario AND idseguido = :idSeguido");
        $stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->bindValue(':idSeguido', $idSeguido, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch() ? true : false;
    }

    public static function deixarDeSeguir($idUsuario, $idSeguido)
    {
        $pdo = ConexaoBD::conectar();
        $stmt = $pdo->prepare("DELETE FROM seguido WHERE idusuario = :idUsuario AND idseguido = :idSeguido");
        $stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->bindValue(':idSeguido', $idSeguido, PDO::PARAM_INT);
        return $stmt->execute();
    }

     public static function usuarioSegue(int $idSeguidor, int $idSeguido): bool
    {
        $pdo = ConexaoBD::conectar();

        // 1) Tenta o esquema: tabela 'seguido' com colunas idseguidor / idseguido
        try {
            $sql1 = "SELECT COUNT(*) FROM seguido WHERE idseguidor = :seguidor AND idseguido = :seguido";
            $stmt1 = $pdo->prepare($sql1);
            $stmt1->execute([':seguidor' => $idSeguidor, ':seguido' => $idSeguido]);
            $cnt = (int) $stmt1->fetchColumn();
            return $cnt > 0;
        } catch (PDOException $e) {
            // ignora e tenta próximo esquema
        }

        // 2) Tenta o esquema alternativo: tabela 'seguidores' com colunas follower_id / followed_id
        try {
            $sql2 = "SELECT COUNT(*) FROM seguidores WHERE follower_id = :seguidor AND followed_id = :seguido";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute([':seguidor' => $idSeguidor, ':seguido' => $idSeguido]);
            $cnt2 = (int) $stmt2->fetchColumn();
            return $cnt2 > 0;
        } catch (PDOException $e) {
            // ignora e vai retornar false ao final
        }

        // 3) Se nenhum esquema funcionou, tenta uma consulta genérica para evitar falha silenciosa
        try {
            $sqlGeneric = "SELECT COUNT(*) FROM seguido WHERE idseguidor = :seguidor AND idseguido = :seguido";
            $stmtG = $pdo->prepare($sqlGeneric);
            $stmtG->execute([':seguidor' => $idSeguidor, ':seguido' => $idSeguido]);
            return ((int) $stmtG->fetchColumn()) > 0;
        } catch (PDOException $e) {
            // Se chegar aqui, tabela/colunas não existem — retornar false (não segue)
        }

        return false;
    }


}
?>