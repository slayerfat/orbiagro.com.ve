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
      return redirect()->back();
    }
    return $next($request);
  }

}
