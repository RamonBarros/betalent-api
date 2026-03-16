# 💳 Payment Gateway Manager - BeTalent Test

Esta é uma API de gerenciamento de pagamentos multi-gateway desenvolvida como parte do desafio técnico para Desenvolvedor Backend na BeTalent. O projeto foca em escalabilidade, segurança (RBAC) e resiliência de transações.

## 🚀 Funcionalidades Principais

- **Autenticação JWT:** Proteção de rotas e identificação de usuários.
- **RBAC (Controle de Acesso):** Permissões distintas para `Admin`, `Finance` e `User`.
- **Multi-Gateway:** Integração com múltiplos provedores de pagamento.
- **Fallback Automático:** Caso o gateway prioritário falhe, o sistema tenta processar a transação pelo próximo gateway disponível.
- **Gestão de Usuários:** CRUD completo de usuários (exclusivo para Admin).
- **Estorno (Refund):** Fluxo de reembolso integrado aos gateways.

---

## 🛠️ Instalação e Configuração

Siga os passos abaixo para subir o ambiente de desenvolvimento usando Docker:

### 1. Clonar o repositório e configurar o `.env`
```bash
git clone https://github.com/RamonBarros/betalent-api.git
cd betalent-api
cp .env.example .env
```

### 2. Subir o Docker
```bash
docker-compose up -d
```

### 3. Instalar dependências e configurar a chave
```bash
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
```

### 4. Executar Migrations e Seeders
```bash
docker-compose exec app php artisan migrate --seed
```

É possivel criar novos usuarios, como descrito na collection do postman, mas alguns já são criados na execução das Migratrions e Seeders. Estes são os abaixo 

🔐 Credenciais de Teste
| Role | E-mail | Senha |
| :--- | :--- | :--- |
| **Admin** | admin@admin.com | password |
| **Finance** | finance@admin.com | password |
| **User** | user@admin.com | password |

### 4 📡 Documentação (Postman)
A collection para testes de todos os endpoints está disponível na pasta /docs deste repositório. Para utilizá-la, basta importar o arquivo JSON no seu Postman.



