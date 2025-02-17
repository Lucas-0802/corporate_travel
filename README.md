# 🛠️ Corporate Travel 

Bem-vindo ao sistema de gerenciamento de pedidos de viagem. Este projeto demonstra uma aplicação FullStack com controle de permissões de usuário e gestão de pedidos de passagem.

## 🚀 Funcionalidades

- **Autenticação:** Tela de Login para o usuário fazer o cadastro e acessar o sistema.
- **Operações CRUD:** Cadastro, listagem e edição de pedidos de viagem.
- **Dashboard:** Possibilidade de acompanhar todos os pedidos feitos.
- **Setup Dockerizado:** Facilmente implantável com Docker e Docker Compose.
- **Banco de Dados MySQL:** Armazenamento das leituras de medidores em um banco de dados MySQL.

## 📂 Rodando o projeto

### 1. `Primeiro passo`

**Descrição:** Com o projeto clonado na sua máquina, configure as variáveis de ambiente para que o banco de dados funcione, depois entre na pasata backend

  ```json
  cd backend
```

### 2. `Segundo passo`

**Descrição:** Suba os containers docker para que a aplicação possa ser acessada.

```json
  docker compose up
```

### 3. `Terceiro passo`

- **Descrição:** Aguarde a aplicação subir por completo e acesse a porta que o frontend está rodando.

 ```json
  http://localhost:5173
```

##  Entendendo a arquitetura

  * Ao subir o projeto um script de seed é rodado, o mesmo cria o usuário Administrador da Aplicação, os demais usuários seguem o fluxo de cadastro convencional.

  ```json
  email: admin@admin.com
  password: admin123
```

## Considerações Finais

* O projeto não foi 100% cncluído conforme os requisitos, enfrentei alguma dificuldades durante o desenvolvimento, mas o maior desafio foi o tempo, tenho certeza que com mais tempo, podeira ter acaabdo todas as funcionalidades e deixado o projeto 100% funcional.
