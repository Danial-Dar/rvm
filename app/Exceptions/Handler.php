<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Monolog\Logger;
use Logtail\Monolog\LogtailHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
            if (!is_null(config('app.env')) && config('app.env') == 'production') {
                $logger = new Logger("vos-portal-logs");
                $logger->pushHandler(new LogtailHandler(config('app.logtail')));
                $logger->error($e->getMessage(),["file" => $e->getFile(),"trace" => $e->getTrace()]);
            }
            // $logger->info("logtail integration is ready");
            // $logger->warning("log structured data", [
            //     "item" => [
            //         "url" => "https://fictional-store.com/item-123",
            //         "price" => 100
            //     ]
            // ]);
        });
    // $this->renderable(function (TokenMismatchException $e, $request) {
    //      if ($e->getStatusCode() == 419) {
    //       return redirect('/login')->with('error','CSRF token mismatch.');
    //     }
    // });

    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // if ($exception instanceof MethodNotAllowedHttpException) //post/get route exception
        // {  // dd($exception->getMessage());
        //     // return redirect()->back();
        //     // return response()->json(['error'=>$exception->getMessage()]);
        // }

        // if ($exception instanceof NotFoundHttpException) { // no url found exception
        //     // return response()->json(['error'=>'Url not found']);
        //     return redirect()->back();
        // }
        // if($exception instanceof \PDOException){ //query exception
        //     // send your custom error message here
        //     return response()->json(['error'=>$exception->getMessage()]);
        // }
        if ($exception instanceof TokenMismatchException) { //form token mismatch exception
            // Redirect to a form. Here is an example of how I handle mine
            return redirect('/login');
        // return response()->json(['csrf_error'=>"Oops! Seems you couldn't submit form for a long time. Please try again."]);
        }
        // if ($exception instanceof \ErrorException) { // php errors exception
        //     // send your custom error message here
        //     return response()->json(['error'=>$exception->getMessage()]);
        // }

        // if ($exception instanceof \BadMethodCallException) { // call undefined function exception
        //     // send your custom error message here
        //     return response()->json(['error'=>$exception->getMessage()]);
        // }
        return parent::render($request, $exception);
    }
}
