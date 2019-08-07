<?php
include("components/header.php");
include("components/navbar.php");
include("functions/koneksidb.php");
include("functions/konversi.php");

  if(isset($_GET["mode"])){
  if($_GET["mode"] == "edit"){
    $id = $_GET["id"];
      $statement = $conn->prepare(
  "select * from tblkelas
  where idkelas=:idkelas"
);
      $statement->bindParam(":idkelas",$id);
      $statement->execute();
      $result = $statement->fetch();
}
}
    if(isset($_POST["simpan"])){
    if($_POST["mode"]=="tambah"){
    $statement = $conn->prepare(
      "insert into tblkelas(nama,semester,jurusan)
      values(:nama,:semester,:jurusan)"
);
  }elseif($_POST["mode"]=="edit"){
  $id = $_POST["id"];
  $statement = $conn->prepare(
  "update tblkelas
  set nama=:nama,
  semester=:semester,
  jurusan=:jurusan
  where idkelas=:idkelas"
);
  $statement->bindParam(":idkelas",$id);
}
    $statement->bindParam(":nama",$_POST["nama"]);
    $statement->bindParam(":semester",$_POST["semester"]);
    $statement->bindParam(":jurusan",$_POST["jurusan"]);
  try{
    $result = $statement->execute();
  if($result){
    header("location:listkelas.php");
}
  }catch(Exception $e){
    $error = $e->getMessage();
}
}
?>
  <div class="container mt-2">

<?php
if(isset($error)){
echo "<div class='alert alert-danger'>{$error}</div>";
}
?>

<div class="card">
<div class="card-header bg-primary text-white">
  <h4>Form Kelas</h4>
</div>
  <div class="card-body">
  <form action="formkelas.php" method="POST">
  <?php
    if(isset($_GET["mode"])){
      echo "<input type='hidden' name='mode' value='{$_GET["mode"]}'>";
      if(isset($_GET["id"])){
        echo "<input type='hidden' name='id' value='{$_GET["id"]}'>";
}
}
?>

<div class="form-group">
<label for="nama">Nama</label>
<input type="text" name="nama" id="nama"
class="form-control"
value="<?= isset($result)?$result["nama"]:"" ?>">
</div>
<div class="form-group">
<label for="semester">Semester</label>
<select name="semester" id="semester" class="form-control">
<?php
for($i=1;$i<=8;$i++){
echo "<option value='{$i}' ".((isset($result) && $result["semester"]==$i)?"SELECTED":"").">".konversiSemester($i)."</option>";
}
?>

</select>
</div>
<div class="form-group">
<label for="jurusan">Jurusan</label>
<select name="jurusan" id="jurusan" class="form-control">
<option value="ti" <?= isset($result) && $result["jurusan"]=="ti"?"SELECTED":"" ?>>Teknik Informatika</option>
<option value="si"<?= isset($result) && $result["jurusan"]=="si"?"SELECTED":"" ?>>Sistem Informasi</option>
</select>
</div>
<div class="form-group float-right">
<input type="submit" class="btn btn-success"
value="Simpan" name="simpan">
<a href="listkelas.php"
class="btn btn-danger">Batal</a>
</div>
</form>
</div>
</div>
</div>

<?php
include("components/footer.php");
?>