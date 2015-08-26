<?php namespace Orbiagro\Http\Requests;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Request
 * @package Orbiagro\Http\Requests
 */
abstract class Request extends FormRequest
{
    /**
     * @var Guard
     */
    protected $auth;

    /**
     * @method __construct
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @see FormRequest.
     *
     * @return \Illuminate\Http\Response
     */
    public function forbiddenResponse()
    {
        flash()->error('Ud. no tiene permisos para esta acción');
        return redirect()->back();
    }

    /**
     * Regresa verdadero si el usuario esta autenticado.
     *
     * @return boolean
     */
    protected function isUserAuthenticated()
    {
        if ($this->auth->user()) {
            return true;
        }

        return false;
    }

    /**
     * Regresa verdadero si el usuario es administrador.
     *
     * @return boolean
     */
    protected function isUserAdmin()
    {
        if (is_null($this->isUserAuthenticated())) {
            return false;
        }

        if ($this->auth->user()->isAdmin()) {
            return true;
        }

        return false;
    }
}
