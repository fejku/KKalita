<!-- TODO:  -->
<!-- EDYCJA PLIKU OBRAZKA I INNYCH PLIKOW -->
<!-- WYGLAD PRZYCISKOW -->
<!-- KOMENTARZE -->
<?php
    require './top.php';
?>
<?php
    
    //DODAWANIE PROJEKTOW
    if(!empty($_POST['nazwa']))
    {
        $blad = 0;
        //USTALENIE KOLEJNEGO ID
        $query = "SELECT MAX(id) AS new_id FROM projekty";
        try
        {
            $stmt = $db->prepare($query);
            $stmt->execute();
        }
        catch(PDOException $ex)
        {
            $blad = 1;
            //die("Failed to run query: " . $ex->getMessage());
        }
        $row = $stmt->fetch();
        $new_id = $row['new_id'] + 1;
        
        //DODAWANIE PLIKOW
        if($blad == 0)
            $blad = ProjektyDodajObrazek($_FILES['obrazek']);
        if($blad == 0)
            $blad = ProjektyDodajPlik($_FILES['bin']);
        if($blad == 0)
            $blad = ProjektyDodajPlik($_FILES['zrodlo']);
        
        //DODAWANIE PROJEKTU DO BAZY
        $query = "
            INSERT INTO projekty (
                id,
                nazwa,
                obrazek,
                opis,
                status,
                jezyk,
                bin,
                zrodlo,
                dodano
            ) VALUES (
                :id,
                :nazwa,
                :obrazek,
                :opis,
                :status,
                :jezyk,
                :bin,
                :zrodlo,
                :dodano
            )
        ";
        
        $data_dodania = new DateTime();
        $data_dodania = $data_dodania->format('Y-m-d H:i:s');
        
        //echo var_dump($_FILES);
        $query_params = array(
            ':id' => $new_id,
            ':nazwa' => $_POST['nazwa'],
            ':obrazek' => $new_id.".png",
            ':opis' => $_POST['opis'],
            ':status' => $_POST['status'],
            ':jezyk' => $_POST['jezyk'],
            ':bin' => $new_id.".zip",
            ':zrodlo' => $new_id.".zip",
            ':dodano' => $data_dodania
        );
        
        try
        {
            // Execute the query to create the user
            $stmt = $db->prepare($query);
            //CZY DODAWANIE SIE POWIODLO
            if($blad == 0)
            {
                //move_uploaded_file($_FILES['obrazek']['tmp_name'], "moje_projekty/obrazki/".$new_id.".png");
                ZmienRozmiarObrazka($_FILES['obrazek'], 160, "moje_projekty/obrazki/".$new_id.".png");
                move_uploaded_file($_FILES['bin']['tmp_name'], "moje_projekty/obrazki/".$new_id.".zip");
                move_uploaded_file($_FILES['zrodlo']['tmp_name'], "moje_projekty/obrazki/".$new_id.".zip");
                $result = $stmt->execute($query_params);
                echo 'Dodano nowy projekt';
            }
            elseif ($blad == 1)
                echo 'Błąd połączenia z bazą danych :(';
            else
                echo 'Nie udało się przesłać plików :(';
        }
        catch(PDOException $ex)
        {
            echo 'Błąd połączenia z bazą danych :(';
            //die("Failed to run query: " . $ex->getMessage());
        }

    }
    
    //EDYCJA PROJEKTU
    if(isset($_POST['submit_zmien']))
    {
        $query = "UPDATE projekty SET 
                nazwa = :nazwa,
                opis = :opis,
                status = :status,
                jezyk = :jezyk
                WHERE id = :id";
        
        $query_params = array(
            ":nazwa" => $_POST['edit_nazwa'],
            ":opis" => $_POST['edit_opis'],
            ":status" => $_POST['edit_status'],
            ":jezyk" => $_POST['edit_jezyk'],
            ":id" => $_POST['zmien_id']
        );
        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch (PDOException $ex)
        {

        }
    }
    
    //USUWANIE PROJEKTU
    if(!empty($_POST['usun_id']))
    {
        $query = "DELETE FROM projekty WHERE id = :id";

        $query_params = array(
            ':id' => $_POST['usun_id']
        );
        
        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        } catch (PDOException $ex) {
            die("Nie udało się usunąc rekordu");
        }
    }
?>
    <?php if(Zalogowany()) {?>
    <div id="projektyDodawanie">
        <div class="wysrodkuj"><div class="MarginesyH2"><h2>Dodawanie nowych projektów</h2></div></div>
    <form action="projekty.php" method="post" enctype="multipart/form-data">
        <table id="tabelaProjektyDodawanie" class="wysrodkuj">
            <tr>
                <td>Podaj nazwę:</td>
                <td class="prawa"><input class="prawa" name="nazwa" type="text"></input></td>
            </tr>
            <tr>
                <td>Wybierz obrazek:</td>
                <td class="prawa"><input class="prawa" name="obrazek" type="file"></input></td>
            </tr>
            <tr>
                <td>Opis:</td>
                <td class="prawa"><textarea class="prawa" name="opis"></textarea></input></td>
            </tr>
            <tr>
                <td>Status projektu:</td>
                <td class="prawa">
                    <select class="prawa" name="status">
                        <option value="1">
                            Skończony
                        </option>
                        <option value="2">
                            W trakcie tworzenia
                        </option>
                        <option value="3">
                            Porzucony
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Język:</td>
                <td class="prawa">
                    <select class="prawa" name="jezyk">
                        <option value="1">
                            C#
                        </option>
                        <option value="2">
                            C/C++
                        </option>
                        <option value="3">
                            Java
                        </option>
                        <option value="4">
                            PHP
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Wybierz bin:</td>
                <td class="prawa"><input class="prawa" name="bin" type="file"></input></td>
            </tr>
            <tr>
                <td>Wybierz źródło:</td>
                <td class="prawa"><input class="prawa" name="zrodlo" type="file"></input></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Dodaj">
                </td>
            </tr>
        </table>
    </form>
    </div>
    <?php } ?>
    <div class="wysrodkuj"><div class="MarginesyH2"><h2>Projekty</h2></div></div>
    <?php
        $query = "
            SELECT
                id,
                nazwa,
                obrazek,
                opis,
                status,
                jezyk,
                bin,
                zrodlo,
                dodano
            FROM projekty
            ORDER BY id
        ";
        
        try
        {
            // These two statements run the query against your database table.
            $stmt = $db->prepare($query);
            $stmt->execute();
        }
        catch(PDOException $ex)
        {
            // Note: On a production website, you should not output $ex->getMessage().
            // It may provide an attacker with helpful information about your code. 
            die("Failed to run query: " . $ex->getMessage());
        }
        
        $rows = $stmt->fetchAll();
    ?>
    <div id="projektyWyswietlanie">
        <?php foreach($rows as $row) 
        {
            if(!empty($_POST['edytuj_id']))
                if($row['id'] == $_POST['edytuj_id'])
                {
        ?>
        <!--EDYTOWANIE-->
        <form action="projekty.php" method="post">
            <div class="projekt">
                <div class="obrazek"><img src="./moje_projekty/obrazki/<?php echo $row['obrazek'] ?>" /></div>
                <div class="info">
                    <div class="naglowek">Nazwa:</div>
                    <div class="zawartosc"><input id="edit_nazwa" type="text" name="edit_nazwa" value="<?php echo $row['nazwa'] ?>" /></div>
                    <div class="naglowek">Język:</div>
                    <div class="zawartosc">
                        <select name="edit_jezyk">
                            <option value="1" <?php if($row['jezyk'] == 1) echo 'selected'; ?>>
                                C#
                            </option>
                            <option value="2" <?php if($row['jezyk'] == 2) echo 'selected'; ?>>
                                C/C++
                            </option>
                            <option value="3" <?php if($row['jezyk'] == 3) echo 'selected'; ?>>
                                Java
                            </option>
                            <option value="4" <?php if($row['jezyk'] == 4) echo 'selected'; ?>>
                                PHP
                            </option>
                        </select>
                    </div>
                    <div class="naglowek">Status:</div>
                    <div class="zawartosc">
                        <select name="edit_status">
                            <option value="1" <?php if($row['status'] == 1) echo 'selected'; ?>>
                                Skończony
                            </option>
                            <option value="2" <?php if($row['status'] == 2) echo 'selected'; ?>>
                                W trakcie tworzenia
                            </option>
                            <option value="3" <?php if($row['status'] == 3) echo 'selected'; ?>>
                                Porzucony
                            </option>
                        </select>
                    </div>
                    <div class="naglowek">Plik wykonalny:</div>
                    <div class="zawartosc"><?php echo ProjektyPlik($row['bin'], true) ?></div>
                    <div class="naglowek">Plik źródłowy:</div>
                    <div class="zawartosc"><?php echo ProjektyPlik($row['zrodlo'], false) ?></div>
                    <div class="naglowek">Opis:</div>
                    <div class="zawartosc"><textarea id="edit_opis" name="edit_opis"><?php echo $row['opis'] ?></textarea></div>
                </div>
                <div class="opcje">
                        <input type="submit" name="submit_anuluj" value="Anuluj"/>
                        <input type="hidden" name="zmien_id" value="<?php echo $row['id'] ?>" />
                        <input type="submit" name="submit_zmien" value="Zmień" />
                    <div class="clear"></div>
                </div>
            </div>
        </form>
        <!--KONIEC EDYTOWANIA-->
        <?php   }
            if(empty($_POST['edytuj_id']) || ((!empty($_POST['edytuj_id'])) && ($row['id'] != $_POST['edytuj_id'])))
            {
        ?>
        <!--WYSWIETLANIE-->
        <div class="projekt">
            <div class="tytul"><h3><?php echo $row['nazwa'] ?></h3></div>
            <div class="obrazek"><img src="./moje_projekty/obrazki/<?php echo $row['obrazek'] ?>" /></div>
            <div class="info">
                <div class="naglowek">Dodano:</div>
                <div class="zawartosc"><?php echo $row['dodano'] ?></div>
                <div class="naglowek">Język:</div>
                <div class="zawartosc"><?php echo ProjektyJezyk($row['jezyk']) ?></div>
                <div class="naglowek">Status:</div>
                <div class="zawartosc"><?php echo ProjektyStatus($row['status']) ?></div>
                <div class="naglowek">Plik wykonalny:</div>
                <div class="zawartosc"><?php echo ProjektyPlik($row['bin'], true) ?></div>
                <div class="naglowek">Plik źródłowy:</div>
                <div class="zawartosc"><?php echo ProjektyPlik($row['zrodlo'], false) ?></div>
                <div class="naglowek">Opis:</div>
                <div class="zawartosc"><?php echo $row['opis'] ?></div>
            </div>
            <div class="opcje">
<!--                <form method="post">
                    <input type="submit" name="submit_komenatarz_<?php echo $row['id'] ?>" value="(<?php echo IloscKomentarzy($db, $row['id'], 2)?>) Komentarze" />
                </form>-->
                <?php if(Zalogowany()) { ?>
                <form id="form_usun_<?php echo $row['id'] ?>" method="post">
                    <input type="hidden" name="usun_id" value="<?php echo $row['id'] ?>" />
                    <input type="submit" name="submit_usun_<?php echo $row['id'] ?>" value="Usuń" />
                </form>
                <form id="form_edytuj_<?php echo $row['id'] ?>" method="post">
                    <input type="hidden" name="edytuj_id" value="<?php echo $row['id'] ?>" />
                    <input type="submit" name="submit_edytuj_<?php echo $row['id'] ?>" value="Edytuj" />
                </form>
                <div class="clear"></div>
                <?php } ?>
            </div>
        </div>
        <!--KONIEC WYSWIETLANIA-->
        <?php 
            }
        }
        ?>
    </div>
<?php
    include './bottom.php';
?>