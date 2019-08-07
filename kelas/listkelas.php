<?php
    include("components/header.php");
    include("components/navbar.php");
    include("functions/koneksidb.php");
    include("functions/konversi.php");

    if(isset($_GET["mode"])){
        if($_GET["mode"]=="hapus"){
            $statement = $conn->prepare(
                "delete from tblkelas
                where idkelas=:idkelas"
            );
            $statement->bindParam(":idkelas",$_GET["idkelas"]);
            $result = $statement->execute();
            if($result){
                $info = "Berhasil Hapus Data Mata Kuliah";
            }
        }
    }
    
    $statement = $conn->prepare("select * from tblkelas");
    $statement->execute();
    $result = $statement->fetchAll();
?>
<div class="container mt-2">
        <?php
            if(isset($info)){
            echo "<div class='alert alert-success'>{$info}</div>";
        }
        ?>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Listing Kelas</h4>
        </div>
        <div class="card-body">
        <a href="formkelas.php?mode=tambah"
        class="btn btn-success mb-2 float-right">TAMBAH</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID kelas</th>
                        <th>Nama</th>
                        <th>Semester</th>
                        <th>Jurusan</th>
                        <th colspan=2>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach($result as $item){
                        echo "<tr>
                                <td>{$item["idkelas"]}</td>
                                <td>{$item["nama"]}</td>
                                <td>{$item["semester"]}</td>
                                <td>".konversiJurusan($item["jurusan"])."</td>
                                <td>
                                    <a href='formkelas.php?mode=edit&id={$item["idkelas"]}' 
                                        class='btn btn-warning btn-block'>Edit</a>
                                </td>
                                <td>
                                    <a href='listkelas.php?mode=hapus&idkelas={$item["idkelas"]}' 
                                        onclick='return confirm(\"Anda Yakin Hapus?\")'
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