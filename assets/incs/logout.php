<?php
// Limpa todos os cookies de login
setcookie("idusuario", "", time() - 3600, "/");
setcookie("nomeusuario", "", time() - 3600, "/");
setcookie("fotousuario", "", time() - 3600, "/");

setcookie("idmentor", "", time() - 3600, "/");
setcookie("nomementor", "", time() - 3600, "/");
setcookie("fotomentor", "", time() - 3600, "/");

setcookie("idempresa", "", time() - 3600, "/");
setcookie("nomeempresa", "", time() - 3600, "/");
setcookie("fotoempresa", "", time() - 3600, "/");

// Redireciona para login de usuário (padrão)
header("location: ../../screens/index.php");
exit;
