<?php namespace Orbiagro\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Log;
use Orbiagro\Mamarrachismo\Upload\Exceptions\OrphanImageException;
use Orbiagro\Models\Image;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as Whoops;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        //config('app.debug')
        //   $this->renderExceptionWithWhoops($e);

        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof OrphanImageException) {
            return $this->renderOrphanImageException($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Render an exception using Whoops.
     *
     * @param  \Exception $e
     * @return Response
     */
    protected function renderExceptionWithWhoops(Exception $e)
    {
        $whoops = new Whoops;
        $whoops->pushHandler(new PrettyPageHandler());

        return new Response(
            $whoops->handleException($e),
            $e->getStatusCode(),
            $e->getHeaders()
        );
    }

    /**
     * @param $request
     * @param Exception $e
     * @return \Illuminate\Http\RedirectResponse
     */
    private function renderOrphanImageException($request, Exception $e)
    {
        Log::critical($e);

        $image = Image::find($e->getImageId());

        if ($image !== null) {
            $image->delete();
        } elseif (is_null($image)) {
            return parent::render($request, $e);
        }

        flash()->error('Error Inesperado, por favor reintente en un momento.');

        return redirect()->back();
    }
}
