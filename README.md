# Stock Manager 

## Como executar o projeto localmente 

## 1. Pré Requisitos 

- PHP 8.2+ 
- Node.js 20+
- Composer 
- PostgreSQL 

## Clonar o projeto 

```
git clone https://github.com/guicastro-23/stock-manager.git
```

## Configurar ambiente 

Duplicar o arquivo "env.example" e renomear para ".env".
Adicionar no ".env" as credencias do banco de dados. 

### Banco de Dados 

No arquivo .env defina as crendenciais

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=stock_manager
DB_USERNAME=postgres
DB_PASSWORD=sua_senha
```