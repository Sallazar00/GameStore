GameStore - loja de jogos digitais com pagamento CaçaPay

Como testar:
1. Extraia o ZIP em uma pasta.
2. No terminal, entre na pasta do projeto.
3. Se necessário, rode: composer install
4. Configure CACAPAY_ENDPOINT e CACAPAY_TOKEN no arquivo .env
5. Inicie o CaçaPay em outra porta, por exemplo: php artisan serve --port=8001
6. Inicie a GameStore: php artisan serve
7. Acesse: http://127.0.0.1:8000

Banco:
- O projeto já inclui database/database.sqlite com dados de exemplo.
- Para recriar do zero: php artisan migrate:fresh --seed

Login administrativo:
- E-mail: admin@gamestore.com
- Senha: 123456

Área administrativa:
- Categorias, plataformas e produtos.
- Produtos possuem slug automático, estoque, preço e até 5 imagens.

Área do cliente:
- Cadastro com nome, CPF, RG, nascimento, telefone, e-mail e senha.
- Carrinho em sessão.
- Checkout sem endereço.
- Pagamento consultado pelo CPF na API CaçaPay.
- Biblioteca digital liberada após aprovação.

Regra principal:
- Pagamento negado: carrinho mantido e estoque inalterado.
- Pagamento aprovado: venda finalizada e jogos liberados.
