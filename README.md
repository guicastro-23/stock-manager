# Stock Manager 

## Como executar o projeto localmente 

### 1. Pré Requisitos 

- PHP 8.2+ 
- Node.js 20+
- Composer 
- PostgreSQL 

### Clonar o projeto 

```
git clone https://github.com/guicastro-23/stock-manager.git
```

### Configurar ambiente 

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

### Instalar as dependências do PHP. 
```
composer install
```

### Instalar as dependências do Node.js. 
```
npm install 
```

### Gerar a chave do arquivo .env. 
```
php artisan key:generate
```

### Executar as migration para criar a base de dados e as tabelas.
```
php artisan migrate
```

### Executar as seeders.
```
php artisan db:seed
```

### Iniciar o projeto com Laravel. 
```
php artisan serve
```

### Executar o Node.js. 
```
npm run dev
```

### Acessar no navegador a URL. 
```
http://127.0.0.1:8000
```


