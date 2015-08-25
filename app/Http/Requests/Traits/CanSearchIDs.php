<?php namespace Orbiagro\Http\Requests\Traits;

use InvalidArgumentException;

trait CanSearchIDs
{

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
                if (strtoupper($this->method) != $array['methodType']) {
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
        switch (get_class($result)) {
            case \Orbiagro\Models\Product::class:
                return $result->user_id;

            case \Orbiagro\Models\Nutritional::class:
                return $result->product->user_id;

            default:
                return null;
        }
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
}
