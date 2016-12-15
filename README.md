# server-status

A web-based Arma 3 server monitoring and mission-management system.

## Requirements

* PHP
* MySQL

## Instructions

* Edit setup.sql, replacing `USERNAME` and `PASSWORD` with your desired username and password
* Run setup.sql to create DB, table and user
* Edit settings.php.sample with your groups details and the DB login you previously set
* Rename `settings.php.sample` to `settings.php`
* Fill in the array in `servers.php.sample` with the servers you want to monitor
* Rename `servers.php.sample` to `servers.php`
* Place `missions` and `monitor` folders in an internet-accessible location (I recommend subdomains so `http://missions.domain.com` and `http://monitor.domain.com`)

## Credits

* __Firefly2442__: For his GameQ implementation of server monitor https://github.com/firefly2442/phparma2serverstatus
* __TheGodDamnSexRobot__: for help with bugfixes and sense-checks
* __Verox__: For getting me started down this road with his server-information system https://github.com/Verox-/server-information-system
