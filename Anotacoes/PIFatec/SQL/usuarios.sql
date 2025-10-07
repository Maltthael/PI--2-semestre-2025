/* BD_LÓ_2SEM: */

CREATE TABLE cliente (
    id INTEGER PRIMARY KEY,
    email VARCHAR(50),
    senha VARCHAR(50),
    endereco VARCHAR(100),
    numero VARCHAR(10),
    bairro VARCHAR(100),
    cep VARCHAR(8)
);

CREATE TABLE adm (
    id INTEGER PRIMARY KEY,
    nome VARCHAR(255),
    email VARCHAR(100) UNIQUE,
    telefone VARCHAR(20),
    cpf VARCHAR(11) UNIQUE,
    cargo VARCHAR(50),
    data_emissao DATE,
    status ENUM('ativo', 'inativo')
);

CREATE TABLE vendas (
    id INTEGER PRIMARY KEY,
    data_venda DATE,
    fk_cliente_id INTEGER,
    fk_adm_id INTEGER
);

CREATE TABLE itens_venda (
    id INTEGER PRIMARY KEY,
    quantidade INTEGER,
    precounitario FLOAT,
    nome VARCHAR(100)
);

CREATE TABLE produtos (
    id INTEGER PRIMARY KEY,
    nome_produto VARCHAR(255),
    quantidade INTEGER,
    tipo VARCHAR(255),
    precounitario FLOAT,
    status ENUM('disponivel', 'esgotado','descontinuado'),
    fk_adm_id INTEGER
);

CREATE TABLE mensagem (
    id INTEGER PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100),
    telefone VARCHAR(11),
    assunto ENUM('orçamento','duvida','reclamacao','elogio'),
    servico ENUM('notebook','desktop','internet','outro'),
    mensagem VARCHAR(255),
    fk_cliente_id INTEGER
);

CREATE TABLE fazem_parte (
    fk_vendas_id INTEGER,
    fk_itens_venda_id INTEGER
);

CREATE TABLE possui (
    fk_itens_venda_id INTEGER,
    fk_produtos_id INTEGER
);
 
ALTER TABLE vendas ADD CONSTRAINT FK_vendas_2
    FOREIGN KEY (fk_cliente_id)
    REFERENCES cliente (id)
    ON DELETE RESTRICT;
 
ALTER TABLE vendas ADD CONSTRAINT FK_vendas_3
    FOREIGN KEY (fk_adm_id)
    REFERENCES adm (id)
    ON DELETE RESTRICT;
 
ALTER TABLE produtos ADD CONSTRAINT FK_produtos_2
    FOREIGN KEY (fk_adm_id)
    REFERENCES adm (id)
    ON DELETE CASCADE;
 
ALTER TABLE mensagem ADD CONSTRAINT FK_mensagem_2
    FOREIGN KEY (fk_cliente_id)
    REFERENCES cliente (id)
    ON DELETE RESTRICT;
 
ALTER TABLE fazem_parte ADD CONSTRAINT FK_fazem_parte_1
    FOREIGN KEY (fk_vendas_id)
    REFERENCES vendas (id)
    ON DELETE RESTRICT;
 
ALTER TABLE fazem_parte ADD CONSTRAINT FK_fazem_parte_2
    FOREIGN KEY (fk_itens_venda_id)
    REFERENCES itens_venda (id)
    ON DELETE RESTRICT;
 
ALTER TABLE possui ADD CONSTRAINT FK_possui_1
    FOREIGN KEY (fk_itens_venda_id)
    REFERENCES itens_venda (id)
    ON DELETE RESTRICT;
 
ALTER TABLE possui ADD CONSTRAINT FK_possui_2
    FOREIGN KEY (fk_produtos_id)
    REFERENCES produtos (id)
    ON DELETE RESTRICT;