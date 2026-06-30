# ⚙️ Command_Os

> Base de connaissances intelligente pour centraliser, documenter et exécuter les commandes et procédures de production.

---

## 📋 Table des matières

- [Présentation](#présentation)
- [Fonctionnalités](#fonctionnalités)
- [Stack technique](#stack-technique)
- [Installation](#installation)
- [Structure de la base de données](#structure-de-la-base-de-données)
- [Roadmap](#roadmap)

---

## Présentation

**Command_Os** répond à un double besoin opérationnel :

**Pour les nouveaux collaborateurs** — une documentation métier claire et structurée. Chaque commande (`docker`, `firewall-cmd`, `git`...) est accompagnée d'une description précise, de ses paramètres et d'exemples concrets.

**Pour les utilisateurs expérimentés** — un outil de productivité. Retrouvez rapidement une commande complexe et copiez-la en remplissant uniquement les parties variables (nom de conteneur, port, message de commit) via une boîte de dialogue interactive.

Au-delà des commandes unitaires, Command_Os permet de créer des **interventions** : des procédures pas-à-pas, potentiellement conditionnelles (`si les logs montrent une erreur → étape A, sinon → étape B`), pour guider une intervention de bout en bout.

---

## Fonctionnalités

- 📚 **Catalogue de commandes** — commandes organisées par outil, avec description et paramètres documentés
- 📋 **Copie interactive** — boîte de dialogue pour remplir les variables (`<container_name>`, `<port>/tcp`) avant copie
- 🔍 **Recherche et filtrage** — par nom de commande, description ou tag
- 🗂️ **Système de tags** — classification flexible des commandes
- 🚨 **Interventions** — procédures séquentielles avec branchements conditionnels (OK / KO)
- 🔗 **Graphe d'intervention** — chaque étape pointe vers la suivante selon le résultat

---

## Stack technique

| Composant | Technologie |
|-----------|-------------|
| Backend   | PHP 8.x / Laravel 12 |
| Base de données | MySQL / PostgreSQL |
| Frontend  | Blade (Laravel) |

---

## Installation

### Prérequis

- PHP >= 8.2
- Composer
- MySQL ou PostgreSQL
- Node.js & NPM (pour les assets)

### Étapes

**1. Cloner le dépôt**

```bash
git clone https://github.com/<votre-username>/command_os.git
cd command_os
```

**2. Installer les dépendances PHP**

```bash
composer install
```

**3. Configurer l'environnement**

```bash
cp .env.example .env
php artisan key:generate
```

Éditez `.env` et renseignez vos paramètres de base de données :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=command_os
DB_USERNAME=root
DB_PASSWORD=
APP_LOCALE=    fr || en         #langage   
```

**4. Créer la base de données et exécuter les migrations**

```bash
php artisan migrate
```

**5. (Optionnel) Charger les données de démonstration**

```bash
php artisan db:seed
```

**6. Compiler les assets**

```bash
npm install && npm run build
```

**7. Lancer le serveur de développement**

```bash
php artisan serve
```

L'application est accessible sur `http://localhost:8000`.

---

## Structure de la base de données

Command_Os repose sur deux modules distincts mais liés.

### Module 1 — Catalogue de commandes

```
tags
 └── commande_tag ──┐
                    ├── commands
                    │    └── commande_parametre ── parametres
```

| Table | Rôle |
|-------|------|
| `commands` | Les commandes racines (`docker`, `firewall-cmd`, `tar`...) |
| `parametres` | Les paramètres et sous-commandes (`exec -it`, `--tail 100`, `-czf`...) |
| `commande_parametre` | Pivot ordonné (`position`) liant une commande à ses paramètres |
| `tags` | Étiquettes de classification |
| `commande_tag` | Pivot many-to-many commandes ↔ tags |

Chaque `parametre` contient trois champs clés pour la reconstitution automatique de la commande :

| Champ | Rôle | Exemple |
|-------|------|---------|
| `nom` | La partie fixe | `logs --tail 100` |
| `argument` | La variable à remplir par l'utilisateur | `<container_name>` |
| `suffix` | La partie fixe après l'argument | `--timestamps` |

Résultat reconstruit : `docker logs --tail 100 <container_name> --timestamps`

---

### Module 2 — Interventions

```
interventions
 └── etapes (graphe auto-référentiel)
      ├── commande_id  → commands
      ├── parametre_id → parametres
      ├── next_step_ok → etapes (branche succès)
      └── next_step_ko → etapes (branche échec)
```

| Table | Rôle |
|-------|------|
| `interventions` | En-tête de la procédure (titre, problème ciblé, étape d'entrée) |
| `etapes` | Chaque étape du graphe, avec sa commande pré-choisie et ses deux branches |

Une étape est **conditionnelle** si `next_step_ko` est renseigné. Une étape est **finale** si `next_step_ok` et `next_step_ko` sont tous les deux `NULL`.

---

## Roadmap

- [ ] 📄 **Export PDF** — impression d'une intervention complète avec toutes ses étapes
- [ ] 📜 **Historique d'exécution** — traçabilité des interventions jouées (date, durée, résultat)
- [ ] 📦 **Import / Export JSON & CSV** — sauvegarde et partage du catalogue de commandes

---

## Licence

Projet personnel — tous droits réservés.
=======
# command-os
A centralized command management web application for IT Infrastructure and DevOps teams.
b3d2c96
