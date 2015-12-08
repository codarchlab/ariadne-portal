<?php
/**
 * Middleware for providing content negotiation.
 *
 * The middleware has to be confirgured to run after request handling by the application and
 * expects a response in simple array format.
 *
 * It then determines the desired output format based on the HTTP Accept Header and provides
 * serialization or calls a given view depending on the requested format.
 *
 * The view name has to be given as a middleware parameter
 * (see http://laravel.com/docs/5.1/middleware#middleware-parameters).
 */

namespace app\Http\Middleware;

use Closure;


class ContentNegotiator {

    /**
     * @param $request
     * @param Closure $next
     * @param $view the view name, can be configured in routes.php
     * @return \Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next, $view) {

        $response = $next($request);

        if ($request->wantsJson()) {
            foreach ($response->original as $key => $value) {
                $data = [];
                // convert complex objects (like paginator) to array to enable json encoding
                if (method_exists($value, 'toArray')) {
                    $data[$key] = $value->toArray();
                } else {
                    $data[$key] = $value;
                }
            }
            return response()->json($data);
        } else {
            return view($view, $response->original);
        }
    }

}