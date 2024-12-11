<?php

namespace Modules\User\src\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;

class demoMiddleware
{
  public function handle(Request $request, Closure $next)
  {
    echo "demo middleware" . "<br/>";
    return $next($request);
  }
}
