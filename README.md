# Projet Vign'UP

---

### Description :
Vign’Up souhaite 
intervenir afin d’aider les vignerons et autres acteurs du vignoble à mieux comprendre les vignes
semi-larges. Vign’Up souhaite mettre en lumière quels sont les avantages, les inconvénients et les conséquences de 
l'installation de VSL sur une exploitation. La solution web qui sera codé ici ira donc dans ce sens.

### Instructions de développement :

* Pour cloner le projet : `git clone https://github.com/bricekc/vign-up.git`  


* Toujours travailler sur une version de composer à jour : `composer self-update`  


* Les push vers la branche main sont interdit, nous devrons travailler avec des branches
portant le noms des fonctions qu'elles implémentent en effectuant des merges requests sur la branche main.  


* Créer une branche : `git branch NomDeMaBranch`
 

* Voir les branches courantes : `git branch` ATTENTION : la branche précédé de * est la branche courante.  


* Voir les branches qui ont déja été fusionné (plus rien n'est à fusionner ou à merge) avec la
branche courante `git branch --merged`  


* Voir les branches qui __**N'ONT PAS**__ déja été fusionné (il reste des éléments à fusionner ou à merge) avec la
  branche courante `git branch --no-merged`


* Une branche dont tous les éléments ont été mergé sera **supprimé** ! Nous ne voulons pas nous retrouver avec 30 
branches à gérer. Supprimer une branche : `git branch -d test` **REMARQUE :** Une branche non mergé ne peut pas être 
supprimé donc pas de panique.


* Changer le nom d'une branche : `git branch --move mauvais-nom-de-branche nom-de-branche-corrigé` PUIS faire :
`git push origin --delete mauvais-nom-de-branche`. **REMARQUE :** C'est à éviter, mais c'est possible.

### Tests et scripts utiles

script pour lancer le serveur : `composer start`

script pour lancer les tests : `composer test:codeception`

script pour créer la base de données : `composer db`

### Identifiant de connexion

Pour se connecter en tant que admin
* Identifiant : `dio@example.com`
* Mot de passe : `adminfloppa01`
cela permet de modifier à peut pret tout ce qui est modifiable sur le site... Ajouter des rubriques, supprimer des posts, modifier la bd... entre autre.

Pour se connecter en tant que viticulteur
* Identifiant : `shaka@example.com`
* Mot de passe : `test01`
Cela permet de répondre aux questionnaire pour viticulteur et d'ajouter des vignes.

Pour se connecter en tant que fournisseur
* Identifiant : `brick@example.com`
* Mot de passe : `test02`
Cela permet d'editer son prfil fournisseur/Prestataire.

### Présentation des différentes pages du projet
Fil d'actualité : `/`

Sur la page Fil d'actualité on va pouvoir retrouver les utilisateurs qui se sont inscrit
dans les 7 derniers jours, les dernières publications sur le forum du site
mais on retrouvera aussi la page facebook de vign'up.

Cartographie : `/carte`

Sur la page Cartographie on va pouvoir retrouver différentes informations comme par exemple
les différentes vignes des viticulteurs. Mais aussi un lien vers le profil du viticulteur

Fournisseur & Prestataire : `/fournisseur`

Sur la page Fournisseur & Prestataire on va pouvoir retrouver les différents fournisseurs
avec leurs matériels et leurs services. Il y a aussi un lien vers les profils des différents users.
Une barre de recherche est mise a disposition de l'utilisateur pour trouver un fournisseur ou rechercher
un tag.

Profil : `/profil/{idProfile}`

Sur la page Profil on va pouvoir retrouver les informations du profil
d'un utilisateur. On va pouvoir voir ses informations, ses matériels proposés...
On pourra aussi voir ses contributions dans le forum.

Forum : `/sujet`

Sur la page Forum on va pouvoir retrouver les différents sujets du forum.
On va pouvoir aller aussi sur les différentes pages des sujets pour voir les posts.
Un utilisateur connecté et vérifié par l'admin pourra ajouter un post ou un sujet.

Documentation : `/rubrique`

Sur la page Rubrique on va pouvoir retrouver différents types de documentation.
Il y aura des témoignages,des vidéos youtubes qui seront directement
sur la page. Il y aura aussi des images qui seront directement affichées sur la page.
Un administrateur pourra ajouter des documentations ou aussi supprimer des
documentations.

Questionnaire : `/questionnaire`

Sur la page Questionnaire on va pouvoir retrouver différents questionnaires.
Il y a un questionnaire ouvert pour tous les utilisateurs et un questionnaire
pour les viticulteurs vérifiés. Les résultats du premier questionnaire ne seront pas enregistrés
alors que celle du questionnaire pour viticulteurs sera enregistré.

Login : `/login`

Sur la page Login on va pouvoir se connecter avec son identifiant et son mot de passe.
Si une personne n'a pas de compte elle retrouvera un lien pour s'inscrire.

Espace Admin : `/espace/admin`

Sur la page Espace Admin l'admin va pouvoir retrouver différents liens
Il va pouvoir aller sur la page pour vérifier les viticulteurs ou les fournisseurs mais
il pourra aussi accéder au dashboard

Dashboard : `/dashboard`

Sur la page du dashboard on va pouvoir retrouver tout les viticulteurs et tout les fournisseurs
avec leurs informations. On va pouvoir aussi voir les différents utilisateurs qui se sont inscrits
et pouvoir les vérifier directement avec un bouton.
Il y aura aussi un lien vers les différents tags matériels et services.
Enfin il y aura un lien vers la partie questionnaire pour pouvoir en
créer un nouveau. Il aura accès aux commentaires, aux réponses, aux questions,
aux thématiques et aux questionnaires.