<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        $rules['subject'] = ['string', 'max:255'];

        $rules['fields'] = ['array','required'];
        $rules['fields.*'] = ['string'];
        $rules['fields.email'] = ['email'];
        $rules['fields.phone'] = ['numeric', 'digits:11','starts_with:7,8'];

        $rules['labels'] = ['array'];
        $rules['labels.*'] = ['string'];

        $rules['attachment'] = ['file', 'mimes:doc,docx,pdf', 'max:1024'];

        return $rules;
    }

    public function messages()
    {
        return [
            'fields.required' => "Поле fields обязательно для заполнения.",
            'fields.array' => 'Поле fields должно быть массивом.',
            'fields.email.*' => 'E-mail должен быть действительным адресом электронной почты.',
            'fields.phone.*' => 'Номер телефона должен состоять из цифр, начинаться с 7 или 8 и содержать не менее 11 цифр.',
            'labels.array' => 'Поле labels должно быть массивом.',
            'labels.*.string' => 'Значения поля labels должны быть строкой.',
            'attachment.mimes' => 'Вложение должно быть файлом типа: doc, docx, pdf.',
            'attachment.file' => 'Вложение должно быть файлом.',
            'attachment.max' => 'Размер файла должен быть не более 1mb.',
            'subject.string' => 'Поле «Тема письма» должно быть строкой.',
            'subject.max' => 'Длина поля «Тема письма» должно быть не более 255 символов.'
        ];
    }
}
