# Openmouse Server

learn more about [OPENMOUSE](https://github.com/rockitbaby/openmouse).

---

*This is a very first quick'n'dirty release.*

The openmouse server lives on the web and collects and displays all data generated by the openmouse extension. (It's not very secure. Run at your own risk.)

## Prerequisites

- Apache with php and mysql, mod_rewrite enabled

## Installation

- copy all files to your webserver
- create a new mysql DB and insert app/scheme.sql
- edit config.php
- copy and edit app/app-settings.example.php to app/app-settings.php