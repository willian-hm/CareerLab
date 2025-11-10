<?php
require_once "ConexaoBD.php";

class PresencaMentoriaDAO
{
    // Confirma presença e adiciona XP
    public static function confirmarPresenca($idmentoria, $idusuario)
    {
        $conexao = ConexaoBD::conectar();

        // verifica se já existe
        $check = $conexao->prepare("SELECT 1 FROM presencamentoria WHERE idmentoria = ? AND idusuario = ?");
        $check->execute([$idmentoria, $idusuario]);
        if ($check->fetch()) {
            throw new Exception("Presença já registrada para este aluno.");
        }

        // registra presença
        $sql = "INSERT INTO presencamentoria (idmentoria, idusuario) VALUES (?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$idmentoria, $idusuario]);

        // adiciona XP
        $xp = 5;
        $sqlXP = "UPDATE usuario SET exp = COALESCE(exp, 0) + ? WHERE idusuario = ?";
        $stmtXP = $conexao->prepare($sqlXP);
        $stmtXP->execute([$xp, $idusuario]);

        return true;
    }

    // Desconfirma presença e remove XP
    public static function desconfirmarPresenca($idmentoria, $idusuario)
    {
        $conexao = ConexaoBD::conectar();

        $sql = "DELETE FROM presencamentoria WHERE idmentoria = ? AND idusuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$idmentoria, $idusuario]);

        // remove XP
        $xp = 5;
        $sqlXP = "UPDATE usuario SET exp = GREATEST(COALESCE(exp, 0) - ?, 0) WHERE idusuario = ?";
        $stmtXP = $conexao->prepare($sqlXP);
        $stmtXP->execute([$xp, $idusuario]);

        return true;
    }

    // Verifica se o usuário já confirmou
    public static function jaConfirmou($idmentoria, $idusuario)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT 1 FROM presencamentoria WHERE idmentoria = ? AND idusuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$idmentoria, $idusuario]);
        return (bool) $stmt->fetch();
    }
}
