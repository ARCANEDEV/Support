<?php

declare(strict_types=1);

namespace Arcanedev\Support\Tests\Stubs;

use Arcanedev\Support\Http\Controller;
use Arcanedev\Support\Http\FormRequest;

/**
 * Class     FormRequestController
 *
 * @package  Arcanedev\Support\Tests\Stubs
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class FormRequestController extends Controller
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function form(DummyFormRequest $request)
    {
        return $request->all();
    }
}

class DummyFormRequest extends FormRequest
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'min:6'],
            'email' => ['required', 'string', 'email'],
        ];
    }

    /**
     * Prepare the data before validation.
     */
    protected function prepareForValidation(): void
    {
        $name = strtoupper(trim((string) $this->get('name')));

        $this->merge(compact('name'));
    }

    /**
     * Prepare the data after validation.
     *
     * @return void
     */
    protected function prepareAfterValidation()
    {
        $email = strtolower(trim((string) $this->get('email')));

        $this->merge(compact('email'));
    }
}
