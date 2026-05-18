# Documentació de Pipelines - Framework de MongoDB

En aquest apartat s'explica l'ús de l'Aggregation Framework de MongoDB que hem implementat de forma nativa al nostre fitxer `lista_logs.php`.

Per optimitzar el rendiment de l'aplicació i descarregar de processament al servidor PHP, hem delegat el càlcul del **Top 3 de pàgines més visitades** directament al motor de la base de dades NoSQL.

## Pipeline: Pàgines Més Visitades (Top 3)

El pipeline de dades consta de 3 etapes bàsiques utilitzant el mètode `aggregate()` de la llibreria de MongoDB per a PHP:

```json
[
  { 
    "$group": { 
      "_id": "$url", 
      "visites": { "$sum": 1 } 
    } 
  },
  { 
    "$sort": { 
      "visites": -1 
    } 
  },
  { 
    "$limit": 3 
  }
]
