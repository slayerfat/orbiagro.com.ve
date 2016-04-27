<?php namespace Orbiagro\Mamarrachismo\Traits\Requests;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use LogicException;
use Orbiagro\Models\Characteristic;
use Orbiagro\Models\Feature;
use Orbiagro\Models\Nutritional;
use Orbiagro\Models\Person;
use Orbiagro\Models\Product;
use Orbiagro\Models\User;

trait CanSearchIDs
{

    /**
     * Invoca findId y regresa si el usuario isOwner or nah.
     *
     * @param  array $array
     *
     * @return boolean
     */
    protected function isUserOwner(array $array)
    {
        return $this->auth->user()
            ->isOwner($this->findId($array));
    }

    /**
     * Busca y retorna el ID de algun recurso solicitado.
     *
     * @param array $data
     * @return int
     */
    protected function findId(array $data)
    {
        $id = null;

        $this->checkResourcesArray($data);

        foreach ($data as $array) {
            if (isset($array['methodType'])) {
                if (strtoupper($this->method()) != $array['methodType']) {
                    continue;
                }
            }

            $result = $array['class']::findOrFail(
                $this->route($array['routeParam'])
            );

            $id = $this->findResourceId($result);
        }

        return $id;
    }

    /**
     * Retorna el ID segun el tipo de modelo.
     *
     * @param  Model $result
     * @return int|null
     */
    protected function findResourceId($result)
    {
        if (is_null($result)) {
            return $result;
        }

        switch (get_class($result)) {
            case User::class:
                $id = $result->id;
                break;

            case Person::class:
            case Product::class:
                $id = $result->user_id;
                break;

            case Feature::class:
            case Nutritional::class:
            case Characteristic::class:
                $id = $result->product->user_id;
                break;

            default:
                throw new InvalidArgumentException(
                    __METHOD__ . ' no encontro una clase apropiada.'
                );
        }

        if ($id === null) {
            $this->throwNullIdException($result);
        }

        return $id;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @param array $data
     *
     * @return void
     */
    protected function checkResourcesArray(array $data)
    {
        foreach ($data as $array) {
            if (!isset($array['routeParam'])) {
                throw new InvalidArgumentException('Index routeParam en array no definido y requerido');
            }
            if (!isset($array['class'])) {
                throw new InvalidArgumentException('Index class en array no definido y requerido');
            }
        }
    }

    /**
     * @throws LogicException
     *
     * @param  Model $class
     *
     * @return void
     */
    protected function throwNullIdException($class)
    {
        if (method_exists($class, 'user')) {
            throw new LogicException(
                'El modelo de tipo '
                . get_class($class)
                . ' tiene un user_id null y posee un metodo definido, puede ser un modelo huerfano.'
            );
        }

        throw new LogicException(
            'El modelo de tipo '
            . get_class($class)
            . ' tiene un user_id null y no posee metodo definido, chequear logica.'
        );
    }
}
