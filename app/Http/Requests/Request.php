<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest {

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
