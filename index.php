<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
 
// Conectar con la BD
try {
    $db = new PDO('sqlite:twitter.database');
} catch (Exception $e) {
    die ($e);
}
 
// Insertar en la BD
if (isset($_POST['palabra'])) {
    try {
        $stmt = $db->prepare("INSERT INTO busqueda (texto) VALUES (:palabra);");
        $stmt->bindParam(':palabra', $palabra);
 
        // Fill in the values
        $palabra = $_POST['palabra'];
        $stmt->execute();
    } catch (Exception $e) {
        die ($e);
    }
}
 
// Busqueda
try {
    $posts = $db->prepare('SELECT * FROM busqueda;');
    $posts->execute();
} catch (Exception $e) {
    die ($e);
}
 
?>
 </head>
<body>
<h2>Nueva</h2>
<form action="" method="post">
 
    <p>
        <label for="title">Palabra:</label>
        <input type="text" name="palabra" />
    </p>
 
    <p>
        <input type="submit" name="submit" value="Submit" />
    </p>
 
</form>

<br>
<img src="grafico.php" />
<br>
<h3>Lista busquedas</h3>
<table>
<?php while ($post = $posts->fetchObject()): ?>
 <tr><td>
    <?php echo $post->texto ?>
     </td></tr>
<?php endwhile; ?>
</table> 
</body>
</html>

