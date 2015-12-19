<?php namespace Arcanedev\Support\Bases;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

/**
 * Class     FormRequest
 *
 * @package  Arcanedev\Support\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class FormRequest extends BaseFormRequest
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The errors format.
     *
     * @var string|null
     */
    protected $errorsFormat = null;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * {@inheritdoc}
     */
    protected function formatErrors(Validator $validator)
    {
        if (is_null($this->errorsFormat)) {
            return parent::formatErrors($validator);
        }

        $errors   = [];
        $messages = $validator->getMessageBag();

        foreach ($messages->keys() as $key) {
            $errors[$key] = $messages->get($key, $this->errorsFormat);
        }

        return $errors;
    }
}
