# Time Exec

``Time exec`` permet de tester rapidement le temps d'exécution d'un code en PHP.

## Installation

1. Télécharger le dossier Time-Exec
2.  Inclure le dossier Time-Exec dans votre projet
```php
require __DIR__.'/lib/TimeExec/TimeExec.php';
```

## Utilisation

### Démarrer le Timer
Pour démarrer le Timer il suffit d'appeler la méthode ``start()``
```php
TimeExec::start();
```


### Stopper le Timer
Pour arrêter le Timer il suffit d'appeler la méthode ``stop()``
```php
TimeExec::stop();
```

### Marquer un évenement

Si vous souhaitez récupérer le temps d’exécution sans stopper le chronomètre, vous pouvez utiliser la méthode ``event()`` 
```php
TimeExec::event();
```
___

### Sauvegarder le numéro de ligne
Si vous souhaitez sauvegarder le numéro de ligne, vous pouvez mettre en paramètre la constante ``__LINE__``dans les méthodes ``event()`` et ``stop()``.
```php
TimeExec::event(__LINE__);
TimeExec::stop(__LINE__);
```

___
### Affichage des résultats

La méthode ``stop()`` va afficher un tableau sous la forme suivante :
![enter image description here](https://lh3.googleusercontent.com/iFNAhkJJ3qRN6NfJY5hk1Hn0d4rICe4Z_RntRXgYwZ8YNCXBqW62d61gQYLCY5G4wiY275yojHDMdQ)

#### Code correspondant au tableau :
```php
TimeExect::start();
//Code
TimeExect::event(__LINE__); // 1er Event => ligne 17
//Code
TimeExect::event(__LINE__); // 2e Event => ligne 19
//Code
TimeExect::stop(__LINE__); // Stop => ligne 21
```

#### Comment lire le tableau ?

- La première colonne correspond au numéro de ligne de l’événement ou du stop
- La deuxième colonne correspond au temps d'exécution entre le start et l'événement / stop
	- Exemple :
		- Entre le start et le premier event  le temps d'exécution et de 29.90ms
		- Entre le start et le deuxième event  le temps d'exécution et de 230.70ms
		- Entre le start et le stop  le temps d'exécution et de 236.11ms
- La troisième colonne correspond au temps d'exécution entre l’événement et le précédent évenement 
	- Exemple :
		- Entre le start et le premier event  le temps d'exécution et de 29.90ms
		- Entre le premier event et le deuxième event  le temps d'exécution et de 200.80ms
		- Entre e deuxième event et le stop  le temps d'exécution et de 5.41ms
- La quatrième colonne comporte les mêmes données que la troisième colonne mais sous forme de pourcentage, il est ainsi très facile de voir qu'elle code partie du code prend le plus de temps à être exécuté.

___

## Tester facilement un bout de code
Pour tester facilement un bout de code vous pouvez utiliser la méthode ``func()``  elle prend en paramètre une Closure (contenant le code à tester).
La méthode renvoie un tableau comme vue précédemment.

```php
TimeExect::func( function() {
	// Code a tester
};
```

Si vous le souhaitez vous pouvez utiliser la méthode ``event()`` dans la Closure.

```php
TimeExect::func( function() {
	// Code a tester
	TimeExec::event();
	// Code a tester
};
```


