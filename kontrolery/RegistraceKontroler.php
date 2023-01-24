<?php

class RegistraceKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        // Hlavička stránky
        $this->hlavicka['titulek'] = 'Registrace';
        if ($_POST) {
            if (empty($_POST['jmeno']) && preg_match('/^[a-zA-Z0-9]+$/', $_POST['jmeno']) == 0) {
                $this->pridejZpravu('Neplatné jméno!');
                $this->presmeruj('registrace');
            }
            if (empty($_POST['prijmeni']) && preg_match('/^[a-zA-Z0-9]+$/', $_POST['prijmeni']) == 0) {
                $this->pridejZpravu('Neplatné příjmení!');
                $this->presmeruj('registrace');
            }
            if (strlen($_POST['heslo']) > 20 || strlen($_POST['heslo']) < 5) {
                $this->pridejZpravu('Heslo musí mít 5 až 20 znaků!');
                $this->presmeruj('registrace');
            }
            if (empty($_POST['email'])) {
                $this->pridejZpravu('Vyplň email!');
                $this->presmeruj('registrace');
            } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $this->pridejZpravu('Neplatný email');
                $this->presmeruj('registrace');
            }
            if (empty($_POST['adresa']) && preg_match('/^[a-zA-Z0-9]+$/', $_POST['adresa']) == 0) {
                $this->pridejZpravu('Neplatná adresa!');
                $this->presmeruj('registrace');
            }
            if (empty($_POST['mesto']) && preg_match('/^[a-zA-Z0-9]+$/', $_POST['mesto']) == 0) {
                $this->pridejZpravu('Neplatné město!');
                $this->presmeruj('registrace');
            }
            if (empty($_POST['psc']) && preg_match('/^[0-9]{5}+$/', $_POST['psc'])) {
                $this->pridejZpravu('Neplatné PSČ!');
                $this->presmeruj('registrace');
            }
            try {
                $spravceUzivatelu = new SpravceUzivatelu();
                $spravceUzivatelu->registruj(ucfirst(trim($_POST['jmeno'])), ucfirst(trim($_POST['prijmeni'])) , trim($_POST['email']), ucfirst(trim($_POST['adresa'])), ucfirst(trim($_POST['mesto'])),trim($_POST['psc']), $_POST['heslo'], $_POST['heslo_znovu'], $_POST['rok']);
                $spravceUzivatelu->prihlas($_POST['email'], $_POST['heslo']);
                $this->pridejZpravu('Byl jste úspěšně zaregistrován.');
                $this->presmeruj('profil');
            } catch (ChybaUzivatele $chyba) {
                $this->pridejZpravu($chyba->getMessage());
            }
        }
        // Nastavení šablony
        $this->pohled = 'registrace';
    }
}