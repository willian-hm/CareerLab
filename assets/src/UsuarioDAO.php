<?php
require_once "ConexaoBD.php";
require_once "Util.php";

class UsuarioDAO
{
    // Verifica se nome de usuário já existe
    public static function nomeExiste($nome_u)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT COUNT(*) as total FROM usuario WHERE nome_u = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$nome_u]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] > 0;
    }

    // Cadastrar usuário
    public static function cadastrarUsuario($dados, $arquivoFoto)
    {
        $conexao = ConexaoBD::conectar();

        if (self::nomeExiste($dados['nome_u'])) {
            throw new Exception("O nome de usuário já está em uso. Escolha outro.");
        }

        $dataNascimento = new DateTime($dados['datanascimento_u']);
        $hoje = new DateTime();
        $idade = $hoje->diff($dataNascimento)->y;
        if ($idade < 18) {
            throw new Exception("Você precisa ter 18 anos ou mais para se cadastrar.");
        }

        if ($dados['senha_u'] !== $dados['confirma_senha']) {
            throw new Exception("As senhas não coincidem.");
        }

        $nomeFoto = Util::salvarFoto($arquivoFoto);

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

    // Buscar usuário por ID
    public static function buscarPorId($id)
    {
        $conexao = ConexaoBD::conectar();

        $sql = "
            SELECT u.idusuario, u.nome_u AS nome, u.email_u, u.foto, u.bio_u AS bio,
                   a.nome_a AS area, 
                   (SELECT COUNT(*) FROM seguido WHERE idseguido = u.idusuario) AS seguidores,
                   (SELECT COUNT(*) FROM seguido WHERE idusuario = u.idusuario) AS seguindo
            FROM usuario u
            LEFT JOIN areaespecializacao a ON u.areaespecializacao = a.idarea
            WHERE u.idusuario = :id
        ";

        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar usuário por nome
    public static function buscarPorNome($nome_u)
    {
        $conexao = ConexaoBD::conectar();
        $stmt = $conexao->prepare("SELECT * FROM usuario WHERE nome_u = ?");
        $stmt->execute([$nome_u]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualizar dados do usuário
    public static function atualizarUsuario($id, $dados, $arquivoFoto = null)
    {
        $conexao = ConexaoBD::conectar();

        // Campos básicos
        $sql = "UPDATE usuario SET nome_u = ?, email_u = ?, bio_u = ?, areaespecializacao = ?";
        $params = [
            $dados['nome_u'],
            $dados['email_u'],
            $dados['bio_u'] ?? "",
            $dados['areaespecializacao']
        ];

        // Se enviar nova foto
        if ($arquivoFoto && $arquivoFoto['tmp_name']) {
            $nomeFoto = Util::salvarFoto($arquivoFoto);
            $sql .= ", foto = ?";
            $params[] = $nomeFoto;
        }

        $sql .= " WHERE idusuario = ?";
        $params[] = $id;

        $stmt = $conexao->prepare($sql);
        return $stmt->execute($params);
    }

    // Excluir usuário
    public static function excluir($idUsuario) {
        $conexao = ConexaoBD::conectar();
        $sql = "DELETE FROM usuario WHERE idusuario = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
