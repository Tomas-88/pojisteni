<?php

/*  _____ _______         _                      _
 * |_   _|__   __|       | |                    | |
 *   | |    | |_ __   ___| |___      _____  _ __| | __  ___ ____
 *   | |    | | '_ \ / _ \ __\ \ /\ / / _ \| '__| |/ / / __|_  /
 *  _| |_   | | | | |  __/ |_ \ V  V / (_) | |  |   < | (__ / /
 * |_____|  |_|_| |_|\___|\__| \_/\_/ \___/|_|  |_|\_(_)___/___|
 *                                _
 *              ___ ___ ___ _____|_|_ _ _____
 *             | . |  _| -_|     | | | |     |  LICENCE
 *             |  _|_| |___|_|_|_|_|___|_|_|_|
 *             |_|
 *
 * IT ZPRAVODAJSTVÍ  <>  PROGRAMOVÁNÍ  <>  HW A SW  <>  KOMUNITA
 *
 * Tento zdrojový kód je součástí výukových seriálů na
 * IT sociální síti WWW.ITNETWORK.CZ
 *
 * Kód spadá pod licenci prémiového obsahu a vznikl díky podpoře
 * našich členů. Je určen pouze pro osobní užití a nesmí být šířen.
 * Více informací na http://www.itnetwork.cz/licence
 */

abstract class  Kontroler
{

    //array Pole, jehož indexy jsou poté viditelné v šabloně jako běžné proměnné
    protected array $data = array();
    //string Název šablony bez přípony
    protected string $pohled = "";
    //array|string[] Hlavička HTML stránky
    protected array $hlavicka = array('titulek' => '', 'klicova_slova' => '', 'popis' => '');

    //     * Hlavní metoda controlleru, array $parametry Pole parametrů pro využití kontrolerem
    abstract function zpracuj(array $parametry): void;

    public function vypisPohled(): void
    {
        if ($this->pohled) {
            extract($this->osetri($this->data));
            extract($this->data, EXTR_PREFIX_ALL, "");
            require("pohledy/" . $this->pohled . ".phtml");
        }
    }

    //Přesměruje na dané URL,  $url URL adresa, na kterou přesměrovat. return never
    public function presmeruj(string $url): never
    {
        header("Location: /$url");
        header("Connection: close");
        exit;
    }

    //Datové typy u funkce neuvádím, protože funkce zvládá ošetřovat jak null, tak string, tak pole, tak i ostatní datové typy.
    private function osetri($x = null)
    {
        if (!isset($x))
            return null;
        elseif (is_string($x))
            return htmlspecialchars($x, ENT_QUOTES);
        elseif (is_array($x)) {
            foreach ($x as $k => $v) {
                $x[$k] = $this->osetri($v);
            }
            return $x;
        } else
            return $x;
    }

    /**
     * Přidá zprávu pro uživatele
     * @param string $zprava Hláška k zobrazení
     * @return void
     */
    public function pridejZpravu(string $zprava): void
    {
        if (isset($_SESSION['zpravy']))
            $_SESSION['zpravy'][] = $zprava;
        else
            $_SESSION['zpravy'] = array($zprava);
    }

    /**
     * Vrátí zprávy pro uživatele
     * @return array Všechny uložené hlášky k zobrazení
     */
    public function vratZpravy(): array
    {
        if (isset($_SESSION['zpravy'])) {
            $zpravy = $_SESSION['zpravy'];
            unset($_SESSION['zpravy']);
            return $zpravy;
        } else
            return array();
    }

    public function overUzivatele(bool $admin = false): void
    {
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        if (!$uzivatel || ($admin && !$uzivatel['admin'])) {
            $this->pridejZpravu('Nedostatečná oprávnění.');
            $this->presmeruj('prihlaseni');
        }
    }
}