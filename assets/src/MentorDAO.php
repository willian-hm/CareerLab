<?php
require_once "ConexaoBD.php";
require_once "Util.php";

class MentorDAO
{
    public static function nomeExiste($nome_mentor)
    {
        $pdo = ConexaoBD::conectar();
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM mentor WHERE nome_mentor = ?");
        $stmt->execute([$nome_mentor]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] > 0;
    }

    public static function cadastrarMentor($dados, $arquivoFoto)
    {
        $pdo = ConexaoBD::conectar();

        if (self::nomeExiste($dados['nome_mentor'])) {
            throw new Exception("O nome de mentor já está em uso. Escolha outro.");
        }

        if ($dados['senha_mentor'] !== $dados['confirma_senha']) {
            throw new Exception("As senhas não coincidem.");
        }

        $senhaHash = password_hash($dados['senha_mentor'], PASSWORD_DEFAULT);
        $nomeFoto = $arquivoFoto && $arquivoFoto['tmp_name']
            ? Util::salvarFoto($arquivoFoto)
            : "padrao.jpg";

        $sql = "INSERT INTO mentor (nome_mentor, email_mentor, senha_mentor, area_mentor, bio_mentor, foto)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $dados['nome_mentor'],
            $dados['email_mentor'],
            $senhaHash,
            $dados['area_mentor'],
            $dados['bio_mentor'] ?? '',
            $nomeFoto
        ]);

        return true;
    }

    public static function buscarPorNome($nome_mentor)
    {
        $pdo = ConexaoBD::conectar();
        $stmt = $pdo->prepare("SELECT * FROM mentor WHERE nome_mentor = ?");
        $stmt->execute([$nome_mentor]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function buscarPorId($idmentor)
    {
        $pdo = ConexaoBD::conectar();
        $stmt = $pdo->prepare("SELECT * FROM mentor WHERE idmentor = ?");
        $stmt->execute([$idmentor]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
