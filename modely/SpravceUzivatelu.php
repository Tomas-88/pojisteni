<?php

// Správce uživatelů redakčního systému
class SpravceUzivatelu
{

    /**
     * Vrátí otisk hesla
     */
    public function vratOtisk(string $heslo): string
    {
        return password_hash($heslo, PASSWORD_DEFAULT);
    }

    /**
     * Registruje nového uživatele do systému
     * @throws ChybaUzivatele
     */
    public function registruj(string $jmeno, string $prijmeni, string $email, string $adresa, string $mesto, string $psc, string $heslo, string $hesloZnovu, string $rok): void
    {
        if ($rok != date('Y'))
            throw new ChybaUzivatele('Chybně vyplněný antispam.');
        if ($heslo != $hesloZnovu)
            throw new ChybaUzivatele('Hesla nesouhlasí.');
        $uzivatel = array(
            'jmeno' => $jmeno,
            'prijmeni' => $prijmeni,
            'email' => $email,
            'adresa' => $adresa,
            'mesto' => $mesto,
            'psc' => $psc,
            'heslo' => $this->vratOtisk($heslo),
        );
        try {
            Db::vloz('uzivatele', $uzivatel);
        } catch (PDOException $chyba) {
            throw new ChybaUzivatele('Uživatel s tímto emailem je již zaregistrovaný.');
        }
    }

    /**
     * Přihlásí uživatele do systému
     * @throws ChybaUzivatele
     */
    public function prihlas(string $email, string $heslo): void
    {
        $uzivatel = Db::dotazJeden('
            SELECT *
            FROM uzivatele
            WHERE email = ?
        ', array($email));
        if (!$uzivatel || !password_verify($heslo, $uzivatel['heslo']))
            throw new ChybaUzivatele('Neplatné jméno nebo heslo.');
        $_SESSION['uzivatel'] = $uzivatel;
    }

    /**
     * Odhlásí uživatele
     */
    public function odhlas(): void
    {
        unset($_SESSION['uzivatel']);
    }

    /**
     * Vrátí aktuálně přihlášeného uživatele
     */
    public function vratUzivatele(): ?array
    {
        if (isset($_SESSION['uzivatel']))
            return $_SESSION['uzivatel'];
        return null;
    }

    public function vratUzivateleDb($uzivatelId): ?array
    {
        $odpoved = Db::dotazJeden('
        SELECT *
        FROM uzivatele
        WHERE uzivatel_id = ?
        ', array($uzivatelId));

        if ($odpoved < 1)
            return null;
        return $odpoved;
    }

    /**
     *  Upraví uživatele v databázi
     */
    public function upravUzivatele(int $uzivatelId, array $uzivatel): void
    {
        Db::zmen('uzivatele', $uzivatel, 'WHERE uzivatel_id = ?', array($uzivatelId));
    }
    /**
     *  Odstraní uživatele z databáze
     */

    public function odstranUzivatele(string $uzivatelId): void
    {
        Db::dotaz('
        DELETE uzivatele, pojisteni
        FROM uzivatele
        LEFT JOIN pojisteni ON uzivatel_id = pojistenec_id 
        WHERE uzivatel_id = ?
    ', array($uzivatelId));
    }

    /**
     *  Vrátí všechny uživatele z databáze
     */
    public function vratVsechnyUzivatele(): array
    {
        return Db::dotazVsechny('
            SELECT *
            FROM `uzivatele`        
            ORDER BY `uzivatel_id` DESC 
        ');
    }

    public static function vytvorUzivatele(array $pole)
    {
        return  [
            'uzivatel_id' => $pole['uzivatel_id'],
            'email' => $pole['email'],
            'jmeno' => $pole['jmeno'],
            'prijmeni' => $pole['prijmeni'],
            'adresa' => $pole['adresa'],
            'mesto' => $pole['mesto'],
            'psc' => $pole['psc'],
            'heslo' => $pole['heslo'],
            'admin' => $pole['admin']
        ];
    }
}
