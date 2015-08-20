<?php namespace App\Mamarrachismo;

class Business {

  public $statements;

  public $slogans;

  public function __construct()
  {
    $this->generateStatements();
    $this->generateSlogans();
  }

  private function generateStatements()
  {
    $this->statements = collect([
      [
        'text'  => 'Pagina web destacada en compra y venta de productos industriales, pensado en particulares y empresas interesadas.',
        'class' => 'fa fa-refresh fa-300px fa-spin',
      ],
      [
        'text'  => 'Promueve el comercio y mercadeo en Venezuela y toda la Region Andina.',
        'class' => 'fa fa-btc fa-300px fa-real-pulse',
      ],
      [
        'text'  => 'Facilita la compra y venta de productos alimenticios, forestales, maquinaria, implementos agricolas y metalmecanicos.',
        'class' => 'fa fa-300px fa-spin fa-cog',
      ],
      [
        'text'  => 'Buscamos establecer lazos comerciales y de mercadeo que generen intercambios lucrativos relacionados con la producción agro-industrial.',
        'class' => 'fa fa-300px fa-line-chart',
      ],
    ]);

    $array = $this->statements->random();

    $this->statement = $array['text'];
    $this->cssClass  = $array['class'];

    return;
  }

  private function generateSlogans()
  {
    $this->slogans = collect([
      'Crece mas quien mejor preste servicio.',
      'Promoviendo el comercio y mercadeo.',
    ]);

    $this->slogan = $this->slogans->random();

    return;
  }
}
