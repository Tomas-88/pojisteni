<?php

class PrehledPojisteniKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        $this->hlavicka = array(
            'titulek' => 'Přehled pojištění',
            'klicova_slova' => 'pojištění, pojišťovna',
            'popis' => 'přehled pojištění pojišťovny'
        );

        $this->pohled = 'prehled-pojisteni';
    }
}