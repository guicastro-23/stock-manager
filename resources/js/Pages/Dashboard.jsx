import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Dashboard({
    totalContagens,
    emAndamento,
    finalizadas,
}) {

    const { flash } = usePage().props;
    return (

        <AuthenticatedLayout>
            <Head title="Dashboard" />
            

            <div className="py-10">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {flash.success && (
                        <div className="mb-6 rounded-xl border border-green-200 bg-green-100 px-4 py-3 text-green-700">
                            {flash.success}
                        </div>
                    )}
                    <div className="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div className="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
                            <h3 className="text-sm font-medium text-gray-500">
                                Total de Contagens
                            </h3>

                            <p className="mt-4 text-3xl font-bold text-gray-900 text-center">
                                {totalContagens}
                            </p>
                        </div>

                        <div className="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
                            <h3 className="text-sm font-medium text-gray-500">
                                Em Andamento
                            </h3>

                            <p className="mt-4 text-3xl font-bold text-red-600 text-center">
                                {emAndamento}
                            </p>
                        </div>

                        <div className="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
                            <h3 className="text-sm font-medium text-gray-500">
                                Finalizadas
                            </h3>

                            <p className="mt-4 text-3xl font-bold text-green-600 text-center">
                                {finalizadas}
                            </p>
                        </div>
                    </div>

                    {/* <div className="mt-8 rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
                        <h3 className="text-lg font-semibold text-gray-800">
                            Conferência de Estoque
                        </h3>

                        <p className="mt-2 text-sm text-gray-500">
                            Acesse a lista de conferências de estoque agendadas.
                        </p>

                        <div className="mt-6">
                            <Link
                                href={route('contagens-estoque.index')}
                                className="inline-flex items-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition"
                            >
                                Ver Conferências
                            </Link>
                        </div>
                    </div> */}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}