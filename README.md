<div align="center">

# 🍕 Pizzaria do João — Sistema de Pedidos

### PHP • MySQL • PDO • CRUD • Bootstrap

Aplicação web desenvolvida em PHP para simular o fluxo de pedidos de uma pizzaria, desde a montagem da pizza até o gerenciamento dos pedidos.

<br>

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap_4-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

</div>

---

## 🎯 Sobre o projeto

O **Pizzaria do João** é um sistema web desenvolvido para praticar conceitos de desenvolvimento backend com PHP e integração com banco de dados MySQL.

A aplicação permite montar pizzas personalizadas, registrar pedidos e posteriormente gerenciá-los através de um painel administrativo.

O projeto trabalha conceitos como:

**Formulários → Validação → Persistência → Relacionamentos → Consulta → Atualização → Exclusão**

---

## ✨ Funcionalidades

### 🍕 Montagem da pizza

O usuário pode:

- Selecionar a borda
- Selecionar o tipo de massa
- Escolher de 1 a 3 sabores
- Enviar o pedido
- Receber mensagens de sucesso ou erro

O backend também valida os dados recebidos antes da gravação.

---

### 📋 Gerenciamento de pedidos

O painel administrativo permite:

- Visualizar pedidos cadastrados
- Consultar borda, massa e sabores
- Visualizar o status atual
- Alterar o status do pedido
- Excluir pedidos
- Confirmar a exclusão antes da operação

---

## 🔄 Fluxo do sistema

```text
Cliente monta a pizza
        ↓
Formulário envia os dados
        ↓
PHP valida as informações
        ↓
Pizza é cadastrada
        ↓
Sabores são relacionados à pizza
        ↓
Pedido é criado
        ↓
Dashboard consulta os pedidos
        ↓
Status pode ser atualizado
        ↓
Pedido pode ser removido
```

---

## 🗃️ Persistência de dados

A aplicação utiliza **MySQL** como banco de dados e **PDO (PHP Data Objects)** para comunicação com a base.

A conexão foi configurada com:

- `utf8mb4`
- `PDO::ERRMODE_EXCEPTION`
- `PDO::FETCH_ASSOC`
- Prepared statements nativos
- Tratamento de exceções

---

## 🔐 Validação e segurança

Algumas práticas aplicadas no projeto incluem:

### Prepared Statements

Operações que recebem dados externos utilizam consultas preparadas:

```php
$stmt = $conn->prepare("
    UPDATE pedidos
    SET status_id = :status
    WHERE pizza_id = :id
");
```

Isso evita a concatenação direta de dados recebidos pelo usuário nas instruções SQL.

### Validação de entrada

IDs recebidos pelos formulários são validados utilizando recursos como:

```php
filter_input(
    INPUT_POST,
    "id",
    FILTER_VALIDATE_INT
);
```

### Escape de saída

Informações apresentadas no HTML utilizam:

```php
htmlspecialchars()
```

reduzindo riscos relacionados à renderização de conteúdo inesperado.

---

## 🔄 Transações

O cadastro e a exclusão de pedidos envolvem múltiplas operações relacionadas no banco.

Para preservar a consistência dos dados, são utilizadas transações:

```text
beginTransaction()
        ↓
Operações no banco
        ↓
commit()
```

Caso alguma etapa falhe:

```text
Erro
 ↓
rollBack()
 ↓
Operações são desfeitas
```

Isso evita que um pedido seja gravado parcialmente.

---

## 🧩 Relacionamentos

Uma pizza pode possuir múltiplos sabores.

O projeto utiliza uma tabela associativa para representar esse relacionamento:

```text
Pizza
  │
  ├── Borda
  │
  ├── Massa
  │
  └── Sabores
        │
        ├── Sabor 1
        ├── Sabor 2
        └── Sabor 3
```

Os sabores são associados através da relação entre `pizzas`, `pizza_sabor` e `sabores`.

---

## 🛠️ Tecnologias utilizadas

| Tecnologia | Utilização |
| --- | --- |
| **PHP** | Backend e regras de negócio |
| **MySQL** | Persistência dos dados |
| **PDO** | Comunicação segura com o banco |
| **HTML5** | Estrutura das páginas |
| **CSS3** | Interface e responsividade |
| **Bootstrap 4** | Componentes e layout |
| **Font Awesome** | Ícones da interface |
| **JavaScript** | Interações básicas da interface |

---

## 📂 Estrutura do projeto

```text
pizzaria-php/
│
├── Header.php
├── conn.php
├── dashboard.php
├── footer.php
├── index.php
├── orders.php
├── pizza.php
├── styles.css
└── README.md
```

### Responsabilidade dos arquivos

| Arquivo | Responsabilidade |
| --- | --- |
| `index.php` | Interface para montagem e envio da pizza |
| `pizza.php` | Consulta das opções e processamento de novos pedidos |
| `dashboard.php` | Interface de gerenciamento dos pedidos |
| `orders.php` | Consulta, atualização e exclusão dos pedidos |
| `conn.php` | Configuração da conexão PDO com MySQL |
| `Header.php` | Cabeçalho, navegação e mensagens da sessão |
| `footer.php` | Rodapé e scripts da interface |
| `styles.css` | Estilização e responsividade |

---

## 🧱 Operações implementadas

O sistema implementa operações equivalentes a um fluxo CRUD de pedidos:

| Operação | Implementação |
| --- | --- |
| **Create** | Cadastro de pizza e criação do pedido |
| **Read** | Consulta e listagem dos pedidos |
| **Update** | Alteração do status |
| **Delete** | Exclusão do pedido e dados relacionados |

---

## 📱 Interface responsiva

A interface utiliza **Bootstrap 4** em conjunto com CSS próprio.

Foram aplicados recursos para adaptação a diferentes tamanhos de tela, incluindo:

- Menu responsivo
- Formulário adaptável
- Tabela com rolagem horizontal
- Botões e campos ajustados para dispositivos menores
- Layout flexível

---

## 🧠 Conceitos praticados

Durante o desenvolvimento e evolução deste projeto foram trabalhados:

`PHP`

`Programação Backend`

`MySQL`

`Banco de Dados Relacional`

`PDO`

`Prepared Statements`

`CRUD`

`SQL JOIN`

`Transações`

`Tratamento de Exceções`

`Validação de Dados`

`Sessões PHP`

`Relacionamentos entre Tabelas`

`HTML5`

`CSS3`

`Bootstrap`

`Design Responsivo`

---

## ▶️ Executando o projeto

### Pré-requisitos

Para executar a aplicação localmente são necessários:

- PHP
- MySQL
- Servidor local compatível com PHP/MySQL

Exemplos incluem XAMPP, WAMP ou configuração equivalente.

### Clone o repositório

```bash
git clone https://github.com/laurajala/pizzaria-php.git
```

### Acesse o projeto

```bash
cd pizzaria-php
```

A aplicação também depende da criação do banco de dados e das tabelas utilizadas pelo sistema.

> ⚠️ Atualmente o repositório não possui um arquivo SQL de inicialização do banco. Portanto, a estrutura do banco precisa ser configurada separadamente para execução completa da aplicação.

---

## 🚀 Melhorias futuras

Algumas evoluções possíveis para o projeto são:

- Adicionar script SQL para criação do banco
- Utilizar variáveis de ambiente para configuração da conexão
- Criar autenticação para o painel administrativo
- Implementar proteção CSRF nos formulários
- Separar responsabilidades em uma arquitetura mais estruturada
- Criar testes automatizados
- Implementar API REST
- Adicionar valores e cálculo total do pedido
- Registrar data e horário dos pedidos
- Criar dashboard com indicadores

---

## 👩‍💻 Autora

<div align="center">

### Laura Ajala

Projeto desenvolvido para estudo e evolução em desenvolvimento de software.

<br>

<a href="https://www.linkedin.com/in/laura-ajala/">
<img src="https://img.shields.io/badge/LinkedIn-Laura_Ajala-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white">
</a>

<a href="https://github.com/laurajala">
<img src="https://img.shields.io/badge/GitHub-laurajala-181717?style=for-the-badge&logo=github&logoColor=white">
</a>

</div>
