# MyApi
1- Installer les dépendences
```php
composer install
```
2- J'ai utilisé docker pour la DB

```php
docker-compose up -d
```

3- Modifier votre .env selon votre configuration local

4- Créer la DB

```php
php bin/console doctrine:database:create
```

5- lancer les migrations
```php
php bin/console doctrine:migrations:migrate
```
6- Url api doc

```php
/api/doc
```

7- lancer les tests unitaires
```php
php bin/phpunit
```
