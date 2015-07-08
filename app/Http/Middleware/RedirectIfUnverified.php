<?php namespace App\Http\Middleware;

use Closure;

class RedirectIfUnverified {

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if ( $request->user()->hasConfirmation() )
    {
      flash()->warning('Ud. todavia no ha verificado su cuenta en el sistema.');
      return redirect('/por-verificar');
    }

    if ( $request->user()->isDisabled() )
    {
      flash()->error('Ud. posee su cuenta desactivada, por favor contactenos a contacto@orbiagro.com.ve si considera que esto es un error.');
      return redirect('/por-verificar');
    }

    return $next($request);
  }

}
