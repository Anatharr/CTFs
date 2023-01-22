
# API CSPJ

Backend du site des Caïdes de Saint Pierre des Jonquières.
Ce serveur communique exclusivement au format JSON.


# Routes

## Résumé

|Route|Méthode|Authentification requise|Paramètres|Description
|---|---|---|---|---|
|[/register](#post-register)|POST||pseudo, password|Crée un compte si le pseudo n'existe pas déjà|
|[/login](#get-post-login)|GET, POST|Basic auth||Renvoie un jeton d'authentification JWT|
|[/comments](#get-comments)|GET||article|Renvoie tous les commentaires pour un id d'article donné|
|[/comments](#post-comments)|POST|Token|token, article, author, content|Crée un nouveau commentaire|

## POST /register

Crée un compte si le pseudo n'existe pas déjà.

**Paramètres:**
- **pseudo** (requis)
- **password** (requis)

Exemple de requête:
```json
{
  "pseudo": "anatharr",
  "password": "azerty"
}
```


Exemples de réponse:
```json
{
  "status": "success",
  "message": "Registered successfully"
}
```
```json
{
  "status": "error",
  "message": "Pseudo already exists"
}
```


## GET, POST /login

Génère un jeton d'authentification JWT valable 30 minutes, en utilisant l'authentification **Basic** du protocole HTTP.

**Paramètres:** aucun

L'authentification se fait avec le header Authorization ([Doc mozilla](https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Authorization))

Exemple de header:
```
Authorization: Basic dXNlcjpwYXNzd29yZAo=
```

Exemple de réponse:
```json
{
  "status": "success",
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJwdWJsaWNfaWQiOiJmYjc0ZjRlNi0zMTQ0LTQ3OGMtYmU4NS0yMmQ2OTg3MDAzMzQiLCJleHAiOjE2NDE1MTYxMjh9.qmNRseVA36Xhj6c7jYowQzwaK1FlLOoMl6luvV79i5B"
}
```


## GET /comments

Récupère tous les commentaires de l'article spécifié.

Aucune authentification requise.

**Paramètres:**
- **article** (requis) Identifiant de l'article demandé

Exemple de requête:
```json
{
  "article": 12
}
```

Exemples de réponse:
```json
[
  {
    "id": "e5b8c6fc-ee2f-4bb2-8a43-4e0467584aa7",
    "author": "user",
    "content": "Awesome content !",
    "timestamp":
  },
  {
    "id": "7d2e7f6c-3cf0-4530-8c21-3fbbd0041005",
    "author": "anatharr",
    "content": "Another boring comment"
  },
]
```


## POST /comments

Crée un nouveau commentaire avec le contenu spécifié, en enlevant les tags `<script>` pour empêcher les vultérabilités de type Stored XSS.

**Paramètres:**
- **article** (requis)
- **author** (requis)
- **content** (requis)


Exemple de requête:
```json
{
  "article": 12,
  "author": "user",
  "content": "Awesome content !"
}
```

Exemples de réponse:
```json
{
  "status": "success",
  "comment": {
    "id": "d7e2f7c6-8c21-4530-3cf0-4e0467584aa7",
    "article": 12,
    "author": "user",
    "content": "Awesome content !",
    "timestamp": 
  }
}
```



# Configuration et Installation

Veuillez vérifier que vous avez préalablement installé [NodeJS](https://nodejs.org/) et [npm](https://www.npmjs.com/).

```sh
# Installation des dépendances
$ npm i

# Modifiez la configuration selon vos besoins
$ cat config.js

# Puis lancez le serveur
$ node index.js
```
