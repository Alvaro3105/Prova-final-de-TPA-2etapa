# Prova final de TPA — 2ª etapa

Revisão pós-avaliação de uma API REST de pedidos em PHP e Laravel 12. O projeto reúne a entrega original e uma versão revisada com apoio de IA, com documentação dos erros identificados, correções propostas e testes automatizados.

## Sobre a prova

A atividade prática de 20/08/2026 solicitou um CRUD de `Order`, com Model, migration, Controller de recursos, rotas `/api/orders` e respostas JSON. O enunciado possui valor total de 14 pontos. A nota informada pelo aluno foi 8,5, mas não há uma correção individual detalhada disponível.

## Requisitos

PHP 8.2 ou superior, com extensões exigidas pelo Laravel, incluindo PDO SQLite, mbstring e XML. Composer 2 e SQLite são utilizados no ambiente local. Node.js não é necessário para testar a API.

## Executar

Na raiz do projeto:

```bash
composer install
```

No Windows PowerShell:

```powershell
Copy-Item .env.example .env
New-Item database/database.sqlite -ItemType File -Force
php artisan key:generate
php artisan migrate
php artisan serve
```

No Linux/macOS, use `cp .env.example .env` e `touch database/database.sqlite` antes dos comandos Artisan. O servidor normalmente inicia em `http://127.0.0.1:8000`.

**Importante:** use um banco novo. A migration foi corrigida e não é compatível com a tabela singular criada na entrega. Não utilize `migrate:fresh` em um banco com dados que queira preservar.

## Endpoints

| Método | Endpoint | Retorno esperado |
| --- | --- | --- |
| GET | `/api/orders` | 200, lista JSON |
| POST | `/api/orders` | 201, pedido criado |
| GET | `/api/orders/{id}` | 200 ou 404 |
| PUT | `/api/orders/{id}` | 200 ou 404 |
| PATCH | `/api/orders/{id}` | 200 ou 404 |
| DELETE | `/api/orders/{id}` | 204 ou 404 |

Exemplo de JSON para cadastro:

```json
{"cliente":"Maria","status":"pendente","codigo_pedido":"PED-001","total":150}
```

`total` é inteiro não negativo. O código do pedido deve ser único. Dados inválidos retornam 422 com os detalhes da validação.

## Testes

```bash
php artisan route:list --path=api
php artisan test
```

Os testes de integração usam SQLite em memória e verificam esquema, CRUD, validação, unicidade, métodos HTTP e respostas JSON. Consulte o resultado da execução ou do GitHub Actions antes de afirmar que todos os testes passaram.

## Entrega original e revisão

Os quatro arquivos diretamente relacionados ao CRUD, preservados sem alterações, estão em `entrega-original/`. A cópia integral recebida permanece disponível no arquivo original enviado nesta conversa; dependências, configurações locais e bancos pessoais não foram incluídos no repositório. A aplicação executável na raiz é a versão revisada.

Leia [a análise dos erros e correções](docs/revisao.md) para acompanhar o que mudou e estudar os conceitos. Esta revisão não substitui a nota nem a avaliação do professor.
