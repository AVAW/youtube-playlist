About
=====
Play videos from YouTube playlists. Allow integrating with Slack and vote form videos in conversations.

Features
--------
- YouTube's integration (OAuth)
- Slack integration (OAuth, Slash Commands, Interactivity)

Run
---
- `docker-compose up -d`
- set constants in `.env.local`
- log into `php` container with `docker-compose exec php bash` and run inside:
  - `composer install`
  - `sf d:m:m`
  - `sf messenger:consume async` - queue

Docker fix permissions
----------------------
`sudo chown -R $USER:$USER .`
