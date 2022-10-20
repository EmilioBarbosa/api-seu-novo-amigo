<p align="center">
    <img src="logo_seu_novo_amigo_sem_fundo.png" style="width: 250px;"/>
</p>

<h3 align="center">
    Seu Novo Amigo
</h3>

## Sobre o projeto

Decidi fazer esse projeto para um trabalho final de uma disciplina da minha faculdade, com esse projeto procurei me desenvolver tecnicamente, e principalmente, ajudar os animais em situação de rua. 

Este repositório contém o código fonte de uma API REST para uma plataforma de adoções de animais.

## Features

- Cadastro de usuários(Ok).
- Cadastro de animais para adoção(Próxima implementação).
- Autenticação(Ok).

## Requisitos

 - <a href="https://www.php.net/downloads.php" _target="blank">PHP ^8.0.2</a> 
 - <a href="https://getcomposer.org/download/" _target="blank">Composer</a> 

## Configuração

- Clone este repositório
- Entre na pasta do projeto e instale as depêndencias com o comando: Composer install
- Copie o arquivo .env.example, cole na raiz do projeto e renomeie para .env
- Edite o arquivo .env com as suas variáveis de ambiente
- Crie as tabelas no banco de dados utilizando o comando: php artisan migrate
- Inicie o servidor utilizando o comando: php artisan serve
- Rode os seeders para popular o banco de dados com as informações necessárias, com o comando: php artisan db:seed


### Rotas da API

|Verbo http  | Rota | Parâmetros | Função
|--|--|--|--
|GET| /users/{user} | id do usuário | Retornar um usuário 
|POST| /users | name, email, email_confirmation, description, password, password_confirmation, phone_number, phone_number_whatsapp, street, neighborhood, city_id| Cadastrar um usuário
|PUT| /users/{user}| id do usuário , name, email, description, password, phone_number, phone_number_whatsapp, street, neighborhood, city_id, token(pelo header, ex: authorization: token) |Editar um usuário
|DELETE| /users/{user}|id do usuário, token(pelo header, ex: authorization: token) | Excluir o usuário


### Tipos dos parâmetros
- Id do usuário = int
- name = string, obrigatório
- email = string, obrigatório
- email_confirmation = string, obrigatório
- description = string, nullable
- password = string, minímo 8 caracteres, obrigatório
- password_confirmation = string, obrigatório
- phone_number = string, obrigatório, mínimo 10 caracteres, máximo 11 caracteres
- phone_number_whatsapp = boolean, obrigatório - campo para informar se o telefone é para whatsapp
- street = string, obrigatório
- neighborhood = string, obrigatório
- city_id = string, obrigatório - referência o campo id da tabela cities

