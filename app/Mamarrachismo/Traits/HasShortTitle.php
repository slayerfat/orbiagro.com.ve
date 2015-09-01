<?php namespace Orbiagro\Mamarrachismo\Traits;

trait HasShortTitle
{
    /**
     * genera una cadena de texto segun el largo especificado.
     *
     * @param  integer $length el tamaño maximo de la cadena de texto.
     * @return string          la cadena a devolver
     */
    public function shortTitle($length = 32)
    {
        if (isset($this->attributes['title'])) {
            return str_limit($this->attributes['title'], $length);

        } elseif (isset($this->attributes['description'])) {
            return str_limit($this->attributes['description'], $length);

        } elseif (isset($this->attributes['name'])) {
            return str_limit($this->attributes['name'], $length);
        }

        return '';
    }
}
