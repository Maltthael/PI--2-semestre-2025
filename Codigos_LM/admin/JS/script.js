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

class ProdutoUtils {
    static setupImagePreview(fileInputId, previewAreaId, fotoAtualId = null) {
        const fileInput = document.getElementById(fileInputId);
        if (!fileInput) return;

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewArea = document.getElementById(previewAreaId);
            const fotoAtualElement = fotoAtualId ? document.getElementById(fotoAtualId) : null;

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (fotoAtualElement) fotoAtualElement.style.display = 'none';
                    previewArea.innerHTML = `<img src="${e.target.result}" alt="Preview" class="img-fluid rounded shadow-sm">`;
                    previewArea.style.borderColor = '#28a745';
                }
                reader.readAsDataURL(file);
            } else {
                if (fotoAtualElement) {
                    fotoAtualElement.style.display = 'block';
                    previewArea.innerHTML = '';
                } else {
                    previewArea.innerHTML = `<i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i><p class="small text-muted mb-0">Clique para enviar</p>`;
                }
                previewArea.style.borderColor = '#ced4da';
            }
        });
    }
}

class GerenciadorProdutos {
    constructor() {
        this._configurarModalNovoProduto();
        this._configurarModalEdicao();
    }

    _configurarModalNovoProduto() {
        ProdutoUtils.setupImagePreview('fileInput', 'previewArea');
    }

    _configurarModalEdicao() {
        const modal = document.getElementById('modalEdicao');
        if (!modal) return;

        ProdutoUtils.setupImagePreview('fileInputEdicao', 'previewAreaEdicao', 'edicao-foto-atual');

        modal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;
            
            const mapa = {
                'edicao-id-produto': 'data-id',
                'edicao-nome': 'data-nome',
                'edicao-categoria': 'data-categoria-id',
                'edicao-custo': 'data-custo',
                'edicao-venda': 'data-venda',
                'edicao-quantidade': 'data-quantidade',
                'edicao-status': 'data-status',
                'edicao-descricao': 'data-descricao'
            };

            for (const [idInput, dataAttr] of Object.entries(mapa)) {
                const value = button.getAttribute(dataAttr) || '';
                const input = document.getElementById(idInput);
                if (input) {
                    input.value = value;
                }
            }

            const nomeProdutoTitle = document.getElementById('edicao-nome-produto-title');
            const fotoAtualElement = document.getElementById('edicao-foto-atual');
            const previewAreaEdicao = document.getElementById('previewAreaEdicao');

            const nome = button.getAttribute('data-nome');
            const fotoUrlCompleta = button.getAttribute('data-full-url');
            
            if(nomeProdutoTitle) nomeProdutoTitle.textContent = nome;

            if(fotoAtualElement) {
                fotoAtualElement.src = fotoUrlCompleta; 
                fotoAtualElement.style.display = 'block'; 
            }

            if(previewAreaEdicao) {
                previewAreaEdicao.innerHTML = '';
                previewAreaEdicao.style.borderColor = '#ced4da';
            }
            
            document.getElementById('fileInputEdicao').value = null; 
        });
    }
}

class GerenciadorClientes {
    constructor() {
        this.initEvents();
    }

    initEvents() {
        this._configurarModalEditar();
        this._configurarModalVisualizar();
        this._configurarBuscaCep();
        this._configurarBuscaClientes();
    }
    
    _configurarBuscaCep() {
        const input = document.getElementById('editCep');
        const btn = document.getElementById('btnBuscarCep');
        const status = () => BuscaCEP.pesquisar(input.value, {
            endereco: 'editEndereco', bairro: 'editBairro', cidade: 'editCidade', estado: 'editEstado', numero: 'editNumero'
        });
        if(input) input.addEventListener('blur', status);
        if(btn) btn.addEventListener('click', status);
    }
    
    _configurarBuscaClientes() {
        const inputBusca = document.getElementById('inputBusca');
        if (!inputBusca) return;

        let timeout = null;
        const tabelaCorpo = document.querySelector('.table.table-hover tbody');
        
        const buscar = async () => {
            const termo = inputBusca.value.trim();
            const endpoint = `../Classes/admin.php?action=busca_cliente&termo=${encodeURIComponent(termo)}`;
            
            tabelaCorpo.innerHTML = '<tr><td colspan="6" class="text-center py-5"><i class="fas fa-spinner fa-spin me-2"></i> Buscando...</td></tr>';

            try {
                const res = await fetch(endpoint);
                const clientes = await res.json();
                
                if (res.ok) {
                    this._renderizarClientes(clientes, tabelaCorpo);
                } else {
                    tabelaCorpo.innerHTML = `<tr><td colspan="6" class="text-center py-5 text-danger"><i class="fas fa-exclamation-triangle me-2"></i> Erro ao buscar clientes: ${clientes.erro || 'Desconhecido'}</td></tr>`;
                }

            } catch (e) {
                tabelaCorpo.innerHTML = `<tr><td colspan="6" class="text-center py-5 text-danger"><i class="fas fa-exclamation-triangle me-2"></i> Erro de comunicação.</td></tr>`;
            }
        };

        inputBusca.addEventListener('keyup', (e) => {
            clearTimeout(timeout);
            timeout = setTimeout(buscar, 300);
        });
        
        buscar();
    }
    
    _renderizarClientes(clientes, tabelaCorpo) {
        if (clientes.length === 0) {
            tabelaCorpo.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="fas fa-user-slash fa-3x mb-3 opacity-50 text-muted"></i>
                        <p class="text-muted">Nenhum cliente encontrado.</p>
                    </td>
                </tr>`;
            return;
        }

        let html = '';
        clientes.forEach(cliente => {
            const inicial = cliente.nome.substring(0, 1).toUpperCase();
            
            html += `
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar-initial shadow-sm bg-primary text-white" style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.1rem; margin-right: 15px;">
                                ${inicial}
                            </div>
                            <div>
                                <div class="fw-bold text-dark">${cliente.nome}</div>
                                <div class="small text-muted">ID: #${cliente.id_cliente}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="text-dark"><i class="far fa-envelope me-1 text-muted"></i> ${cliente.email}</span>
                            <span class="small text-muted mt-1"><i class="fas fa-phone-alt me-1"></i> ${cliente.telefone || ''}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-medium">${cliente.cidade} - ${cliente.estado}</span>
                            <span class="small text-muted">${cliente.bairro}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">${cliente.cpf}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success-subtle text-success rounded-pill">Ativo</span>
                    </td>
                    <td class="text-end pe-4">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-secondary btn-visualizar"
                                title="Ver Detalhes"
                                data-bs-toggle="modal"
                                data-bs-target="#modalVisualizar"
                                data-nome="${cliente.nome}"
                                data-email="${cliente.email}"
                                data-cpf="${cliente.cpf}"
                                data-endereco="${cliente.endereco}"
                                data-numero="${cliente.numero}"
                                data-bairro="${cliente.bairro}"
                                data-cep="${cliente.cep}"
                                data-cidade="${cliente.cidade}"
                                data-estado="${cliente.estado}">
                                <i class="fas fa-eye"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-primary"
                                title="Editar"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditar"
                                data-id="${cliente.id_cliente}"
                                data-nome="${cliente.nome}"
                                data-email="${cliente.email}"
                                data-telefone="${cliente.telefone || ''}"
                                data-cpf="${cliente.cpf}"
                                data-cep="${cliente.cep}"
                                data-endereco="${cliente.endereco}"
                                data-numero="${cliente.numero}"
                                data-bairro="${cliente.bairro}"
                                data-cidade="${cliente.cidade}"
                                data-estado="${cliente.estado}">
                                <i class="fas fa-pencil-alt"></i>
                            </button>

                            <form action="../Classes/admin.php" method="POST" onsubmit="confirmarExclusao(event, '${cliente.nome}')" style="display: inline;">
                                <input type="hidden" name="action" value="excluir_cliente">
                                <input type="hidden" name="id_cliente" value="${cliente.id_cliente}">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            `;
        });
        tabelaCorpo.innerHTML = html;
        this._configurarModalEditar();
        this._configurarModalVisualizar();
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
    
}


document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('modalEdicao')) { 
        new GerenciadorProdutos();
    } 
    if (document.getElementById('modalEditar')) { 
        new GerenciadorClientes();
    }
});

function confirmarExclusao(event, nomeItem) {
    event.preventDefault(); 
    
    Swal.fire({
        title: 'Tem certeza?',
        text: `Você está prestes a excluir: "${nomeItem}"`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    
    var modalEdicaoOS = document.getElementById('modalEdicaoOS');

    if (modalEdicaoOS) {
        modalEdicaoOS.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;

            var id = button.getAttribute('data-id');
            var titulo = button.getAttribute('data-titulo');
            var cliente = button.getAttribute('data-cliente');
            var prazo = button.getAttribute('data-prazo');
            var status = button.getAttribute('data-status');

            document.getElementById('edit_id_ordem').value = id;
            document.getElementById('edit_titulo').value = titulo;
            document.getElementById('edit_id_cliente').value = cliente;
            document.getElementById('edit_prazo').value = prazo;
            document.getElementById('edit_status').value = status;
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
    const alertaDiv = document.getElementById('alerta-sistema');

    if (alertaDiv) {
        const icon = alertaDiv.getAttribute('data-icon');
        const title = alertaDiv.getAttribute('data-title');
        const message = alertaDiv.getAttribute('data-message');

        Swal.fire({
            icon: icon,
            title: title,
            text: message,
            confirmButtonColor: '#3085d6', 
            confirmButtonText: 'Ok'
        }).then((result) => {
        });
    }
});
});
