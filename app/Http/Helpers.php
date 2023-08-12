<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
    return number_format($price, 2, '.', ',');
}

function dateFormate($date)
{
    $date = Carbon::parse($date);
    return $date->format('F j, Y');
}

function breakString($str)
{
    $sentences = explode(".", $str); // split the string into an array of sentences
    $sentences = array_map('trim', $sentences); // remove whitespace from each sentence
    $sentences = array_filter($sentences); // remove empty sentences
    $sentences = array_map(function($sentence) {
      return $sentence . "."; // add a full stop to the end of each sentence
    }, $sentences);
    return $sentences; // return the array of sentences
}

function addDaysToDate($date, $days) 
{
    return Carbon::parse($date)->addDays($days)->format('F j, Y');
}

function currentDate() 
{
    return Carbon::today()->format('F j, Y');
}

function lowerCaseAndAddDashes($str)
{
    return strtolower(str_replace(' ', '_', $str));
}

function replaceUnderscoreWithDash($str)
{
    return ucfirst(str_replace('_', '-', $str));
}

function upperCaseAndRemoveUnderscore($str)
{
    return ucwords(str_replace('_', ' ', $str));
}

function calculateSum($data, $type) 
{
    $total_amount = 0;
    switch ($type) {
        case 'quotation':
            $data->each(function ($item, $key) use (&$total_amount){
                if ($item->tax) {
                    $tax = ((float)$item->total_price / 100 ) * (float) $item->tax;
                    $items_total = (float)$item->total_price + $tax;
                    $total_amount += (float)$items_total;
                } else {
                    $total_amount += (float)$item->total_price;
                }
            });
            break;
        
        default:
            # code...
            break;
    }
    return $total_amount;
}

function calculateTaxAndGetTotal($amount, $tax_percent)
{
    $tax = ((float)$amount / 100 ) * (float) $tax_percent;
    return $amount + $tax;
}