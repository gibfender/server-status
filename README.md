# server-status

A web-based Arma 3 server monitoring and mission-management system.

## Requirements

* PHP
* MySQL

## Instructions

* Edit setup.sql, replacing `USERNAME` and `PASSWORD` with your desired username and password
* Run setup.sql to create DB, table and user
* Edit settings.php.sample with your groups details and the DB login you previously set
* Fill in the array in `settings.php.sample` with the servers you want to monitor
* Rename `settings.php.sample` to `settings.php`
* Place `missions` and `monitor` folders in an internet-accessible location (I recommend subdomains so `http://missions.domain.com` and `http://monitor.domain.com`)
* Make your servers MPmissions and RPT folders internet-accessible with the addresses 'http://srv1missions.domain.com' and 'http://srv1rpt.domain.com' (repeat for each server)

### H3 Sample apache virtual hosts setup:

```<VirtualHost *:80>
	ServerName monitor.armagoons.com
	DocumentRoot "C:\wamp\www\server-status\missions"
	DirectoryIndex monitor.php
	<Directory  "C:\wamp\www\server-status\missions">
		AllowOverride All
		Require all granted
	</Directory>
</VirtualHost>

<VirtualHost *:80>
	ServerName missions.armagoons.com
	DocumentRoot "C:\wamp\www\server-status\missions"
	<Directory "C:\wamp\www\server-status\missions">
		AllowOverride All
		Require all granted
	</Directory>
</VirtualHost>```

## Credits

* __Firefly2442__: For his GameQ implementation of server monitor https://github.com/firefly2442/phparma2serverstatus
* __TheGodDamnSexRobot__: for help with bugfixes and sense-checks
* __Verox__: For getting me started down this road with his server-information system https://github.com/Verox-/server-information-system
