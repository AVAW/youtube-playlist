About
=====
Arris YouTube playlist 

Features
--------
- YouTube integration (OAuth)
- Slack integration (OAuth, Slash Commands, Interactivity)

Run
---
- `docker-compose up -d`
- log into `php` container with `docker-compose exec php bash` and run inside:
  - `composer install`
  - `sf d:m:m`
  - `sf messenger:consume async` - queue

Docker fix permissions
----------------------
`sudo chown -R $USER:$USER .`
