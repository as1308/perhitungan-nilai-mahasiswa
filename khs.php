<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KHS - Kartu Hasil Studi</title>
    <style>
        table{
            border-collapse:collapse;
        }
        td{
            padding:10px;
        }
    </style>
</head>
<body>
    
     <?php
         include("functions/koneksidb.php");

         if(isset($_GET["nim"])){
            $statement=$conn->prepare("select * from tblmahasiswa");
            $statement->bindparam(":nim",$_GET["nim"]);
            $statement->execute();
            $mahasiswa=$statement->fetch();


             $statement=$conn->prepare("select b.nama as matakuliah,a.total,a.huruf
             from tblnilai a join tblmatakuliah b on a.idmatakuliah=b.idmatakuliah 
             where nim=:nim");
            $statement->bindparam(":nim",$_GET["nim"]);
            $statement->execute();
            $nilai=$statement->fetchAll();
    }
     ?>

    <table width="30%" border="0">
       <tr>
           <td>Nim</td>
           <td>:</td>
           <td><?=$mahasiswa["nim"]?></td>
        </tr>
        <tr>
           <td>Nama</td>
           <td>:</td>
           <td><?=$mahasiswa["nama"]?></td>
        </tr>
        </table>
        <table width="100%" border="1">
        <thead>
            <th>Mata Kuliah</th>
            <th>Nilai</th>
            <th>Huruf</th>
        </thead>
        <tbody>
     
       <?php
        $grandtotal=0;
        foreach($nilai as $item){
            echo"<tr>
                     <td>{$item["matakuliah"]}</td>
                     <td>{$item["total"]}</td>
                     <td>".strtoupper($item["huruf"])."</td>
                </tr>";
                $grandtotal += $item["total"];
        }
       ?>
        <tr>
            <td>Total</td>
            <td><?=$grandtotal ?></td>
            <td></td>
        </tbody>
    </table>
</body>
</html>