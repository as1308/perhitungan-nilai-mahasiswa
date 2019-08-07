<?php
   include("components/header.php");
   include("components/navbar.php");
   include("functions/koneksidb.php");

     if(isset($_GET["mode"])){
        if($_GET["mode"]=="hapus"){
         $statment=$conn->prepare("delete from tblmahasiswa where nim=:nim");

          $statment->bindparam(":nim",$_GET["nim"]);

          $result =$statment->execute();
          if($result){
             $info="berhasil hapus data";
          }
        }
     }

   $statment=$conn->prepare(
      "select * from tblmahasiswa"
   );
   $statment->execute();
   $result=$statment->fetchAll();
?>
<div class="container mt-2">
    <?php
      if(isset($info)){
         echo"<div class='alert alert-success'>
         {$info}
         </div>";
      }
    ?>
   <div class="card">
    <div class="card-header bg-primary text-white">
        <center><h4>Listing Mahasiswa</h4>    
    </div>
    <div class="card-body">
   <a href='formmahasiswa.php?mode=tambah' class='btn btn-success mb-2 float-right'>Tambah</a>
    <table class="table table-striped">
      <thead>
         <tr>
            <th>NIM</th>
            <th>NAMA</th>
            <th>ALAMAT</th>
            <th>TELEPON</th>
            <th colspan=2>Action</th>
         </tr>
      </thead>
       <tbody>
       <?php
         foreach($result as $item){
            echo" <tr>
            <td>{$item["nim"]}</td>
            <td>{$item["nama"]}</td>
            <td>{$item["alamat"]}</td>
            <td>{$item["telepon"]}</td>
            <td> <a href='formmahasiswa.php?mode=edit&id={$item["nim"]}' ' class='btn btn-warning btn-block'>Edit</a></td>
            <td> <a href='listmahasiswa.php?mode=hapus&nim={$item['nim']}'
            onclick='return confirm(\"anda yakin hapus?\")'
            class='btn btn-danger btn-block'>Hapus</a></td>
             </tr>";
         }
       ?>
        

      <div class="card-body"></div>
    </div>
<?php 
   include("components/footer.php");
?>