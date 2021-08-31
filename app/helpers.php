<?php

if (!function_exists('currentUser')) {

    /**
     * If more then one guard is used in the app return the correct user instance
     * First condition returns the default guard
     * Else add more conditions for other guards
     *
     * @return \App\User|null
     */
    function currentUser()
    {
        if (\Auth::check() && \Auth::user() && \Auth::user() instanceof \App\User) {
            return Auth::user();
        }
        //else if (Auth::guard('customer')->check() && Auth::guard('customer')->user() instanceof \App\Models\Customers) {
        //    return Auth::guard('customer')->user();
        //}

        return null;
    }
}

if (!function_exists('currentGuard')) {

    /**
     * If more then one guard is used in the app return the current guard
     * First condition returns the default guard
     * Else add more conditions for other guards
     *
     * @return string
     */
    function currentGuard()
    {
        if (\Auth::guard('web')->check() && \Auth::guard('web')->user() instanceof \App\User) {
            return 'web';
        }
        //else if (Auth::guard('customer')->check() && Auth::guard('customer')->user() instanceof \App\Models\Customers) {
        //    return 'customer';
        //}

        return 'user';
    }
}

if (!function_exists('onlyDate')) {

    /**
     * Return date from datetime string in Y-m-d format
     *
     * @param $datetime
     * @return false|string
     */
    function onlyDate($datetime)
    {
        return date('Y-m-d', strtotime($datetime));
    }
}

if (!function_exists('displayDate')) {

    /**
     * Return date from datetime string in d.m.Y format
     *
     * @param $datetime
     * @return false|string
     */
    function displayDate($datetime)
    {
        return date('d.m.Y', strtotime($datetime));
    }
}

if (!function_exists('capitalize')) {

    /**
     * Capitalize a given string
     *
     * @param $string
     * @return string
     */
    function capitalize($string)
    {
        $firstChar = mb_substr($string, 0, 1, "UTF-8");
        $then = mb_substr($string, 1, null, "UTF-8");

        return mb_strtoupper($firstChar, "UTF-8") . $then;
    }
}
