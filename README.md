# Gestió de Guardies/Reserves (Versió 2025-06-19)
Una aplicació web realitzada amb PHP per gestionar les Guardies docents i Reserves d'aulari/recursos d'un centre de Secundaria i FP.

Està contextualitzat a l'IES Sant Vicent Ferrer d'Algemesí http://iessantvicent.com

Ferran Pelechano. Llicència Creative Commons BY-NC-SA. f.pelechanogarcia@edu.gva.es

Parteix d'un desenvolupament previ realitzat en Java per Jose Chamorro Molina (j.chamorromolina@edu.gva.es)

## Importar dades des de GHC Peñalara
1. El fitxer d'importació import.csv el genere directament des del XRHO que genera GHC Peñalara.
2. Elegir: "Transferir el horari a"
3. Elegir: "Altres formats d'intercanvi"
4. Marcar: CSV (Identificatius de les llistes + Tipus 1)
5. Elegir: Separador ; i format UTF-8
6. Posar el fitxer generat al PATH: import/import.csv
7. Per executar la importació cal afegir 66 al final de la URL generada: importar_definitiu66
8. Hi ha Creates d'ubicacions sense docència per poder ser reservades (accio_importar.php). Comentades perquè es poden afegir a través de l'opció Gestió!

## Configuració
1. Es pot personalizar el logo a images/logo.png
2. Permet mode 2 columnes, definir a true $config_columnes al fitxer index_config.php
3. Les franges horaries estan definides al fitxer index_config.php
4. Es poden personalitzar les etiquetes d'idioma al fitxer index_idioma_ca.php o definir un altre index_idioma_XX.php i canviar en index.php la variable $idioma
5. Les rutes de bd, backup i import així com els noms dels fitxers es poden personalitzar.

## Gestió de Professorat
Una vegada realitzada la importació inicial, es pot complementar la info del professorat en "Administrar-Gestió Professorat" per possibilitar la creació automàtica de les llistes de correu.

## Personalitzacions en codi
En accio_mostrar.php hi ha personalitzacions per mostrar botons de patis/consergeria o convivència en diferents franges que es poden configurar sobre el mateix codi (lin 347 endavant). 

## Usuaris
Cal utilitzar .htaccess a l'arrel, i un .htpasswd en la ruta definida per gestionar els usuaris que accedeixen al sistema. 

L'usuari privilegiat es defineix a index_config.php en la variable $usuari_privilegiat i el dels professors pot ser qualsevol altre.

```
AuthName "Restricted Area" 
AuthType Basic 
AuthUserFile /path/to/.htpasswd 
AuthGroupFile /dev/null 
require valid-user
```

## Base de Dades
Es gasta un fitxer SQLITE ubicat en una ruta definida a index_config.php

Deuria canviar-se a una unicació no navegable!

## Control Horari (desenvolupament futur?)
Hi ha unes opcions de Control horari en desenvolupament que actualment no està en producció.

El codi de validació està autogenerat per cada professor i es pot vore a la seva fitxa.

De moment no es gasta ni hi ha previssió de fer-ho