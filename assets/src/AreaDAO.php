<?php
require_once "ConexaoBD.php";

class AreaDAO
{
    public static function listarAreas()
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT * FROM areaespecializacao ORDER BY nome_a";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
