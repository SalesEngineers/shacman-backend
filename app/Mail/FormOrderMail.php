<?php

namespace App\Mail;

use App\Models\FormOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @param FormOrder $order
     */
    public function __construct(FormOrder $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $attachment = $this->order->attachment;
        $fields = prepareOrderFormFields($this->order->fields, $this->order->labels);

        $view = $this->view('emails.form-order')->with([
            'fields' => $fields
        ]);

        if ($this->order->subject) {
            $view->subject($this->order->subject);
        }

        if ($attachment) {
            $view->attachFromStorageDisk('admin', $attachment->url);
        }

        return $view;
    }
}
