import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, router } from '@inertiajs/react';

export default function Index({ auth, contagens }) {

    function formatarData(data) {
        return data.split('-').reverse().join('/');
    }

    function statusClasses(status) {
        switch (status) {
            case 'FINALIZADA':
                return 'bg-green-100 text-green-700';

            case 'EM_ANDAMENTO':
                return 'bg-yellow-100 text-yellow-700';

            default:
                return 'bg-gray-100 text-gray-700';
        }
    }

    const handleDelete = (id) => {
        if (confirm('Deseja excluir esta contagem?')) {
            router.delete(route('contagens-estoque.destroy', id));
        }
    };



    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Contagens de Estoque" />

            <div className="min-h-screen bg-gray-100 p-6">

                {/* HEADER */}
                <div className="max-w-7xl mx-auto mb-6 flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-800">
                            Contagens de Estoque
                        </h1>

                        <p className="text-gray-500 mt-1">
                            Gerencie e acompanhe as conferências agendadas
                        </p>
                    </div>

                    <Link
                        href={route('contagens-estoque.create')}
                        className="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold transition-all shadow-sm"
                    >
                        Nova Conferência
                    </Link>
                </div>

                {/* TABELA */}
                <div className="max-w-7xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    <table className="w-full">

                        <thead className="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th className="text-left px-6 py-4 text-sm font-semibold text-gray-600">
                                    Código
                                </th>

                                <th className="text-left px-6 py-4 text-sm font-semibold text-gray-600">
                                    Responsável
                                </th>

                                <th className="text-left px-6 py-4 text-sm font-semibold text-gray-600">
                                    Data
                                </th>

                                <th className="text-left px-6 py-4 text-sm font-semibold text-gray-600">
                                    Status
                                </th>

                                <th className="text-left px-6 py-4 text-sm font-semibold text-gray-600">
                                    Itens
                                </th>

                                <th className="text-right px-6 py-4 text-sm font-semibold text-gray-600">
                                    Ações
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            {contagens.length === 0 && (
                                <tr>
                                    <td
                                        colSpan="6"
                                        className="px-6 py-10 text-center text-gray-500"
                                    >
                                        Nenhuma contagem encontrada.
                                    </td>
                                </tr>
                            )}

                            {contagens.map((contagem) => (
                                <tr
                                    key={contagem.id}
                                    className="border-b border-gray-100 hover:bg-gray-50 transition-colors"
                                >
                                    <td className="px-6 py-4 font-semibold text-gray-800">
                                        #{contagem.codigo}
                                    </td>

                                    <td className="px-6 py-4 text-gray-700">
                                        {contagem.responsavel?.nome}
                                    </td>

                                    <td className="px-6 py-4 text-gray-600">
                                        {formatarData(contagem.data_agendada)}
                                    </td>

                                    <td className="px-6 py-4">
                                        <span
                                            className={`px-3 py-1 rounded-full text-xs font-semibold ${statusClasses(contagem.status)}`}
                                        >
                                            {contagem.status}
                                        </span>
                                    </td>

                                    <td className="px-6 py-4 text-gray-600">
                                        {contagem.itens_count}
                                    </td>

                                    <td className="px-6 py-4 text-right">
                                        <Link
                                            href={route('contagens.show', contagem.id)}
                                            className="inline-flex items-center gap-2 bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-2 rounded-lg text-sm font-semibold transition-all"
                                        >
                                            Abrir
                                        </Link>
                                        <button
                                            onClick={() => handleDelete(contagem.id)}
                                            className="inline-flex items-center gap-2 bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-lg text-sm font-semibold transition-all"
                                        >
                                            Excluir
                                        </button>
                                    </td>
                                </tr>
                            ))}

                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}