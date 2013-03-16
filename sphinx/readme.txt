Antes de lanzar el demonio sphinx, se debe preparar la configuracion. Para ello
dentro de la subcarpeta etc, renombrar sphinx.conf.sample a sphinx.conf y
modificar los parametros de conexión a la base de datos.


Para lanzar demonio sphinx:

1.- Posicionarse en esta carpeta. Ej: cd /var/www/chileatiende/sphinx
2.- Ejecutar el comando: searchd -c etc/sphinx.conf


Para detener demonio sphinx:

1.- Posicionarse en esta carpeta. Ej: cd /var/www/chileatiende/sphinx
2.- Ejecutar el comando: searchd -c etc/sphinx.conf --stop


Para reindexar contenidos:

1.- Posicionarse en esta carpeta. Ej: cd /var/www/chileatiende/sphinx
2.- Ejecutar el comando: indexer -c etc/sphinx.conf --rotate --all