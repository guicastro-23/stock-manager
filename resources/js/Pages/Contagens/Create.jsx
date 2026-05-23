import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';

export default function Create({ auth, funcionarios }) {
    const { data, setData, post, processing, errors } = useForm({
        responsavel_id: '',
        data_agendada: '',
    });

    function submit(e) {
        e.preventDefault();

        post(route('contagens-estoque.store'));
    }

    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Nova Conferência" />

            <div className="min-h-screen bg-gray-100 p-6">
                <div className="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                    <h1 className="text-2xl font-bold text-gray-800 mb-6">
                        Nova Conferência de Estoque
                    </h1>

                    <form onSubmit={submit} className="space-y-5">

                        {/* RESPONSÁVEL */}
                        <div>
                            <label className="block text-sm font-semibold text-gray-700 mb-2">
                                Responsável
                            </label>

                            <select
                                value={data.responsavel_id}
                                onChange={(e) =>
                                    setData('responsavel_id', e.target.value)
                                }
                                className="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                            >
                                <option value="">
                                    Selecione um funcionário
                                </option>

                                {funcionarios.map((funcionario) => (
                                    <option
                                        key={funcionario.id}
                                        value={funcionario.id}
                                    >
                                        {funcionario.nome}
                                    </option>
                                ))}
                            </select>

                            {errors.responsavel_id && (
                                <p className="text-red-500 text-sm mt-1">
                                    {errors.responsavel_id}
                                </p>
                            )}
                        </div>

                        {/* DATA */}
                        <div>
                            <label className="block text-sm font-semibold text-gray-700 mb-2">
                                Data da Conferência
                            </label>

                            <input
                                type="date"
                                value={data.data_agendada}
                                onChange={(e) =>
                                    setData('data_agendada', e.target.value)
                                }
                                className="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                            />

                            {errors.data_agendada && (
                                <p className="text-red-500 text-sm mt-1">
                                    {errors.data_agendada}
                                </p>
                            )}
                        </div>

                        {/* BOTÃO */}
                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-3 font-semibold transition-all"
                        >
                            Criar Conferência
                        </button>

                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}