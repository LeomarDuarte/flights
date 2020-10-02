# API Flights

Buscar voos e realizar o agrupamento dos mesmos de acordo com tipo de tarifa, preço e se o voo é de ida ou volta.

### Requirements:
- [Lumen Framework - 6.3.3](https://lumen.laravel.com/docs/6.x)
- [PHP - Versão 7.2.^](https://www.php.net/downloads.php)
- [phpdbg](https://imasters.com.br/back-end/gerando-code-coverage-com-phpunit-e-phpdbg)

### Endpoint API Flights.

- http://localhost:PORTA/api/v1/flights

- http://localhost:PORTA/api/v1/flights?outbound=1

- http://localhost:PORTA/api/v1/flights?inbound=1

### API Documentation

- [URL](https://documenter.getpostman.com/view/2613074/TVReeBHS)

### Setup Project.

- Fazer o clone do projeto
    
    `git clone https://github.com/LeomarDuarte/flights.git`

- Acessar o diretório flights
    
    `cd flights
    `
- Instalar as dependências do projeto

    `composer install`

- Criar e editar o arquivo .env

    `cp .env.example .env`

- Criar a chave de criptografia

    `php artisan key:generate`

### Up Application

- Localhost
    
    `php -S localhost:PORTA -t public`

### Tests

- Integração

    `vendor/bin/phpunit tests` ou `phpdbg -qrr ./vendor/bin/phpunit`

- Code coverage

    - Após a execução dos testes, será criado o diretório `tests/reports` dentro do path `tests`.
    - Copiar o path do arquivo `tests/reports/coverage/index.html` e coloar em seu navegador para ver a análise de cobertura.