<?php
require_once "ConexaoBD.php";

class MentoriaDAO {
    public static function CadastrarMentor($mentoria) {
        $pdo = ConexaoBD::conectar();
        $sql = "INSERT INTO mentoria (titulo, descricao, area, data, horario, idmentor, vaga_limite, local, status)
                VALUES (:titulo, :descricao, :area, :data, :horario, :mentor_id, :vaga_limite, :local, 'ativa')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($mentoria);
    }

    public static function listarPorMentor($idMentor) {
        $pdo = ConexaoBD::conectar();
        $stmt = $pdo->prepare("SELECT * FROM mentoria WHERE idmentor = :idMentor ORDER BY data DESC");
        $stmt->bindValue(":idMentor", $idMentor);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
