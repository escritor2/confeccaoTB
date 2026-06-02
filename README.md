# TS Confeccoes

Sistema web para gerenciamento de uma confeccao, desenvolvido com Laravel. O projeto centraliza o controle de clientes, pedidos, fornecedores, produtos, estoque e notificacoes em uma area administrativa autenticada.

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-38B2AC)
![Vite](https://img.shields.io/badge/Vite-7.x-646CFF)

## Sobre o projeto

O TS Confeccoes foi criado para apoiar a rotina administrativa de uma pequena confeccao. A aplicacao oferece cadastros essenciais, acompanhamento de estoque baixo, painel com indicadores e notificacoes internas ou por e-mail para eventos importantes do sistema.

O projeto usa Laravel Breeze para autenticacao, views Blade para a interface, Tailwind CSS para estilizar as telas e Vite para o fluxo de frontend.

## Funcionalidades

- Autenticacao de usuarios com area protegida.
- Dashboard com indicadores gerais do sistema.
- CRUD de clientes.
- CRUD de pedidos.
- CRUD de fornecedores.
- CRUD de produtos.
- Controle de estoque com quantidade minima.
- Alerta automatico para estoque baixo.
- Central de notificacoes no banco de dados.
- Envio opcional de notificacoes por e-mail.
- Tela visivel para conferir o status do SMTP e disparar e-mail de teste.
- Comando Artisan para verificacao diaria de estoque baixo.
- Configuracao para deploy com Docker e Render.

## Tecnologias

- PHP 8.2+
- Laravel 12
- Laravel Breeze
- Composer
- Node.js
- npm
- Vite
- Tailwind CSS
- Alpine.js
- SQLite para desenvolvimento local
- PostgreSQL para deploy no Render
- Docker

## Modulos

| Modulo | Descricao |
| --- | --- |
| Dashboard | Exibe totais de clientes, fornecedores, produtos, estoque, pedidos, estoque baixo e notificacoes nao lidas. |
| Clientes | Cadastro, listagem, edicao e exclusao de clientes. |
| Pedidos | Cadastro, listagem, edicao e exclusao de pedidos. |
| Fornecedores | Cadastro, listagem, edicao e exclusao de fornecedores. |
| Produtos | Cadastro, listagem, edicao e exclusao de produtos do catalogo. |
| Estoque | Controle de itens, quantidade atual e quantidade minima. |
| Notificacoes | Registro e leitura de alertas de pedidos, cadastros e estoque baixo. |

## Requisitos

Antes de rodar o projeto, tenha instalado:

- PHP 8.2 ou superior
- Composer
- Node.js
- npm
- SQLite habilitado no PHP

## Como rodar localmente

Clone o repositorio e acesse a pasta do projeto:

```bash
git clone <url-do-repositorio>
cd confeccaoTB
```

Instale as dependencias PHP:

```bash
composer install
```

Instale as dependencias do frontend:

```bash
npm install
```

Crie o arquivo de ambiente:

```powershell
Copy-Item .env.example .env
```

Em Linux/macOS:

```bash
cp .env.example .env
```

Gere a chave da aplicacao:

```bash
php artisan key:generate
```

Execute as migrations:

```bash
php artisan migrate
```

Inicie o servidor Laravel:

```bash
php artisan serve
```

Em outro terminal, inicie o Vite:

```bash
npm run dev
```

Acesse no navegador:

```text
http://127.0.0.1:8000
```

## Script de desenvolvimento

O projeto tambem possui um script Composer para iniciar servidor, fila, logs e Vite ao mesmo tempo:

```bash
composer run dev
```

## Configuracoes importantes

No arquivo `.env`, revise principalmente:

```env
APP_NAME="TS Confeccoes"
APP_URL=http://localhost:8000
DB_CONNECTION=sqlite
ESTOQUE_LIMITE_BAIXO=10
NOTIFICACAO_EMAIL_ADMIN=
```

Para envio de e-mail via SMTP:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu_email@gmail.com
MAIL_PASSWORD=sua_senha_de_app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Comandos uteis

Executar testes:

```bash
php artisan test
```

Gerar build de producao:

```bash
npm run build
```

Verificar estoque baixo manualmente:

```bash
php artisan estoque:verificar-baixo
```

Testar envio de e-mail:

```bash
php artisan mail:testar email@exemplo.com
```

Limpar caches do Laravel:

```bash
php artisan optimize:clear
```

## Notificacoes e estoque baixo

O sistema possui uma regra para identificar itens com estoque baixo. Um item entra em alerta quando:

```text
quantidade <= quantidade_minima
```

Se a quantidade minima nao estiver configurada no item, o sistema usa o valor definido em `ESTOQUE_LIMITE_BAIXO`, que por padrao e `10`.

Tambem existe um agendamento em `routes/console.php` para verificar o estoque diariamente as 08:00:

```php
Schedule::command('estoque:verificar-baixo')->dailyAt('08:00');
```

Na tela `Notificacoes`, o sistema mostra o status da configuracao SMTP e permite enviar um e-mail de teste para qualquer destinatario. Isso facilita validar se o envio real esta funcionando sem precisar usar o terminal.

Se estiver usando Gmail, crie uma senha de app na conta Google e use essa senha em `MAIL_PASSWORD`. Senha normal da conta geralmente nao funciona com SMTP.

## Estrutura principal

```text
app/
  Console/Commands/       Comandos Artisan personalizados
  Http/Controllers/       Controllers dos modulos
  Models/                 Models Eloquent
  Notifications/          Notificacoes do sistema
  Services/               Servicos compartilhados
  Support/                Regras auxiliares
database/
  migrations/             Estrutura do banco de dados
resources/
  views/                  Telas Blade
routes/
  web.php                 Rotas da aplicacao
  console.php             Agendamentos Artisan
docker/                   Script de inicializacao do container
```

## Deploy

O projeto possui arquivos preparados para deploy:

- `Dockerfile`
- `docker/entrypoint.sh`
- `render.yaml`

O blueprint do Render configura um servico web Docker e um banco PostgreSQL. Durante a inicializacao do container, o sistema executa migrations, cache de configuracao e cache de views.

## Documentacao completa

Para detalhes tecnicos sobre rotas, controllers, models, tabelas, comandos e fluxos do sistema, consulte:

- [DOCUMENTACAO.md](DOCUMENTACAO.md)

## Observacoes de manutencao

- A tabela de fornecedores esta nomeada como `fornecedor`, no singular.
- O model de estoque esta nomeado como `estoque`, em minusculo.
- O controle de quantidade operacional esta concentrado no modulo Estoque.
- O envio de e-mail depende de credenciais SMTP validas.

## Autor

Projeto desenvolvido para fins academicos e de estudo, com foco em gestao administrativa para confeccoes.
