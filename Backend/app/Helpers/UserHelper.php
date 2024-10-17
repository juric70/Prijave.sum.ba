<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('isInRole')) {
    function isInRole($role) {
        $user = Auth::user();
        return $user && $user->role === $role;
    }
}
