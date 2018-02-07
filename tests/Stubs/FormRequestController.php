<?php namespace Arcanedev\Support\Tests\Stubs;

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
        return [
            'name'  => ['required', 'string', 'min:6'],
            'email' => ['required', 'string', 'email'],
        ];
    }

    /**
     * Sanitize the inputs after the validation.
     *
     * @return array
     */
    public function sanitize()
    {
        return [
            'name'  => strtoupper(trim($this->get('name'))),
            'email' => strtolower(trim($this->get('email'))),
        ];
    }
}
