<?php

class AdminProfilKontroler extends ProfilKontroler
{
    public function zpracuj(array $parametry): void
    {

        parent::zpracuj($parametry);
        // Hlavička stránky
        $this->hlavicka['titulek'] = 'Admin profil';

        $spravceUzivatelu = new SpravceUzivatelu();
        $spravcePojisteni = new SpravcePojisteni();

        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $pojisteni = null;
        if (htmlspecialchars(isset($_GET['id'])))
            $pojisteni = $spravcePojisteni->vratPojisteni(htmlspecialchars($_GET['id']));
        if (!$uzivatel) {
            $this->presmeruj('registrace');
        } elseif (!$uzivatel['admin']) {
            $this->presmeruj('profil');
        }

        if (htmlspecialchars(isset($_GET['delete'])))
            if (!$uzivatel['admin']) {
                $this->pridejZpravu(Zpravy::$neniAdmin);
                $this->presmeruj('uvod');
            } else {
                $spravcePojisteni->odstranPojisteni(htmlspecialchars($_GET['delete']));
                $this->pridejZpravu(Zpravy::$odstraneno);
                $this->presmeruj('admin-profil?id=' . htmlspecialchars($_GET['id']));
            }

        $this->pohled = 'admin-profil';
    }
}
