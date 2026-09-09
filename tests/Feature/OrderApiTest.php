<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    private function dados(array $alteracoes = []): array
    {
        return array_merge([
            'cliente' => 'Maria',
            'status' => 'pendente',
            'codigo_pedido' => 'PED-001',
            'total' => 150,
        ], $alteracoes);
    }

    public function test_migration_e_model(): void
    {
        $this->assertTrue(Schema::hasTable('orders'));
        $this->assertTrue(Schema::hasColumns('orders', ['id', 'cliente', 'status', 'codigo_pedido', 'total', 'created_at', 'updated_at']));
        $this->assertSame(['cliente', 'status', 'codigo_pedido', 'total'], (new Order)->getFillable());
        $this->assertFalse(Schema::hasTable('order'));
    }

    public function test_listagem_e_cadastro(): void
    {
        $this->getJson('/api/orders')->assertOk()->assertExactJson([]);
        $resposta = $this->postJson('/api/orders', $this->dados());
        $resposta->assertCreated()->assertJsonPath('cliente', 'Maria')->assertJsonPath('total', 150)->assertJsonStructure(['id', 'codigo_pedido']);
        $this->assertDatabaseHas('orders', ['codigo_pedido' => 'PED-001', 'total' => 150]);
        $this->getJson('/api/orders')->assertOk()->assertJsonCount(1)->assertJsonPath('0.cliente', 'Maria');
    }

    public function test_busca_atualizacao_e_exclusao(): void
    {
        $id = $this->postJson('/api/orders', $this->dados())->json('id');
        $this->getJson("/api/orders/{$id}")->assertOk()->assertJsonPath('cliente', 'Maria');
        $this->putJson("/api/orders/{$id}", $this->dados(['status' => 'enviado', 'total' => 200]))
            ->assertOk()->assertJsonPath('status', 'enviado')->assertJsonPath('total', 200);
        $this->patchJson("/api/orders/{$id}", ['status' => 'entregue'])
            ->assertOk()->assertJsonPath('status', 'entregue')->assertJsonPath('total', 200);
        $this->deleteJson("/api/orders/{$id}")->assertNoContent();
        $this->assertDatabaseMissing('orders', ['id' => $id]);
        $this->getJson("/api/orders/{$id}")->assertNotFound()->assertJsonStructure(['message']);
        $this->putJson("/api/orders/{$id}", $this->dados())->assertNotFound();
        $this->patchJson("/api/orders/{$id}", ['status' => 'novo'])->assertNotFound();
        $this->deleteJson("/api/orders/{$id}")->assertNotFound();
    }

    public function test_validacao_e_codigo_unico(): void
    {
        $this->postJson('/api/orders', [])->assertUnprocessable()->assertJsonValidationErrors(['cliente', 'status', 'codigo_pedido', 'total']);
        $this->postJson('/api/orders', $this->dados(['total' => -1]))->assertUnprocessable()->assertJsonValidationErrors('total');
        $this->postJson('/api/orders', $this->dados(['total' => 1.5]))->assertUnprocessable()->assertJsonValidationErrors('total');
        $this->postJson('/api/orders', $this->dados(['cliente' => ['nome' => 'Maria']]))->assertUnprocessable()->assertJsonValidationErrors('cliente');
        $id = $this->postJson('/api/orders', $this->dados())->json('id');
        $this->postJson('/api/orders', $this->dados())->assertUnprocessable()->assertJsonValidationErrors('codigo_pedido');
        $this->putJson("/api/orders/{$id}", $this->dados())->assertOk();
        $this->patchJson("/api/orders/{$id}", ['total' => -10])->assertUnprocessable()->assertJsonValidationErrors('total');
        $this->assertDatabaseHas('orders', ['id' => $id, 'total' => 150]);
    }

    public function test_rotas_e_respostas_sao_api(): void
    {
        $this->getJson('/api/order')->assertNotFound()->assertHeader('Content-Type', 'application/json');
        $this->getJson('/api/orders/999')->assertNotFound()->assertHeader('Content-Type', 'application/json');
        $this->postJson('/api/orders', [])->assertUnprocessable()->assertHeader('Content-Type', 'application/json');
        $this->post('/api/orders', [], ['Accept' => 'text/html'])->assertUnprocessable()->assertHeader('Content-Type', 'application/json');
    }
}
