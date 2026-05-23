<?php

namespace App\Http\Requests;

use App\Models\ContagemEstoque;
use Illuminate\Foundation\Http\FormRequest;

class StoreContagemEstoqueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'responsavel_id' => [
                'required',
                'exists:funcionarios,id',
            ],

            'data_agendada' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $existeContagem = ContagemEstoque::where('responsavel_id', $this->responsavel_id)
                ->whereDate('data_agendada', $this->data_agendada)
                ->whereIn('status', ['AGENDADA', 'EM_ANDAMENTO'])
                ->exists();

            if ($existeContagem) {
                $validator->errors()->add(
                    'responsavel_id',
                    'Este funcionário já possui uma conferência agendada nesta data.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'data_agendada.after_or_equal' =>
                'Não é permitido selecionar uma data passada.',

            'responsavel_id.required' =>
                'Selecione um responsável.',

            'data_agendada.required' =>
                'Selecione uma data.',
        ];
    }
}