#Ukazky integrace

##Debug panel dava zakladni informace
Zakladni informace jsou videt ihned na debug panelu.

Informace o pozadavcich na Skautis
![Skautis debug panel](img/skautis_thumb.png)

Informace o uzivateli prihlasenem pres Skautis
![Skautis user debug panel](img/skautis_user_thumb.png)

##Vlastni debug stranka
SkautisBundle pridava vlastni stranku obsahujici informace o nastaveni.


![App settings](img/skautis_app_details.png)


##Integrace s profilerem
Profiler zobrazuje kolik casu casti aplikace trvaji. 
Na screenshotu je videt controller ktery obsahuje 3 volani na Skautis ``UserDetail``, ``EventAll`` a ``EventCampAll``.

![Profiler](img/skautis_profiler.png)

##Prihlaseni do Skautisu je propojeno se Symfony loginem (volitelne)
Username je nacteno ze skautisu a vsem uzivatelum prihlasenym pres Skautis je pridana role ``ROLE_SKAUTIS``

![Security](img/skautis_security.png)


