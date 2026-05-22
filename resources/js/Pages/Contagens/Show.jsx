import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, router } from '@inertiajs/react';
import { useState } from 'react';

/* ─── badges de contagem ─── */
function Badge({ count, color }) {
    const colors = {
        blue: 'bg-blue-100 text-blue-700 border-blue-200',
        red: 'bg-red-100 text-red-700 border-red-200',
        green: 'bg-green-100 text-green-700 border-green-200',
    };
    return (
        <span className={`text-xs font-bold px-2 py-0.5 rounded-full border ${colors[color]}`}>
            {count} {count === 1 ? 'Item' : 'Itens'}
        </span>
    );
}

// modal de confirmação 
function ModalFinalizar({ codigo, onConfirm, onCancel }) {
    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div className="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
                <div className="flex items-center gap-3 mb-4">
                    <h2 className="text-lg font-bold text-gray-800">Finalizar Conferência</h2>
                </div>
                <p className="text-gray-600 text-sm leading-relaxed mb-6">
                    Deseja concluir a conferência código:{' '}
                    <strong className="text-gray-900">{codigo}</strong>? Ao confirmar,{' '}
                    <span className="text-red-600 font-semibold">não será possível</span> continuar
                    fazendo a conferência posteriormente.
                </p>
                <div className="flex gap-3">
                    <button
                        onClick={onCancel}
                        className="flex-1 border border-gray-300 text-gray-700 rounded-lg py-2.5 text-sm font-semibold hover:bg-gray-50 transition-colors"
                    >
                        Cancelar
                    </button>
                    <button
                        onClick={onConfirm}
                        className="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg py-2.5 text-sm font-semibold transition-colors"
                    >
                        Confirmar Finalização
                    </button>
                </div>
            </div>
        </div>
    );
}


export default function Show({ auth, contagem }) {
    const [showModal, setShowModal] = useState(false);
    const [mensagem, setMensagem] = useState('');
    const itensAConferir = contagem.itens.filter((i) => i.situacao === 'A_CONFERIR');
    const itensDivergentes = contagem.itens.filter((i) => i.situacao === 'FALTANTE_EXCEDENTE');
    const itensConferidos = contagem.itens.filter((i) => i.situacao === 'CONFERIDO');
    const finalizada = contagem.status === 'FINALIZADA';

    function handleFinalizar() {
        router.patch(
            route('contagens-estoque.status', contagem.id),
            { status: 'FINALIZADA' },
            { preserveScroll: true, onSuccess: () => setShowModal(false) }
        );
    }

    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title={`Conferência ${contagem.codigo}`} />

            {showModal && (
                <ModalFinalizar
                    codigo={contagem.codigo}
                    onConfirm={handleFinalizar}
                    onCancel={() => setShowModal(false)}
                />
            )}

            <div className="min-h-screen bg-gray-100 p-4 lg:p-6">

                {/* ── HEADER ── */}
                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
                    <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <div className="flex items-center gap-2 mb-1">
                                <span className="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                    Conferência de Estoque
                                </span>
                                {finalizada ? (
                                    <span className="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full font-semibold border">
                                        FINALIZADA
                                    </span>
                                ) : (
                                    <span className="text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full font-semibold border border-yellow-200">
                                        EM ANDAMENTO
                                    </span>
                                )}
                            </div>
                            <h1 className="text-2xl font-extrabold text-gray-900 tracking-tight">
                                #{contagem.codigo}
                            </h1>
                            <p className="text-sm text-gray-500 mt-0.5">
                                Responsável:{' '}
                                <span className="font-semibold text-gray-700">
                                    {contagem.responsavel?.nome}
                                </span>
                                {contagem.data_agendada && (
                                    <>
                                        {' · '}
                                        <span>{new Date(contagem.data_agendada).toLocaleDateString('pt-BR')}</span>
                                    </>
                                )}
                            </p>
                        </div>

                        {!finalizada && (
                            <div className="flex items-center gap-3">

                                {/* SALVAR PARCIAL */}
                                <button
                                    onClick={() =>
                                        router.patch(
                                            route('contagens-estoque.status', contagem.id),
                                            { status: 'EM_ANDAMENTO' },
                                            {
                                                preserveScroll: true,
                                                onSuccess: () => {
                                                    setMensagem('Progresso salvo com sucesso!');

                                                    setTimeout(() => {
                                                        setMensagem('');
                                                    }, 3000);
                                                },
                                            }
                                        )
                                    }
                                    className="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 active:scale-95 transition-all text-gray-700 px-5 py-2.5 rounded-xl font-semibold text-sm shadow-sm"
                                >
                                    Salvar
                                </button>

                                {/* FINALIZAR */}
                                <button
                                    onClick={() => setShowModal(true)}
                                    className="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 active:scale-95 transition-all text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-sm"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        className="w-4 h-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        strokeWidth={2}
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>

                                    Finalizar Conferência
                                </button>

                            </div>
)}
                    </div>
                </div>

                {mensagem && (
                    <div className="mb-4 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-semibold">
                        {mensagem}
                    </div>
                )}
                
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-5 max-w-7xl mx-auto">

                    {/* A CONFERIR */}
                    <div className="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
                        <div className="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                            <div className="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" className="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <h2 className="text-base font-bold text-gray-800">A Conferir</h2>
                            </div>
                            <Badge count={itensAConferir.length} color="blue" />
                        </div>
                        <div className="p-4 space-y-3 overflow-y-auto flex-1">
                            {itensAConferir.length === 0 && (
                                <p className="text-sm text-gray-400 text-center py-6">Nenhum item pendente</p>
                            )}
                            {itensAConferir.map((item) => (
                                <ItemAConferir key={item.id} item={item} disabled={finalizada} />
                            ))}
                        </div>
                    </div>

                    {/* DIVERGÊNCIAS */}
                    <div className="bg-red-50 rounded-2xl shadow-sm border border-red-100 flex flex-col">
                        <div className="flex items-center justify-between px-5 py-4 border-b border-red-100">
                            <div className="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" className="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                                </svg>
                                <h2 className="text-base font-bold text-red-800">Divergências</h2>
                            </div>
                            <Badge count={itensDivergentes.length} color="red" />
                        </div>
                        <div className="p-4 space-y-3 overflow-y-auto flex-1">
                            {itensDivergentes.length === 0 && (
                                <p className="text-sm text-red-300 text-center py-6">Sem divergências</p>
                            )}
                            {itensDivergentes.map((item) => (
                                <ItemDivergente key={item.id} item={item} disabled={finalizada} />
                            ))}
                        </div>
                    </div>

                    {/* CONFERIDOS */}
                    <div className="bg-green-50 rounded-2xl shadow-sm border border-green-100 flex flex-col">
                        <div className="flex items-center justify-between px-5 py-4 border-b border-green-100">
                            <div className="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" className="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h2 className="text-base font-bold text-green-800">Conferidos</h2>
                            </div>
                            <Badge count={itensConferidos.length} color="green" />
                        </div>
                        <div className="p-4 space-y-3 overflow-y-auto flex-1">
                            {itensConferidos.length === 0 && (
                                <p className="text-sm text-green-400 text-center py-6">Nenhum item conferido</p>
                            )}
                            {itensConferidos.map((item) => (
                                <ItemConferido key={item.id} item={item} />
                            ))}
                        </div>
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}


// ITEM A CONFERIR

function ItemAConferir({ item, disabled }) {
    const { data, setData, patch, processing } = useForm({
        quantidade_contada: '',
        observacao: '',
    });

    function confirmar() {
        patch(route('itens-contagem.update', item.id), { preserveScroll: true });
    }

    return (
        <div className="bg-white border border-gray-200 rounded-xl p-4 hover:border-blue-200 hover:shadow-sm transition-all">
            <div className="flex items-start justify-between mb-2">
                <div>
                    <p className="text-xs font-mono font-semibold text-blue-600 mb-0.5">
                        Cód: {item.produto.codigo_sistema}
                    </p>
                    <h3 className="font-bold text-gray-800 text-sm leading-tight">
                        {item.produto.nome}
                    </h3>
                </div>
                <span className="text-xs bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md whitespace-nowrap ml-2 shrink-0 font-semibold">
                    Sistema: {item.quantidade_sistema} itens
                </span>
            </div>

            <div className="mt-3">
                <label className="block text-xs font-semibold text-gray-500 mb-1">
                    Quantidade Contada:
                </label>
                <div className="flex gap-2">
                    <input
                        type="number"
                        min="0"
                        disabled={disabled}
                        className="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent disabled:bg-gray-50"
                        value={data.quantidade_contada}
                        onChange={(e) => setData('quantidade_contada', e.target.value)}
                        placeholder="0"
                    />
                    <button
                        onClick={confirmar}
                        disabled={processing || disabled || data.quantidade_contada === ''}
                        className="bg-blue-700 hover:bg-blue-700 disabled:opacity-80 disabled:cursor-not-allowed active:scale-95 transition-all text-white px-4 py-2 rounded-lg text-sm font-semibold"
                    >
                        Confirmar
                    </button>
                </div>
            </div>
        </div>
    );
}

// ITEM DIVERGENTE

function ItemDivergente({ item, disabled }) {
    const { data, setData, patch, processing } = useForm({
        observacao: item.observacao ?? '',
    });

    const diff = item.quantidade_contada - item.quantidade_sistema;
    const isFaltante = diff < 0;

    function salvarObservacao() {
        patch(route('itens-contagem.observacao', item.id), { preserveScroll: true });
    }

    return (
        <div className="bg-white border border-red-200 rounded-xl p-4">
            <p className="text-xs font-mono font-semibold text-red-500 mb-0.5">
                Cód: {item.produto.codigo_sistema}
            </p>
            <h3 className="font-bold text-gray-800 text-sm leading-tight mb-3">
                {item.produto.nome}
            </h3>

            <div className="flex gap-2 mb-3">
                <div className="flex-1 bg-gray-50 rounded-lg px-3 py-2 text-center">
                    <p className="text-xs text-gray-400 font-semibold mb-0.5">Sistema</p>
                    <p className="text-lg font-extrabold text-gray-700">{item.quantidade_sistema}</p>
                </div>
                <div className="flex-1 bg-red-50 rounded-lg px-3 py-2 text-center border border-red-100">
                    <p className="text-xs text-red-400 font-semibold mb-0.5">Contado</p>
                    <p className="text-lg font-extrabold text-red-600">{item.quantidade_contada}</p>
                </div>
                <div className={`flex-1 rounded-lg px-3 py-2 text-center border ${isFaltante ? 'bg-orange-50 border-orange-100' : 'bg-blue-50 border-blue-100'}`}>
                    <p className={`text-xs font-semibold mb-0.5 ${isFaltante ? 'text-orange-400' : 'text-blue-400'}`}>
                        {isFaltante ? 'Faltante' : 'Excedente'}
                    </p>
                    <p className={`text-lg font-extrabold ${isFaltante ? 'text-orange-600' : 'text-blue-600'}`}>
                        {isFaltante ? diff : `+${diff}`}
                    </p>
                </div>
            </div>

            <label className="block text-xs font-semibold text-red-600 mb-1">
                Observação Obrigatória
            </label>
            <textarea
                rows={2}
                disabled={disabled}
                placeholder="Ex: produto avariado, erro de entrada anterior..."
                className="w-full border border-red-200 rounded-lg px-3 py-2 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-transparent disabled:bg-gray-50 placeholder:text-gray-300"
                value={data.observacao}
                onChange={(e) => setData('observacao', e.target.value)}
            />

            {!disabled && (
                <button
                    onClick={salvarObservacao}
                    disabled={processing || !data.observacao.trim()}
                    className="w-full mt-2 bg-red-600 hover:bg-red-700 disabled:opacity-40 disabled:cursor-not-allowed active:scale-95 transition-all text-white py-2 rounded-lg text-sm font-semibold"
                >
                    Salvar Justificativa
                </button>
            )}
        </div>
    );
}


// ITEM CONFERIDO

function ItemConferido({ item }) {
    return (
        <div className="bg-white border border-green-200 rounded-xl p-4">
            <p className="text-xs font-mono font-semibold text-green-600 mb-0.5">
                Cód: {item.produto.codigo_sistema}
            </p>
            <h3 className="font-bold text-gray-800 text-sm leading-tight mb-3">
                {item.produto.nome}
            </h3>
            <div className="flex gap-2">
                <div className="flex-1 bg-gray-50 rounded-lg px-3 py-2 text-center">
                    <p className="text-xs text-gray-400 font-semibold mb-0.5">Sistema</p>
                    <p className="text-lg font-extrabold text-gray-600">{item.quantidade_sistema}</p>
                </div>
                <div className="flex-1 bg-green-50 rounded-lg px-3 py-2 text-center border border-green-100">
                    <p className="text-xs text-green-500 font-semibold mb-0.5">Contado</p>
                    <p className="text-lg font-extrabold text-green-700">{item.quantidade_contada}</p>
                </div>
            </div>
        </div>
    );
}