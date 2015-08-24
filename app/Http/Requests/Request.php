<?php namespace Orbiagro\Http\Requests;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * @var Guard
     */
    protected $auth;

    /**
     * @method __construct
     * @param Guard $auth
     *
     * @return void
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
}
