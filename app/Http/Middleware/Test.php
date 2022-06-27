<?php
 
namespace App\Http\Middleware;
 
use Closure;
 
class Test
{
    public function handle($request, Closure $next)
    {
        // Perform action
 
        return response()->json("Middleware worked!");
    }
}