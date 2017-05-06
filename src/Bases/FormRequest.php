<?php namespace Arcanedev\Support\Bases;

use Arcanedev\Support\Http\FormRequest as BaseFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

/**
 * Class     FormRequest
 *
 * @package  Arcanedev\Support\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @deprecated: Use `Arcanedev\Support\Http\FormRequest` or `Arcanedev\LaravelApiHelper\Http\FormRequest` instead.
 */
abstract class FormRequest extends BaseFormRequest
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Specify if the form request is an ajax request.
     *
     * @var bool
     */
    protected $ajaxRequest = false;

    /**
     * The errors format.
     *
     * @var string|null
     */
    protected $errorsFormat = null;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        return $this->ajaxRequest
            ? $this->formatJsonErrorsResponse($errors)
            : parent::response($errors);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Format the json response.
     *
     * @param  array  $errors
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function formatJsonErrorsResponse(array $errors)
    {
        return new JsonResponse([
            'status' => 'error',
            'code'   => 422,
            'errors' => array_map('reset', $errors)
        ], 422);
    }

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
