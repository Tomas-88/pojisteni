<?php

class UvodKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        $this->hlavicka = array(
            'titulek' => 'Úvod',
            'klicova_slova' => 'pojištění, pojišťovna',
            'popis' => 'Úvodní stránka pojišťovny.'
        );

        $this->pohled = 'uvod';
    }
}