ShipStream Test Plugin
======================

This is a simple implementation of a ShipStream Merchant Plugin which is meant for demonstration purposes
and primarily to confirm correct setup of the [ShipStream Merchant Middleware](https://github.com/shipstream/middleware).

![screenshot](https://raw.githubusercontent.com/shipstream/plugin-test/master/assets/plugin-test-screenshot.png)

Installation
------------

See the [ShipStream Merchant Middleware Installation](https://github.com/shipstream/middleware#installation) for the
middleware environment installation which includes the installation of this test plugin.

```
$ bin/modman init
$ bin/modman clone https://github.com/shipstream/plugin-test.git
$ bin/mwrun ShipStream_Test update_ip
```