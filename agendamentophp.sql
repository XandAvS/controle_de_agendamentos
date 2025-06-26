CREATE TABLE procedimentos (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  descricao LONGTEXT,
  preco DECIMAL(8,2) NOT NULL,
  tempo VARCHAR(10)
);

id: Identificador do procedimento (ex: 1 = Corte, 2 = Barba...).
nome: Nome do serviço.
descricao: Descrição opcional.
preco: Preço do serviço (ex: 25.00).
tempo: Duração (ex: "30 minutos").

CREATE TABLE barbeiros (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  foto VARCHAR(255),
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

id: Identificador único para cada barbeiro (chave primária).
nome: Nome do barbeiro (ex: João da Silva).
foto: Nome do arquivo da imagem salva no servidor (ex: joao.jpg).
criado_em: Data e hora do cadastro, preenchida automaticamente.

CREATE TABLE barbeiro_servico (
  barbeiro_id INT,
  servico_id INT,
  PRIMARY KEY (barbeiro_id, servico_id),
  FOREIGN KEY (barbeiro_id) REFERENCES barbeiros(id),
  FOREIGN KEY (servico_id) REFERENCES procedimentos(id)
);

barbeiro_id: ID do barbeiro (ligado à tabela barbeiros).
servico_id: ID do procedimento (ligado à tabela procedimentos).
PRIMARY KEY (barbeiro_id, servico_id): Garante que um mesmo serviço não seja duplicado para o mesmo barbeiro.

CREATE TABLE agendamentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cliente_nome VARCHAR(100) NOT NULL,
  data_agendada DATE NOT NULL,
  hora TIME NOT NULL,
  barbeiro_id INT NOT NULL,
  usuario_id INT NOT NULL,
 
  FOREIGN KEY (barbeiro_id) REFERENCES barbeiros(id),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE agendamento_servico (
    agendamento_id INT,
    servico_id INT,
    PRIMARY KEY (agendamento_id, servico_id),
    FOREIGN KEY (agendamento_id) REFERENCES agendamentos(id),
    FOREIGN KEY (servico_id) REFERENCES procedimentos(id)
);