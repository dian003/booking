<?PHP

if(isset($_POST['submit'])){
    $links = preg_split("/\\r\\n|\\r|\\n/", $_POST['urls']);
    
    foreach($links as $link){
        $newlink = file_get_contents('https://tinyurl.com/api-create.php?url=' . $link);
        echo($link . ' => ' . $newlink.'<br>');
    }
}else{
    echo('
    1 URL per line:<br>
    <form action="" method="POST" name="form">
    <textarea name="urls" rows="20" cols="75" form="form">
    </textarea>
    <input type="submit" name="submit" value="submit">
    </form>
    ');
}
?>
