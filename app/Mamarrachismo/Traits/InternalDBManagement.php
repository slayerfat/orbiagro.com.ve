<?php namespace App\Mamarrachismo\Traits;

use Auth;

trait InternalDBManagement
{
    /**
     * el InternalDBManagement es usado
     * para los modelos a la hora de guardarlos.
     * originalmente se planeo usar service providers:
     * https://github.com/slayerfat/orbiagro.com.ve/commit/2c678fb09aee8548152b5bad74ba4417345b27f6
     * pero la idea fracaso porque a la hora de que Laravel hace su bootstrap
     * y cae a los service providers, el usuario todavia no ha sido autenticado.
     *
     * asi que por ahora, decidi hacer esta solucion.
     */

    /**
     * el ID del usuario a asociar con algun modelo.
     * @var int
     */
    protected $userId;

    /**
     * se modifica el metodo save() de la clase para poder
     * automaticamente añadir los atributos adicionales
     * created_by y updated_by a la entidad.
     *
     * @param array $options la declaracion de este metodo debe ser compatible con eloquent. NO QUITAR.
     *
     * @method save
     */
    public function save(array $options = [])
    {
        // si la aplicacion esta por consola (artisan u otro)
        // simplemente se guarda de forma normal.
        if (app()->runningInConsole()) {
            return parent::save();
        }

        // se asigna el id
        $this->setUserid();

        // si el modelo no exixte, se asigna el creado por
        if (!$this->exists) {
            $this->attributes['created_by'] = $this->userId;
        }

        // si existe o no, igual necesita un actualizado por
        $this->attributes['updated_by'] = $this->userId;

        parent::save();
    }

    /**
     * asocia el ID del usuario autenticado en el sistema para
     * poder asociar su id con algun modelo.
     *
     * @method setUserid
     */
    protected function setUserid()
    {
        if (Auth::user()) {
            $this->userId = Auth::user()->id;
        }

        if (!isset($this->userId)) {
            throw new \Exception("Para guardar estos datos, se necesita informacion del usuario");
        }
    }
}
