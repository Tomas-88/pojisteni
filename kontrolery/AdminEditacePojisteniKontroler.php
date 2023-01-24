<?php

class AdminEditacePojisteniKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        $this->hlavicka['titulek'] = 'Editace Pojištění';

        $spravcePojisteni = new SpravcePojisteni();
        $spravceUzivatelu = new SpravceUzivatelu();

        //nachystám si proměnné na potom, abych jim mohl dát hodnoty až v ifu, ale zároveň byly funkční i mimo něj
        $pojistka = null;
        $pojistka_uzivatel = null;
        $uzivatel = null;

        $uzivatel = $spravceUzivatelu->vratUzivatele();
        if (!$uzivatel) {
            $this->presmeruj('registrace');
        }
        elseif (!$uzivatel['admin']) {
            $this->presmeruj('profil');
        }

        if (htmlspecialchars(isset($_GET['id']))) {
            $uzivatel = $spravceUzivatelu->vratUzivatele(); // upravující uživatel
            if (!$uzivatel) {
                $this->presmeruj('registrace');
            } elseif (!$uzivatel['admin']) {
                $this->presmeruj('profil');
            }

            // přes left join si vytáhnu pojistění i pojištěnce
            $vysledekJoinu = $spravcePojisteni->vratPojisteniDb(htmlspecialchars($_GET['id']));
            // pak si je všechny dám zvlášť do proměnných, abych je nemusel složitě vypisovat
            $pojistka = SpravcePojisteni::vytvorPojistku($vysledekJoinu);
            $pojistka_uzivatel = SpravceUzivatelu::vytvorUzivatele($vysledekJoinu);

            if (!$pojistka_uzivatel) {  // získali jsme pojistku?
                $this->presmeruj('registrace');
            }

            // nahrání dat do pohedu
            $this->data['castka'] = $pojistka['castka'];
            $this->data['platnost_od'] = $pojistka['platnost_od'];
            $this->data['platnost_do'] = $pojistka['platnost_do'];
            $this->data['pojistenec_id'] = $pojistka['pojistenec_id'];
            $this->data['pojisteni_id'] = $pojistka['pojisteni_id'];
            $this->data['jmeno'] = $pojistka_uzivatel['jmeno'];
            $this->data['prijmeni'] = $pojistka_uzivatel['prijmeni'];
        }

        if ($_POST)
            try {
                $upravenePojisteni = array(
                    'castka' => $_POST['castka'],
                    'platnost_od' => $_POST['platnost_od'],
                    'platnost_do' => $_POST['platnost_do'],
                );
                $spravcePojisteni->upravPojisteni($pojistka['pojisteni_id'], $upravenePojisteni);
                $this->pridejZpravu('Pojištění upraveno');
                $this->presmeruj('admin-uzivatele');
            } catch (ChybaUzivatele $chyba) {
                $this->pridejZpravu($chyba->getMessage());
            }
        $this->pohled = 'admin-editace-pojisteni';
    }
}
