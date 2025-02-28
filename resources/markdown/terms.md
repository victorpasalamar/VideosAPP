# Guia del Projecte VideosApp

## Descripció del Projecte

**VideosApp** és una aplicació dissenyada per a gestionar vídeos. El projecte permet als usuaris crear, visualitzar i gestionar vídeos, amb funcionalitats bàsiques com la visualització de llistats i detalls dels vídeos, així com la creació de vídeos de prova per a desenvolupar funcionalitats addicionals.

## Objectius Principals

1. Crear una aplicació web en Laravel per a gestionar vídeos.
2. Implementar funcionalitats bàsiques com la creació, visualització i gestió de vídeos.
3. Realitzar proves automatitzades per garantir el correcte funcionament de les funcionalitats.

---

## Sprint 1: Planificació i Funcionalitats Bàsiques

### Durada: 2 setmanes

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

### Durada: 2 setmanes

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

## Sprint 3: Implementació de permisos, rols i millores en l'autenticació

### Durada: 2 setmanes

### Objectius

1. Instal·lar el paquet **spatie/laravel-permission** per gestionar permisos i rols.
2. Afegir un camp **super_admin** a la taula dels usuaris per gestionar l'accés d'usuaris superadministradors.
3. Crear les funcions al model d'usuaris `testedBy()` i `isSuperAdmin()`.
4. Configurar la creació de rols i permisos, afegir usuaris per defecte amb diferents rols (superadmin, regular, video manager).
5. Crear proves per a validar la gestió de vídeos segons els permisos dels usuaris.

### Tasques Realitzades

- Instal·lació i configuració del paquet **spatie/laravel-permission** per gestionar rols i permisos.
- Creació d'una migració per afegir el camp **super_admin** a la taula `users` i actualització del model **User**.
- Afegit la funció `isSuperAdmin()` al model `User` per verificar si un usuari és un superadministrador.
- Creació de funcions addicionals per generar usuaris amb permisos específics: `create_regular_user()`, `create_video_manager_user()`, `create_superadmin_user()`.
- Actualització del **DatabaseSeeder** per incloure usuaris per defecte amb rols de **regular**, **video manager** i **superadmin**.
- Creació de les funcions `define_gates()` i `create_permissions()` per definir les portes d'accés i permisos dels usuaris.
- Implementació de la funció `add_personal_team()` per separar la creació d'equips i usuaris.
- Creació de proves a **VideosManageControllerTest** per comprovar que els usuaris amb permisos poden gestionar vídeos i que els usuaris sense permisos no poden.
- Implementació de les funcions de prova a **UserTest** per validar la lògica de l'usuari superadmin.

---

## Sprint 4: Correccions i Millores en el CRUD de Vídeos

### Durada: 2 setmanes

### Objectius

1. Corregir els errors del 3r sprint, especialment en els tests relacionats amb els permisos d'accés a la ruta `/videosmanage`.
2. Implementar el controlador `VideosManageController` amb les funcions necessàries per al CRUD de vídeos.
3. Crear les vistes necessàries per al CRUD de vídeos, assegurant que només els usuaris amb permisos adequats puguin accedir-hi.
4. Millorar les proves existents i afegir noves proves per garantir el correcte funcionament de les funcionalitats.

### Tasques Realitzades

- **Correccions dels errors del 3r sprint**:
    - Modificació dels tests per assegurar que els usuaris amb permisos puguin accedir a la ruta `/videosmanage`.
    - Revisió i correcció dels tests existents per garantir que es comprova correctament l'accés als vídeos segons els permisos dels usuaris.

- **Creació del `VideosManageController`**:
    - Implementació de les funcions `testedBy`, `index`, `store`, `show`, `edit`, `update`, `delete` i `destroy` al controlador `VideosManageController`.
    - Creació de la funció `index` al `VideosController` per mostrar tots els vídeos disponibles.

- **Creació de les vistes per al CRUD de vídeos**:
    - Creació de les vistes `index.blade.php`, `create.blade.php`, `edit.blade.php` i `delete.blade.php` dins de la carpeta `resources/views/videos/manage/`.
    - A la vista `index.blade.php`, s'ha afegit una taula per mostrar el llistat de vídeos amb opcions per editar i eliminar.
    - A la vista `create.blade.php`, s'ha afegit un formulari per afegir nous vídeos, utilitzant l'atribut `data-qa` per facilitar les proves.
    - A la vista `edit.blade.php`, s'ha afegit un formulari per editar els vídeos existents.
    - A la vista `delete.blade.php`, s'ha afegit una confirmació per a l'eliminació de vídeos.

- **Creació de la vista principal de vídeos**:
    - Creació de la vista `index.blade.php` dins de `resources/views/videos/` per mostrar tots els vídeos disponibles, similar a la pàgina principal de YouTube.
    - En clicar a un vídeo, es redirigeix a la vista de detall del vídeo (funció `show` implementada en sprints anteriors).

- **Modificació dels tests**:
    - Modificació del test `user_with_permissions_can_manage_videos()` per assegurar que hi hagi 3 vídeos creats.
    - Creació de les funcions de prova a `VideoTest`:
        - `user_without_permissions_can_see_default_videos_page`
        - `user_with_permissions_can_see_default_videos_page`
        - `not_logged_users_can_see_default_videos_page`
    - Creació de les funcions de prova a `VideosManageControllerTest`:
        - `loginAsVideoManager`
        - `loginAsSuperAdmin`
        - `loginAsRegularUser`
        - `user_with_permissions_can_see_add_videos`
        - `user_without_videos_manage_create_cannot_see_add_videos`
        - `user_with_permissions_can_store_videos`
        - `user_without_permissions_cannot_store_videos`
        - `user_with_permissions_can_destroy_videos`
        - `user_without_permissions_cannot_destroy_videos`
        - `user_with_permissions_can_see_edit_videos`
        - `user_without_permissions_cannot_see_edit_videos`
        - `user_with_permissions_can_update_videos`
        - `user_without_permissions_cannot_update_videos`
        - `user_with_permissions_can_manage_videos`
        - `regular_users_cannot_manage_videos`
        - `guest_users_cannot_manage_videos`
        - `superadmins_can_manage_videos`

- **Creació de permisos i assignació a usuaris**:
    - A `helpers`, s'han creat els permisos necessaris per al CRUD de vídeos i s'han assignat als usuaris corresponents.

- **Configuració de les rutes**:
    - Creació de les rutes per al CRUD de vídeos dins de `videos/manage`, amb el middleware corresponent per assegurar que només els usuaris loguejats puguin accedir-hi.
    - Creació de la ruta per a la pàgina principal de vídeos (`/videos`), accessible tant per usuaris loguejats com no loguejats.

- **Millores en la interfície d'usuari**:
    - Afegit un navbar i un footer a la plantilla `resources/layouts/videosapp` per facilitar la navegació entre pàgines.

---

## Tecnologies Utilitzades

- **Laravel 11.x**: Framework per a construir l'aplicació web.
- **PHP 8.x**: Llenguatge de programació utilitzat per al backend.
- **SQLite**: Base de dades utilitzada durant el desenvolupament.
- **PHPUnit**: Eina per a les proves automatitzades.
- **spatie/laravel-permission**: Paquet per gestionar rols i permisos a Laravel.

---

## Conclusió

Aquesta aplicació proporciona una estructura bàsica per gestionar vídeos amb Laravel. Els quatre sprints han permès desenvolupar la funcionalitat principal de l'aplicació, incloent la gestió de rols i permisos per assegurar l'accés controlat a diferents seccions de l'aplicació. També s'ha establert una base sòlida de proves automatitzades per garantir la qualitat del codi. L'objectiu del projecte és establir una infraestructura robusta sobre la qual es poden afegir més funcionalitats i millores en el futur.
