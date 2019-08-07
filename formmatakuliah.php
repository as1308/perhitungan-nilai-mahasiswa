<?php
    include("components/header.php");
    include("components/navbar.php");
    include("functions/koneksidb.php");

    if(isset($_GET["mode"])){
      if($_GET["mode"]=="edit"){
      $id = $_GET["id"];
      $statement = $conn->prepare(
      "select * from tblmatakuliah
      where idmatakuliah=:idmatakuliah"
      );
      
            $statement->bindParam(":idmatakuliah",$id);
            $statement->execute();
            $result = $statement->fetch();
      }
      }
      
         if(isset($_POST["simpan"])){
            if($_POST["mode"]=="tambah")
               $statement = $conn->prepare(
                 "insert into tblmatakuliah
                     (idmatakuliah,nama,jurusan)
                      values(:idmatakuliah,:nama,:jurusan)");
         elseif($_POST["mode"] == "edit"){
      $statement = $conn->prepare(
                  "update tblmatakuliah
                   set idmatakuliah=:idmatakuliah,
                   nama=:nama,
                    jurusan=:jurusan
                     where idmatakuliah=:idmatakuliah"
      );
      }
         $statement->bindParam(":idmatakuliah",$_POST["idmatakuliah"]);
         $statement->bindParam(":nama",$_POST["nama"]);
         $statement->bindParam(":jurusan",$_POST["jurusan"]);
         try {
         $result = $statement->execute();
         if($result){
         header("location:listmatakuliah.php");
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
<div class="container mt-2">
   <div class="card">
     <div class="card-header bg-primary text-white">
       <h4>Form Matakuliah</h4>
    </div>
    <div class="card-body">
       <form action="formmatakuliah.php" method="POST">
       <?php
      if(isset($_GET["mode"])){
      echo "<input type='hidden' name='mode'
       value='{$_GET["mode"]}'>";
}
?> 
        <div class="form-group">
         <input type="hidden" name="idmatakuliah" id="idmatakuliah" class="form-control"
         value="<?= isset($result)?$result["idmatakuliah"]:"" ?>">
     </div>

         <div class="form-group">
         <label for="nama">NAMA</label>
         <input type="text" name="nama" id="nama" class="form-control"
         value="<?= isset($result)?$result["nama"]:"" ?>">
     </div>
     
         <div class="form-group">
         <label for="jurusan">Jurusan</label>
         <input type="text" name="jurusan" id="jurusan" class="form-control"
         value="<?= isset($result)?$result["jurusan"]:"" ?>">
     </div>

       <div class="form-group float-right">
       <input type="submit" name="simpan"  class="btn btn-success" value="simpan">
       <a href="listmatakuliah.php" class="btn btn-danger">Batal</a>
     </div>
  </form>
  </div>
</div>
<?php
    include("components/footer.php");
    ?>