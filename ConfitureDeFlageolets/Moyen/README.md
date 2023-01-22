# CTF 2 (Moyen)

## Scénario
La cible de l'attaque est le site de RockIt, un grand festival de rock.

Pour parvenir à s'introduire sur le serveur, l'attaquant devra exploiter une **LFI** (Local File Inclusion) coupléee à un **PHP filter**, dans le but de récuperer le fichier de configuration du site web. Ce fichier contient les identifiants de l'administrateur ainsi que son mot de passe hashé, qu'il est possible de cracker avec la liste Rockyou.

Une fois connecté sur le dashboard administrateur, un formulaire d'upload permet à l'attaquant d'**uploader un shell PHP**. Cependant, le serveur change les noms des fichiers uploadés par des mots aléatoires de longueur 5 ou 6. L'attaquant devra alors réaliser un **brute force** pour trouver le nom de son shell.

Une fois introduit sur le serveur, l'attaquant sera dans un docker en tant que www-data, il peut alors récupérer le premier flag dans */var/www/flag.txt*. Pour obtenir le flag root, il faut tout d’abord devenir root dans le docker. Pour cela, l’attaquant devra exploiter une vulnérabilité de l'interprétation des **wildcards** ('\*'). Ensuite, il devra réaliser un docker escape grâce à la **CVE-2019-14271**.


## Benchmarking

Deux attaques par force brute sont nécessaires dans la réalisation de ce CTF. Nous avons donc estimé le temps nécessaire pour chacun d'entre eux dans différents contextes, dans le but d'évaluer la difficulté de notre CTF.

> **Attention** toutes les durées et vitesses données ci-dessous changent en fonction de la configuration matérielle de l'ordinateur de l'attaquant et de la connexion réseau.
> Les tests ont été réalisés en **localhost** sur une machine virtuelle. La machine hôte possède un CPU Intel Core i7 9th Generation et une carte graphique NVIDIA GeForce RTX 2060.


### Bruteforce du dashboard
L'algorithme de chiffrement utilisé ici est le SHA-256. Nous avons retenus plusieurs mots de passes en fonction de leur placement dans la liste Rockyou.

| Occurence | Mot de passe | Temps nécéssaire | Hash |
|---|---|---|---|
| 5952274 | lynyrdskynyrd#1 | 1,159s | 3459d16b25556ac7f38a84e9633f94b9de6306e5b5a232b8d4f8f767fa1852fe |
| 7785481 | greenday#1! | 1,455s | f9f7140b4564d10b47664da2e9ac3c192291dc41447414d93bf04961886a30a5 |
| 12892209 | 21gunsgreenday | 2,345s | 44f143d9637b2115e45119696226dec279de5fa9e94078ed0edefeaa710a93e2 |
| 14301479 | \*freebird\* | 2,565s | b09fecee0d882969e91f6e571594bf896d27b93adc10ede750702760082714d6 |
| 14333469 | #1greenday | 2,714s | 3f8567225b20f4326ce9d2d818265783b45b102f9c1796f9f259e40f68b73d49 |

Le placement dans la liste importe donc peu.

Afin de forcer l'utilisation de la LFI, nous avons rendu très lent le brute force direct via le formulaire http, en ajoutant une instruction sleep() à chaque calcul de mot de passe. En choisissant par exemple le mot de passe **#1greenday**, et en essayant le bruteforce avec hydra, on a :

| Instruction | Vitesse        | Temps nécessaire estimé |
| ----------- | -------------- | ----------------------- |
| sleep(0)    | ~5000 keys/min | 0h 47min 46sec          |
| sleep(1)    | 800 keys/min   | 4h 58min 36sec          |
| sleep(2)    | ~500 keys/min  | 7h 56min 46sec          |

En parallélisant le bruteforce sur plusieurs ordinateurs il est toujours possible de réduire ce temps, on pourrait alors penser à installer **fail2ban** pour mitiger cette route d'exploitation, cependant cela empêcherait le bon déroulement du reste du CTF, car un bruteforce est prévu dans les différentes étapes. On accepte donc cette façon de faire comme un chemin alternatif.

### Bruteforce du nom du shell
Il s'agit ici de trouver un mot de longueur fixe avec des caractères alphanumériques. La LFI permettant de lire directement le code source permettant de générer ces mots. Afin d'accélérer l'opération, il suffit d'upload plusieurs shells.

> Les tests ont été réalisés en localhost, à une vitesse d'environ 4000 keys/min. Les temps varient beaucoup d'un essai à l'autre, ce qui est dû aux noms aléatoires.
> Cependant, plus le nombre de shells augmente, plus le temps devrait en théorie se stabiliser d'un essai à l'autre

| Longueur du nom | Nombre de shells uploadés | Temps nécessaire | Emplacement du premier shell trouvé |
|---|----|-------|-----------------------------|
| 4 | 10 | <2min | 494800 sur 14776336 (3.35%) |
| 5 | 10 | <30min | 13938249 sur 916132832 (1.52%)|
| 5 | 10 | ~3h | 84389283 sur 916132832 (9.21%)|
| 6 | 500 | ~29h | 816812423 sur 56800235584 (1.44%)|
| 6 | 5000 | ~3min | 1489924 sur 56800235584 (0.002%)|

On en conclut que même avec une longueur de 6 et donc plus de 5e10 possibilités, cela reste réalisable en temps raisonnable en uploadant plus de shells !

