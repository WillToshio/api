# 🧠 API de Análise de Usuários

Este projeto é uma **API RESTful desenvolvida em PHP (CodeIgniter 4)** que executa diversas análises sobre dados de usuários, incluindo ranking de países, atividades por dia, insights por equipe e muito mais.

> 🔥 Este desafio foi inspirado no vídeo do Fellyph Cintra no YouTube:  
> 👉 [Desenvolvendo um projeto de backend com CodeIgniter](https://www.youtube.com/watch?v=AFtRYXJVO-4)

---

## 🎯 Objetivo

A proposta do desafio é simular um cenário real de backend, com análise de dados a partir de um grande volume de usuários (JSON com até 100.000 registros), e construção de uma API capaz de:

- Processar dados em memória (simulando um banco)
- Analisar times e projetos
- Agrupar logins por dia
- Gerar ranking por países
- Avaliar o desempenho da própria API

---

## 🛠 Tecnologias Utilizadas

- ✅ **PHP 8+**
- ✅ **CodeIgniter 4**
- ✅ **JSON como fonte de dados**
- ✅ **cURL** para chamadas internas
- ✅ **MySQL / SQL Server / PostgreSQL** (estruturas disponíveis)
- ✅ **Postman / Insomnia** para testes

---

## 📂 Estrutura do Projeto

```
/app
├─ /Controllers 🛠 Endpoints da API
├─ /Models 💾 Simulação de armazenamento e lógica
├─ /Libraries 📚 DTOs e estruturas auxiliares
└─ /Database/Seeds 🌱 Seeder para usuários
/public
└─ /usuarios_100000.json 📄 Base de dados em JSON
```

---

## 📌 Endpoints Disponíveis

| Método | Endpoint                    | Descrição                                    |
|--------|-----------------------------|-----------------------------------------------|
| POST   | `/users`                   | Adiciona usuários na memoria/array            |
| GET    | `/superusuarios`           | Lista usuários com score alto e ativos        |
| GET    | `/ranking-paises`          | Top países por quantidade de usuários ativos  |
| GET    | `/analise-equipes`         | Estatísticas por equipe                       |
| GET    | `/usuarios-ativos-por-dia` | Agrupamento de logins por data                |
| GET    | `/evaluation`              | Testa a própria API e retorna relatório        |

---

## ⚙️ Como rodar

```bash
# Clone o projeto
git clone https://github.com/WillToshio/api.git
cd api

# Instale dependências do CodeIgniter (se necessário)
composer install

# Rode o servidor embutido
php spark serve
```
---
## 🧪 Testando a API
Você pode testar diretamente com:
- ✅ *Postman* ou *Insomnia*
- ✅ Ou acessar /evaluation para ver os endpoints em tempo real

---
## 🧱 Suporte a Banco de Dados
Embora a API funcione em memória com JSON, o projeto fornece scripts SQL para simular persistência em diferentes bancos:
- ✅ **tables_mysql.sql**
- ✅ **tables_sqlserver.sql**
- ✅ **tables_sqlserver.sql**

---

##👨‍💻 Autor
Desenvolvido por [WillToshio](https://www.linkedin.com/in/williantoshiocorr%C3%AAa/) como parte do desafio técnico proposto no vídeo:
📺 Fellyph Cintra – [YouTube Link](https://www.youtube.com/watch?v=AFtRYXJVO-4)

##👨‍💻 Autor
Este projeto está sob a licença [MIT](https://pt.wikipedia.org/wiki/Licen%C3%A7a_MIT).
