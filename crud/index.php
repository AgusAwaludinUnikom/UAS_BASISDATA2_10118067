<?php
    //koneksi database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "10118067_akademik";
    $myConnection= mysqli_connect("$servername","$username","$password") or die ("could not connect to mysql"); 

    mysqli_select_db($myConnection, "10118067_akademik") or die ("no database"); 


    //jika tombol simpan di klik
    if(isset($_POST['bsimpan']))
    {
        //pengujian apakah data akan diedit atau disimpan baru
        if($_GET['hal'] == "edit")
        {
            //data akan diedit
            $edit = mysqli_query($myConnection,   " UPDATE mahasiswa set
                                                    nim = '$_POST[tnim]',
                                                    nama = '$_POST[tnama]',
                                                    fakultas = '$_POST[tfakultas]',
                                                    jurusan = '$_POST[tjurusan]'
                                                    WHERE id = '$_GET[id]'
                                                ");
            if($edit) //jika simpan sukses
            {
                echo "<script>
                        alert('Edit data sukses!');
                        document.location='index.php';
                    </script>";
            }
            else
            {
                echo "<script>
                        alert('Edit data gagal!');
                        document.location='index.php';
                    </script>";
            }

        }
        else
        {
            //data akan disimpan baru
            $simpan = mysqli_query($myConnection,   "INSERT INTO mahasiswa (nim, nama, fakultas, jurusan)
                                                    VALUES ('$_POST[tnim]',
                                                            '$_POST[tnama]',
                                                            '$_POST[tfakultas]',
                                                            '$_POST[tjurusan]')
                                                    ");
            if($simpan) //jika simpan sukses
            {
                echo "<script>
                        alert('Simpan data sukses!');
                        document.location='index.php';
                    </script>";
            }
            else
            {
                echo "<script>
                        alert('Simpan data gagal!');
                        document.location='index.php';
                    </script>";
            }
        }

        
    }

    //pengujian jika tombol edit atau hapus di klik
    if(isset($_GET['hal']))
    {
        //pengujian jiga edit data
        if($_GET['hal'] == "edit")
        {
            //tampil data yang akan diedit
            $tampil = mysqli_query($myConnection, "SELECT * FROM mahasiswa WHERE id = '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                //jika data ditemukan, data akan ditampung ke variabel
                $vnim = $data['nim'];
                $vnama = $data['nama'];
                $vfakultas = $data['fakultas'];
                $vjurusan = $data['jurusan'];
            }
        }
        else if($_GET['hal'] == "hapus")
        {
            //persiapan hapus data
            $hapus = mysqli_query($myConnection, "DELETE FROM mahasiswa WHERE id = '$_GET[id]' ");
            if($hapus)
            {
                echo "<script>
                        alert('Hapus data Sukses!');
                        document.location='index.php';
                    </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title> Data Mahasiswa Manager </title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">


    <h2 class="text-center"> Data Mahasiswa Manager </h2>
    <h4 class="text-center"> Created by Agus Awaludin<h4>
    <h4 class="text-center"> 10118067 <h4>

    <!---Awal card form--->
    <div class="card mt-5">
    <div class="card-header bg-secondary text-white font-weight-light">
        Form Input Data Mahasiswa
    </div>
    <div class="card-body font-weight-light">
        <form method="post" action="">
            <div class="form-group">
                <label> NIM </label>
                <input type="text" name="tnim" value="<?=@$vnim?>" class="form-control" placeholder="Nomor Induk Mahasiswa" required>
            </div>
            <div class="form-group">
                <label> Nama </label>
                <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Nama Lengkap" required>
            </div>
            <div class="form-group">
                <label> Fakultas </label>
                <input type="text" name="tfakultas" value="<?=@$vfakultas?>" class="form-control" placeholder="Fakultas anda" required>
            </div>
            <div class="form-group">
                <label> Jurusan </label>
                <input type="text" name="tjurusan" value="<?=@$vjurusan?>" class="form-control" placeholder="Jurusan anda" required>
            </div>
            <button type="submit" class="btn btn-success" name="bsimpan"> Simpan </button>
            <button type="reset" class="btn btn-danger" name="breset"> Clear </button>

        </form>
    </div>
    </div>
    <!---Akhir card form--->

    <!---Awal card tabel--->
    <div class="card mt-5">
    <div class="card-header bg-secondary text-white font-weight-light">
        Tabel Data Mahasiswa
    </div>
    <div class="card-body font-weight-light">
        <table class="table table-bordered table-striped font-size: 12px">
            <tr>
                <th> No. </th>
                <th> NIM </th>
                <th> Nama </th>
                <th> Fakultas </th>
                <th> Jurusan </th>
                <th> Aksi </th>
            </tr>
            <?php
                $no = 1;
                $tampil = mysqli_query($myConnection, "SELECT * from mahasiswa order by id desc");
                while($data = mysqli_fetch_array($tampil)) :
            ?>
            <tr>
                <td><?=$no++;?></td>
                <td><?=$data['nim']?></td>
                <td><?=$data['nama']?></td>
                <td><?=$data['fakultas']?></td>
                <td><?=$data['jurusan']?></td>
                <td>
                    <a href="index.php?hal=edit&id=<?=$data['id']?>" class="btn btn-warning"> Edit </a>
                    <a href="index.php?hal=hapus&id=<?=$data['id']?>" 
                    onclick="return confirm('Apakah yakin akan menghapus data ini?')" class="btn btn-danger"> Hapus </a>
            </tr>
                <?php endwhile; //penutup perulangan while ?>
        </table>
    </div>
    </div>
    <!---Akhir card tabel--->

</div>
<script type= "text/javascript" src="js/bootstrap.min.js"></script>

<body>
</html>