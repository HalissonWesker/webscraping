# Web Scraping Challenge

![Laravel](https://img.shields.io/badge/Laravel-8.0-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.0-purple?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-5.7-blue?style=for-the-badge&logo=mysql)
![Redis](https://img.shields.io/badge/Redis-6.0-red?style=for-the-badge&logo=redis)
![Docker](https://img.shields.io/badge/Docker-20.10-blue?style=for-the-badge&logo=docker)

Este projeto foi desenvolvido como parte de um desafio técnico para capturar dados sobre moedas utilizando scraping de uma fonte externa (Wikipedia) e fornecer esses dados através de uma API.

## Estrutura do Projeto

O projeto foi estruturado utilizando o framework Laravel, seguindo as melhores práticas de design de software, como a separação de responsabilidades através de camadas e o uso do padrão Repository para interagir com o banco de dados.

### Principais Diretórios e Arquivos

- **app/Http/Controllers**
  - `CurrencyController.php`: Controlador responsável por receber requisições e delegar chamadas para o serviço.
- **app/Models**
  - `Currency.php`: Modelo que representa os dados das moedas.
- **app/Providers**
  - `AppServiceProvider.php`: Provider responsável por registrar bindings no container de serviços do Laravel.
- **app/Repositories**
  - `CurrencyRepositoryInterface.php`: Interface do repository para interação com o banco de dados.
  - `Eloquent/CurrencyRepository.php`: Implementação do repository utilizando Eloquent.
- **app/Services**
  - `CurrencyService.php`: Serviço que contém a lógica de scraping e interação com o repository.
- **database/migrations**
  - `create_currencies_table.php`: Migração para criar a tabela de moedas no banco de dados.

## Configuração

### Pré-requisitos

- Docker
- Docker Compose
- PHP 8.0+
- Composer
- MySQL (pode usar XAMPP)

### Passos para Configuração com Docker

1. Clone o repositório:

   ```bash
   git clone <repository-url>
   cd webScraping-challenge
Copie o arquivo .env.example para .env e configure as variáveis de ambiente:

bash
Copiar código
cp .env.example .env
Configure as seguintes variáveis de ambiente no arquivo .env:

env
Copiar código
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=webscrap
DB_USERNAME=root
DB_PASSWORD=root

REDIS_CLIENT=phpredis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

CACHE_DRIVER=redis
Suba os containers Docker:

bash
Copiar código
docker-compose up -d --build
Execute as migrações:

bash
Copiar código
docker-compose exec app php artisan migrate
Passos para Configuração sem Docker
Instale o PHP, Composer e MySQL (pode usar XAMPP para facilitar a configuração do MySQL).

Clone o repositório:

bash
Copiar código
git clone <repository-url>
cd webScraping-challenge
Copie o arquivo .env.example para .env e configure as variáveis de ambiente:

bash
Copiar código
cp .env.example .env
Configure as variáveis de ambiente no arquivo .env para apontar para o seu servidor MySQL local:

env
Copiar código
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=webscrap
DB_USERNAME=root
DB_PASSWORD=root
Instale as dependências do PHP:

bash
Copiar código
composer install
Execute as migrações:

bash
Copiar código
php artisan migrate
Inicie o servidor local do Laravel:

bash
Copiar código
php artisan serve
Uso
Endpoints da API
Buscar Dados de Moedas
URL: /api/currency

Método: POST

Body:

json
Copiar código
{
  "code": "GBP"
}
ou

json
Copiar código
{
  "number": 826
}
Exemplo de Requisição com cURL:

bash
Copiar código
curl -X POST http://localhost:8000/api/currency -H "Content-Type: application/json" -d '{"code":"GBP"}'
ou

bash
Copiar código
curl -X POST http://localhost:8000/api/currency -H "Content-Type: application/json" -d '{"number":826}'
Resposta Esperada
json
Copiar código
[
  {
    "code": "GBP",
    "number": 826,
    "decimal": 2,
    "currency": "Libra Esterlina",
    "currency_locations": [
      {
        "location": "Reino Unido",
        "icon": "https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/Flag_of_the_United_Kingdom.svg/22px-Flag_of_the_United_Kingdom.svg.png"
      },
      {
        "location": "Ilha de Man",
        "icon": ""
      },
      {
        "location": "Guernesey",
        "icon": ""
      },
      {
        "location": "Jersey",
        "icon": ""
      }
    ]
  }
]
Testes
Para executar os testes, utilize o seguinte comando:

bash
Copiar código
docker-compose exec app php artisan test
ou, se estiver rodando localmente sem Docker:

bash
Copiar código
php artisan test
Contribuição
Se você deseja contribuir para este projeto, por favor, siga as diretrizes de contribuição e abra um pull request.

Licença
Este projeto está licenciado sob a MIT License. Veja o arquivo LICENSE para mais detalhes.
