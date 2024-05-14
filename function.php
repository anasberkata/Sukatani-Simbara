<?php
session_start();

$koneksi = mysqli_connect("localhost", "root", "", "db_skt");

//login
if (isset($_POST['login'])) {
    $username = $_POST['uname'];
    $password = $_POST['pass'];

    $cek_user = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' and password='$password'");
    $cek = mysqli_num_rows($cek_user);

    if ($cek > 0) {
        $role_name = mysqli_fetch_array($cek_user);
        $role = $role_name['role'];

        if ($role == 'admin') {
            $_SESSION['log'] = 'true';
            $_SESSION['role'] = 'admin';

            header("location: d_admin.php");

        } else {
            $_SESSION['log'] = 'true';
            $_SESSION['role'] = 'user';

            header("location: d_user.php");
        }
    } else {
        echo '<script>alert("User tidak ditemukan!")</script>';
    }
}

//add user
if (isset($_POST['adduser'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $addketable = mysqli_query($koneksi, "INSERT into user (username, password, role) values ('$username', '$password', '$role')");

    if ($addketable) {
        header('location: adduser.php');
    } else {
        echo 'Gagal';
        header('location: adduser.php');
    }
}

//edit user
if (isset($_POST['edituser'])) {
    $id_user = $_POST['id_user'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $editketable = mysqli_query($koneksi, "UPDATE user SET username = '$username', password = '$password', role = '$role' WHERE id_user = '$id_user'");

    if ($editketable) {
        header('location: adduser.php');
    } else {
        echo 'Gagal';
        header('location: adduser.php');
    }
}

//delete user
if (isset($_POST['deleteuser'])) {
    $id_user = $_POST['id_user'];

    $deleteketable = mysqli_query($koneksi, "DELETE FROM user WHERE id_user = '$id_user'");

    if ($deleteketable) {
        header('location: adduser.php');
    } else {
        echo 'Gagal';
        header('location: adduser.php');
    }
}


//BARANG
//tambah barang
if (isset($_POST['addbarang'])) {
    $namabarang = $_POST['namabarang'];
    $hargabeli = $_POST['hargabeli'];
    $hargajual = $_POST['hargajual'];
    $stok = 0;

    $addketable = mysqli_query($koneksi, "INSERT INTO nama_barang VALUES (NULL, '$namabarang', '$hargabeli', '$hargajual', $stok)");

    if ($addketable) {
        header('location: d_admin.php');
    } else {
        echo 'Gagal';
        header('location: d_admin.php');
    }
}

//ubah barang
if (isset($_POST['editbarang'])) {
    $id_barang = $_POST['id_barang'];
    $namabarang = $_POST['namabarang'];
    $hargabeli = $_POST['hargabeli'];
    $hargajual = $_POST['hargajual'];

    $editketable = mysqli_query($koneksi, "UPDATE nama_barang SET namabarang = '$namabarang', hargabeli = '$hargabeli', hargajual = '$hargajual' WHERE id_barang = '$id_barang'");

    if ($editketable) {
        header('location: d_admin.php');
    } else {
        echo 'Gagal';
        header('location: d_admin.php');
    }
}

//hapus barang
if (isset($_POST['deletebarang'])) {
    $id_barang = $_POST['id_barang'];

    $deleteketable = mysqli_query($koneksi, "DELETE FROM nama_barang WHERE id_barang = '$id_barang'");

    if ($deleteketable) {
        header('location: d_admin.php');
    } else {
        echo 'Gagal';
        header('location: d_admin.php');
    }
}

// STOCK IN
//tambah barang masuk
if (isset($_POST['addbarangmasuk'])) {
    $barang = $_POST['barang'];
    $jumlahmasuk = $_POST['jumlahmasuk'];

    $cekstok = mysqli_query($koneksi, "SELECT * FROM nama_barang WHERE id_barang = '$barang'");
    $getdata = mysqli_fetch_array($cekstok);

    $stocksekarang = $getdata['stock'];
    $jumlahstockall = $stocksekarang + $jumlahmasuk;

    $updatemasuk = mysqli_query($koneksi, "UPDATE nama_barang SET stock = '$jumlahstockall' WHERE id_barang = '$barang'");
    $addmasuk = mysqli_query($koneksi, "INSERT INTO masuk (idbarang, jumlahmasuk) VALUES ('$barang', '$jumlahmasuk')");

    if ($addmasuk) {
        header('location: stockin.php');
    } else {
        echo 'Gagal';
        header('location: stockin.php');
    }
}

//ubah barang masuk
if (isset($_POST['editbarangmasuk'])) {
    $idmasuk = $_POST['idmasuk'];
    $stock = $_POST['stock'];
    $jumlahmasukawal = $_POST['jumlahmasukawal'];
    $barang = $_POST['barang'];
    $jumlahmasukakhir = $_POST['jumlahmasukakhir'];

    $stockakhir = ($stock - $jumlahmasukawal) + $jumlahmasukakhir;


    $updatestock = mysqli_query($koneksi, "UPDATE nama_barang SET stock = '$stockakhir' WHERE id_barang = '$barang'");
    $editmasuk = mysqli_query($koneksi, "UPDATE masuk SET jumlahmasuk = '$jumlahmasukakhir' WHERE idmasuk = '$idmasuk'");

    if ($editmasuk) {
        header('location: stockin.php');
    } else {
        echo 'Gagal';
        header('location: stockin.php');
    }
}

//delete barang masuk
if (isset($_POST['deletebarangmasuk'])) {
    $idmasuk = $_POST['idmasuk'];
    $stock = $_POST['stock'];
    $jumlahmasuk = $_POST['jumlahmasuk'];
    $barang = $_POST['barang'];

    $stockakhir = $stock - $jumlahmasuk;

    $updatestock = mysqli_query($koneksi, "UPDATE nama_barang SET stock = '$stockakhir' WHERE id_barang = '$barang'");
    $deletemasuk = mysqli_query($koneksi, "DELETE FROM masuk WHERE idmasuk = '$idmasuk'");

    if ($deletemasuk) {
        header('location: stockin.php');
    } else {
        echo 'Gagal';
        header('location: stockin.php');
    }
}

// STOCK OUT
//tambah barang keluar
if (isset($_POST['addbarangkeluar'])) {
    $barang = $_POST['barang'];
    $jumlahkeluar = $_POST['jumlahkeluar'];

    $cekstok = mysqli_query($koneksi, "SELECT * FROM nama_barang WHERE id_barang = '$barang'");
    $getdata = mysqli_fetch_array($cekstok);

    $stocksekarang = $getdata['stock'];
    $jumlahstockall = $stocksekarang - $jumlahkeluar;

    $updatemasuk = mysqli_query($koneksi, "UPDATE nama_barang SET stock = '$jumlahstockall' WHERE id_barang = '$barang'");
    $addkeluar = mysqli_query($koneksi, "INSERT INTO keluar (idbarang, jumlahkeluar) VALUES ('$barang', '$jumlahkeluar')");

    if ($addkeluar) {
        header('location: stockout.php');
    } else {
        echo 'Gagal';
        header('location: stockout.php');
    }
}

// edit barang keluar
if (isset($_POST['editbarangkeluar'])) {
    $idkeluar = $_POST['idkeluar'];
    $stock = $_POST['stock'];
    $jumlahkeluarawal = $_POST['jumlahkeluarawal'];
    $barang = $_POST['barang'];
    $jumlahkeluarakhir = $_POST['jumlahkeluarakhir'];

    $stockakhir = ($stock + $jumlahkeluarawal) - $jumlahkeluarakhir;


    $updatestock = mysqli_query($koneksi, "UPDATE nama_barang SET stock = '$stockakhir' WHERE id_barang = '$barang'");
    $editkeluar = mysqli_query($koneksi, "UPDATE keluar SET jumlahkeluar = '$jumlahkeluarakhir' WHERE idkeluar = '$idkeluar'");

    if ($editkeluar) {
        header('location: stockout.php');
    } else {
        echo 'Gagal';
        header('location: stockout.php');
    }
}

//delete barang keluar
if (isset($_POST['deletebarangkeluar'])) {
    $idkeluar = $_POST['idkeluar'];
    $stock = $_POST['stock'];
    $jumlahkeluar = $_POST['jumlahkeluar'];
    $barang = $_POST['barang'];

    $stockakhir = $stock + $jumlahkeluar;

    $updatestock = mysqli_query($koneksi, "UPDATE nama_barang SET stock = '$stockakhir' WHERE id_barang = '$barang'");
    $deletekeluar = mysqli_query($koneksi, "DELETE FROM keluar WHERE idkeluar = '$idkeluar'");

    if ($deletekeluar) {
        header('location: stockout.php');
    } else {
        echo 'Gagal';
        header('location: stockout.php');
    }
}

// ORDER
//tambah order
if (isset($_POST['addorder'])) {
    $barang = $_POST['barang'];
    $jumlah_order = $_POST['jumlah_order'];

    $addmasuk = mysqli_query($koneksi, "INSERT INTO order_list (idbarang, jumlah_order) VALUES ('$barang', '$jumlah_order')");

    if ($addmasuk) {
        header('location: listorder.php');
    } else {
        echo 'Gagal';
        header('location: listorder.php');
    }
}

//Ubah order
if (isset($_POST['editorder'])) {
    $idorder = $_POST['idorder'];
    $barang = $_POST['barang'];
    $jumlah_order = $_POST['jumlah_order'];

    $editorder = mysqli_query($koneksi, "UPDATE order_list SET idbarang = '$barang', jumlah_order = '$jumlah_order' WHERE idorder = '$idorder'");

    if ($editorder) {
        header('location: listorder.php');
    } else {
        echo 'Gagal';
        header('location: listorder.php');
    }
}

//Hapus order
if (isset($_POST['deleteorder'])) {
    $idorder = $_POST['idorder'];

    $deleteorder = mysqli_query($koneksi, "DELETE FROM order_list WHERE idorder = '$idorder'");

    if ($deleteorder) {
        header('location: listorder.php');
    } else {
        echo 'Gagal';
        header('location: listorder.php');
    }
}
?>