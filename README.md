# GameStore — loja digital com CaçaPay

Projeto Laravel de uma loja de jogos exclusivamente digitais. O checkout consulta a API CaçaPay usando o CPF do cliente. Não há cadastro de endereço, cidade ou integração logística.

## Fluxo de compra

1. O cliente adiciona jogos ao carrinho e abre o checkout.
2. A GameStore envia CPF, nome, e-mail, token da empresa e valor para o endpoint `POST /api/compras` do CaçaPay.
3. Se o pagamento for negado, a tentativa é registrada como não finalizada, o estoque não muda e o carrinho permanece preenchido.
4. Se o pagamento for aprovado, a venda é finalizada, o estoque é atualizado e os jogos são liberados na biblioteca.

## Configuração do CaçaPay

No arquivo `.env`, configure:

```env
CACAPAY_ENDPOINT=http://127.0.0.1:8001/api/compras
CACAPAY_TOKEN=SEU_TOKEN_DA_EMPRESA_PARCEIRA
CACAPAY_CONNECT_TIMEOUT=5
CACAPAY_TIMEOUT=15
```

O endpoint e o token são configuráveis para permitir executar a API em outra porta ou servidor.

## Como executar

Requisitos: PHP 8.2 ou superior, Composer e extensões `mbstring`, `dom/xml`, `pdo_sqlite`, `fileinfo`, `openssl` e `zip`.

```bash
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

O ZIP já inclui `database/database.sqlite` com produtos de demonstração. Para manter esse banco, não é necessário executar `migrate:fresh`.

Execute o CaçaPay em outro terminal/porta, por exemplo:

```bash
cd caminho/do/cacapay
php artisan serve --port=8001
```

Depois acesse a GameStore, normalmente em `http://127.0.0.1:8000`.

## Administrador de demonstração

- E-mail: `admin@gamestore.com`
- Senha: `123456`

## Arquivos principais da integração

- `app/Services/CacaPayService.php`
- `app/Exceptions/CacaPayException.php`
- `app/Http/Controllers/StoreController.php`
- `app/Models/Venda.php`
- `config/services.php`
- `resources/views/store/checkout.blade.php`
- `resources/views/biblioteca.blade.php`
- `database/migrations/2026_01_01_000800_create_vendas_table.php`
