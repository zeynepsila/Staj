<?php
  $conn = mysqli_connect('localhost', 'root', '', 'ilkadimbelediyesi'); //ip adresi, kullanici adi, sifresi, db adi

  $sql =$conn->query("SELECT * FROM calisanlar order by id asc");


?>


<!DOCTYPE html>
<html lang="tr">
<?php include('eklentiler/baslik.php'); ?>


<h5>İLKADIM BELEDİYESİ ÇALIŞANLARI İZİN LİSTESİ</h5>
  <?php
    echo "<table width='100%' border='1'>
            <tr align='center'>
                <th>ID</th>
                <th> ÇALIŞAN ADI SOYADI</th>
                <th>ÇALIŞTIĞI BİRİM</th>
                <th>İZİNE ÇIKTIĞI TARİH</th>
                <th>İZİNDEN DÖNDÜĞÜ TARİH</th>
                <th>İZİN ALDIĞI GÜN SAYISI</th>
            </tr>";

    while ($satir = $sql->fetch_object()) {
      echo "<tr align='center'>
                <td> $satir->id</td>
                <td> $satir->ad </td>
                <td> $satir->birim </td>
                <td> $satir->cikis_tarihi </td>
                <td> $satir->donus_tarihi </td>
                <td> $satir->izin_gun_sayisi </td>
                <td>  <a href='sil.php?id=$satir->id'>sil</a> </td>  </td>
            </tr>";
}

    echo "</table>";


    $sql->free_result();

    $conn->close();

?>

</html>

