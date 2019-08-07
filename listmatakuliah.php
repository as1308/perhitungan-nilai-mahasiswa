<?php
    include("components/header.php");
    include("components/navbar.php");
    include("functions/koneksidb.php");
    include("functions/konversi.php");

    if(isset($_GET["mode"])){
        if($_GET["mode"]=="hapus"){
            $statement =$conn->prepare("
            delete from tblmatakuliah
            where idmatakuliah=:idmatakuliah");
            $statement->bindparam(":idmatakuliah",$_GET["idmatakuliah"]);
            $result = $statement->execute();
            if($result){
                $info="Berhasil Hapus Data Matakuliah";
                
            }
        }
    }
    $statement = $conn->prepare(
        "select * from tblmatakuliah"
    );
    $statement->execute();
    $result = $statement->fetchAll();
?>
<div class="container mt-2">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Listing Mata Kuliah</h4>
        </div>
        <div class="card-body">
        <a href="formmatakuliah.php?mode=tambah"
        class="btn btn-success mb-2 float-right">TAMBAH</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th colspan=2>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                 foreach ($result as $item)
                    {
                     echo"<tr>
                            <td>{$item['nama']}</td> 
                            <td>".konversiJurusan($item["jurusan"])."</td>
                            <td>
                                <a href='formmatakuliah.php?mode=edit&id={$item['idmatakuliah']}'
                                class='btn btn-warning btn-block'><i class='fa fa-pencil-alt'></i>Edit</a>
                            </td>
                            <td>
                                <a href='listmatakuliah.php?mode=hapus&idmatakuliah={$item['idmatakuliah']}'
                                onclick='return confirm(\"Anda Yakin Ingin Hapus?\")'
                                class='btn btn-danger btn-block'>Hapus</a>
                            </td>
                            </tr>";
                        }  
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
    include("components/footer.php");
?>

