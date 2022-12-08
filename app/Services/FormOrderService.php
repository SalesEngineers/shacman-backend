<?php

namespace App\Services;

use App\Http\Requests\FormOrderRequest;
use App\Mail\FormOrderMail;
use App\Models\Attachment;
use App\Models\FormOrder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class FormOrderService
{
    public function save(FormOrderRequest $request)
    {
        $formOrder = new FormOrder();

        $formOrder->subject = $request->get('subject', 'Новая заявка');
        $formOrder->fields = $request->get('fields', []);
        $formOrder->labels = $request->get('labels', null);
        $formOrder->page = $request->get('page', $_SERVER['HTTP_REFERER'] ?? null);

        if ($formOrder->save() && $request->hasFile('attachment')) {
            $attachment = new Attachment();
            $attachment->url = Storage::disk('admin')->putFile('files', $request->file('attachment'));
            $formOrder->attachment()->save($attachment);
        }

        $this->sendEmail($formOrder);

        return $formOrder;
    }

    public function sendEmail(FormOrder $order)
    {
        Mail::to(config('mail.order_email'))->send(new FormOrderMail($order));
    }
}
