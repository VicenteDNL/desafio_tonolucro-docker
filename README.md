
# Desafio Tonolucro

Projeto Desenvolvido para o processo seletivo Back-end PHP para o Tonolucro


## Descrição do Desafio

Utilizando as boas práticas de programação e utilizando a linguagem php, crie as seguintes soluções:


  

#### Solução 1

Utilizando o Laravel 8, crie uma api seguindo o padrão REST que permita a criação de Restaurantes e seus Cardápios. Cada restaurante deve ter no máximo 3 cardápios ativos. Cada cardápio deverá ter no máximo 10 Produtos.
Permita o controle de disponibilidade (restaurante, cardápio e produto) seguindo a hierarquia de dependência.
A aplicação deverá ter rotas privadas para o gerenciamento dos recursos. Apenas usuários autenticados poderão inserir, atualizar e deletar informações do banco.
A consulta e listagem dos recursos deverá ser pública.

#### Solução 2

Utilizando Laravel 8, crie uma aplicação MVC que permita a listagem e visualização de todos os restaurantes. Na listagem basta exibir o nome do restaurante, e na visualização exiba todos os cardápios e seus produtos.


#### Importamte

Utilize docker para provisionar a aplicação em modo de produção. As soluções e também o banco de dados (MYSQL ou Postgres) deverão ser provisionados no docker. Crie uma imagem para cada solução. A solução 2 deverá conversar com a solução 01 através da rede interna do docker.

As soluções deverão ser acessíveis para o host nas seguintes portas:

**Solução 1 → 8081** 

**Solução 2 → 8082**

## Instalação

 Clone o repositório:
```bash
  git clone https://github.com/VicenteDNL/desafio_tonolucro-docker.git
```
 Criar imagem docker e subir os containers:
```bash
  docker-compose up -d
```

 Instalar dependências da API e migrations:
```bash
  docker container exec -it desafio-tonolucro-api /bin/sh
```
```bash
  composer install
```
```bash
  cp .env.example .env
```
```bash
  php artisan key:generate
```
```bash
  php artisan migrate
```

 Instalar dependências da aplicaçãoo WEB:
 ```bash
  docker container exec -it desafio-tonolucro-web /bin/sh
```
```bash
  composer install
```
    
## Collections API

[Postman](https://github.com/VicenteDNL/desafio_tonolucro-docker/blob/main/colllection_postman)


## Referencia API

### Autenticação:

#### Cadastrar:
```http
  POST /api/register
```
##### Body:
```bash
{
    "name":"",
    "email":"",
    "password": ""
}
```
| Parametro   | Tipo     | Descrição  |
| :---------- | :------- | :----------|
|  `name`     | `string` | `required` |
|  `email    `| `string` | `required` |
|  `password` | `string` | `required` |

#### Login:
```http
  POST /api/login
```
##### Body:
```bash
{
    "email":"",
    "password": ""
}
```
| Parametro   | Tipo     | Descrição  |
| :---------- | :------- | :----------|
|  `email    `| `string` | `required` |
|  `password` | `string` | `required` |

#### Buscar dados usuário autenticado:
```http
  GET /api/me
```
### Restaurantes:

#### Listar restaurantes:

```http
  GET /api/restaurante
```

| Parametro | Tipo     | Descrição                      |
| :-------- | :------- | :----------------------------- |
|           |          | **Não é requerido**. Token JWT |

#### Buscar restaurante:

```http
  GET /api/restaurante/${id}
```

| Parametro | Tipo     | Descrição                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Não é requerido**. Token JWT        |


#### Criar restaurante:

```http
  POST /api/restaurante
```

| Parametro | Tipo     | Descrição                       |
| :-------- | :------- | :-------------------------------- |
|     |  | **Requerido**. Token JWT |

##### Body:
```bash
{
    "nome":"",
    "descricao":"",
    "telefone": "",
    "endereco": "",
    "cep": "",
    "cidade": "",
    "estado": ""
}
```
| Parametro   | Tipo     | Descrição            |
| :---------- | :------- | :--------------------|
|  `nome`     | `string` | `required` `max:255` |
|  `descricao`| `string` | `required`           |
|  `telefone` | `string` | `size:11`            |
|  `endereco` | `string` | `max:255`            |
|  `cep`      | `string` | `size:8`             |
|  `cidade`   | `string` | `max:255`            |
|  `estado`   | `string` | `size:2`             |

#### Alterar restaurante:

```http
  POST /api/restaurante/${id}
```

| Parametro | Tipo     | Descrição                       |
| :-------- | :------- | :-------------------------------- |
|   `id`   | `string` | **Requerido**. Token JWT |

##### Body:
```bash
{
    "nome":"",
    "descricao":"",
    "telefone": "",
    "endereco": "",
    "cep": "",
    "cidade": "",
    "estado": ""
}
```
| Parametro   | Tipo     | Descrição |
| :---------- | :------- | :---------|
|  `nome`     | `string` | `max:255` |
|  `descricao`| `string` |           |
|  `telefone` | `string` | `size:11` |
|  `endereco` | `string` | `max:255` |
|  `cep`      | `string` | `size:8`  |
|  `cidade`   | `string` | `max:255` |
|  `estado`   | `string` | `size:2`  |

#### Excluir restaurante:

```http
  DELETE /api/restaurante/${id}
```

| Parametro | Tipo     | Descrição                |
| :-------- | :------- | :----------------------  |
|   `id`   | `string`  | **Requerido**. Token JWT |

# 

### Cardápio:

#### Listar cardápios:

```http
  GET /api/cardapio
```

| Parametro | Tipo     | Descrição                      |
| :-------- | :------- | :----------------------------- |
|           |          | **Não é requerido**. Token JWT |

#### Buscar cardápio:

```http
  GET /api/cardapio/${id}
```

| Parametro | Tipo     | Descrição                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Não é requerido**. Token JWT         |


#### Criar cardápio:

```http
  POST /api/cardapio
```

| Parametro | Tipo     | Descrição                       |
| :-------- | :------- | :-------------------------------- |
|     |  | **Requerido**. Token JWT |

##### Body:
```bash
{
    "nome":"",
    "descricao":"",
    "restaurante_id": 
}
```
| Parametro         | Tipo     | Descrição            |
| :---------------- | :------- | :--------------------|
|  `nome`           | `string` | `required` `max:255` |
|  `descricao`      | `string` | `required`           |
|  `restaurante_id` | `int`    | `required`           |

#### Alterar cardápio:

```http
  POST /api/cardapio/${id}
```

| Parametro | Tipo     | Descrição                       |
| :-------- | :------- | :-------------------------------- |
|   `id`   | `string` | **Requerido**. Token JWT |

##### Body:
```bash
{
    "nome":"",
    "descricao":"",
    "restaurante_id": 
}
```
| Parametro         | Tipo     | Descrição  |
| :---------------- | :------- | :----------|
|  `nome`           | `string` | `max:255`  |
|  `descricao`      | `string` |            |
|  `restaurante_id` | `int`    |            |

#### Excluir cardápio:

```http
  DELETE /api/cardapio/${id}
```

| Parametro | Tipo     | Descrição                |
| :-------- | :------- | :----------------------  |
|   `id`   | `string`  | **Requerido**. Token JWT |

# 

### Produtos:

#### Listar produtos:

```http
  GET /api/produto
```

| Parametro | Tipo     | Descrição                      |
| :-------- | :------- | :----------------------------- |
|           |          | **Não é requerido**. Token JWT |

#### Buscar produto:

```http
  GET /api/produto/${id}
```

| Parametro | Tipo     | Descrição                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Não é requerido**. Token JWT         |


#### Criar produto:

```http
  POST /api/produto
```

| Parametro | Tipo     | Descrição                       |
| :-------- | :------- | :-------------------------------- |
|     |  | **Requerido**. Token JWT |

##### Body:
```bash
{
    "nome":"",
    "descricao":"",
    "preco":,
    "cardapio_id": 
}
```
| Parametro         | Tipo     | Descrição            |
| :---------------- | :------- | :--------------------|
|  `nome`           | `string` | `required` `max:255` |
|  `descricao`      | `string` | `required`           |
|  `preco`          | `float`  |                      |
|  `cardapio_id`    | `int`    | `required`           |

#### Alterar produto:

```http
  POST /api/produto/${id}
```

| Parametro | Tipo     | Descrição                       |
| :-------- | :------- | :-------------------------------- |
|   `id`   | `string` | **Requerido**. Token JWT |

##### Body:
```bash
{
    "nome":"",
    "descricao":"",
    "preco":,
    "cardapio_id": 
}
```
| Parametro         | Tipo     | Descrição  |
| :---------------- | :------- | :----------|
|  `nome`           | `string` |  `max:255` |
|  `descricao`      | `string` |            |
|  `preco`          | `float`  |            |
|  `cardapio_id`    | `int`    |            |

#### Excluir produto:

```http
  DELETE /api/produto/${id}
```

| Parametro | Tipo     | Descrição                |
| :-------- | :------- | :----------------------  |
|   `id`   | `string`  | **Requerido**. Token JWT |


  
