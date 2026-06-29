<?php

namespace App\Services;

use App\Exceptions\CacaPayException;
use App\Models\Cliente;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class CacaPayService
{
    /**
     * Envia a cobrança da loja digital para a API CaçaPay.
     *
     * A API exige CPF, token e valor. Nome e e-mail também são enviados
     * para permitir que o CaçaPay cadastre automaticamente um CPF novo.
     *
     * @throws CacaPayException
     */
    public function cobrar(Cliente $cliente, float $valor): array
    {
        $endpoint = trim((string) config('services.cacapay.endpoint'));
        $token = trim((string) config('services.cacapay.token'));

        if ($endpoint === '' || $token === '') {
            throw new CacaPayException(
                'A integração com o CaçaPay ainda não foi configurada. Preencha CACAPAY_ENDPOINT e CACAPAY_TOKEN no arquivo .env.'
            );
        }

        $payload = [
            'cpf' => $cliente->cpf,
            'token' => $token,
            'valor' => round($valor, 2),
            'nome' => $cliente->nome,
            'email' => $cliente->email,
        ];

        try {
            // A API não documenta chave de idempotência. Por segurança, não
            // repetimos a requisição automaticamente para evitar cobrança dupla.
            $response = Http::acceptJson()
                ->asJson()
                ->connectTimeout((int) config('services.cacapay.connect_timeout', 5))
                ->timeout((int) config('services.cacapay.timeout', 15))
                ->post($endpoint, $payload);
        } catch (ConnectionException $exception) {
            throw new CacaPayException(
                'Não foi possível conectar ao CaçaPay. Verifique se a API está em execução e tente novamente.',
                previous: $exception,
            );
        }

        $data = is_array($response->json()) ? $response->json() : [];
        $status = (string) data_get($data, 'status.nome', '');

        if ($response->status() === 201 && strcasecmp($status, 'Aprovado') === 0) {
            return $data;
        }

        $message = (string) data_get($data, 'message', '');

        if ($message === '') {
            $message = $response->serverError()
                ? 'O CaçaPay está indisponível no momento. A compra não foi finalizada.'
                : 'O pagamento não foi aprovado pelo CaçaPay.';
        }

        throw new CacaPayException($message, $response->status(), $data);
    }
}
