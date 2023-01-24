<?php

class SjednatPojisteniKontroler extends Kontroler
{

    function zpracuj(array $parametry): void
    {
        $this->hlavicka['titulek'] = 'Sjednat pojištění';

        $spravcePojisteni = new SpravcePojisteni();
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();

        if (htmlspecialchars(isset($_GET['id'])))
            if ($uzivatel['uzivatel_id'] != htmlspecialchars($_GET['id']))
            $uzivatel = $spravceUzivatelu->vratUzivateleDb(htmlspecialchars($_GET['id']));

        if (!$uzivatel) {
            $this->presmeruj('registrace');
        }
        if ($_POST)
            try {
            $spravcePojisteni->vytvorPojisteni($uzivatel['uzivatel_id'], $_POST['typ_pojisteni'], $_POST['platnost_od'], $_POST['platnost_do'], $_POST['castka']);
            $this->pridejZpravu('Pojištěn');
                $this->presmeruj('profil');
            } catch (Exception $chyba) {
            $this->pridejZpravu($chyba->getMessage());
            }

        $this->pohled = 'sjednat-pojisteni';
    }
}