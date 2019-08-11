<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function redirectWithSuccessMessage(Request $request, $to, $message) {
        $request->session()->flash("message", $message);
        $request->session()->flash("message-level", "success");
        $request->session()->flash("message-icon", "check");

        return redirect($to);
    }

    public function redirectWithInfoMessage(Request $request, $to, $message) {
        $request->session()->flash("message", $message);
        $request->session()->flash("message-level", "info");
        $request->session()->flash("message-icon", "info");

        return redirect($to);
    }

    public function redirectWithWarningMessage(Request $request, $to, $message) {
        $request->session()->flash("message", $message);
        $request->session()->flash("message-level", "warn");
        $request->session()->flash("message-icon", "warning");

        return redirect($to);
    }

    public function redirectWithErrorMessage(Request $request, $to, $message) {
        $request->session()->flash("message", $message);
        $request->session()->flash("message-level", "danger");
        $request->session()->flash("message-icon", "ban");

        return redirect($to);
    }
}
