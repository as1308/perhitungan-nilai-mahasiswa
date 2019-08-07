<?php
include("components/header.php");
include("components/navbar.php");
include("functions/koneksidb.php");
include("functions/konversi.php");

   if(isset($_GET["mode"])){
   if($_GET["mode"]=="hapus"){
      $statement = $conn->prepare(
         "delete from tblnilai
            where idnilai=:idnilai"
);

   $statement->bindParam(":idnilai",$_GET["idnilai"]);
   $result = $statement->execute();
   if($result){
      $info = "Berhasil Hapus Data nilai";
}
}
}
      $statement = $conn->prepare("
      select
      A.idnilai,
      a.nim,b.nama,
      c.nama as kelas,
      d.nama as matakuliah,
      a.total,a.huruf
      from tblnilai as a
      join tblmahasiswa as b on a.nim=b.nim
      join tblkelas as c on a.idkelas=c.idkelas
      join tblmatakuliah as d on a.idmatakuliah=d.idmatakuliah");
      $statement->execute();
      $result = $statement->fetchAll();
?>


<div class="container mt-2">
<div class="card">
<div class="card-header bg-primary text-white">
<h4><center>Listing Nilai</h4>
</div>

   <div class="card-body">
   <a href="formnilai.php?mode=tambah"
   class="btn btn-success mb-2 float-right">Tambah</a>
   <table class="table table-striped">
<thead>
<tr>
   <th>Nim</th>
   <th>Nama</th>
   <th>kelas</th>
   <th>id matakuliah</th>
   <th>Nilai</td>
   <th>Huruf</th>
   <th colspan=2>Action</th>
</tr>
</thead>

<tbody>
<?php
foreach($result as $item){
echo "<tr>
      <td>{$item["nim"]}</td>
      <td>{$item["nama"]}</td>
      <td>{$item["kelas"]}</td>
      <td>{$item["matakuliah"]}</td>
      <td>{$item["total"]}</td>
      <td>".strtoupper($item["huruf"])."</td>
      
   <td>
      <a href='formnilai.php?mode=edit&id={$item["idnilai"]}'
      class='btn btn-warning btn-block'>Edit</a>
</td>
<td>
      <a href='listnilai.php?mode=hapus&idnilai={$item["idnilai"]}'
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