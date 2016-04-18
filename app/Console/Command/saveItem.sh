#!/bin/bash

cd /opt/contents/app/Console/Command/
/usr/bin/php ../cake.php saveItem >> log.txt
/usr/bin/php ../cake.php updateItemOrder >> log_order.txt