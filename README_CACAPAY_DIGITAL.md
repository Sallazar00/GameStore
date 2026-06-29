# Alteração para loja somente digital

## O que foi removido

- Cadastro e gerenciamento de endereços do cliente.
- Cadastro administrativo de cidades.
- Models, controller, views, rotas e migrations desses módulos.
- Vínculo de endereço nas vendas e no checkout.
- Qualquer etapa ou campo relacionado à logística.

## O que foi integrado

A classe `CacaPayService` chama `POST /api/compras` com:

```json
{
  "cpf": "CPF DO CLIENTE",
  "token": "TOKEN DA EMPRESA",
  "valor": 59.90,
  "nome": "NOME DO CLIENTE",
  "email": "EMAIL DO CLIENTE"
}
```

Uma resposta HTTP `201` com `status.nome` igual a `Aprovado` finaliza a compra. Respostas negadas ou falhas de comunicação mantêm o carrinho e o estoque intactos.

## Dados salvos na venda

- Código do pedido.
- Status local da tentativa.
- ID e status da transação CaçaPay.
- Resposta JSON da API.
- Data da aprovação.
- Mensagem de erro, quando houver.

## Observação sobre segurança

O token fica somente no `.env` e é usado no servidor. Ele não é enviado para o navegador nem incluído no formulário do checkout.
