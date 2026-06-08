<?php
namespace App\Http\Requests;

use App\Models\Unit;
use Illuminate\Foundation\Http\FormRequest;

class PinjamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        // unit_id diambil dari URL parameter, bukan dari form body
        $unitId = $this->route('unitId');
        $unit   = Unit::find($unitId);

        // Validasi langsung di authorize level
        return [];
    }

    // Override prepareForValidation - validasi unit di sini
    protected function prepareForValidation(): void
    {
        $unitId = $this->route('unitId');
        $unit   = Unit::find($unitId);

        if (!$unit) {
            abort(404, 'Unit alat tidak ditemukan.');
        }

        if ($unit->status !== 'Tersedia') {
            abort(422, 'Unit ini sedang ' . $unit->status . ', tidak bisa dipinjam.');
        }
    }
}
