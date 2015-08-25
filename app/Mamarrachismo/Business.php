<?php namespace Orbiagro\Mamarrachismo;

class Business
{

    /**
     * una coleccion de arrays que poseen el texto y
     * caracteristicas asociadas a la declaracion.
     *
     * @var \Collection
     */
    public $statements;

    /**
     * una declaracion previamente generada.
     *
     * @var string
     */
    public $statement = '';

    /**
     * una coleccion de texto con slogans.
     *
     * @var \Collection
     */
    public $slogans;

    /**
     * un slogan previamente generado.
     *
     * @var string
     */
    public $slogan = '';

    /**
     * @uses \Orbiagro\Mamarrachismo\Business::generateStatements()
     * @uses \Orbiagro\Mamarrachismo\Business::generateSlogans()
     */
    public function __construct()
    {
        $this->generateStatements();
        $this->generateSlogans();
    }

    /**
     * genera la coleccion de declaraciones y las
     * asocia a atributos pertinentes del objeto.
     *
     * @return void
     */
    private function generateStatements()
    {
        $this->statements = collect([
            [
                'text'  => 'Pagina web destacada en compra y venta de productos'
                    .'industriales, pensado en particulares y empresas interesadas.',
                'class' => 'fa fa-refresh fa-300px fa-spin',
            ],
            [
                'text'  => 'Promueve el comercio y mercadeo en Venezuela y toda la Region Andina.',
                'class' => 'fa fa-btc fa-300px fa-real-pulse',
            ],
            [
                'text'  => 'Facilita la compra y venta de productos alimenticios, '
                    .'forestales, maquinaria, implementos agricolas y metalmecanicos.',
                'class' => 'fa fa-300px fa-spin fa-cog',
            ],
            [
                'text'  => 'Buscamos establecer lazos comerciales y de mercadeo que generen '
                    .'intercambios lucrativos relacionados con la producción agro-industrial.',
                'class' => 'fa fa-300px fa-line-chart',
            ],
        ]);

        $array = $this->statements->random();

        $this->statement = $array['text'];
        $this->cssClass  = $array['class'];

        return;
    }

    /**
     * genera la coleccion de declaraciones y las
     * asocia a atributos pertinentes del objeto.
     *
     * @return void
     */
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
