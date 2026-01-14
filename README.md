# Supply Task - Management System

Desafio técnico para gestão de fornecedores, produtos e pedidos. Desenvolvido com foco em escalabilidade, performance e processamento assíncrono.

## 🛠 Tecnologias e Arquitetura
- **Framework:** Laravel 12 + PHP 8.5
- **Frontend:** Vue.js 3 + Inertia.js + Tailwind CSS + DaisyUI
- **Database:** MySQL 8.4
- **Cache & Queue:** Redis
- **Infraestrutura:** Docker (Laravel Sail)
- **Ferramentas de Teste:** Mailpit (E-mail)

## 🚀 Como Rodar o Projeto

1. **Clone o repositório:**
   ```bash
   git clone <url-do-repositorio>
   cd supply-task
   ```

2. **Setup:**
   ```bash
   # Copie o template de variáveis de ambiente
   cp .env.example .env
   # NOTA: No arquivo .env, altere as conexões para os serviços do Sail:
   # DB_HOST=mysql
   # REDIS_HOST=redis
   # CACHE_STORE=redis
   # QUEUE_CONNECTION=redis
   ```

3. **Inicie o Sail e as migrations**
   ```bash
   ./vendor/bin/sail up -d
   ./vendor/bin/sail artisan key:generate
   ./vendor/bin/sail artisan migrate
   ./vendor/bin/sail npm install
   ./vendor/bin/sail npm run build
   ```