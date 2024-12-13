<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "corememories";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM islandsOfPersonality WHERE islandOfPersonalityID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$island = $result->fetch_assoc();

$sql2 = "SELECT * FROM islandContents WHERE islandID = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("i", $id);
$stmt2->execute();
$contents = $stmt2->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title><?= htmlspecialchars($island['name']) ?></title>
</head>
<body>
<header>
    <h1><?= htmlspecialchars($island['name']) ?></h1>
    <p><?= htmlspecialchars($island['shortDescription']) ?></p>
</header>
<main>
    <section>
        <?php while ($row = $contents->fetch_assoc()): ?>
        <article>
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><?= htmlspecialchars($row['description']) ?></p>
        </article>
        <?php endwhile; ?>
    </section>
</main>
<footer>
    <p>&copy; 2024 Inside Out Memories. All rights reserved.</p>
</footer>
</body>
</html>
<?php $conn->close(); ?>
