<?php
include_once "../assets/incs/valida-sessao.php";
require_once "../assets/src/InscricaoDesafioDAO.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['iddesafio'])) {
    InscricaoDesafioDAO::cancelar($_POST['iddesafio'], $id);
}

header("Location: desafios.php?filtro=meus");
exit;
