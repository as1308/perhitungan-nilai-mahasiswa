<?php
include("components/header.php");
include("components/navbar.php");
include("functions/koneksidb.php");

$statement=$conn->prepare("select * from tblkelas");
$statement->execute();
$kelas=$statement->fetchAll();

 if(isset($_POST["kelas"])){
     $statement=$conn->prepare("select a.nim,a.nama 
     from tblmahasiswa a inner join tblnilai b on a.nim=b.nim
     where b.idkelas=:kelas
     group by a.nim");
     $statement->bindparam(":kelas",$_POST["kelas"]);
     $statement->execute();
     $mahasiswa=$statement->fetchAll();
 }
?>

<div class="container mt-2">
<form action="listnilaimahasiswa.php" method="POST" class="form-inline">
  <div class="form-group">
     <label for="kelas">kelas</label>
      <select name="kelas" id="kelas" class="form-control mx-2">
        
        <?php    
        foreach($kelas as $item){
            echo"<option value='{$item["idkelas"]}'>
                 {$item["nama"]}</option>";
        }
        ?>

        </select>
          <input type="submit" class="btn btn-primary" value="submit">
    </div>
 </form>
 <table class="table table-striped table-bordered">
    <thead>
      <tr>
          <th>NIM</th>
          <th>Nama</th>
          <th>Action</th>
       </tr>
     </thead>

 <?php
    if(isset($mahasiswa)){
        foreach($mahasiswa as $item){
        echo"<tr>
                 <td>{$item["nim"]}</td>
                 <td>{$item["nama"]}</td>
                 <td><a target='_blank' a href='khs.php?nim={$item["nim"]}' class='btn btn-success'>Tampil Khs</a></td>
                 <tr>";
    }
   }
 ?>

    <tbody>
 </table>
</div>
     
<?php
include("components/footer.php");
?>