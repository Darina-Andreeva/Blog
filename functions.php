<?php

include"config.php";


function get_menu(){
    global $connection;
    $r=$connection->query("select * from cats");


    $result = "<a href='index.php'> Main page</a><br>";

    while ($row=mysqli_fetch_array($r))
      $result.="<a href='index.php?p=filter&cat=$row[id]>$row[cname]'</a><br>";
    return $result;
}




    function get_comments($id){
        global $connection;
        $id= strip_tags($id);
        $result="";
        if(is_numeric($id)){
            $r=$connection->query("select * from comments where rid=$id order by id desc");
            while ($row =mysqli_fetch_array($r)){
                $dt=date('d-m-y', $row['dt']);
                $result.="<hr><a href=mailto:$row[email]>$row[uname]</a>($dt)<p>$row[txt]";
            }

        }
        else $result = "Wrong arguments in get_comments()";
        return $result;
    }




 function get_blog_record($id){
     global $connection;
     $id= strip_tags($id);
     if(is_numeric($id)){
         $r= $connection->query("select * from blog where id=$id limit 1");
         $row= mysqli_fetch_array($r);
         $dt=date('d-m-y', $row['dt']);
         $comments = get_comments($id);
         $result= "<h1>$row[header]</h1>
                     <p>$dt<p>
                     <b>$row[anonce]</b>
                     <p>$row[comments]
                      <p><h2>Comments</h2><p><a href=add_comment.php?id=$id>Add comment</a>$comments";
     }
     else $result= "wrong entry ID";
     return $result;
 }



function get_cat_name($id){
    $id= strip_tags($id);
    if(is_numeric($id)){
        global $connection;
        $r= $connection->query("select * from cats WHERE  id=$id limit 1");
        $row= mysqli_fetch_array($r);
        return $row['cname'];
    }
    else return "Wrong category";

}



function get_cat($id){
     $cat =$_GET['cat'];
     if(is_numeric($cat)){
         global $connection;
         $q=$connection->query("select * from  blog WHERE  cid=$cat order by id DESC ");

         $list="";

         while ($row=mysqli_fetch_array($q)){
             $dt= date ('d-m-y H:i', $row['dt']);
             $list .= "<p><table width='100%'>
                       <tr><td bgcolor='#808080 width=80%'>$row[heaer]</td>
                        <td bgcolor='#808080' width='20%'>$dt</td></tr></table>";
             $list.= "<p>$row[anonce]";
             $cat = get_cat_name($row['cid']);
             $list .= "<p><table width='100%'>
                             <tr>
                             <td width='60%'><a href='index.php?p=show&id=$row[id]'>Read more</a></td>
                               <td width='20%'>$cat</td>>
                               <td width='20%'>Comments:  $row[comments]</td>
                               </tr></table>";
         }
         return $list;
     }
    else return "Wrong category ID";


}