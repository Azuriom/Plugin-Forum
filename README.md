# Forum (Azuriom Plugin)

[![Chat](https://img.shields.io/discord/625774284823986183?color=5865f2&label=Discord&logo=discord&logoColor=fff&style=flat-square)](https://azuriom.com/discord)

Add a full discussion space with categories, topics, tags, permissions, and moderation tools for your community.

## API routes

The following API routes are available to retrieve public forum content.

### JSON

* `/api/forum/categories`
* `/api/forum/forums/{forum_slug}`
* `/api/forum/forums/{forum_slug}/discussions`
* `/api/forum/discussions/latest`
* `/api/forum/discussions/{discussion_id}`
* `/api/forum/discussions/{discussion_id}/posts`

### RSS

* `/api/forum/rss`
* `/api/forum/forums/{forum_slug}/rss`

### Atom

* `/api/forum/atom`
* `/api/forum/forums/{forum_slug}/atom`
