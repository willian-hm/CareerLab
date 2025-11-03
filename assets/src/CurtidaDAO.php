<?php
require_once "ConexaoBD.php";

class CurtidaDAO {
    public static function usuarioCurtiu($idusuario, $idpostagem) {
        $con = ConexaoBD::conectar();
        $sql = "SELECT COUNT(*) FROM curtida WHERE idusuario = ? AND idpostagem = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$idusuario, $idpostagem]);
        return $stmt->fetchColumn() > 0;
    }

    public static function contarCurtidas($idpostagem) {
        $con = ConexaoBD::conectar();
        $sql = "SELECT COUNT(*) FROM curtida WHERE idpostagem = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$idpostagem]);
        return (int)$stmt->fetchColumn();
    }

    public static function curtir($idusuario, $idpostagem) {
        $con = ConexaoBD::conectar();
        $sql = "INSERT INTO curtida (idusuario, idpostagem) VALUES (?, ?)";
        $stmt = $con->prepare($sql);
        return $stmt->execute([$idusuario, $idpostagem]);
    }

    public static function descurtir($idusuario, $idpostagem) {
        $con = ConexaoBD::conectar();
        $sql = "DELETE FROM curtida WHERE idusuario = ? AND idpostagem = ?";
        $stmt = $con->prepare($sql);
        return $stmt->execute([$idusuario, $idpostagem]);
    }
}
