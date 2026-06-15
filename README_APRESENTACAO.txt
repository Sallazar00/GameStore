GameStore - versão Laravel com requisitos de e-commerce

Como testar:
1. Extraia o ZIP em uma pasta.
2. No terminal, entre na pasta do projeto.
3. Se necessário, rode: composer install
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
