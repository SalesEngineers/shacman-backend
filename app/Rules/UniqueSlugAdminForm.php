<?php

namespace App\Rules;

use Encore\Admin\Form;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UniqueSlugAdminForm implements Rule
{
    /**
     * @var Model
     */
    private $model;
    /**
     * @var string
     */
    private $attribute;
    /**
     * @var Form
     */
    private $form;

    /**
     * Create a new rule instance.
     *
     * @param string $model
     * @param Form $form
     *
     * @throws \Exception
     */
    public function __construct(string $model, Form $form)
    {
        if (!class_exists($model)) {
            throw new \Exception("$model not found.");
        }

        $this->model = new $model;
        $this->form = $form;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->attribute = $attribute;

        return 0 === $this->model->where(function (Builder $query) use ($attribute, $value) {
                    $query->where($attribute, Str::slug($value));

                    if ($this->form->model()->id) {
                        $query->where('id', '<>', $this->form->model()->id);
                    }
                })->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The {$this->attribute} has already been taken.";
    }
}
