<?php
require_once "ConexaoBD.php";

class MentorDAO {

    public static function cadastrarMentor($dados)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "INSERT INTO mentor 
                (nome_mentor, email_mentor, senha_mentor, area_atuacao, linkedin, foto, bio_m) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            $dados['nome_mentor'],
            $dados['email_mentor'],
            password_hash($dados['senha_mentor'], PASSWORD_DEFAULT),
            $dados['area_atuacao'],
            $dados['linkedin'] ?? "",
            $dados['foto'] ?? "",
            $dados['bio_m'] ?? ""
        ]);
    }

    public static function emailExiste($email)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT COUNT(*) as total FROM mentor WHERE email_mentor = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] > 0;
    }
    public static function buscarPorEmail($email) {
    $conexao = ConexaoBD::conectar();
    $stmt = $conexao->prepare("SELECT * FROM mentor WHERE email_mentor = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
?>
