# TWE Projet

**Avant d'utiliser ce repository, bien ajoutez le sql dans votre phpmyadmin et modifiez le fichier config.php pour s'accorder avec vos conditions concretes.**

## TODO

Dans ce sujet, nous souhaitons développer une application web de covoiturage dédiée aux trajets aller-retour entre Lille et l’IG2I, à destination de tous les intervenants se rendant à Lens (vacataires, enseignants permanents, personnels techniques de l’Institut).

Cette application devra permettre notamment : 

- [ ] d’exploiter les véhicules de Centrale Lille Institut en offrant une plateforme de réservation à distance
- [ ] d’identifier les personnes intervenant à l’IG2I dans les prochains jours
- [ ] d’optimiser les points de rendez-vous entre collègues se rendant à l’IG2I, par la connaissance de leurs lieux de résidence
- [ ] de gérer des trajets dans les deux sens, pour l’organisation de réunions à Lille pour des personnels habitant à proximité de l’IG2I
- [ ] de gérer les interactions entre les covoitureurs pour finaliser leurs rendez-vous, prévenir d'un retard…
- [ ] d'afficher les rendez-vous planifiés pour pouvoir les rejoindre à la dernière minute

## Les tache

- Le backend
    - bdd
        - les voitures
        - les utilisateurs
            - compte
            - mot de passe
        - les conversations
        - les horaires
- Le frontend
    - css
      - calendar
      - chat
      - car
    - html
    - javascript

## Les pages

- Homepage
- Login
- Car
  - Choisir voiture
  - annuler la chosie
- Plans
  - la page pour choisir la date et regarder si vous avez des plans ce jour-là
- map
  - vous pouvez y accéder depuis la page de planification pour voir les trajets
- Talks
  - Chats avec les gens qui partagent les voitures avec vous
- Configuration
  - config
  - history
- History
- Header
  - Return
  - configuration
- footer
- Menu
  - Car
  - Plans
  - Talks

## Les fonctions

1. chargerCars