<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\ApiToken\CreateToken;
use App\Actions\Core\ApiToken\DeleteToken;
use App\Actions\Core\ApiToken\GetUserTokens;
use App\Http\Controllers\CoreController;
use App\Http\Requests\Core\StoreApiTokenRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class ApiTokenController extends CoreController
{
    public function __construct()
    {
        $this->data['title'] = 'API Tokens';
        $this->data['active_menu'] = 'api-tokens';
    }

    public function index(Request $request): Response
    {
        $this->data['tokens'] = (new GetUserTokens)->execute($request->user());

        return $this->inertia('Core/Admin/ApiTokens/Index', $this->data);
    }

    public function store(StoreApiTokenRequest $request): RedirectResponse
    {
        $permissions = $request->input('permissions', ['*']);
        $token = (new CreateToken)->execute($request->user(), $request->name, $permissions);

        return back()->with('flash', [
            'token' => explode('|', $token->plainTextToken)[1],
            'plainTextToken' => $token->plainTextToken,
            'message' => 'Token created successfully.',
        ]);
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        (new DeleteToken)->execute($request->user(), $id);

        return back()->with('message', 'Token revoked successfully.');
    }
}
