<h1 align="center">
  Sistema de Gestão de Chamados 🖥️
</h1>

<p align="center">
  Um sistema desenvolvido em <b>PHP MVC</b> para substituir o controle manual de chamados em planilhas, trazendo mais agilidade, organização e facilidade na emissão de informações.
</p>

## 🎨 Interface e Design
O painel (Dashboard) e toda a interface foram desenvolvidos utilizando uma paleta de cores focada em **tons de azul e branco**, garantindo um aspecto limpo, corporativo e agradável para uso contínuo, com layout totalmente responsivo.

## 📌 Contexto e Problema Resolvido
Uma organização buscou o desenvolvimento desta aplicação devido à dificuldade de realizar consultas, organização e emissão de informações, problemas decorrentes do uso de planilhas e registros manuais.

## ⚙️ Módulos do Sistema
- **Usuários:** Gestão de quem pode acessar e operar o sistema.
- **Chamados:** Abertura, acompanhamento e gerenciamento das solicitações.
- **Categorias:** Classificação dos chamados (ex: Suporte TI, Manutenção, RH, etc).
- **Dashboard:** Painel gerencial com indicadores e gráficos da operação.

## 📋 Requisitos Funcionais
- **RF01:** Cadastrar, editar, excluir e listar usuários.
- **RF02:** Cadastrar, editar, excluir e listar chamados.
- **RF03:** Cadastrar, editar, excluir e listar categorias.
- **RF04:** Dashboard com totais, gráficos simples ou indicadores visuais.
- **RF05:** Pesquisa por palavra-chave.

## 🛡️ Regras de Negócio Aplicadas
- Validação estruturada para não permitir o envio ou processamento de campos obrigatórios vazios.
- Modelagem de dados relacional (MySQL) com o uso correto de Chaves Primárias (PK) e Estrangeiras (FK).
- Interface organizada e responsiva, adaptando-se a diferentes tamanhos de tela (desktop, tablet e mobile).
- Estruturação do código-fonte seguindo rigorosamente a **Arquitetura MVC** (Model-View-Controller).

## 🚀 Tecnologias Utilizadas
- **Backend:** PHP
- **Arquitetura:** MVC
- **Banco de Dados:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript (Estilização exclusiva em azul e branco)

## 📦 Entregáveis do Projeto
- `database.sql`: Script de criação do banco de dados e tabelas.
- Diretórios e arquivos do Projeto PHP MVC.
- `README.md`: Documentação atual do repositório.
- (Apresentação funcional preparada para demonstração).

## 🛠️ Como Executar o Projeto Localmente
1. Clone este repositório para o seu ambiente local (ex: pasta `htdocs` do XAMPP ou `www` do WAMP):
   ```bash
   git clone https://github.com/seu-usuario/seu-repositorio.git
   ```
2. Inicie os serviços do **Apache** e **MySQL** no seu servidor local.
3. Importe o arquivo `.sql` (disponível na raiz do projeto) para o seu MySQL através do *phpMyAdmin* ou terminal.
4. Caso necessário, ajuste as credenciais de acesso ao banco de dados no arquivo de configuração do projeto (geralmente em `config/database.php` ou `.env`).
5. Acesse o sistema através do seu navegador: `http://localhost/seu-repositorio/`.
