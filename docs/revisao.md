# Revisão pós-prova de TPA — 2ª etapa

A análise compara a entrega em ZIP com o enunciado de 20/08/2026. A nota informada pelo aluno foi 8,5; a rubrica totaliza 14 pontos. Não recebemos uma folha de correção individual, portanto não é possível atribuir cada desconto a um erro específico.

## Problemas e soluções

| Arquivo | Problema da entrega | Solução da revisão |
| --- | --- | --- |
| OrderController.php | Namespace `App\Http\Controllers\OrderController`, classe `orderController` e ausência de imports. | Namespace e classe canônicos, imports de Model, Request, JsonResponse e Response. |
| routes/api.php | Singular `/order`, GET e PUT trocados, PATCH ausente. | `Route::apiResource('orders', OrderController::class)`, com prefixo automático `/api`. |
| Migration | Tabela `order`, colunas com maiúsculas e ausência de timestamps. | Tabela `orders`, colunas padronizadas, tipos exigidos, timestamps e código único. |
| Model | Nome de arquivo e classe minúsculos; `$fillable` incompatível com o enunciado. | Classe `Order`, convenções Eloquent e quatro atributos em massa. |
| store | Criação direta com `$request->all()` sem validação. | Validação antes de `Order::create()`, retorno 201. |
| show | Código dependente de uma classe que não carregava. | Route Model Binding e retorno 200/404. |
| update | `UpdateOrderRequest` não existente, imports ausentes e mensagem de outra entidade. | Validação compartilhada, atualização completa ou parcial e retorno do pedido atualizado. |
| destroy | Assinatura e parâmetro de rota desalinhados. | Route Model Binding, exclusão e HTTP 204 sem corpo. |
| Projeto | Dependências e dados de execução misturados com a entrega. | Fontes organizados, `.gitignore`, ambiente de exemplo, testes e documentação. |

## Decisões da revisão

`codigo_pedido` recebeu restrição de unicidade e validação correspondente, para evitar pedidos duplicados. Os campos `cliente`, `status` e `codigo_pedido` são strings obrigatórias de até 255 caracteres. `total` é inteiro não negativo. O enunciado não especifica uma lista fechada de status nem uma unidade monetária, então não foram inventadas regras adicionais. PUT exige o registro completo; PATCH aceita atualização parcial. O Laravel responde 422 para dados inválidos e 404 para registros inexistentes, sempre em JSON nas rotas da API.

O esquema original da entrega não é compatível com a tabela revisada. Utilize um banco novo de desenvolvimento. A revisão não tenta alterar automaticamente dados antigos de outras atividades e não publica o SQLite enviado.

## Matriz de avaliação

| Critério | Peso | Evidência na revisão |
| --- | ---: | --- |
| CLI scaffolding | 1,0 | Arquivos canônicos de Model, migration e Controller |
| Migration schema | 1,0 | Migration `create_orders_table` e teste de esquema |
| Model fillable | 1,0 | Quatro atributos definidos no Model |
| API routing | 2,0 | `apiResource` e verificação de rotas |
| GET listagem | 1,5 | `index` e teste de listagem |
| POST cadastro | 2,5 | Validação, Eloquent e 201 |
| GET por ID | 1,5 | Route Model Binding e 200/404 |
| PUT/PATCH | 2,0 | Validação, update e 200/404 |
| DELETE | 1,5 | Exclusão e 204/404 |

A tabela demonstra o atendimento técnico esperado, não uma nova nota oficial nem uma confirmação dos pontos que o professor concederia.

## Como estudar

Reproduza cada erro em uma cópia da entrega, observe a mensagem, faça a correção e execute o teste relacionado. Compare o namespace e a classe, as convenções de nomes, o mapeamento HTTP, o fluxo Request → validação → Eloquent → JSON e a diferença entre 200, 201, 204, 404 e 422. A revisão foi preparada com apoio de ChatGPT e deve ser compreendida e validada pelo aluno antes de ser apresentada como trabalho realizado de forma independente.
