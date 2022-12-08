<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Settings;
use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Tab;

class SettingsController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('Настройки')
            ->body(new Settings\BasicForm());
    }
}
