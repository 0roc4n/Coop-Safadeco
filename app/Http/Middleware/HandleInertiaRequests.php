<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'userPermissions' => function () {
                if (!Auth::check()) {
                    return null;
                }
                
                $user = Auth::user();
                $role = $user->role;
                
                if (!$role) {
                    return null;
                }
                
                $privileges = $role->privileges->first();
                
                return [
                    'role' => [
                        'id' => $role->id,
                        'name' => $role->name,
                    ],
                    'privileges' => $privileges ? [
                        'can_read' => (bool) $privileges->can_read,
                        'can_add' => (bool) $privileges->can_add,
                        'can_update' => (bool) $privileges->can_update,
                        'can_delete' => (bool) $privileges->can_delete,
                    ] : null,
                ];
            },
        ];
    }
}
