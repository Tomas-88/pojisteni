<?php

class ProfilEditaceKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        $this->hlavicka['titulek'] = 'Editace profilu';
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();


        if (htmlspecialchars(isset($_GET['id'])) && ($uzivatel['admin']))
            $editaceUzivatel = $spravceUzivatelu->vratUzivateleDb(htmlspecialchars($_GET['id']));
        else
            $editaceUzivatel = $spravceUzivatelu->vratUzivatele();

        if (!$uzivatel['admin'] && $uzivatel['uzivatel_id'] != $editaceUzivatel['uzivatel_id'])
            $this->presmeruj('profil-editace');

        $this->data['editaceUzivatel'] = $editaceUzivatel;
        $this->data['uzivatel'] = $uzivatel;

         if ($_POST)
             try {
             $upravenyUzivatel = array (
                 'jmeno' => $_POST['jmeno'],
                 'prijmeni' => $_POST['prijmeni'],
                 'email' => $_POST['email'],
                 'adresa' => $_POST['adresa'],
                 'mesto' => $_POST['mesto'],
                 'psc' => $_POST['psc'],
             );
                 $spravceUzivatelu->upravUzivatele($editaceUzivatel['uzivatel_id'], $upravenyUzivatel);
                 $this->pridejZpravu('Uživatel upraven');
                 $_SESSION['uzivatel'] = $spravceUzivatelu->vratUzivateleDb($uzivatel['uzivatel_id']);
                 if (!$uzivatel['admin'])
                 {
                     $this->presmeruj('profil');
                 }
                 else

                     $this->presmeruj('admin-uzivatele');


             } catch (ChybaUzivatele $chyba) {
                 $this->pridejZpravu($chyba->getMessage());

             }
        $this->pohled = 'profil-editace';
    }
}