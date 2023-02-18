<?php
use Carbon\Carbon;

/**
 * Set flash messages
 */
function flash($message, $style = 'info')
{
    session()->flash('flash.banner', $message);
    session()->flash('flash.bannerStyle', $style);
}

/**
 * Get logged in user role
 * @return object
 */
function getRole($user)
{
    return $user && $user->roles ? $user->roles[0] : NULL;
}

/**
 * Get role permissions
 * @return object
 */
function getPermissionsName($role)
{
    return $role->permissions()->pluck('name');
}

function setDateValues($value)
{
    if ($value) {
        return date("Y-m-d H:i:s", strtotime($value));
    }
}

function calculateTax($percentage, $total)
{
    return ($percentage * $total) / 100;
}

function numberFormate($price)
{
    return number_format($price, 0, '.', ',');
}

function dateFormate($date)
{
    $date = Carbon::parse($date);
    return $date->format('F j, Y');
}