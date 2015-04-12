# Pioutter_copyTwitter
Projet réalisé en binôme. Ce site internet est une copie du réseau social Twitter que nous avons appelé Pioutter.

Après avoir importé la base de donnée, si la connexion ne s'établit toujours pas :
il faut aller changer les paramètres de connexions de la fonction mysql_connect(... , ... , ...)
Si elle est présente dans un fichier .php, cette fonction se trouve au début

Dans la plupart des cas il vous suffira de ne changer que le dernier des 3 paramètres et de mettre, soit :
- mysql_connect(... , ... , 'root')
- mysql_connect(... , ... , '')
