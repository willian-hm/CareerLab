<?php
require_once "ConexaoBD.php";

class EmpresaDAO {

    public static function cadastrarEmpresa($dados)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "INSERT INTO empresa 
                (nome_empresa, email_empresa, cnpj, senha_empresa, area_atuacao, foto, bio_e) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            $dados['nome_empresa'],
            $dados['email_empresa'],
            $dados['cnpj'],
            password_hash($dados['senha_empresa'], PASSWORD_DEFAULT),
            $dados['area_atuacao'],
            $dados['foto'] ?? null,
            $dados['bio_e'] ?? ""
        ]);
    }

    public static function emailExiste($email)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT COUNT(*) as total FROM empresa WHERE email_empresa = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] > 0;
    }
    public static function buscarPorCNPJ($cnpj) {
    $conexao = ConexaoBD::conectar();
    $stmt = $conexao->prepare("SELECT * FROM empresa WHERE cnpj = ?");
    $stmt->execute([$cnpj]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
?>
