/**
 * Classe para buscar endereço (ViaCEP)
 */
class BuscaCEP {
    static async pesquisar(valor, campos) {
        const cep = valor.replace(/\D/g, '');
        if (cep === "" || !/^[0-9]{8}$/.test(cep)) {
            if(cep.length > 0) alert("Formato de CEP inválido.");
            return;
        }

        this._preencher(campos, "...");

        try {
            const res = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await res.json();

            if (!data.erro) {
                if(campos.endereco) document.getElementById(campos.endereco).value = data.logradouro;
                if(campos.bairro) document.getElementById(campos.bairro).value = data.bairro;
                if(campos.cidade) document.getElementById(campos.cidade).value = data.localidade;
                if(campos.estado) document.getElementById(campos.estado).value = data.uf;
                if(campos.numero) document.getElementById(campos.numero).focus();
            } else {
                alert("CEP não encontrado.");
                this._preencher(campos, "");
            }
        } catch (e) {
            console.error(e);
            this._preencher(campos, "");
        }
    }

    static _preencher(campos, val) {
        if(campos.endereco) document.getElementById(campos.endereco).value = val;
        if(campos.bairro) document.getElementById(campos.bairro).value = val;
        if(campos.cidade) document.getElementById(campos.cidade).value = val;
        if(campos.estado) document.getElementById(campos.estado).value = val;
    }
}

/**
 * Classe responsável pela Pesquisa em Tempo Real
 */
class BuscaClientes {
    constructor() {
        this.inputBusca = document.getElementById('inputBusca');
        this.tabelaBody = document.querySelector('table tbody');
        this.init();
    }

    init() {
        if (!this.inputBusca) return;

        // Evento 'input' dispara a cada letra digitada
        this.inputBusca.addEventListener('input', (e) => {
            this.buscar(e.target.value);
        });
    }

    async buscar(termo) {
        try {
            // Chama o nosso novo arquivo PHP
            const response = await fetch(`PHP/busca.php?termo=${encodeURIComponent(termo)}`);
            const clientes = await response.json();
            this.renderizarTabela(clientes);
        } catch (error) {
            console.error('Erro na busca:', error);
        }
    }

    renderizarTabela(clientes) {
        this.tabelaBody.innerHTML = ''; // Limpa a tabela

        if (clientes.length === 0) {
            this.tabelaBody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <p class="text-muted">Nenhum cliente encontrado.</p>
                    </td>
                </tr>`;
            return;
        }

        // Reconstrói as linhas com HTML
        clientes.forEach(cliente => {
            const inicial = cliente.nome.charAt(0).toUpperCase();
            const telefone = cliente.telefone || ''; // Trata nulo
            
            const html = `
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar-initial shadow-sm bg-primary text-white">${inicial}</div>
                            <div>
                                <div class="fw-bold text-dark">${cliente.nome}</div>
                                <div class="small text-muted">ID: #${cliente.id_cliente}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="text-dark"><i class="far fa-envelope me-1 text-muted"></i> ${cliente.email}</span>
                            <span class="small text-muted mt-1"><i class="fas fa-phone-alt me-1"></i> ${telefone}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-medium">${cliente.cidade} - ${cliente.estado}</span>
                            <span class="small text-muted">${cliente.bairro}</span>
                        </div>
                    </td>
                    <td><span class="badge bg-light text-dark border">${cliente.cpf}</span></td>
                    <td class="text-center"><span class="badge bg-success-subtle text-success rounded-pill">Ativo</span></td>
                    <td class="text-end pe-4">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-secondary" title="Ver Detalhes" 
                                data-bs-toggle="modal" data-bs-target="#modalVisualizar"
                                data-nome="${cliente.nome}" data-email="${cliente.email}" data-cpf="${cliente.cpf}"
                                data-endereco="${cliente.endereco}" data-numero="${cliente.numero}"
                                data-bairro="${cliente.bairro}" data-cep="${cliente.cep}"
                                data-cidade="${cliente.cidade}" data-estado="${cliente.estado}">
                                <i class="fas fa-eye"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-primary" title="Editar"
                                data-bs-toggle="modal" data-bs-target="#modalEditar"
                                data-id="${cliente.id_cliente}" data-nome="${cliente.nome}"
                                data-email="${cliente.email}" data-telefone="${telefone}"
                                data-cpf="${cliente.cpf}" data-cep="${cliente.cep}"
                                data-endereco="${cliente.endereco}" data-numero="${cliente.numero}"
                                data-bairro="${cliente.bairro}" data-cidade="${cliente.cidade}"
                                data-estado="${cliente.estado}">
                                <i class="fas fa-pencil-alt"></i>
                            </button>

                            <form action="PHP/excluir.php" method="POST" onsubmit="return confirm('Tem certeza?');" style="display: inline;">
                                <input type="hidden" name="id_cliente" value="${cliente.id_cliente}">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            `;
            this.tabelaBody.insertAdjacentHTML('beforeend', html);
        });
    }
}

/**
 * Gerenciador Geral
 */
class GerenciadorClientes {
    constructor() {
        this.initEvents();
        // Inicia a busca também
        new BuscaClientes();
    }

    initEvents() {
        this._configurarModalEditar();
        this._configurarModalVisualizar();
        this._configurarBuscaCep();
    }

    _configurarModalEditar() {
        const modal = document.getElementById('modalEditar');
        if (!modal) return;
        modal.addEventListener('show.bs.modal', (event) => {
            const btn = event.relatedTarget;
            const map = {
                'editId': 'data-id', 'editNome': 'data-nome', 'editEmail': 'data-email',
                'editTelefone': 'data-telefone', 'editCpf': 'data-cpf', 'editCep': 'data-cep',
                'editEndereco': 'data-endereco', 'editNumero': 'data-numero',
                'editBairro': 'data-bairro', 'editCidade': 'data-cidade', 'editEstado': 'data-estado'
            };
            for (const [id, attr] of Object.entries(map)) {
                const el = document.getElementById(id);
                if(el) el.value = btn.getAttribute(attr) || '';
            }
        });
    }

    _configurarModalVisualizar() {
        const modal = document.getElementById('modalVisualizar');
        if (!modal) return;
        modal.addEventListener('show.bs.modal', (event) => {
            const btn = event.relatedTarget;
            const set = (id, val) => { document.getElementById(id).textContent = val; };
            
            set('viewNome', btn.getAttribute('data-nome'));
            set('viewEmail', btn.getAttribute('data-email'));
            set('viewCpf', btn.getAttribute('data-cpf'));
            set('viewEndereco', `${btn.getAttribute('data-endereco')}, ${btn.getAttribute('data-numero')}`);
            set('viewBairroCidade', `${btn.getAttribute('data-bairro')} - ${btn.getAttribute('data-cidade')}/${btn.getAttribute('data-estado')}`);
            set('viewCep', `CEP: ${btn.getAttribute('data-cep')}`);
        });
    }

    _configurarBuscaCep() {
        const input = document.getElementById('editCep');
        const btn = document.getElementById('btnBuscarCep');
        const acao = () => BuscaCEP.pesquisar(input.value, {
            endereco: 'editEndereco', bairro: 'editBairro', cidade: 'editCidade', estado: 'editEstado', numero: 'editNumero'
        });
        if(input) input.addEventListener('blur', acao);
        if(btn) btn.addEventListener('click', acao);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new GerenciadorClientes();
});