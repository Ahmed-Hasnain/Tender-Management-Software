<?php

/**
 * Set flash messages
 */
function flash($message, $style = 'info')
{
    session()->flash('flash.banner', $message);
    session()->flash('flash.bannerStyle', $style);
}