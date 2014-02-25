# BackNg
#### A PHP+MongoDB Backend for rapid prototyping with AngularJS

**Warning** This doesn't do anything yet. Pre-alpha!
MIT Licensed (see LICENSE file)

## How does it work?
You define your schemas in a PHP array and BackNG then does everything else. Schemas don't just contain
names of fields but validators, rules and all sorts of other exciting stuff. Schemas support inheritance.

The idea is that the setup is totally declarative, the aim being that /config/dbConfig.var.php is the
only file which you actually need to edit in order to get up and running. Plugins can provide extra
functionality like e.g. a users DB and custom endpoints to authenticate users. Your schemas can
extend schemas provided by plugins. Plugins can expose validators, field types etc. which can then
be used globally (not great from a loose-coupling PoV but meh).

##...why?
I'm a PHP developer and writing/deploying Node.js apps (or even meteor) is scary voodoo! I thought about
using the MEAN stack but all I really wanted/needed was Angular and ui-router, and couldn't spare the
time to learn node and express just to hook up a REST backend. There are far more options for hosting
PHP apps than JS ones.

## Installation
- Ensure dependencies are met
- Download or clone this repo somewhere accessible from your web server
- Installation is now done ;-)

### Dependencies
- PHP >5.3
- MongoDB
- [PHP Mongo driver](http://www.php.net/manual/en/mongo.installation.php)

## Roadmap/TODOs
- ~~Plugin framework - everything is a plugin~~
- ~~App flow - initialise, authorise etc. events fired on every plugin instance.~~
- Abstract schemas
- Automatically ensure Mongo collections exist for all schemas we're using
- Hydrate schemas from plugins into one canonical schema (support inheritance, other magic)
- Routing - define which endpoints are accessible and add custom handlers for non-CRUD endpoints
- Security - fine-grained control over who can CRUD what and where they can do it.

###Wishlist
- Auto-generate some Angular boilerplate code or at least provide a native JS implementation of
common stuff.
