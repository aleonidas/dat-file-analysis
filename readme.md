## Análise de arquivos

### Estrutura
- PHP 7+
- [Lumen](https://lumen.laravel.com/)

### Requisito
Modo de leitura/escrita pastas:
- `data/in`
- `data/out`

### Execução

`php -S localhost:8000 -t public`

Link: `localhost:8000`


### Objetivos
Efetuar upload de arquivo restrito ao formato *.dat*.
Listar os arquivos enviados para efetuar o processamento.

O processamento verifica as entidades disponíveis no arquivo:
- `Salesman`
- `Customer`
- `Sales`
    - `Items`

Deve ser retornado as seguintes informações:
- Quantidade de Vendedores
- Quantidade de Clientes
- Média salarial dos vendedores
- ID Melhor Venda
- Pior Vendedor

Após o processamento, o arquivo deve ser movido para pasta *out*.
