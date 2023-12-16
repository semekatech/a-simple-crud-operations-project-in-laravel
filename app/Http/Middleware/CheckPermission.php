// app/Http/Middleware/CheckPermission.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        if (Gate::denies($permission)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
