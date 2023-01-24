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

class Db
{
    private static PDO $spojeni;

    private static array $nastaveni = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    public static function pripoj(string $host, string $uzivatel, string $heslo, string $databaze): void
    {
        if (!isset(self::$spojeni)) {
            self::$spojeni = @new PDO(
                "mysql:host=$host;dbname=$databaze",
                $uzivatel,
                $heslo,
                self::$nastaveni
            );
        }
    }

    public static function dotazJeden(string $dotaz, array $parametry = array()): array|bool
    {
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetch();
    }

    public static function dotazVsechny(string $dotaz, array $parametry = array()): array|bool
    {
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetchAll();
    }

    public static function dotazSamotny(string $dotaz, array $parametry = array()): string
    {
        $vysledek = self::dotazJeden($dotaz, $parametry);
        return $vysledek[0];
    }

    //Spustí dotaz a vrátí počet ovlivněných řádků
    public static function dotaz(string $dotaz, array $parametry = array()): int
    {
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->rowCount();
    }

    /**
     * Vloží do tabulky nový řádek jako data z asociativního pole
     * @param string $tabulka Název databázové tabulky
     * @param array $parametry Asociativní pole parametrů pro vložení
     * @return bool TRUE v případě úspěšného provedení dotazu
     */
    public static function vloz(string $tabulka, array $parametry = array()): bool
    {
        return self::dotaz(
            "INSERT INTO `$tabulka` (`" .
                implode('`, `', array_keys($parametry)) .
                "`) VALUES (" . str_repeat('?,', sizeOf($parametry) - 1) . "?)",
            array_values($parametry)
        );
    }

    /**
     * Změní řádek v tabulce tak, aby obsahoval data z asociativního pole
     * @param string $tabulka Název databázové tabulky
     * @param array $hodnoty Asociativní pole hodnot ke změně
     * @param $podminka Podmínka pro ovlivňované záznamy ("WHERE ...")
     * @param array $parametry Asociativní pole dalších parametrů
     * @return bool TRUE v případě úspěšného provedení dotazu
     */
    public static function zmen(string $tabulka, array $hodnoty = array(), string $podminka, array $parametry = array()): bool
    {
        return self::dotaz(
            "UPDATE `$tabulka` SET `" .
                implode('` = ?, `', array_keys($hodnoty)) .
                "` = ? " . $podminka,
            array_merge(array_values($hodnoty), $parametry)
        );
    }

    /**
     * Vrací ID posledně vloženého záznamu
     * @return int ID posledního vloženého záznamu
     */
    public static function posledniId(): int
    {
        return self::$spojeni->lastInsertId();
    }

}