<?php
    require './top.php';
?>

<?php 
    //Pobierz newsy
    $query = 'SELECT A.id, A.tytul, A.dodano, A.tresc, B.username AS autor_username, '
            . 'B.imie AS autor_imie, B.nazwisko AS autor_nazwisko, '
            . 'C.nazwa AS dzial, C.id AS dzial_id '
            . 'FROM news A '
            . 'LEFT JOIN users B ON A.autor_id = B.id '
            . 'LEFT JOIN dzial C ON A.dzial_id = C.id ';

    if(isset($_GET['dzial']))
    {
        $query .= 'WHERE dzial_id = :dzial_id ';

    
        $query_params = array(
          ':dzial_id'  => $_GET['dzial']
        );
    }
    $query .= 'ORDER BY A.dodano DESC';
    try
    {
        $stmt = $db->prepare($query);
        if(isset($_GET['dzial']))
            $stmt->execute($query_params);
        else
            $stmt->execute();
    }
    catch (PDOException $ex)
    {
        //cos tam
    }
    $newsy = $stmt->fetchAll();
    
    
    //Pobierz tagi
    $query = 'SELECT A.news_id AS news_id, A.tagi_id AS tags_id, B.nazwa '
            . 'FROM tagi_news A '
            . 'LEFT JOIN tagi B ON A.tagi_id = B.id '
            . 'ORDER BY news_id ';
    try
    {
        $stmt = $db->prepare($query);
        $stmt->execute();
    } catch (PDOException $ex) {
        // cos tam
    }
    $tagi = $stmt->fetchAll();
//    echo '<pre>';
//    print_r($tagi);
//    echo '</pre>';
?>
<div class="wysrodkuj"><div class="MarginesyH2"><h2>News</h2></div></div>
<div id="NewsWyswietlanie">
    <?php if(Zalogowany()) { ?>
    <div id="DodajNews"><button onclick="window.location='./news/news_add.php'" onmouseover=""><img src="./obrazki/dodaj.png" /></button></div>
    <?php } ?>
    <?php foreach($newsy as $news_i => $news_e) { 
        if(empty($_GET['tag']) || SprawdzNewsTags($tagi, $news_e['id'], $_GET['tag'])) { ?>
        <div class="news">
            <div class="tytul"><h3><?php echo $news_e['tytul']; ?></h3><!-- Ilosc komentarzy--></div>
            <!--Obrazek?-->
            <ul class="meta">
                <li class="data"><?php echo ZwrocData($news_e['dodano']); ?></li>
                <li class="autor"><?php echo ZwrocAutor($news_e['autor_username'], $news_e['autor_imie'], $news_e['autor_nazwisko']) ?></li>
                <li class="dzial"><a href="index.php?dzial=<?php echo $news_e['dzial_id'] ?>"><?php echo $news_e['dzial'] ?></a></li>
            </ul>
            <div class="tresc"><?php echo $news_e['tresc'] ?></div>
            <div class='tagi'>Tagi :
                <?php foreach($tagi as $tagi_i => $tagi_e) 
                { 
                    if($tagi_e['news_id'] == $news_e['id'])
                    {
                ?>
                        <a href="index.php?tag=<?php echo $tagi_e['tags_id'] ?>"><?php echo $tagi_e['nazwa'] ?></a>
                <?php
                    }
                }
                ?>
            </div>
            <?php if(Zalogowany()) { ?>
            <div class="opcje">
                <form id="newsDelete<?php echo $news_e['id'] ?>" action="./news/news_delete.php" method="post">
                    <input type="hidden" name="hUsun" value="<?php echo $news_e['id'] ?>" />
                </form>
                <button window.location='news_edit.php'><img src="obrazki/edytuj.png" /></button>
                <button type="submit" name="bUsun" form="newsDelete<?php echo $news_e['id'] ?>"><img src="obrazki/usun.png" /></button>
            </div>
            <?php } ?>
        </div>
    <?php }
        }?>
</div>
<?php
    require './bottom.php';
?>
