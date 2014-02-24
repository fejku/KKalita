<?php
    function Zalogowany()
    {
        if(empty($_SESSION['user']))
            return false;
        else
            return true;
    }
    
    //KOMENTARZE
    function IloscKomentarzy($db, $idElement, $idKategoria)
    {
        $query = "SELECT COUNT(*) AS ilosc FROM komentarze WHERE  id_kategoria = :id_kategoria AND id_element = :id_element";
        
        $query_params = array(
            ":id_kategoria" => $idKategoria,
            ":id_element" => $idElement
        );
        
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
            $row = $stmt->fetch();
            return $row['ilosc'];
        } catch (PDOException $ex) {
            die(':)'.$ex);
        }
        
    }
    //END KOMENTARZE
    
    //PROJEKTY
    function ProjektyJezyk($num_jezyka)
    {
        switch($num_jezyka)
        {
            case '1' :
                return "C#";
                break;
            case '2' :
                return "C/C++";
                break;
            case '3' :
                return "Java";
                break;
            case '4' :
                return "PHP";
                break;
            default :
                return "-1";
        }
    }
    
    function ProjektyStatus($num_status)
    {
        switch($num_status)
        {
            case '1' :
                return "Skończony";
                break;
            case '2' :
                return "W trakcie tworzenia";
                break;
            case '3' :
                return "Porzucony";
                break;
            default :
                return "-1";
        }
    }
    
    function ProjektyPlik($plik, $czy_bin)
    {
        if(empty($plik))
            echo "Brak pliku";
        else
            if($czy_bin)
                echo "<a href=\"./moje_projekty/bin/$plik\">Pobierz program</a>";
            else
                echo "<a href=\"./moje_projekty/source/$plik\">Pobierz źródło programu</a>";
    }
    
    function ProjektyDodajObrazek($obrazek)
    {
        $dozwolone_rozszerzenia = array("gif", "jpeg", "jpg", "png");
        $temp = explode('.', $obrazek['name']);
        $rozszerzenie = strtolower(end($temp));
        //CZY ZGADZA SIE TYP WIELKOSC I ROZSZERZENIE PLIKU
        if((($obrazek['type'] == "image/gif")
                || ($obrazek['type'] == "image/jpeg")
                || ($obrazek['type'] == "image/jpg")
                || ($obrazek['type'] == "image/pjpeg")
                || ($obrazek['type'] == "image/x-png")
                || ($obrazek['type'] == "image/png"))
                && ($obrazek['size'] < 5*1024*1024)
                && in_array($rozszerzenie, $dozwolone_rozszerzenia))
        {
            //CZY WYSTAPIL BLAD PODCZAS WGRYWANIA PLIKU
            if ($obrazek['error'] > 0)
            {
                return 2;
                //echo "Błąd przy wgrywaniu pliku";
            }
            else
            {
                //WSZYSTKO JEST PRAWIDŁOWO
                return 0;
            }
        }
        else
        {
            return 2;
            //echo 'Nieprawidłowy lub zbyt duży plik.';
        }
    }
    
    function ProjektyDodajPlik($plik)
    {
        $dozwolone_rozszerzenia = array("zip");
        $temp = explode('.', $plik['name']);
        $rozszerzenie = strtolower(end($temp));
        //CZY ZGADZA SIE TYP WIELKOSC I ROZSZERZENIE PLIKU
        if(empty($plik['name']))
        {
            return 0;
        }
        else
        {
            if((($plik['type'] == 'application/x-zip')
                    || ($plik['type'] == 'application/zip')
                    || ($plik['type'] == 'application/x-zip-compressed'))
                    && ($plik['size'] < 5*1024*1024)
                    && in_array($rozszerzenie, $dozwolone_rozszerzenia))
            {
                //CZY WYSTAPIL BLAD PODCZAS WGRYWANIA PLIKU
                if ($plik['error'] > 0)
                {
                    return 2;
                    //echo "Błąd przy wgrywaniu pliku";
                }
                else
                {
                    //WSZYSTKO JEST PRAWIDŁOWO
                    return 0;
                }
            }
            else
            {
                return 2;
                //echo 'Nieprawidłowy lub zbyt duży plik.';
            }
        }
    }
    
    function ZmienRozmiarObrazka($obrazekWejsciowy, $szerokosc, $obrazekWyjsciowy)
    {
        list($w, $h) = getimagesize($obrazekWejsciowy['tmp_name']);
        $stosunek = $w / $h;
        //ceil - zakraglenie
        $nowaWysokosc = ceil($szerokosc / $stosunek);
        
        //wczytaj binarne dane obrazka
        $imgString = file_get_contents($obrazekWejsciowy['tmp_name']);
        $image = imagecreatefromstring($imgString);
        $tmp = imagecreatetruecolor($szerokosc, $nowaWysokosc);
        imagecopyresampled($tmp, $image, 0, 0, 0, 0, 160, $nowaWysokosc, $w, $h);
        imagepng($tmp, $obrazekWyjsciowy, 0);
        
        imagedestroy($image);
        imagedestroy($tmp);
    }
    //END PROJEKTY
    
    //NEWS
    function ZwrocData($data)
    {
        $miesiac_slownie = array(
            1 => 'stycznia', 2 => 'lutego', 3 => 'marca', 4 => 'kwietnia',
            5 => 'maja', 6 => 'czerwca', 7 => 'lipca', 8 => 'sierpnia',
            9 => 'wrzesnia', 10 => 'października', 11 => 'listopada', 12 => 'grudnia'
        );
        
        $dzien = date('d', strtotime($data));
        $miesiac = date('n', strtotime($data));
        $rok = date('Y', strtotime($data));
        
        return $dzien.' '.$miesiac_slownie[$miesiac].' '.$rok;
    }
    
    function ZwrocAutor($username, $imie, $nazwisko)
    {
        if(empty($imie) || empty($nazwisko))
            return $username;
        else
            return $imie.' '.$nazwisko;
    }
    
//    function ZwrocAutor($db, $idAutor)
//    {
//        $query = 'SELECT username, imie, nazwisko '
//                . 'FROM users '
//                . 'WHERE id = :id';
//        
//        $query_params = array (
//            ':id' => $idAutor
//        );
//        try
//        {
//            $stmt = $db->prepare($query);
//            $result = $stmt->execute($query_params);
//        } catch (PDOException $ex) {
//            //Cos tam
//        }
//        
//        $autor = $stmt->fetch();
//        if(!empty($autor))
//        {
//            if(empty($autor['imie']) || empty($autor['nazwisko']))
//                return $autor['username'];
//            else
//                return $autor['imie'].' '.$autor['nazwisko'];
//        }
//        else
//        {
//            //Nie znaleziono autora news-a
//        }
//    }

    function SprawdzNewsTags($tags, $news_id, $get_tag_id)
    {
            foreach($tags as $tag_e)
            {
                if($get_tag_id == $tag_e['tags_id'])
                    if($tag_e['news_id'] == $news_id)
                        return true;
            }
            return false;
    }
    //END NEWS