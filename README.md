# Projet Technique Laravel & React

![Backend CI](https://github.com/Audmqx/InvoiceApi/actions/workflows/CI.yml/badge.svg)


## Enoncé
Nous voulons concevoir une API pour accéder à nos factures. 

Une facture est composée de : 
Un client* (pour la V1 un simple champ texte)
Un numéro* 
Un statut (envoyée, en retard, réglée, annulée)
Une date d'émission*
Une note interne (champ texte)
Une date de règlement
Une ou plusieurs lignes*

Une ligne de facture est composée de : 
Un produit* (pour la V1 un simple champ texte)
Un montant*

*: champs obligatoires

Résultat attendu
Une route /api/invoices paginée qui rend un json avec 20 factures par page ordonnées par date d’émission
Chaque facture est représentée par tous ses champs sauf note interne + un champ “total” qui calcule l’ensemble des lignes d’une facture à la volée

Exemple : 
{
      “invoices”: [
          {
               “customer” : “John Doe”,
               “number” : “FA-2022-10-003”,
               “status” : “sent”,
               “sent_at” : “2022-10-06 10:02:03”,
               “paid_at” : null,
               “total”: 54.20,
          },
          {...}
      ]
}

Un seeder qui ajoute 100 factures automatiquement
Un ou plusieurs tests sur cette route

## Installation

### Prérequis

- **PHP 8.2 ou supérieur**
- **Composer 2.0 ou supérieur**

### Run & Build up

- `composer setup-project`

### Test

- `php artisan test`

### Méthodologie de Développement

J'ai appliqué la méthode du Test-Driven Development (TDD) au maximum
Mise en place de l'intégration continue (CI) pour le backend.
J'ai privilégié le développement sur la branch main (trunk-based development) au lieu du développement basé sur des branches pour aller plus vite.