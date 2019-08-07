<?php
include("components/header.php");
include("components/navbar.php");
include("functions/koneksidb.php");


if(isset($_GET["mode"])){
if($_GET["mode"]=="edit"){
$id = $_GET["id"];
$statement = $conn->prepare(
"select * from tblmahasiswa
where nim=:nim"
);

      $statement->bindParam(":nim",$id);
      $statement->execute();
      $result = $statement->fetch();
}
}

   if(isset($_POST["simpan"])){
      if($_POST["mode"]=="tambah")
         $statement = $conn->prepare(
"insert into tblmahasiswa
(nim,nama,alamat,telepon)
values(:nim,:nama,:alamat,:telepon)");
      elseif($_POST["mode"] == "edit"){
$statement = $conn->prepare(
"update tblmahasiswa
set nama=:nama,
alamat=:alamat,
telepon=:telepon
where nim=:nim"
);
}

   $statement->bindParam(":nim",$_POST["nim"]);
   $statement->bindParam(":nama",$_POST["nama"]);
   $statement->bindParam(":alamat",$_POST["alamat"]);
   $statement->bindParam(":telepon",$_POST["telepon"]);
   try {
   $result = $statement->execute();
   if($result){
   header("location:listmahasiswa.php");
   }
   }catch(Exception $e){
   $error = $e->getMessage();
      }
         }
   ?>

<div class="container mt-2">
<?php
  if(isset($error)){
  echo "<div class='alert alert-danger'>
  {$error}
  </div>";
  }
  ?>

<div class="card">
<div class="card-header bg-primary text-white">
<h4><CEBTER>Form Mahasiswa</h4>
</div>
<div class="card-body">
<form action="formmahasiswa.php" method="POST">

<?php
if(isset($_GET["mode"])){
echo "<input type='hidden' name='mode'
value='{$_GET["mode"]}'>";
}
?>

<div class="form-group">
<label for="nim">NIM</label>
<input type="text" name="nim" id="nim"
class="form-control"
value="<?= isset($result)?$result["nim"]:"" ?>">
</div>

<div class="form-group">
<label for="nama">Nama</label>
<input type="text" name="nama" id="nama"
class="form-control"
value="<?= isset($result)?$result["nama"]:"" ?>">
</div>

<div class="form-group">
<label for="alamat">Alamat</label>
<input type="text" name="alamat" id="alamat"
class="form-control"
value="<?= isset($result)?$result["alamat"]:"" ?>">
</div>

<div class="form-group">
<label for="telepon">Telepon</label>
<input type="text" name="telepon" id="telepon"
class="form-control"
value="<?= isset($result)?$result["telepon"]:"" ?>">
</div>

<div class="form-group float-right">
<input type="submit" name="simpan"
class="btn btn-success" value="Simpan">
 <a href="listmahasiswa.php"
class="btn btn-danger">Batal</a>
</div>
</form>
</div>
</div>
</div>

<?php
include("components/footer.php");
?>