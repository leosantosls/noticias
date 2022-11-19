# Teste Pratico Dev. Back-End
A aplicação foi construída utilizando [Laravel v9.40.1](https://laravel.com/) e como auxilio de SGBD foi utilizado o Mysql

## Requisitos
+ PHP (v8.1 ou superior)
+ SGBD Mysql Server (v8 ou superior)
+ [Docker Desktop](https://www.docker.com/products/docker-desktop/)

## Configurações iniciais
+ Após a criação do projeto, no Terminal você pode navegar até o diretório do aplicativo e gerar as Keys necessárias com os comandos abaixo:

```
php artisan key:generate  

php artisan jwt:secret 
```
Esses comandos gera as Keys de segurança do seu aplicativo

+ Em seu editor de código preferido, abra o arquivo `.env` que se encontra no diretório do seu aplicativo. Configure os dados de acesso ao seu SGBD
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=noticias
DB_USERNAME=root
DB_PASSWORD=
```

+ No SGBD informado acima. Crie o DATABASE com o nome `noticias`.

+ No Terminal você pode navegar até o diretório do aplicativo e rodar os comandos abaixo, para a criação das Tabelas e semeação dos dados
```
php artisan migrate:install 

php artisan migrate

php artisan db:seed --class=NoticiaSeeder
```

+ Para finalizar as configurações iniciais, No Terminal você pode navegar até o diretório do aplicativo e iniciar o Laravel Sail.
```
./vendor/bin/sail up
```
Essa ação iniciará a construção dos contêineres do Docker do aplicativo. Ao finalizar você poderá acessar o aplicativo em seu navegador da Web em: `http://localhost`.


# Registro de Usúario [/api/auth/register]

## Registro de Novos Usúarios [POST]

+ Request (application/json)
    +   Body

            {
                "name":"Leonardo Santos",
                "email":"devLeonardo@gmail.com",
                "password":"123456",
                "password_confirmation":"123456"
            }

+ Response 201 (application/json)

    + Body

            {
                "message": "Usúario registado com sucesso",
                "user": {
                    "name": "Leonardo Santos",
                    "email": "devLeonardo@gmail.com",
                    "updated_at": "2022-11-19T13:54:36.000000Z",
                    "created_at": "2022-11-19T13:54:36.000000Z",
                    "id": 1
                }
            }

    + Schema

            {
                "type": "object",
                "properties": {
                    "message": {
                        "type": "string"
                    },
                    "user": {
                        "type": "array",
                        "items": {
                            "name": "string",
                            "email": "string",
                            "updated_at": "timestamp",
                            "created_at": "timestamp",
                            "id": "int"
                        }
                    }
                }
            }

# Login de Usúario [/api/auth/login]

## Login [POST]

+ Request (application/json)
    +   Body

            {
                "email":"devLeonardo@gmail.com",
                "password":"123456"
            }

+ Response 200 (application/json)

    + Body

            {
                "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNjY4ODY2MzMzLCJleHAiOjE2Njg4Njk5MzMsIm5iZiI6MTY2ODg2NjMzMywianRpIjoiak1BbHpRdWdzZWZXUkVBYiIsInN1YiI6IjYiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.JkTxaVg7iAWsxs_gGq0thjJsTiXo3ktQGA06Swq0n3U",
                "token_type": "bearer",
                "expires_in": 3600,
                "user": {
                    "id": 1,
                    "name": "Leonardo Santos",
                    "email": "devLeonardo@gmail.com",
                    "email_verified_at": null,
                    "created_at": "2022-11-19T13:54:36.000000Z",
                    "updated_at": "2022-11-19T13:54:36.000000Z"
                }
            }

    + Schema

            {
                "type": "object",
                "properties": {
                    "access_token": {
                        "type": "string"
                    },
                    "token_type": {
                        "type": "string"
                    },
                    "expires_in": {
                        "type": "int"
                    },
                    "user": {
                        "type": "array",
                        "items": {
                            "id": "int"
                            "name": "string",
                            "email": "string",
                            "email_verified_at": "boolean",
                            "created_at": "timestamp"
                            "updated_at": "timestamp",
                        }
                    }
                }
            }

# Dados do Usúario [/api/auth/user-profile]

## Profile [GET]

+ Request
    +   Header

           + Authorization (obrigatório)

+ Response 200 (application/json)

    + Body

            {
                "id": 1,
                "name": "Leonardo Santos",
                "email": "devLeonardo@gmail.com",
                "email_verified_at": null,
                "created_at": "2022-11-19T13:54:36.000000Z",
                "updated_at": "2022-11-19T13:54:36.000000Z"
            }

    + Schema

            {
                "type": "object",
                "properties": {
                    "id": {
                        "type": "int"
                    },
                    "name": {
                        "type": "string"
                    },
                    "email": {
                        "type": "string"
                    },
                    "email_verified_at": {
                        "type": "boolean"
                    },
                    "created_at": {
                        "type": "timestamp"
                    },
                    "updated_at": {
                        "type": "timestamp"
                    },
                }
            }

# Refresh Token de Usúario [/api/auth/refresh]

## Login [POST]

+ Request
    +   Header

           + Authorization (obrigatório)

+ Response 200 (application/json)

    + Body

            {
                "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2FwaS9hdXRoL3JlZnJlc2giLCJpYXQiOjE2Njg4NjcxNDgsImV4cCI6MTY2ODg3MDc1NywibmJmIjoxNjY4ODY3MTU3LCJqdGkiOiJtcFZXTTJJbTFhTXhCOUhtIiwic3ViIjoiNiIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.cLrqqdLGoFrN3xJfZTeCuuMDIeXTLB6biuTs6NDNGso",
                "token_type": "bearer",
                "expires_in": 3600,
                "user": {
                    "id": 1,
                    "name": "Leonardo Santos",
                    "email": "devLeonardo@gmail.com",
                    "email_verified_at": null,
                    "created_at": "2022-11-19T13:54:36.000000Z",
                    "updated_at": "2022-11-19T13:54:36.000000Z"
                }
            }

    + Schema

            {
                "type": "object",
                "properties": {
                    "access_token": {
                        "type": "string"
                    },
                    "token_type": {
                        "type": "string"
                    },
                    "expires_in": {
                        "type": "int"
                    },
                    "user": {
                        "type": "array",
                        "items": {
                            "id": "int"
                            "name": "string",
                            "email": "string",
                            "email_verified_at": "boolean",
                            "created_at": "timestamp"
                            "updated_at": "timestamp",
                        }
                    }
                }
            }

# Posts [/api/auth/posts/{?id}]

## List Posts [GET]
Retorna a lista com todas as postagens realizadas.

+ Parameters

    + tag (string, opcional)

        Retorna os Posts com a Tag informada 

        + Default: `null`

+ Request
    +   Header

           + Authorization (obrigatório)
+ Response 200 (application/json)

    + Body

            [{
                "id": 2,
                "title": "json-server",
                "author": "Eldora Schinner",
                "content": "Laudantium illum modi tenetur possimus natus. Sed tempora molestiae fugiat id dolor rem ea aliquam. Ipsam quibusdam quam consequuntur. Quis aliquid non enim voluptatem nobis. Error nostrum assumenda ullam error eveniet. Ut molestiae sit non suscipit.\\nQui et eveniet vel. Tenetur nobis alias dicta est aut quas itaque non. Omnis iusto architecto commodi molestiae est sit vel modi. Necessitatibus voluptate accusamus.",
                "tags": [
                    "api",
                    "json",
                    "schema",
                    "node",
                    "github",
                    "rest"
                ],
                "created_at": "17-11-2022 17:28:48",
                "updated_at": null
            },
            {
                "id": 3,
                "title": "fastify",
                "author": "Delpha Balistreri",
                "content": "Eos corrupti qui omnis error repellendus commodi praesentium necessitatibus alias. Omnis omnis in. Labore aut ea minus cumque molestias aut autem ullam. Consectetur et labore odio quae eos eligendi sit. Quam placeat repellendus.\\n Odio nisi dolores dolorem ea. Qui dicta nulla eos quidem iusto. Voluptatibus qui est accusamus sint perferendis est quae recusandae. Qui repudiandae cupiditate fugiat est.",
                "tags": [
                    "web",
                    "framework",
                    "node",
                    "http2",
                    "https",
                    "localhost"
                ],
                "created_at": "17-11-2022 17:28:49",
                "updated_at": null
            }]

    + Schema

            {
                "type": "object",
                "properties": {
                     "id": {
                        "type": "string"
                    },
                    "title": {
                        "type": "string"
                    },
                    "author": {
                        "type": "string"
                    },
                    "content": {
                        "type": "string"
                    },
                    "tags": {
                        "type": "array",
                        "items": {
                            "type": "string"
                        }
                    },
                    "created_at": {
                        "type": "timestamp"
                    },
                    "updated_at": {
                        "type": "timestamp"
                    },
                }
            }

## Create Posts [POST]
Criar novas postagens.

+ Request (application/json)
    +   Header

           + Authorization (obrigatório)

    + Body

            {
                "title": "hotel",
                "authot": "Jett Hilpert",
                "content": "Local app manager. Start apps within your browser, developer tool with local .localhost domain and https out of the box.",
                "tags":["node", "organizing", "webapps", "domain", "developer", "https", "proxy"]
            }

+ Response 201 (application/json)

    + Body

            {
                "id": 4,
                "title": "hotel",
                "author": "Jett Hilpert",
                "content": "Local app manager. Start apps within your browser, developer tool with local .localhost domain and https out of the box.",
                "tags": [
                    "node",
                    "organizing",
                    "webapps",
                    "domain",
                    "developer",
                    "https",
                    "proxy"
                ],
                "created_at": "19-11-2022 11:40:21",
                "updated_at": "19-11-2022 11:40:21"
            }

    + Schema

            {
                "type": "object",
                "properties": {
                     "id": {
                        "type": "string"
                    },
                    "title": {
                        "type": "string"
                    },
                    "author": {
                        "type": "string"
                    },
                    "content": {
                        "type": "string"
                    },
                    "tags": {
                        "type": "array",
                        "items": {
                            "type": "string"
                        }
                    },
                    "created_at": {
                        "type": "timestamp"
                    },
                    "updated_at": {
                        "type": "timestamp"
                    },
                }
            }

## Edit Posts [PUT]
Edição de postagens antigas, é necessario informar o ID da postagem ao final da URL.

+ Parameters

    + id (int, obrigatório)

+ Request (application/json)
    +   Header

           + Authorization (obrigatório)
    
    + Body

            {
                "title": "hotel",
                "authot": "Taylor Haag",
                "content": "Local app manager. Start apps within your browser, developer tool with local .localhost domain and https out of the box.",
                "tags":["organizing", "webapps", "domain", "developer", "proxy"]
            }
    
+ Response 200 (application/json)

    + Body

            {
                "id": 4,
                "title": "hotel",
                "author": "Taylor Haag",
                "content": "Local app manager. Start apps within your browser, developer tool with local .localhost domain and https out of the box.",
                "tags": [
                    "organizing",
                    "webapps",
                    "domain",
                    "developer",
                    "proxy"
                ],
                "created_at": "19-11-2022 11:40:21",
                "updated_at": "19-11-2022 11:48:21"
            }

    + Schema

            {
                "type": "object",
                "properties": {
                     "id": {
                        "type": "string"
                    },
                    "title": {
                        "type": "string"
                    },
                    "author": {
                        "type": "string"
                    },
                    "content": {
                        "type": "string"
                    },
                    "tags": {
                        "type": "array",
                        "items": {
                            "type": "string"
                        }
                    },
                    "created_at": {
                        "type": "timestamp"
                    },
                    "updated_at": {
                        "type": "timestamp"
                    },
                }
            }

## Delete Posts [DELETE]
Exclui postagens antigas, é necessario informar o ID da postagem ao final da URL.

+ Parameters

    + id (int, obrigatório)

+ Request
    +   Header

           + Authorization (obrigatório)
           
+ Response 204