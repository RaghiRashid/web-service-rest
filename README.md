# Web Service REST

## Requisitos

-   PHP 7.4.33
-   Servidor Web (Apache, Nginx, etc.)
-   Composer

## Instalação

1. Clone o repositório:

    ```bash
    git clone https://github.com/seu-usuario/web-service-rest.git
    ```

2. Navegue até o diretório do projeto:

    ```bash
    cd web-service-rest
    ```

3. Instale as dependências do Composer:

    ```bash
    composer install
    ```

## Configuração

1. Copie o arquivo `.env.example` para `.env`:

    ```bash
    cp .env.example .env
    ```

2. Configure as variáveis de ambiente no arquivo `.env` conforme necessário.

## Uso

### Endpoints Disponíveis

#### Autenticação

-   `POST /api/register` - Registra um novo usuário.
-   `POST /api/login` - Autentica um usuário.

#### Usuários

-   `GET /api/users` - Retorna uma lista de usuários.
-   `GET /api/users/{id}` - Retorna um usuário específico.
-   `PUT /api/users/{id}` - Atualiza um usuário específico.
-   `DELETE /api/users/{id}` - Deleta um usuário específico.

#### Clientes

-   `GET /api/customers` - Retorna uma lista de clientes.
-   `POST /api/customers` - Cria um novo cliente.
-   `GET /api/customers/{id}` - Retorna um cliente específico.
-   `PUT /api/customers/{id}` - Atualiza um cliente específico.
-   `DELETE /api/customers/{id}` - Deleta um cliente específico.

### Exemplo de Requisição

#### POST /api/register

```bash
curl -X POST http://localhost/api/register -d '{"name": "John Doe", "email": "john@example.com", "password": "secret"}' -H "Content-Type: application/json"
```

#### POST /api/login

```bash
curl -X POST http://localhost/api/login -d '{"email": "john@example.com", "password": "secret"}' -H "Content-Type: application/json"
```

#### GET /api/users

```bash
curl -X GET http://localhost/api/users -H "Authorization: Bearer {token}"
```

#### POST /api/customers

```bash
curl -X POST http://localhost/api/customers -d '{"name": "Jane Doe", "email": "jane@example.com", "phone": "123456789", "identification": "ID12345", "street": "Main St", "number": "123", "district": "Downtown", "complement": "Apt 1", "zip_code": "12345"}' -H "Content-Type: application/json" -H "Authorization: Bearer {token}"
```

## Testes

Para rodar os testes, utilize o seguinte comando:

```bash
composer test
```
