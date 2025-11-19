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