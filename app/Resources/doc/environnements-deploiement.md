Environnements et déploiement
=============================

Environnements
--------------

Les environnements suivants son disponibles :

 * **Production** : https://flattracker-api.ghribi.net/
    - IP : `92.222.47.24` ou `2001:41d0:52:100::124e`
    - Branche git associée : `master`

Déploiement
-----------

Le déploiement se fait grâce au Gem `capifony`.
Pour déployer sur un environnement, il faut ajouter sa clé publique à l'utilisateur `www-data` de l'environnement où l'on souhaite déployer.

``` bash
bundle exec cap <env> deploy
```

Où `<env>` est : `prod`
