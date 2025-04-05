# API do Projeto Top 5 Tião Carreiro e Pardinho
Bem-vindo ao repositório da API do projeto "Top 5 Tião Carreiro e Pardinho". Esta API fornece os endpoints necessários para gerenciar e exibir as músicas mais populares da dupla, permitindo que usuários sugiram novas músicas através de links do YouTube. Além disso, oferece funcionalidades como registro e login de usuários, autenticação e operações administrativas para gerenciamento das músicas sugeridas.

## Implementado com Laravel 11 e SQLite.


## Para facilitar o desenvolvimento e a execução, os repositórios devem ser organizados da seguinte forma:
project-root/
├── backend/   # Repositório da API (este repositório)
└── frontend/  # Repositório do frontend

## Funcionalidades Principais
Autenticação de Usuários: Permite que usuários se registrem, façam login e logout.

Sugestão de Músicas: Usuários autenticados podem sugerir novas músicas através de links do YouTube.

Gerenciamento de Sugestões: Administradores podem aprovar ou rejeitar sugestões de músicas.

CRUD de Músicas: Administradores podem adicionar, editar e excluir músicas da lista.

Paginação: Exibe a lista de músicas com paginação, destacando as 5 primeiras e listando as demais com paginação.

Pré-requisitos
Antes de iniciar, certifique-se de ter instalado em sua máquina:

PHP (versão 8.0 ou superior)

Composer

Docker (opcional, caso opte por executar via Docker)

## Configuração e Execução da API
Você pode executar a API de duas maneiras: diretamente com PHP e Composer ou utilizando Docker.

### 1. Execução com PHP e Composer
Instale as dependências:

composer install

## Execute as migrações e seeders:

php artisan migrate --seed

## Inicie o servidor de desenvolvimento:

php artisan serve

A API estará disponível em http://localhost:8000.

### 2. Execução com Docker
Configure as variáveis de ambiente:

Renomeie o arquivo .env.example para .env e configure as variáveis conforme necessário para o ambiente Docker.

No diretório frontend , execute:

docker-compose up --build

Isso construirá a imagem e iniciará o contêiner para a API.

Acesse a API:

A API estará disponível em http://localhost:3000.

## Comunicação entre Frontend e Backend
Para garantir que o frontend se comunique corretamente com a API:

Execução com PHP e Composer: O frontend deve ser configurado para acessar a API em http://localhost:8000. Certifique-se de que a API esteja em execução antes de iniciar o frontend.

Execução com Docker: O Docker Compose configura uma rede interna (app-network) onde os serviços frontend e backend podem se comunicar diretamente. O frontend acessa a API através do nome do serviço backend definido no docker-compose.yml.

## Funcionalidades Detalhadas
Autenticação de Usuários
Utilizamos o Laravel Sanctum para gerenciar a autenticação de usuários na API. Isso permite a criação de tokens de acesso seguros para autenticar solicitações de usuários. Para mais informações sobre como implementar autenticação com Laravel Sanctum, consulte a documentação oficial.

Paginação
A API fornece endpoints que retornam listas paginadas de músicas, destacando as 5 primeiras e listando as demais com paginação. A paginação é implementada utilizando os recursos nativos do Laravel. Para mais detalhes, consulte a documentação de paginação do Laravel.

Gerenciamento de Músicas
Administradores têm acesso a endpoints que permitem operações de CRUD (Criar, Ler, Atualizar, Deletar) para gerenciar as músicas sugeridas. Isso inclui a aprovação ou rejeição de sugestões feitas por usuários. Para implementar operações CRUD no Laravel 11, você pode seguir este tutorial de CRUD com Laravel 11.



