<?php
require_once "ConexaoBD.php";

class ComentarioDAO {
    public static function adicionarComentario($idusuario, $idpostagem, $conteudo) {
        $pdo = ConexaoBD::conectar();
        $stmt = $pdo->prepare("INSERT INTO comentario (idusuario, idpostagem, conteudo, datahora) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$idusuario, $idpostagem, $conteudo]);
    }

    public static function listarComentarios($idpostagem) {
        $pdo = ConexaoBD::conectar();
        $stmt = $pdo->prepare("
            SELECT c.conteudo, u.nome_u 
            FROM comentario c 
            JOIN usuario u ON c.idusuario = u.idusuario
            WHERE c.idpostagem = ? 
            ORDER BY c.datahora ASC
        ");
        $stmt->execute([$idpostagem]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obterPrimeiroComentario($idpostagem) {
        $pdo = ConexaoBD::conectar();
        $stmt = $pdo->prepare("
            SELECT c.conteudo, u.nome_u 
            FROM comentario c 
            JOIN usuario u ON c.idusuario = u.idusuario
            WHERE c.idpostagem = ?
            ORDER BY c.datahora ASC
            LIMIT 1
        ");
        $stmt->execute([$idpostagem]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function contarComentarios($idpostagem) {
        $pdo = ConexaoBD::conectar();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM comentario WHERE idpostagem = ?");
        $stmt->execute([$idpostagem]);
        return (int)$stmt->fetchColumn();
    }
}
?>
