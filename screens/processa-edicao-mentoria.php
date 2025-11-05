<?php
require_once "../assets/src/MentoriaDAO.php";

try {
    MentoriaDAO::editar($_POST);
    header("Location: painel-mentor.php");
    exit;
} catch (Exception $e) {
    echo "Erro ao editar mentoria: " . $e->getMessage();
}
