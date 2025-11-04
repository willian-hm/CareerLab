<?php
require_once "ConexaoBD.php";
require_once "Util.php";

class MentorDAO
{
    // Verifica se já existe mentor com o mesmo e-mail
    public static function emailExiste($email)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT COUNT(*) as total FROM mentor WHERE email_mentor = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] > 0;
    }

    // Cadastrar mentor
    public static function cadastrarMentor($dados, $arquivoFoto)
    {
        $conexao = ConexaoBD::conectar();

        if (self::emailExiste($dados['email_mentor'])) {
            throw new Exception("Este e-mail já está em uso.");
        }

        if ($dados['senha_mentor'] !== $dados['confirma_senha']) {
            throw new Exception("As senhas não coincidem.");
        }

        // Upload de foto
        $nomeFoto = Util::salvarFoto($arquivoFoto);

        $sql = "INSERT INTO mentor 
                (nome_mentor, email_mentor, senha_mentor, areaespecializacao, linkedin, foto, bio_m)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);

        $senhaHash = password_hash($dados['senha_mentor'], PASSWORD_DEFAULT);

        $stmt->execute([
            $dados['nome_mentor'],
            $dados['email_mentor'],
            $senhaHash,
            $dados['areaespecializacao'],
            $dados['linkedin'] ?? "",
            $nomeFoto,
            $dados['bio_m'] ?? ""
        ]);

        return true;
    }

    // Buscar mentor por e-mail (para login)
    public static function buscarPorEmail($email)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT * FROM mentor WHERE email_mentor = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar mentor por ID
    public static function buscarPorId($id)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT m.*, a.nome_a AS area_nome 
                FROM mentor m
                LEFT JOIN areaespecializacao a ON m.areaespecializacao = a.idarea
                WHERE idmentor = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
