<?php

class SpravcePojisteni
{
    public function vytvorPojisteni(string $pojistenecId, string $typPojisteni, string $platnostOd, string $platnostDo, string $castkaPojisteni): void
    {
        $pojisteni = array(
            'pojistenec_id' => $pojistenecId,
            'typ_pojisteni' => $typPojisteni,
            'platnost_od' => $platnostOd,
            'platnost_do' => $platnostDo,
            'castka' => $castkaPojisteni,
        );
        try {
            Db::vloz('pojisteni', $pojisteni);
        } catch (PDOException $chyba) {
            throw new Exception('Uživatel s tímto emailem je již zaregistrovaný.');
        }
    }

    public function upravPojisteni(int $pojisteniId, array $pojistka): void
    {
        Db::zmen('pojisteni', $pojistka, 'WHERE pojisteni_id = ?', array($pojisteniId));
    }

    public function odstranPojisteni(string $pojisteniId): void
    {
        Db::dotaz('
        DELETE FROM pojisteni
        WHERE pojisteni_id = ?
    ', array($pojisteniId));
    }

    public function vratPojisteni(string $pojistenecId): array
    {
        return Db::dotazVsechny('
        SELECT *
        FROM `pojisteni`
        WHERE `pojistenec_id` = ?
        ', array($pojistenecId));
    }
    public function vratPojisteniDb($pojisteniId): ?array
    {
        // použijeme join, získáme  pojištění a na vazbu i uživatele
        return  Db::dotazJeden('
        SELECT *
        FROM pojisteni
        LEFT JOIN uzivatele ON uzivatel_id = pojistenec_id
        WHERE pojisteni_id = ?
        ', array($pojisteniId));
    }

    public function vratPocetPojisteni()
    {
        return Db::dotazVsechny('
        SELECT `pojistenec_id`, COUNT(`pojisteni`)
        FROM `pojisteni`');
    }

    public static function vytvorPojistku(array $pole)
    {
        return [
            'pojisteni_id' => $pole['pojisteni_id'],
            'pojistenec_id' => $pole['pojistenec_id'],
            'typ_pojisteni' => $pole['typ_pojisteni'],
            'castka' => $pole['castka'],
            'platnost_od' => $pole['platnost_od'],
            'platnost_do' => $pole['platnost_do']
        ];
    }
}
