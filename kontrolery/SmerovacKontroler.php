<?php

class SmerovacKontroler extends Kontroler
{

    protected Kontroler $kontroler;

    private function pomlckyDoVelbloudiNotace(string $text): string
    {
        $veta = str_replace('-', ' ', $text);
        $veta = ucwords($veta);
        $veta = str_replace(' ', '', $veta);
        return $veta;
    }

    public function zpracuj(array $parametry): void
    {
        $naparsovanaURL = $this->parsujURL($parametry[0]);
        if (empty($naparsovanaURL[0]))
            $this->presmeruj('uvod');
        $tridaKontroleru = $this->pomlckyDoVelbloudiNotace(array_shift($naparsovanaURL)) . 'Kontroler';
        if (file_exists('kontrolery/' . $tridaKontroleru . '.php'))
            $this->kontroler = new $tridaKontroleru;
        else
            $this->presmeruj('chyba');

        // Volání controlleru
        $this->kontroler->zpracuj($naparsovanaURL);

        //Nastavení proměnných pro šablonu
        $this->data['titulek'] = $this->kontroler->hlavicka['titulek'];
        $this->data['popis'] = $this->kontroler->hlavicka['popis'];
        $this->data['klicova_slova'] = $this->kontroler->hlavicka['klicova_slova'];
        $this->data['zpravy'] = $this->vratZpravy();

        //Nastavení hlavní šablony
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $this->data['admin'] = $uzivatel && $uzivatel['admin'];
        $this->data['uzivatel'] = $uzivatel;
        if ($this->data['admin']) {
            $this->pohled = 'rozlozeniUzivatel';
        } else if ($this->data['uzivatel']) {
            $this->pohled = 'rozlozeniUzivatel';
        } else {
            $this->pohled = 'rozlozeni';
        }
    }


    private function parsujURL(string $url): array
    {
        // Naparsuje jednotlivé části URL adresy do asociativního pole
        $naparsovanaURL = parse_url($url);
        // Odstranění počátečního lomítka
        $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
        // Odstranění bílých znaků kolem adresy
        $naparsovanaURL["path"] = trim($naparsovanaURL["path"]);
        // Rozbití řetězce podle lomítek
        $rozdelenaCesta = explode("/", $naparsovanaURL["path"]);
        return $rozdelenaCesta;
    }
}