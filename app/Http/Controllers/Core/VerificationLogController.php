<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\VerificationLog\GetFilteredVerificationLogs;
use App\Http\Controllers\CoreController;
use App\Models\VerificationLog;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;

class VerificationLogController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'license';
        $this->data['active_menu'] = 'verification_logs';
        $this->data['title'] = 'Verification Logs';
    }

    public function index(Request $request, GetFilteredVerificationLogs $action): InertiaResponse
    {
        abort_if(! auth()->user()->can('verification_logs_view'), 403);

        $this->data = array_merge($this->data, $action->execute($request));

        return $this->inertia('Core/VerificationLogs/Index', $this->data);
    }

    public function show(VerificationLog $verificationLog): InertiaResponse
    {
        abort_if(! auth()->user()->can('verification_logs_view'), 403);

        $this->data['log'] = $verificationLog->load(['license', 'activation']);

        return $this->inertia('Core/VerificationLogs/Show', $this->data);
    }
}
