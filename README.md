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
- set constants in `.env.local`
- log into `php` container with `docker-compose exec php bash` and run inside:
  - `composer install`
  - `sf d:m:m`
  - `sf messenger:consume async` - queue

Start the development server: `yarn encore dev-server` or `yarn encore dev --watch`

Docker fix permissions
----------------------
`sudo chown -R $USER:$USER .`
