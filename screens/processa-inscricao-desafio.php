<?php
require_once "../assets/incs/valida-sessao.php"; 
require_once "../assets/src/InscricaoDesafioDAO.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $iddesafio = (int)$_POST['iddesafio'];
    $linkgit = trim($_POST['linkgit']);

    // Só usuários podem se inscrever
    if ($tipo !== 'usuario') {
        $_SESSION['mensagem'] = "Apenas usuários podem se inscrever em desafios.";
        header("Location: desafios.php");
        exit;
    }

    // Verifica se já está inscrito
    if (InscricaoDesafioDAO::jaInscrito($iddesafio, $id)) {
        $_SESSION['mensagem'] = "Você já está inscrito neste desafio!";
    } else {
        $dados = [
            'iddesafio' => $iddesafio,
            'idusuario' => $id,
            'linkgit' => $linkgit
        ];

        InscricaoDesafioDAO::cadastrar($dados);
        $_SESSION['mensagem'] = "Inscrição realizada com sucesso!";
    }

    header("Location: desafios.php");
    exit;
}
