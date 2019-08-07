<?php
include("components/header.php");
include("components/navbar.php");
include("functions/koneksidb.php");
if(isset($_GET["mode"])){
if($_GET["mode"] == "edit"){
$id = $_GET["id"];
$statement = $conn->prepare(
"select * from tblnilai
where idnilai=:idnilai"
);
$statement->bindParam(":idnilai",$id);
$statement->execute();
$result = $statement->fetch();
}
}
if(isset($_POST["simpan"])){
if($_POST["mode"]=="tambah"){
$statement = $conn->prepare(
"insert into tblnilai(nim,idkelas,idmatakuliah,kehadiran,tugas,mid,uas,total,huruf)
values(:nim,:idkelas,:idmatakuliah,:kehadiran,:tugas,:mid,:uas,:total,:huruf)"
);
}elseif($_POST["mode"]=="edit"){
$id = $_POST["id"];
$statement = $conn->prepare(
"update tblnilai
set nim=:nim,
idkelas=:idkelas,
idmatakuliah=:idmatakuliah,
kehadiran=:kehadiran,
tugas=:tugas,
mid=:mid,
uas=:uas,
total=:total,
huruf=:huruf
where idnilai=:idnilai"
);
$statement->bindParam(":idnilai",$id);
}
$statement->bindParam(":nim",$_POST["nim"]);
$statement->bindParam(":idkelas",$_POST["idkelas"]);
$statement->bindParam(":idmatakuliah",$_POST["idmatakuliah"]);
$statement->bindParam(":kehadiran",$_POST["kehadiran"]);
$statement->bindParam(":tugas",$_POST["tugas"]);
$statement->bindParam(":mid",$_POST["mid"]);
$statement->bindParam(":uas",$_POST["uas"]);
$statement->bindParam(":total",$_POST["total"]);
$statement->bindParam(":huruf",$_POST["huruf"]);
try{
    $result = $statement->execute();
if($result){
    header("location:listnilai.php");
}
}catch(Exception $e){
    $error = $e->getMessage();
}
}
function querydata($sql){
    include("functions/koneksidb.php");
$statement = $conn->prepare($sql);
$statement->execute();
    return $statement->fetchAll();
};
    $mahasiswa = querydata("select * from tblmahasiswa");
        $kelas = querydata("select * from tblkelas");
    $matakuliah = querydata("select * from tblmatakuliah");
?>

<div class="container mt-2">
<?php
if(isset($error)){
echo "<div class='alert alert-danger'>{$error}</div>";
}
?>

<div class="card">
<div class="card-header bg-primary text-white"><h4>Form Nilai</h4></div>
<div class="card-body">
<form action="formnilai.php" method="POST">

<?php
if(isset($_GET["mode"])){
echo "<input type='hidden' name='mode' value='{$_GET["mode"]}'>";
if(isset($_GET["id"])){
echo "<input type='hidden' name='id' value='{$_GET["id"]}'>";
}
}
?>

<div class="form-group">
<label for="nim">NIM</label>
<select name="nim" id="nim"
class="form-control">

<?php
foreach($mahasiswa as $item){
echo "<option value={$item["nim"]} ".((isset($result) && $result["nim"]==$item["nim"])?"SELECTED":"").">
{$item["nim"]} - {$item["nama"]}
</option>";
}
?>

</select>
</div>
<div class="form-group">
<label for="idkelas">Kelas</label>
<select name="idkelas" id="idkelas" class="form-control">

<?php
foreach($kelas as $item){
echo "<option value='{$item['idkelas']}' ".((isset($result) && $result["idkelas"]==$item["idkelas"])?"SELECTED":"").">
{$item["nama"]}
</option>";
}
?>

</select>
</div>
<div class="form-group">
<label for="idmatakuliah">Mata Kuliah</label>
<select name="idmatakuliah" id="idmatakuliah" class="form-control">

<?php
foreach($matakuliah as $item){
echo "<option value='{$item['idmatakuliah']}' ".((isset($result) && $result["idmatakuliah"]==$item["idmatakuliah"])?"SELECTED":"").">
{$item["nama"]}
</option>";
}
?>

</select>
</div>
<div class="form-group">
   <label for="kehadiran">Kehadiran</label>
    <input type="number" name="kehadiran" class="form-control"
     value="<?= isset($result)?$result["kehadiran"]:"" ?>">
</div>

<div class="form-group">
  <label for="tugas">Tugas</label>
   <input type="number" name="tugas" class="form-control"
    value="<?= isset($result)?$result["tugas"]:"" ?>">
</div>

<div class="form-group">
   <label for="mid">MID</label>
    <input type="number" name="mid" class="form-control"
   value="<?= isset($result)?$result["mid"]:"" ?>">
</div>

<div class="form-group">
      <label for="uas">UAS</label>
    <input type="number" name="uas" class="form-control"
   value="<?= isset($result)?$result["uas"]:"" ?>">
</div>

<div class="form-group">
    <label for="total">Total</label>
     <input type="number" step="any" name="total" class="form-control"
      value="<?= isset($result)?$result["total"]:"" ?>">
</div>

<div class="form-group">
   <label for="huruf">Huruf</label>
     <input type="text" name="huruf"  class="form-control"
         value="<?= isset($result)?$result["huruf"]:"" ?>">
</div>

<div class="form-group float-right">
<input type="submit" value="Simpan" name="simpan" class="btn btn-success">
<a href="listnilai.php" class="btn btn-danger">Batal</a>
</div>
</form>
</div>
</div>
</div>

<script>
  function hitungtotal(){
      var kehadiran=document.getElementsByName("kehadiran")[0].value;
      var tugas=document.getElementsByName("tugas")[0].value;
      var mid=document.getElementsByName("mid")[0].value;
      var uas=document.getElementsByName("uas")[0].value;

      return(kehadiran*0.1)+(tugas*0.2)+(mid*0.3)+(uas*0.4);
  }

    function carihuruf(){
        var total=document.getElementsByName("total")[0].value;
        var huruf="";
        switch(true){
            case(total <60): huruf="e"; break;
            case(total <69): huruf="d"; break;
            case(total <79): huruf="c"; break;
            case(total <89): huruf="b"; break;
            case(total <100): huruf="a"; break;       
             }
             return huruf;
            }
     //mengambil semua element dengan type number
    var inputbox=document.querySelectorAll("input[type='number']");
    //loping satu satu elemenya
    for(var i=0;i<inputbox.length;i++){
        inputbox[i].addEventListener("keyup",function(){
            document.getElementsByName("total")[0].value=hitungtotal();
            document.getElementsByName("huruf")[0].value=carihuruf();
        });
    }
</script>

<?php
include("components/footer.php");
?>