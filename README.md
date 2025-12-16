# 🔍 UniScan - Sistema de Gestão de Patrimônios

<p align="center">
  <img src="public/images/logo-horizontal.png" alt="UniScan Logo" width="300">
</p>

<p align="center">
  <strong>Sistema completo de gestão de patrimônios com QR Code</strong><br>
  Desenvolvido para a <strong>UNIVC - Centro Universitário Cidade Verde</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat-square&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?style=flat-square&logo=tailwind-css" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/Versão-1.2.0-green?style=flat-square" alt="Versão">
</p>

---

## 📋 Índice

- [Sobre o Projeto](#-sobre-o-projeto)
- [Funcionalidades](#-funcionalidades)
- [Tecnologias](#-tecnologias)
- [Requisitos](#-requisitos)
- [Instalação](#-instalação)
- [Deploy em Produção](#-deploy-em-produção)
- [Uso](#-uso)
- [Estrutura do Projeto](#-estrutura-do-projeto)
- [Changelog](#-changelog)
- [Comandos Úteis](#-comandos-úteis)

---

## 📖 Sobre o Projeto

O **UniScan** é um sistema web desenvolvido para facilitar a gestão de patrimônios da UNIVC através de QR Codes. O sistema permite:

- Identificar rapidamente qualquer patrimônio escaneando seu QR Code
- Manter um controle centralizado de todos os bens da instituição
- Rastrear empréstimos entre setores
- Gerar relatórios detalhados em PDF
- Visualizar histórico completo de alterações

### Por que UniScan?

| Problema Anterior | Solução UniScan |
|-------------------|-----------------|
| Planilhas desatualizadas | Banco de dados centralizado em tempo real |
| Difícil localizar patrimônios | QR Code em cada item para consulta instantânea |
| Sem controle de empréstimos | Sistema de empréstimos com rastreamento completo |
| Relatórios manuais | Geração automática de PDFs |
| Sem histórico de mudanças | Log completo de todas as alterações |

---

## ✨ Funcionalidades

### 📦 Gestão de Patrimônios
- ✅ Cadastro completo com código de barras, nome, tipo e local
- ✅ Situações: Disponível, Manutenção, Emprestado, Descartado, Separado p/ Descarte
- ✅ Busca e filtros avançados
- ✅ Edição rápida via QR Code (admin)

### 📱 QR Codes
- ✅ Geração automática de QR Codes em lote
- ✅ Impressão em folha A4 otimizada (etiquetas 3x10)
- ✅ Consulta pública via escaneamento
- ✅ Cadastro rápido de patrimônios pendentes

### 🔄 Sistema de Empréstimos
- ✅ Registro de empréstimos entre locais
- ✅ Visualização vai-volta (Local Origem ↔ Local Destino)
- ✅ Histórico de empréstimos por patrimônio
- ✅ Devolução automática ao mudar status
- ✅ Painel dedicado para empréstimos ativos

### 📊 Relatórios em PDF
- ✅ Relatório geral de patrimônios
- ✅ Filtros por tipo, local e situação
- ✅ Tabela de empréstimos do período
- ✅ Estatísticas resumidas

### 👥 Multi-Usuários
- ✅ Sistema de autenticação
- ✅ Gerenciamento de usuários (admin master)
- ✅ Log de ações por usuário

### 📈 Dashboard
- ✅ Estatísticas em tempo real
- ✅ Cards com totais por situação
- ✅ Últimas movimentações

### 🔔 Sistema de Changelog
- ✅ Pop-up automático de novidades
- ✅ Exibido uma vez por versão
- ✅ Histórico de atualizações

---

## 🛠 Tecnologias

### Backend
- **[Laravel 12](https://laravel.com/)** - Framework PHP
- **[PHP 8.2+](https://php.net/)** - Linguagem server-side
- **[MySQL](https://mysql.com/)** - Banco de dados relacional

### Frontend
- **[Blade](https://laravel.com/docs/blade)** - Template engine do Laravel
- **[TailwindCSS](https://tailwindcss.com/)** - Framework CSS utilitário
- **[Alpine.js](https://alpinejs.dev/)** - JavaScript reativo
- **[Font Awesome](https://fontawesome.com/)** - Ícones

### Bibliotecas Principais
- **[chillerlan/php-qrcode](https://github.com/chillerlan/php-qrcode)** - Geração de QR Codes
- **[barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)** - Geração de PDFs

---

## 📋 Requisitos

### Servidor
- PHP 8.2 ou superior
- MySQL 5.7+ ou MariaDB 10.3+
- Composer 2.x
- Extensões PHP:
  - BCMath, Ctype, Fileinfo, JSON
  - Mbstring, OpenSSL, PDO (pdo_mysql)
  - Tokenizer, XML, GD

---

## 🚀 Instalação

### Desenvolvimento Local

```bash
# 1. Clone o repositório
git clone https://github.com/seu-usuario/uniscan.git
cd uniscan

# 2. Instale as dependências PHP
composer install

# 3. Copie o arquivo de ambiente
cp .env.example .env

# 4. Gere a chave da aplicação
php artisan key:generate

# 5. Configure o banco de dados no .env
# Para desenvolvimento rápido, use SQLite:
# DB_CONNECTION=sqlite
# 
# Ou MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=uniscan
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Crie o banco (SQLite)
touch database/database.sqlite

# 7. Execute as migrations e seed
php artisan migrate
php artisan db:seed

# 8. Inicie o servidor
php artisan serve
```

Acesse: **http://localhost:8000**

### 🔐 Credenciais Padrão
| Campo | Valor |
|-------|-------|
| Email | `admin@univc.edu.br` |
| Senha | `admin123` |

⚠️ **IMPORTANTE:** Altere a senha após o primeiro login!

---

## 🌐 Deploy em Produção

### Hostgator / cPanel

#### 1. Preparar arquivos
```bash
composer install --optimize-autoloader --no-dev
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

#### 2. Upload via cPanel
1. Acesse o **cPanel** da Hostgator
2. Vá em **Gerenciador de Arquivos**
3. Navegue até `public_html`
4. Faça upload de todos os arquivos

#### 3. Criar Banco MySQL
1. cPanel > **Bancos de Dados MySQL**
2. Crie banco, usuário e vincule com **TODOS OS PRIVILÉGIOS**

#### 4. Configurar .env
```env
APP_NAME=UniScan
APP_ENV=production
APP_KEY=base64:SUA_CHAVE_AQUI
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

#### 5. Executar Migrations
```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
```

#### 6. Permissões
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

---

## 📱 Uso

### Consulta Pública (QR Code)
1. Escaneie o QR Code do patrimônio com a câmera do celular
2. Você será redirecionado para a página de informações
3. Veja nome, tipo, local e situação do patrimônio

### Painel Administrativo
1. Acesse `/login` e faça login
2. Use o menu lateral para navegar:
   - **Dashboard** - Visão geral
   - **Patrimônios** - Cadastro e edição
   - **QR Codes** - Geração e impressão
   - **Emprestados** - Controle de empréstimos
   - **Relatórios** - Geração de PDFs
   - **Tipos** - Categorias de patrimônios
   - **Locais** - Setores/salas

### Gerenciar Usuários (Admin Master)
Acesse: `/admin/master/usuarios` (rota oculta no menu)

---

## 📁 Estrutura do Projeto

```
uniscan/
├── app/
│   ├── Console/Commands/         # Comandos Artisan
│   ├── Http/Controllers/         # Controllers
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── EmprestimoController.php
│   │   ├── PatrimonioController.php
│   │   ├── QrCodeController.php
│   │   └── RelatorioController.php
│   └── Models/                   # Models Eloquent
│       ├── Emprestimo.php
│       ├── LocalArmazenamento.php
│       ├── LogPatrimonio.php
│       ├── Patrimonio.php
│       ├── TipoPatrimonio.php
│       └── User.php
├── config/
│   └── versao.php               # Versão e changelog
├── database/
│   ├── migrations/              # Estrutura do banco
│   └── seeders/                 # Dados iniciais
├── public/
│   ├── images/                  # Logos
│   └── index.php
├── resources/views/
│   ├── admin/                   # Views do painel
│   ├── auth/                    # Views de login
│   ├── components/              # Componentes Blade
│   ├── layouts/                 # Layouts base
│   └── public/                  # Views públicas
├── routes/web.php               # Rotas
└── .env                         # Configurações (NÃO COMMITTAR!)
```

---

## 📝 Changelog

### v1.2.0 (16/12/2024) - Sistema de Empréstimos
- ✨ Nova funcionalidade de empréstimos entre locais
- ✨ Visualização vai-volta (origem ↔ destino)
- ✨ Página dedicada para empréstimos ativos
- ✨ Relatórios incluem tabela de empréstimos
- ✨ Devolução automática ao mudar status

### v1.1.0 (16/12/2024) - Multi-Usuários
- ✨ Sistema de multi-usuários
- ✨ Gerenciamento de usuários (admin master)
- ✨ Sistema de changelog com pop-up

### v1.0.0 (15/12/2024) - Lançamento Inicial
- ✨ Cadastro de patrimônios
- ✨ Geração de QR Codes
- ✨ Consulta pública
- ✨ Relatórios em PDF
- ✨ Dashboard com estatísticas

---

## 🧹 Comandos Úteis

```bash
# Limpar todos os caches
php artisan optimize:clear

# Otimizar para produção
php artisan optimize

# Ver rotas disponíveis
php artisan route:list

# Criar novo usuário via Tinker
php artisan tinker
>>> User::create(['name'=>'Admin','email'=>'email@univc.edu.br','password'=>bcrypt('senha123')])

# Limpar empréstimos antigos (devolvidos há mais de 6 meses)
php artisan emprestimos:limpar
```

---

## 🛡️ Segurança

- **Sempre** mantenha `APP_DEBUG=false` em produção
- Use HTTPS (certificado SSL)
- Altere a senha padrão imediatamente
- Configure backups automáticos do banco
- Mantenha as dependências atualizadas

---

## 📞 Suporte

Em caso de dúvidas, entre em contato com a equipe de TI da UNIVC.

---

<p align="center">
  Desenvolvido com ❤️ para <strong>UNIVC</strong>
</p>
