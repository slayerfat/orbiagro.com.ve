<?php namespace App\Http\Middleware;

use Closure;

class RedirectIfNotAdmin {

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if ( !$request->user()->esAdministrador() ) {
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->back();
    }
    return $next($request);
  }

}
