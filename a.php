

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">


</head>
<body>
<table class="table">
  <thead class="thead-dark">
    <tr>
      
      <th scope="col">resim</th>
      <th scope="col">yazi</th>
      <th scope="col">fiyat</th>
    
    </tr>
  </thead>
  <tbody>
   
<?php 

function minify($buffer) {
    $search = array(
        '/\>[^\S ]+/s', 
        '/[^\S ]+\</s',
        '/(\s)+/s'     
    );
    $replace = array(
        '>',
        '<',
        '\\1'
    );
    $buffer = preg_replace($search, $replace, $buffer);
    $buffer = str_replace('> <', '><', $buffer);
    $buffer = str_replace("\t", '', $buffer);
    $buffer = preg_replace('/<!--.*?-->/ms', '', $buffer);
    return $buffer;
}

$ch = curl_init();
curl_setopt_array($ch, [
        CURLOPT_URL => 'https://www.olx.ro/ajax/search/list/',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => http_build_query(array('search' => array('category_id' =>138))),

        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_HEADER => true,

    ]
);
  
$buffer = minify(curl_exec($ch));
curl_close($ch);
 
preg_match_all('#<img class="fleft" src="(.+?)" alt="(.+?)">#si', $buffer, $matches);
 
 preg_match_all('#<p class="price"><strong>(.+?)</strong></p>#si',$buffer,$fiyat);





$b=0;
foreach ($matches[2] as $index => $img) {
   




?>
<tr>
  <td><img src="<?php echo $matches[1][$index]; ?>" style="width:70px; height:70px;o bject-fit:cover;"></td>  
  <td><?php echo $matches[2][$index];  ?></td>
  <td><?php echo $fiyat[0][$b]; ?></td>
 

</tr>

<?php 




if (!empty($_POST['veri']) == "cek") {



$doldur= $db->prepare("INSERT INTO xtablom(resim,baslik,fiyat)VALUES(?,?,?)");
$doldur->bindParam(1,$matches[1][$index]);
$doldur->bindParam(2,$matches[2][$index]);
$doldur->bindParam(3,$fiyat[0][$b]);
$doldur->execute();

$dol= $doldur->rowCount();

if ($dol) {
    
echo 'başarılı bir şekilde veri tabanına kaydedildi';


}



}
else{




}

?>

<?php

$b++;

$page= @$_GET['page'];
}
?>
</tbody>
</table>





<nav aria-label="Page navigation example">
  <ul class="pagination">

<?php 

if ($page > 1) {



?>

    <li class="page-item"><a class="page-link" href="a.php?page=<?php echo $page-1; ?>">Previous</a></li>

<?php 

}
else{


}


?>

<?php

$gorunensayfa= 3;
$sayfa_sayisi= 25;
for($i=$page-$gorunensayfa; $i<$page+$gorunensayfa+1; $i++) { 




if($i > 0 && $i <= $sayfa_sayisi){

if($i != $page){


?>

    
    <li class="page-item"><a href="a.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a></li>

    
  

<?php 

}
}
}

if($page != $sayfa_sayisi){
?>
<li class="page-item"><a class="page-link" href="a.php?page=<?php echo $page+1; ?>">Next</a></li>

<?php 


}
?>
</ul>
</nav>

<form action="" method="post">

<button type="submit" name="veri" value="cek">Verileri çek</button>



</form>




</body>
</html>






