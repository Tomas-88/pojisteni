<?php

class ProfilKontroler extends Kontroler
{

    public function zpracuj(array $parametry): void
    {

        // Hlavička stránky
        $this->hlavicka['titulek'] = 'Profil';
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();

        if (htmlspecialchars(isset($_GET['id']))) {
            $uzivatel = $spravceUzivatelu->vratUzivateleDb(htmlspecialchars($_GET['id']));
        }

        if (!$uzivatel) {
            $this->presmeruj('prihlaseni');
        }
        $this->data['email'] = $uzivatel['email'];
        $this->data['jmeno'] = $uzivatel['jmeno'];
        $this->data['prijmeni'] = $uzivatel['prijmeni'];
        $this->data['adresa'] = $uzivatel['adresa'];
        $this->data['mesto'] = $uzivatel['mesto'];
        $this->data['psc'] = $uzivatel['psc'];
        $this->data['id'] = $uzivatel['uzivatel_id'];

// proc se pole vypisuje dvakrat?
        //$this->data['uzivatel'] = $uzivatel;

        $spravcePojisteni = new SpravcePojisteni();
        $this->data['pojisteni'] = $spravcePojisteni->vratPojisteni($uzivatel['uzivatel_id']);


        $this->pohled = 'profil';
    }
}