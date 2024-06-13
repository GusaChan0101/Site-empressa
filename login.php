<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinic";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verificar se o formulário de login foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Verificar se o usuário existe e a senha está correta
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Autenticado com sucesso, redirecionar para a página principal
        header("Location: index.php");
        exit;
    } else {
        $error = "Usuário ou senha incorretos";
    }
}

?>

<!-- Formulário de login -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="username">Usuário:</label>
    <input type="text" id="username" name="username"><br><br>
    <label for="password">Senha:</label>
    <input type="password" id="password" name="password"><br><br>
    <input type="submit" value="Entrar">
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
</form>