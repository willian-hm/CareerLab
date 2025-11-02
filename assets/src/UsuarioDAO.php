<?php
require_once "ConexaoBD.php";
require_once "Util.php";

class UsuarioDAO
{

    public static function nomeExiste($nome_u)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT COUNT(*) as total FROM usuario WHERE nome_u = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$nome_u]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] > 0;
    }

    public static function cadastrarUsuario($dados, $arquivoFoto)
    {
        $conexao = ConexaoBD::conectar();

        // Verifica se o nome já existe
        if (self::nomeExiste($dados['nome_u'])) {
            throw new Exception("O nome de usuário já está em uso. Escolha outro.");
        }

        // Verifica idade mínima
        $dataNascimento = new DateTime($dados['datanascimento_u']);
        $hoje = new DateTime();
        $idade = $hoje->diff($dataNascimento)->y;
        if ($idade < 18) {
            throw new Exception("Você precisa ter 18 anos ou mais para se cadastrar.");
        }

        // Verifica senha
        if ($dados['senha_u'] !== $dados['confirma_senha']) {
            throw new Exception("As senhas não coincidem.");
        }

        // Salva foto
        $nomeFoto = Util::salvarFoto($arquivoFoto);

        // Inserir no banco
        $sql = "INSERT INTO usuario 
                (nome_u, email_u, datanascimento_u, bio_u, areaespecializacao, senha_u, foto)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $senhaHash = password_hash($dados['senha_u'], PASSWORD_DEFAULT);

        $stmt->execute([
            $dados['nome_u'],
            $dados['email_u'],
            $dados['datanascimento_u'],
            $dados['bio_u'] ?? "",
            $dados['areaespecializacao'],
            $senhaHash,
            $nomeFoto
        ]);

        return true;
    }

    public static function buscarPorNome($nome_u)
    {
        $conexao = ConexaoBD::conectar();
        $stmt = $conexao->prepare("SELECT * FROM usuario WHERE nome_u = ?");
        $stmt->execute([$nome_u]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
