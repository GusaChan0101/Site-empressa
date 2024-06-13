<?php
// Verificar se o usuário está autenticado
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

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

// Exibir mapa de salas
$query = "SELECT * FROM rooms";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    ?>
    <h1>Mapa de salas</h1>
    <div id="map"></div>
    <script>
        // Utilizar biblioteca Leaflet para criar o mapa
        var map = L.map('map').setView([51.505, -0.09], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
            subdomains: ['a', 'b', 'c']
        }).addTo(map);

        <?php
        while ($row = $result->fetch_assoc()) {
            ?>
            L.marker([<?php echo $row["latitude"]; ?>, <?php echo $row["longitude"]; ?>]).addTo(map)
                .bindPopup("<?php echo $row["name"]; ?>");
            <?php
        }
        ?>
    </script>
    <?php
} else {
    echo "Nenhuma sala encontrada";
}

// Exibir lista de atendimentos
$query = "SELECT * FROM appointments";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    ?>
    <h1>Atendimentos</h1>
    <table>
        <tr>
            <th>Data e hora</th>
            <th>Sala</th>
            <th>Usuário</th>
            <th>Status</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row["datetime"]; ?></td>
                <td><?php echo $row["room_name"]; ?></td>
                <td><?php echo $row["user_name"]; ?></td>
                <td><?php echo $row["status"]; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
} else {
    echo "Nenhum atendimento encontrado";
}