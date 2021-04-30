About
=====
Arris YouTube playlist 

Features
--------
- YouTube integration
- Slack integration (chat commands)

Run
---
- `docker-compose up -d`
- log into `php` container with `docker-compose exec php bash` and run inside:
  - `bin/console d:m:m`
  - `sf messenger:consume async` - queue

Docker fix permissions
----------------------
`sudo chown -R $USER:$USER .`
