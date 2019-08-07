<?php
function konversiJurusan($jurusan){
  $hasil = "";
if($jurusan == "ti"){
  $hasil = "Teknik Informatika";
}elseif($jurusan == "si"){
  $hasil = "Sistem Informasi";
}else{
   $hasil = "Jurusan tidak terdaftar";
}
return $hasil;
}
    function konversiSemester($semester){
  $hasil = "";

    switch($semester){
    case 1: $hasil = "I"; break;
    case 2: $hasil = "II"; break;
    case 3: $hasil = "III"; break;
    case 4: $hasil = "IV"; break;
    case 5: $hasil = "V"; break;
    case 6: $hasil = "VI"; break;
    case 7: $hasil = "VII"; break;
    case 8: $hasil = "VIII"; break;
    default: $hasil = "Semester tidak terdaftar";
    }
        return $hasil;
    }
?>