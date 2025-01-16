# Guia del Projecte VideosApp

## Descripció del Projecte

**VideosApp** és una aplicació dissenyada per a gestionar vídeos. El projecte permet als usuaris crear, visualitzar i gestionar vídeos, amb funcionalitats bàsiques com la visualització de llistats i detalls dels vídeos, així com la creació de vídeos de prova per a desenvolupar funcionalitats addicionals.

## Objectius Principals

1. Crear una aplicació web en Laravel per a gestionar vídeos.
2. Implementar funcionalitats bàsiques com la creació, visualització i gestió de vídeos.
3. Realitzar proves automatitzades per garantir el correcte funcionament de les funcionalitats.

---

## Sprint 1: Planificació i Funcionalitats Bàsiques

**Durada**: 2 setmanes

### Objectius

1. Definir l'estructura de l'aplicació, incloent models, rutes i controladors.
2. Crear la funcionalitat per afegir, veure i editar vídeos.
3. Implementar proves de base per a verificar les funcionalitats.

### Tasques Realitzades

- Creació del model `Video` amb les migracions per a la taula `videos`.
- Implementació de les rutes i controladors per a gestionar vídeos.
- Creació de proves bàsiques per a validar la creació i visualització de vídeos.
- Implementació de la vista per mostrar els vídeos a l'usuari.

---

## Sprint 2: Millores i Proves Addicionals

**Durada**: 2 setmanes

### Objectius

1. Afegir funcionalitats addicionals com la creació de vídeos per defecte i usuaris per defecte.
2. Millorar la documentació i les proves de l'aplicació.
3. Assegurar que l'aplicació sigui funcional en diferents entorns de desenvolupament.

### Tasques Realitzades

- Creació del seeder per generar usuaris i vídeos per defecte.
- Millores en la configuració del layout de la vista per una millor experiència d'usuari.
- Implementació de proves unitàries per a la lògica de dates de publicació dels vídeos.
- Creació de proves de tipus *feature* per assegurar que els usuaris poden veure vídeos i que la visualització d'un vídeo no existent retorna un error 404.
- Documentació de l'estructura del projecte i les funcionalitats implementades fins al moment.

---

## Tecnologies Utilitzades

- **Laravel 11.x**: Framework per a construir l'aplicació web.
- **PHP 8.x**: Llenguatge de programació utilitzat per al backend.
- **SQLite**: Base de dades utilitzada durant el desenvolupament.
- **PHPUnit**: Eina per a les proves automatitzades.

---

## Conclusió

Aquesta aplicació proporciona una estructura bàsica per gestionar vídeos amb Laravel. Els dos sprints han permès desenvolupar la funcionalitat principal de l'aplicació, així com establir una base de proves automatitzades per garantir la qualitat del codi. L'objectiu del projecte és establir una base sòlida sobre la qual es poden afegir més funcionalitats i millores en el futur.
