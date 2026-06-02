# Documentacao do Sistema TS Confeccoes

## Visao geral

O projeto e um sistema web para gestao de uma confeccao, desenvolvido em Laravel 12. Ele permite controlar clientes, pedidos, fornecedores, estoque, produtos e notificacoes internas, com area administrativa protegida por login.

O sistema usa Laravel Breeze para autenticacao, Blade para as telas, Tailwind CSS para estilos, Alpine.js para interacoes no frontend e Vite para empacotamento dos assets.

## Tecnologias utilizadas

- PHP 8.2 ou superior
- Laravel 12
- Composer
- Node.js e npm
- Vite
- Tailwind CSS
- Alpine.js
- SQLite em ambiente local
- PostgreSQL no deploy configurado para Render
- Docker para execucao em producao

## Estrutura do projeto

```text
app/
  Console/Commands/       Comandos Artisan personalizados
  Http/Controllers/       Controllers das funcionalidades
  Models/                 Models Eloquent
  Notifications/          Notificacoes do sistema
  Services/               Servicos compartilhados
  Support/                Regras auxiliares
config/                   Configuracoes da aplicacao
database/
  migrations/             Estrutura das tabelas
  factories/              Factories para testes/desenvolvimento
  seeders/                Seeders
resources/
  views/                  Telas Blade
  css/                    CSS principal
  js/                     JavaScript principal
routes/
  web.php                 Rotas web
  console.php             Agendamento de comandos
docker/                   Scripts do container
```

## Instalacao local

1. Instale as dependencias PHP:

```bash
composer install
```

2. Instale as dependencias JavaScript:

```bash
npm install
```

3. Crie o arquivo `.env`:

```powershell
Copy-Item .env.example .env
```

4. Gere a chave da aplicacao:

```bash
php artisan key:generate
```

5. Execute as migrations:

```bash
php artisan migrate
```

6. Inicie o Laravel:

```bash
php artisan serve
```

7. Em outro terminal, inicie o Vite:

```bash
npm run dev
```

Tambem existe o script:

```bash
composer run dev
```

Ele inicia servidor Laravel, fila, logs e Vite ao mesmo tempo.

## Autenticacao e acesso

As rotas administrativas estao protegidas pelos middlewares `auth` e `verified`. Assim, o usuario precisa estar logado e, quando a verificacao estiver ativa, ter o e-mail verificado.

A rota publica principal e:

- `GET /`

As rotas autenticadas ficam agrupadas em `routes/web.php`.

## Modulos do sistema

### Dashboard

Controller: `app/Http/Controllers/DashboardController.php`

Rota:

- `GET /dashboard`

O dashboard exibe contadores de clientes, fornecedores, produtos, estoque, pedidos, estoque baixo e notificacoes nao lidas.

### Clientes

Controller: `app/Http/Controllers/ClienteController.php`

Model: `app/Models/Clientes.php`

Tabela: `clientes`

Campos:

- `nome`
- `cpf`, unico
- `email`, unico
- `telefone`
- `endereco`, opcional

Rotas:

- `GET /clientes`
- `GET /clientes/create`
- `POST /clientes`
- `GET /clientes/{id}/edit`
- `PUT /clientes/{cliente}`
- `DELETE /clientes/{cliente}`

Ao cadastrar um cliente, o sistema envia uma notificacao de operacao para os usuarios.

### Pedidos

Controller: `app/Http/Controllers/PedidoController.php`

Model: `app/Models/Pedidos.php`

Tabela: `pedidos`

Campos:

- `nome`
- `telefone`, unico
- `endereco`, opcional

Rotas:

- `GET /pedidos`
- `GET /pedidos/create`
- `POST /pedidos`
- `GET /pedidos/{id}/edit`
- `PUT /pedidos/{pedido}`
- `DELETE /pedidos/{pedido}`

Ao cadastrar um pedido, o sistema envia a notificacao `NovoPedidoNotification`.

### Fornecedores

Controller: `app/Http/Controllers/FornecedorController.php`

Model: `app/Models/Fornecedor.php`

Tabela: `fornecedor`

Campos:

- `nome`
- `telefone`, unico
- `endereco`, opcional

Rotas:

- `GET /fornecedores`
- `GET /fornecedores/create`
- `POST /fornecedores`
- `GET /fornecedores/{id}/edit`
- `PUT /fornecedores/{fornecedor}`
- `DELETE /fornecedores/{fornecedor}`

Ao cadastrar um fornecedor, o sistema envia uma notificacao de operacao para os usuarios.

### Estoque

Controller: `app/Http/Controllers/EstoqueController.php`

Model: `app/Models/estoque.php`

Tabela: `estoques`

Campos:

- `nome`
- `quantidade`
- `quantidade_minima`

Rotas:

- `GET /estoque`
- `GET /estoque/create`
- `POST /estoque`
- `GET /estoque/{id}/edit`
- `PUT /estoque/{estoque}`
- `DELETE /estoque/{estoque}`

Regras:

- `quantidade` deve ser inteiro e maior ou igual a zero.
- `quantidade_minima` pode ser nula, mas se informada deve ser inteiro e maior ou igual a zero.
- Um item fica em estoque baixo quando `quantidade <= quantidade_minima`.
- Se nao houver quantidade minima especifica, o sistema usa o limite padrao de `ESTOQUE_LIMITE_BAIXO`, com valor padrao `10`.

Quando um item e criado ou atualizado, o sistema verifica automaticamente se ele esta abaixo do minimo e envia alerta.

### Produtos

Controller: `app/Http/Controllers/ProdutoController.php`

Model: `app/Models/Produto.php`

Tabela: `produtos`

Campos:

- `nome`
- `descricao`, opcional
- `preco`

Rotas:

- `GET /produtos`
- `GET /produtos/create`
- `POST /produtos`
- `GET /produtos/{id}/edit`
- `PUT /produtos/{produto}`
- `DELETE /produtos/{produto}`

Ao cadastrar um produto, o sistema envia uma notificacao de operacao para os usuarios.

## Notificacoes

Controller: `app/Http/Controllers/NotificationController.php`

Service: `app/Services/NotificacaoService.php`

Rotas:

- `GET /notificacoes`
- `POST /notificacoes/email-teste`
- `PATCH /notificacoes/lidas`
- `PATCH /notificacoes/{id}/lida`

Tipos de notificacao:

- `EstoqueBaixoNotification`: alerta quando um item esta com estoque abaixo ou igual ao minimo.
- `NovoPedidoNotification`: alerta quando um pedido e cadastrado.
- `OperacaoSistemaNotification`: alerta para operacoes gerais do sistema.

As notificacoes sao salvas no banco de dados e tambem podem ser enviadas por e-mail quando o SMTP estiver configurado.

O `NotificacaoService` envia notificacoes para todos os usuarios cadastrados. Se a variavel `NOTIFICACAO_EMAIL_ADMIN` estiver definida, uma copia tambem e enviada para esse e-mail.

A tela de notificacoes tambem exibe o status basico do SMTP e possui um formulario de teste. Esse formulario envia um e-mail real usando as configuracoes atuais de `config/mail.php` e `.env`.

## Comandos Artisan

### Verificar estoque baixo

Arquivo:

```text
app/Console/Commands/VerificarEstoqueBaixoCommand.php
```

Comando:

```bash
php artisan estoque:verificar-baixo
```

Esse comando verifica todos os itens de estoque e envia alertas para os que estiverem abaixo ou iguais ao limite minimo.

Agendamento em `routes/console.php`:

```php
Schedule::command('estoque:verificar-baixo')->dailyAt('08:00');
```

### Testar e-mail

Arquivo:

```text
app/Console/Commands/TestarEmailCommand.php
```

Comando:

```bash
php artisan mail:testar
```

Com destinatario especifico:

```bash
php artisan mail:testar email@exemplo.com
```

Esse comando envia um e-mail simples para validar a configuracao SMTP.

## Variaveis de ambiente importantes

Aplicacao:

```env
APP_NAME="TS Confeccoes"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

Banco local:

```env
DB_CONNECTION=sqlite
```

Notificacoes e estoque:

```env
ESTOQUE_LIMITE_BAIXO=10
NOTIFICACAO_EMAIL_ADMIN=
```

SMTP:

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

Para Gmail, use senha de app gerada na Conta Google. A senha normal da conta pode ser recusada pelo SMTP com erro de autenticacao.

## Banco de dados

Principais tabelas:

- `users`
- `clientes`
- `pedidos`
- `fornecedor`
- `estoques`
- `produtos`
- `notifications`
- `cache`
- `jobs`

Observacoes:

- A tabela de fornecedores se chama `fornecedor`, no singular.
- O model `Fornecedor` define `protected $table = 'fornecedor';`.
- A tabela `produtos` tem uma coluna `quantidade`, mas o controller atual trabalha apenas com `nome`, `descricao` e `preco`.
- O controle de quantidade usado pelo sistema fica no modulo Estoque.

## Interface

As telas ficam em `resources/views`.

Principais pastas:

- `clientes/`
- `pedido/`
- `fornecedor/`
- `estoque/`
- `produto/`
- `notifications/`
- `profile/`
- `auth/`

A navegacao principal fica em:

```text
resources/views/layouts/navigation.blade.php
```

Menus disponiveis:

- Dashboard
- Clientes
- Pedidos
- Fornecedores
- Estoque
- Produtos
- Notificacoes
- Perfil
- Logout

## Testes

Para executar os testes:

```bash
php artisan test
```

Ou:

```bash
composer test
```

O projeto possui testes padrao do Laravel Breeze para autenticacao e perfil, alem de testes de exemplo.

## Build de frontend

Ambiente de desenvolvimento:

```bash
npm run dev
```

Build de producao:

```bash
npm run build
```

## Deploy

O projeto possui configuracao para deploy com Docker e Render.

Arquivos:

- `Dockerfile`
- `docker/entrypoint.sh`
- `render.yaml`

No Render, o blueprint cria:

- Banco PostgreSQL `confeccao-db`
- Servico web Docker `confeccao-tb`

Durante a inicializacao do container, o entrypoint executa:

```bash
php artisan migrate --force --no-interaction
php artisan config:cache
php artisan view:cache
```

Depois o servidor Laravel e iniciado na porta configurada por `PORT`, com padrao `8000`.

## Fluxos principais

### Cadastro de cliente

1. Usuario acessa Clientes.
2. Preenche nome, CPF, e-mail, telefone e endereco.
3. Sistema valida campos obrigatorios e duplicidade.
4. Sistema salva o cliente.
5. Sistema envia notificacao de novo cliente.

### Cadastro de pedido

1. Usuario acessa Pedidos.
2. Preenche nome, telefone e endereco.
3. Sistema valida o telefone como unico.
4. Sistema salva o pedido.
5. Sistema envia notificacao de novo pedido.

### Controle de estoque baixo

1. Usuario cria ou atualiza item de estoque.
2. Sistema valida nome, quantidade e quantidade minima.
3. Sistema salva o item.
4. Sistema verifica se `quantidade <= quantidade_minima`.
5. Se estiver baixo, envia notificacao.
6. Diariamente as 08:00, o comando agendado tambem verifica todos os itens.

## Pontos de atencao

- Alguns nomes fogem do padrao comum do Laravel, como o model `estoque` em minusculo e a tabela `fornecedor` no singular.
- Os controllers usam `create($request->all())` em alguns modulos. Como os models possuem `$fillable`, isso funciona, mas em manutencoes futuras pode ser melhor usar `$request->only(...)`.
- O envio de e-mails depende de SMTP configurado corretamente.
- Para Gmail, normalmente e necessario usar senha de app.
- O README padrao do Laravel foi substituido por um resumo do projeto, e esta documentacao concentra os detalhes tecnicos.
