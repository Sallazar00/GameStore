<<<<<<< HEAD
GameStore - loja de jogos digitais com pagamento CaçaPay
=======
GameStore - versão Laravel com requisitos de e-commerce
>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a

Como testar:
1. Extraia o ZIP em uma pasta.
2. No terminal, entre na pasta do projeto.
3. Se necessário, rode: composer install
<<<<<<< HEAD
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
=======
4. Rode: php artisan serve
5. Acesse: http://127.0.0.1:8000

Banco:
- O projeto já vai com database/database.sqlite criado e com alguns dados de exemplo.
- Se quiser recriar do zero, rode: php artisan migrate:fresh --seed

Login:
- Administrador de teste:
  email: admin@gamestore.com
  senha: 123456

- Cliente:
  Use o botão "Cadastrar" no menu e cadastre um cliente.

Área do administrador:
- Disponível após login como admin.
- Cadastra categorias, plataformas, cidades e produtos.
- Produtos possuem slug automático.
- Produtos podem ter URL de imagem e/ou upload de fotos.
- Limite de 5 fotos por produto.

Área do cliente:
- Cadastro de cliente com nome, CPF, RG, data de nascimento, telefone, email e senha.
- Cadastro de endereços.
- Carrinho usando sessão.
- Checkout escolhendo endereço.
- Biblioteca com jogos comprados.

Observação:
- Esta versão foi organizada para atender aos requisitos solicitados de última hora.
- O sistema usa SQLite para facilitar a apresentação em sala.
>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
