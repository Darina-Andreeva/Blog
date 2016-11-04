<?php
 include"config.php";
 $connection=mysqli_connect($server, $username, $password, $db);

include"functions.php";

$header= join('',file('header.html'));
$footer=join('', file('footer.html'));

echo $header;

$left = get_menu();
$content="";
if(isset($_GET['p'])){
    $p=$_GET['p'];
    $id= $_GET['id'];
    if ($p == "show") $content = get_blog_record($id);
    elseif ($p == "filter") $content = get_cat($cat);
    else $content = "Wrong Page";
}
else {
    $N=5;
    $r1= $connection->query("select count(*)as records from blog");
    $f=mysqli_fetch_row($r1);
    $rec_count= $f[0];
    if(!isset($_GET['page'])) $page=0;
    else $page= $_GET['page'];
    $records=$page*$N;
    $q=$connection->query('select * from blog order by id desc limit '.$records.",$N");
   // $result=$connection->query($q);
    $max=mysqli_num_rows($q);
    if($page>0){
        $p= $page - 1;
        $content.="<a href=index.php?page=$p>Back</a>&nbsp";
    }
    $page++;

    if($records+$N < $rec_count)
        $content.="<a href=index.php?pge=$page>Next</a>";
    for($i=0; $i<$max; $i++){
        $row=mysqli_fetch_array($q);
        $dt=date('d-m-y H:i',$row['dt']);
        $content.="<p><table width='100%'>
                <tr><td bgcolor='#808080' width='80%'>$row[header]</td>
                <td bgcolor='#808080' width='20%'>$dt</td></tr></table>";
        $content.="<p>$row[anonce]";
        $cat=get_cat_name($row['cid']);
        $content.="<p><table width='100%'>
                           <td> <td width='60%'><a href=index.php?p=show&id=$row[id]> Read more</a></td>>
                           <td width='20%'>$cat</td>
                           <td width='20%'>Comments:  $row[comments]</td>
                           </tr></table>";

    }
}
echo "<table border='0' width='100%'>
<tr><td valign='top' width='20%'>$left</td><td valign='top'>$content</td></tr></table>
$footer";