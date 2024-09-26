# Projet Technique Laravel

![Backend CI](https://github.com/Audmqx/InvoiceApi/actions/workflows/CI.yml/badge.svg)

## Enoncé

Nous voulons concevoir une API pour accéder à nos factures.

Une facture est composée de :  
- Un client* (pour la V1 un simple champ texte)  
- Un numéro*  
- Un statut (envoyée, en retard, réglée, annulée)  
- Une date d'émission*  
- Une note interne (champ texte)  
- Une date de règlement  
- Une ou plusieurs lignes*

Une ligne de facture est composée de :  
- Un produit* (pour la V1 un simple champ texte)  
- Un montant*

\* : champs obligatoires

### Résultat attendu

Une route `/api/invoices` paginée qui rend un JSON avec 20 factures par page ordonnées par date d’émission.  
Chaque facture est représentée par tous ses champs, sauf la note interne, plus un champ `total` qui calcule l’ensemble des lignes d’une facture à la volée.

Exemple :

```json
{
    "invoices": [
        {
            "customer" : "John Doe",
            "number" : "FA-2022-10-003",
            "status" : "sent",
            "sent_at" : "2022-10-06 10:02:03",
            "paid_at" : null,
            "total": 54.20
        },
        {...}
    ]
}
```

### Seeder

Un seeder ajoute automatiquement 100 factures dans la base de données. Pour réinitialiser la base de données et la peupler à nouveau avec des factures, vous pouvez exécuter la commande suivante :

```bash
php artisan db:seed
```

### Swagger

L'API est documentée avec Swagger. Une fois l'application démarrée, vous pouvez accéder à la documentation de l'API à l'URL suivante :

```
/api/documentation
```

## Installation

### Prérequis

- **PHP 8.2 ou supérieur**
- **Composer 2.0 ou supérieur**
- **Docker (si vous choisissez l'installation via Docker)**

### Option 1 : Installation Manuelle

#### Étapes

1. Clonez le dépôt :

    ```bash
    git clone https://github.com/Audmqx/InvoiceApi.git
    cd InvoiceApi
    ```

2. Exécutez la commande suivante pour configurer et démarrer le projet automatiquement :

    ```bash
    composer setup-project
    ```

Cette commande fait les actions suivantes :
- Installe les dépendances via Composer
- Copie le fichier `.env.example` vers `.env` si nécessaire
- Génère la clé d'application Laravel
- Exécute les migrations de la base de données
- Exécute le seeder pour peupler la base de données avec 100 factures
- Démarre le serveur local sur `127.0.0.1:8000`

### Option 2 : Installation avec Docker

#### Étapes

1. Clonez le dépôt :

    ```bash
    git clone https://github.com/Audmqx/InvoiceApi.git
    cd InvoiceApi
    ```

2. Construisez les images Docker et démarrer les conteneurs en arrière plan :

    ```bash
    docker-compose up -d
    ```


Vous pouvez accéder à l'application sur `http://127.0.0.1:8000`.

### Tests

Pour exécuter les tests, utilisez la commande suivante :

```bash
php artisan test
```

Si vous utilisez Docker, exécutez les tests dans le conteneur :

```bash
docker-compose exec app php artisan test
```

## Méthodologie de Développement

J'ai appliqué la méthode du Test-Driven Development (TDD) au maximum.  
L'intégration continue (CI) est mise en place pour le backend.  
J'ai privilégié le développement sur la branche principale (trunk-based development) pour aller plus vite, au lieu de créer plusieurs branches.

## Remarques

J'ai réalisé l'énoncé en 2 heures et n'ai pas pu aborder les bonus par manque de temps.  
J'aurais aimé pouvoir développer la partie bonus et ajouter plus de tests pour vérifier la pagination, le nombre total de factures, etc.
Je me suis permis de prendre un peu de temps pour dockeriser et documenter l'application.
