<?php namespace Orbiagro\Http\Requests\Traits;

use LogicException;
use InvalidArgumentException;

trait CanSearchIDs
{

    /**
     * Invoca findId y regresa si el usuario isOwner or nah.
     *
     * @param  array   $array
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
     * @param  string $result
     * @return int|null
     */
    protected function findResourceId($result)
    {
        if (is_null($result)) {
            return $result;
        }

        switch (get_class($result)) {
            case \Orbiagro\Models\Person::class:
            case \Orbiagro\Models\Product::class:
                $id = $result->user_id;
                break;

            case \Orbiagro\Models\Feature::class:
            case \Orbiagro\Models\Nutritional::class:
            case \Orbiagro\Models\Characteristic::class:
                $id = $result->product->user_id;
                break;

            default:
                throw new InvalidArgumentException(
                    __METHOD__.' no encontro una clase apropiada.'
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

    protected function throwNullIdException($class)
    {
        if (method_exists($class, 'user')) {
            throw new LogicException(
                'El modelo de tipo '
                .get_class($class)
                .' tiene un user_id null y posee un metodo definido, puede ser un modelo huerfano.'
            );
        }

        throw new LogicException(
            'El modelo de tipo '
            .get_class($class)
            .' tiene un user_id null y no posee metodo definido, chequear logica.'
        );
    }
}
