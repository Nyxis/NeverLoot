NeverLoot
=========

Application web Sfy1.4 de gestion de raids de guilde sur WoW

# Install
```
git clone git://github.com/QuentinCerny/NeverLoot.git .
php symfony project:permissions
php symfony propel:build --all
mysql -p -u root #DBNAME# < data/fixtures.sql
```