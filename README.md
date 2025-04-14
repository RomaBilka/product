# Product

Simple setup:

```bash
cd docker
docker-compose up -d --build
```
## In PHP container
```bash
cd /home/www/product
composer install
vendor/bin/phinx migrate
vendor/bin/phinx seed:run
```

[Documentation](http://localhost:8083/api/)