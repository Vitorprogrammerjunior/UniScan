# 🔍 UniScan - Sistema de Gestão de Patrimônios

Sistema de gestão de patrimônios com QR Code desenvolvido para a **UNIVC**.

## 📋 Funcionalidades

- ✅ Cadastro de patrimônios com QR Code
- ✅ Geração automática de QR Codes em lote
- ✅ Leitura de QR Code para consulta pública
- ✅ Cadastro de patrimônio via escaneamento (admin)
- ✅ Edição rápida via QR Code (admin)
- ✅ Controle de tipos de patrimônio
- ✅ Controle de locais de armazenamento
- ✅ Histórico de alterações (logs)
- ✅ Relatórios em PDF
- ✅ Dashboard com estatísticas

## 🚀 Requisitos

- PHP 8.1 ou superior
- MySQL 5.7+ ou MariaDB 10.3+
- Composer
- Extensões PHP: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, GD

## 📦 Instalação Local (Desenvolvimento)

```bash
# Clonar o repositório
git clone [url-do-repositorio]
cd uniscan

# Instalar dependências
composer install

# Copiar arquivo de configuração
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate

# Configurar banco de dados no .env
# Para desenvolvimento local, pode usar SQLite:
# DB_CONNECTION=sqlite

# Criar banco SQLite (se estiver usando)
touch database/database.sqlite

# Executar migrations
php artisan migrate

# Criar usuário admin
php artisan db:seed

# Iniciar servidor
php artisan serve
```

## 🌐 Deploy na Hostgator (Produção)

### Passo 1: Preparar arquivos

```bash
# Instalar dependências de produção
composer install --optimize-autoloader --no-dev

# Limpar caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Passo 2: Upload via cPanel

1. Acesse o **cPanel** da Hostgator
2. Vá em **Gerenciador de Arquivos**
3. Navegue até `public_html`
4. Faça upload de **TODOS** os arquivos do projeto

### Passo 3: Criar Banco de Dados MySQL

1. No cPanel, vá em **Bancos de Dados MySQL**
2. Crie um novo banco de dados
3. Crie um usuário para o banco
4. Adicione o usuário ao banco com **TODOS OS PRIVILÉGIOS**

### Passo 4: Configurar .env

1. Renomeie `.env.example` para `.env`
2. Configure as variáveis:

```env
APP_NAME=UniScan
APP_ENV=production
APP_KEY=  # Será gerado no próximo passo
APP_DEBUG=false
APP_URL=https://seu-dominio.com.br

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=cpanel_nomebanco
DB_USERNAME=cpanel_usuario
DB_PASSWORD=sua_senha_segura

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

### Passo 5: Gerar APP_KEY

Acesse via SSH ou Terminal do cPanel:

```bash
cd public_html
php artisan key:generate
```

Ou gere manualmente em: https://generate-random.org/laravel-key-generator

### Passo 6: Executar Migrations

```bash
php artisan migrate --force
php artisan db:seed --force
```

### Passo 7: Permissões de Pastas

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Passo 8: Configurar PHP (se necessário)

No cPanel > **Selecionar Versão do PHP**:
- Selecione PHP 8.1 ou 8.2
- Ative as extensões: `pdo_mysql`, `mbstring`, `xml`, `gd`, `fileinfo`

## 👤 Acesso Padrão

Após o seed, use:
- **Email:** admin@univc.edu.br
- **Senha:** admin123

⚠️ **IMPORTANTE:** Altere a senha após o primeiro login!

## 🔒 Segurança em Produção

1. **Sempre** mantenha `APP_DEBUG=false`
2. Use HTTPS (SSL)
3. Altere a senha padrão do admin
4. Configure backups automáticos do banco de dados
5. Mantenha o Laravel e dependências atualizados

## 📁 Estrutura de Pastas

```
uniscan/
├── app/                    # Código da aplicação
│   ├── Http/Controllers/   # Controllers
│   └── Models/             # Models
├── database/
│   ├── migrations/         # Migrations
│   └── seeders/            # Seeders
├── public/                 # Arquivos públicos
│   └── images/             # Logos
├── resources/views/        # Views Blade
├── routes/web.php          # Rotas
└── .env                    # Configurações (não committar!)
```

## 🛠️ Comandos Úteis

```bash
# Limpar todos os caches
php artisan optimize:clear

# Otimizar para produção
php artisan optimize

# Ver rotas
php artisan route:list

# Criar novo admin via Tinker
php artisan tinker
>>> User::create(['name'=>'Admin','email'=>'novo@email.com','password'=>bcrypt('senha123')])
```

## 📞 Suporte

Em caso de dúvidas, entre em contato com a equipe de TI da UNIVC.

---

Desenvolvido com ❤️ para UNIVC
