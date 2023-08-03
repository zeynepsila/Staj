<?php
$conn = mysqli_connect('localhost', 'root', '', 'ilkadimbelediyesi'); //ip adresi, kullanici adi, sifresi, db adi
$conn->set_charset("utf8");

$deleteno = $_GET["id"];

$sql= $conn->query("delete from calisanlar where id=$deleteno");

if ($sql) {
    echo "<script>
            alert('Kayıt Silindi!');
            window.location.href = 'liste.php';
            </script>";
} else {
    echo "Kayıt Silinemedi.";
}
?>