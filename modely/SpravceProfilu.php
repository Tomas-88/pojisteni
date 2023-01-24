<?php

class SpravceProfilu
{
    public function upravUzivatele(int|bool $uzivatel_id, array $uzivatele): void
    {
        if ($uzivatel_id)
            Db::zmen('uzivatele', $uzivatele, 'WHERE uzivatel_id = ?', array($uzivatel_id));
    }

    public function vypisUzivatele(): array
    {
        return Db::dotazJeden('
          SELECT `uzivatel_id`, `email`, `jmeno`, `prijmeni`, `adresa`, `mesto`, `psc`
          FROM `uzivatele`
          WHERE `uzivatel_id`
        ');
    }
}