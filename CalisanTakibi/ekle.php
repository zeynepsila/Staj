<?php
  include('D:\xampp\htdocs\CalisanTakibi\eklentiler\degiskenler.php');
  $conn = mysqli_connect('localhost', 'root', '', 'ilkadimbelediyesi'); //ip adresi, kullanici adi, sifresi, db adi
  // veritabani baglantisi kontrol
  if (!$conn) {
     echo 'Connection error: ' . mysqli_connect_error();
  } else {
    echo('veritabanı baglantisi kuruldu');
  }

  if (isset($_POST['submit'])) {

    // ad kontrol
    if (empty($_POST['ad'])) {
        $errors['ad'] = 'Bir isim giriniz';
    } else {
        $ad = $_POST['ad'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $ad)) {
            $errors['ad'] = 'Lütfen sadece harf ve boşluk kullanınız';
            echo("harf kullanın");
        }
    }

    // birim kontrol
    if (empty($_POST['birim'])) {
        $errors['birim'] = 'Bir birim giriniz';
    } else {
        $birim = $_POST['birim'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $birim)) {
            $errors['birim'] = 'Lütfen sadece harf ve boşluk kullanınız';
        }
    }
    // cikis_tarihi kontrol
    if (empty($_POST['cikis_tarihi'])) {
        $errors['cikis_tarihi'] = 'Bir tarih giriniz';
    } else {
        $cikis_tarihi = $_POST['cikis_tarihi'];
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $cikis_tarihi) || !strtotime($cikis_tarihi)) {
            $errors['cikis_tarihi'] = 'Geçerli bir tarih formatı kullanınız (Örn: YYYY-MM-DD)';
        }
    }
    //  donus_tarihi kontrol
    if (empty($_POST['donus_tarihi'])) {
        $errors['donus_tarihi'] = 'Bir tarih giriniz';
    } else {
        $donus_tarihi = $_POST['donus_tarihi'];
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $donus_tarihi) || !strtotime($donus_tarihi)) {
            $errors['donus_tarihi'] = 'Geçerli bir tarih formatı kullanınız (Örn: YYYY-MM-DD)';
        }
    }
    //  izin_gun_sayisi kontrol
    if (empty($_POST['izin_gun_sayisi'])) {
        $errors['izin_gun_sayisi'] = 'Bir sayı giriniz';
    } else {
        $izin_gun_sayisi = $_POST['izin_gun_sayisi'];
        intval($izin_gun_sayisi);
        if (!is_numeric($izin_gun_sayisi)) {
            $errors['izin_gun_sayisi'] = 'Lütfen geçerli bir sayı giriniz';
        }
    }

    if (array_filter($errors)) {
        //echo 'errors in form';
    } else {
        // escape sql chars
        $ad = mysqli_real_escape_string($conn, $ad);
        $birim = mysqli_real_escape_string($conn, $birim);

        // check cikis_tarihi
        if (empty($_POST['cikis_tarihi'])) {
            $errors['cikis_tarihi'] = 'Bir tarih giriniz';
        } else {
            $cikis_tarihi_str = $_POST['cikis_tarihi'];
            $cikis_tarihi = DateTime::createFromFormat('Y-m-d', $cikis_tarihi_str);
        }
        if ($cikis_tarihi === false) {
            // Geçersiz tarih formatı
            echo 'Lütfen geçerli bir tarih girin.';
        } else {
            // Tarih geçerli, işlem yapabilirsiniz.
            $formatted_cikis_tarih = $cikis_tarihi->format('Y-m-d');
        }


        // check donus_tarihi
        if (empty($_POST['donus_tarihi'])) {
            $errors['donus_tarihi'] = 'Bir tarih giriniz';
        } else {
            $donus_tarihi_str = $_POST['donus_tarihi'];
            $donus_tarihi = DateTime::createFromFormat('Y-m-d', $donus_tarihi_str);
        }
        if ($cikis_tarihi === false) {
            // Geçersiz tarih formatı
            echo 'Lütfen geçerli bir tarih girin.';
        } else {
            // Tarih geçerli, işlem yapabilirsiniz.
            $formatted_donus_tarih = $donus_tarihi->format('Y-m-d');
        }
        // İzin gün sayısını tamsayıya dönüştürelim
        $izin_gun_sayisi = intval($_POST['izin_gun_sayisi']);


        // create sql
        $sql = "INSERT INTO calisanlar(ad, birim, cikis_tarihi, donus_tarihi, izin_gun_sayisi) VALUES('$ad', '$birim', '$formatted_cikis_tarih', '$formatted_donus_tarih', '$izin_gun_sayisi')";

        // save to db and check
        if (mysqli_query($conn, $sql)) {
            // success
            echo "Ekleme işlemi başarılı!";
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }

    }

} // end POST check
?>

<!DOCTYPE html>
<html>
<?php include('eklentiler/baslik.php'); ?>


<form class="border shadow p-3 rounded" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

    <legend>Çalışan Bilgileri Ekle</legend>
    <div class="mb-3">
        <label for="disabledTextInput" class="form-label">Çalışan Adı</label>
        <input type="text" name="ad" value="<?php echo htmlspecialchars($ad) ?>">
        <div class="red-text"><?php echo $errors['ad']; ?></div>
    </div>

    <div class="mb-3">
        <label for="disabledTextInput" class="form-label">Birimi</label>
        <input type="text" name="birim" value="<?php echo htmlspecialchars($birim) ?>">
        <div class="red-text"><?php echo $errors['birim']; ?></div>
    </div>

    <div class="mb-3">
        <label for="disabledTextInput" class="form-label">İzine Çıktığı Tarih</label>
        <input type="text" name="cikis_tarihi" value="<?php echo htmlspecialchars($cikis_tarihi) ?>">
        <div class="red-text"><?php echo $errors['cikis_tarihi']; ?></div>
    </div>

    <div class="mb-3">
        <label for="disabledTextInput" class="form-label">İzinden Döndüğü Tarih</label>
        <input type="text" name="donus_tarihi" value="<?php echo htmlspecialchars($donus_tarihi) ?>">
        <div class="red-text"><?php echo $errors['donus_tarihi']; ?></div>
    </div>

    <div class="mb-3">
        <label for="disabledTextInput" class="form-label">İzin Kullandığı Gün Sayısı</label>
        <input type="text" name="izin_gun_sayisi" value="<?php echo htmlspecialchars($izin_gun_sayisi) ?>">
        <div class="red-text"><?php echo $errors['izin_gun_sayisi']; ?></div>
    </div>

    <input type="submit" name="submit" value="Ekle" class="btn btn-primary">
    }
</form>

<!-- Eklenen form verilerini görmek için -->
<?php var_dump($_POST); ?>
</html>

