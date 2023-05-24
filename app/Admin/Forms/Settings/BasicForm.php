<?php

namespace App\Admin\Forms\Settings;

use App\Models\Attachment;
use App\Models\Settings;
use Encore\Admin\Admin;
use Encore\Admin\Form\NestedForm;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BasicForm extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = 'Основные настройки сайта';

    protected $buttons = ['submit'];

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        if ($this->save($request)) {
            admin_success('Настройки сохранены.');
        } else {
            admin_error('Что-то пошло не так.');
        }

        return back();
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    protected function save(Request $request)
    {
        $settings = Settings::first();

        if (!$settings) {
            $settings = new Settings();
        }

        $settings->social_networks = getSocialNetworks($request->get('social_networks'));
        $settings->operating_mode = getOperationMode($request->get('operating_mode'));
        $settings->phone = $request->get('phone');
        $settings->email = $request->get('email');
        $settings->address = $request->get('address');
        $settings->requisites = $request->get('requisites');
        $settings->video = $request->get('video');

         if ($settings->save()) {
             $attachmentRequest = $request->get('attachment');

             $attachment = $settings->attachment ?? new Attachment();

             if (!$request->hasFile('attachment.url') && $attachmentRequest['delete']) {
                 Storage::disk('admin')->delete($attachment->url);
                 $attachment->delete();
             } else {
                 $attachment->name = $attachmentRequest['name'] ?? null;
                 $attachment->is_active = $attachmentRequest['is_active'] === 'off' ? false : true;

                 if ( $request->hasFile('attachment.url') ) {
                     if ( $attachment->url ) {
                         Storage::disk('admin')->delete($attachment->url);
                     }

                     $attachment->url = Storage::disk('admin')->putFile('files', $request->file('attachment.url'));
                     $settings->attachment()->save($attachment);
                 }
             }

             return true;
         }

         return  false;
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->text('video', __('panel.video'));
        $this->text('phone', __('panel.phone'))->inputmask(['mask' => '7|8 999 999-99-99']);
        $this->email('email', __('panel.email'))->rules('email');
        $this->textarea('address', __('panel.address'));

        $this->divider('<i class="fa fa-link"></i> Социальные сети');
        $this->table('social_networks', '', function (NestedForm $form) {
            $form->textarea('icon', __('panel.icon'))->rows(1);
            $form->text('name', __('panel.name'))->required();
            $form->url('url', __('panel.link'))->required();
            $form->number('sort', __('panel.sort'))->min(0)->default(0)->width('40px');
        });

        $this->divider('<i class="fa fa-calendar-check-o"></i> Режим работы');
        $this->table('operating_mode', '', function (NestedForm $form) {
            $form->text('name', __('panel.day'))->required();
            $form->text('value', __('panel.time'))->required();
            $form->number('sort', __('panel.sort'))->min(0)->default(0)->width('40px');
        });

        $this->divider('<i class="fa fa-file-text-o"></i> ' . __('panel.requisites'));
        $this->textarea('requisites', '')
             ->rows(10)
             ->help('Укажите каждый реквизит с новой строки. Заголовок отделяется символом «:». Например, ИНН: 0123456789');

        $this->divider('<i class="fa fa-file-o"></i> ' . __('panel.requisites_file'));
        $this->file('attachment.url', __('panel.file'));
        $this->text('attachment.name', __('panel.file_name'));
        $this->switch('attachment.is_active', __('panel.is_active'))->default(true);
        $this->hidden('attachment.delete')->default(0);

        Admin::script('(function () {
            document.addEventListener("click", function (e) {
                if (e.target.classList.contains("fileinput-remove")) {
                    document.querySelector("input[name=\"attachment[delete]\"]").value = 1;
                }
            })
        })()');

        Admin::style('.fileinput-remove > * { pointer-events: none; }');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        $settings = Settings::first();

        if ($settings) {
            return array_replace_recursive(
                $settings->toArray(),
                [
                    'attachment' => array_replace_recursive(['name' => '', 'url' => ''], optional($settings->attachment)->toArray() ?? [])
                ]
            );
        }

        return [];
    }
}
