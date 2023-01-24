<?php

class AdminUzivateleKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        // Do administrace mají přístup jen přihlášení uživatelé
        $this->overUzivatele();
        // Hlavička stránky
        $this->hlavicka['titulek'] = 'Přihlášení';
        // Získání dat o přihlášeném uživateli
        $spravceUzivatelu = new SpravceUzivatelu();
        if (!empty($parametry[0]) && $parametry[0] == 'odhlasit') {
            $spravceUzivatelu->odhlas();
            $this->presmeruj('prihlaseni');
        }
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        if (!$uzivatel) {
            $this->presmeruj('registrace');
        }
        elseif (!$uzivatel['admin']) {
            $this->presmeruj('profil');
        }
        if (htmlspecialchars(isset($_GET['id'])) && ($uzivatel['admin'])) {
            $uzivatel = $spravceUzivatelu->vratUzivateleDb(htmlspecialchars($_GET['id']));
            if ($uzivatel == null)
                $this->presmeruj('admin-uzivatele');
            $spravceUzivatelu->odstranUzivatele($uzivatel['uzivatel_id']);
            $this->pridejZpravu('Uživatel byl smazán!');
        }

        $uzivatele = $spravceUzivatelu->vratVsechnyUzivatele();
        $this->data['uzivatele'] = $uzivatele;


        // Nastavení šablony
        $this->pohled = 'admin-uzivatele';
    }
}