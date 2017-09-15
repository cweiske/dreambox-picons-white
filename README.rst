Senderlogos für die Dreambox
============================
Keyword: picon, picons

picon-in-opendreambox-2.5-Diskussion:
 http://dreambox.de/board/index.php?thread/22782

Benötigt ``enigma2-plugin-systemplugins-jsonapi`` auf der dreambox.
Lokal wird PHP 5.6+ benötigt.


Ordner
------
``orig/``
  Originaldateien von Wikipedia
``white/``
  Angepasste Dateien
``picon/``
  Generierte picon-Dateien


picons generieren
-----------------
#. Hostnamen in ``fetch-services.php`` anpassen
#. ``services.csv`` von Dreambox generieren::

     php fetch-services.php

#. ``.svg``-Dateien aus ``white/`` skalieren und mit dem richtigen Namen
   in ``picon/`` legen::

     $ php convert.php

#. picons auf Dreambox installieren::

     $ scp picon/* dreambox:/data/picon/
