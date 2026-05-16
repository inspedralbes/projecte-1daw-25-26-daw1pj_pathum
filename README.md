## NOM DELS INTEGRANTS
Patrick Nima i Humberto Minaya

## NOM DEL PROJECTE
PROJECTE_FINAL2

## DESCRIPCIO WEB
Aplicació web feta en PHP per gestionar incidències tècniques de l'institut. Hi ha tres tipus d'usuari: el professor/usuari que obre incidències, el tècnic que les resol, i l'administrador que ho controla tot. La base de dades principal és MySQL i els logs es guarden a MongoDB.

## SISTEMAS INFORMATICOS
Desplegament amb Docker. El projecte inclou un Dockerfile_php per aixecar el servidor PHP amb un Docker Compose up

## ESTAT
L'aplicació té totes les funcionalitats principals implementades: creació i consulta d'incidències per part dels usuaris, gestió i resolució per part dels tècnics, i administració completa per part de l'admin. També funciona el sistema de logs amb MongoDB i el panell d'estadístiques.

## ERSTRUCTURA DE PÀGINES
**index.php** — Pàgina d'inici
La portada de l'aplicació. Mostra tres botons per entrar com a Tècnic, Administrador o Usuari. Serveix de menú principal per escollir amb quin rol vols treballar.

**interfaz_incidencias_profesor.php** — Menú de l'usuari/professor
Menú per al professor o qualsevol usuari normal. Des d'aquí pots anar a crear una incidència nova o consultar l'estat d'una que ja hagis obert abans.

**crear_incidencia.php** — Formulari per obrir una incidència
L'usuari omple un formulari per reportar un problema. Ha d'escollir el departament, el tipus d'incidència i escriure una descripció. Té validació en JavaScript perquè no s'enviï amb camps buits.

**guardar_incidencia.php** — Desa la incidència a la base de dades
Rep les dades del formulari anterior, les insereix a la base de dades i torna el número d'incidència generat. L'usuari necessita aquest número per consultar l'estat després.

**estado_incidencia_profesor.php** — Consultar l'estat d'una incidència
L'usuari introdueix el número de la seva incidència i pot veure tota la informació: qui la té assignada, la prioritat, si està pendent o ja l'han resolt, i les actuacions que el tècnic hagi marcat com a visibles.

**interfaz_tecnic.php** — Selecció de tècnic
Mostra una llista amb tots els tècnics del sistema. Quan un fa clic al seu nom, entra a veure les seves incidències. Funciona com a pantalla d'accés sense contrasenya.

**incidencies_tecnico.php** — Llista d'incidències del tècnic
El tècnic veu totes les incidències que té assignades amb el seu estat (pendent o finalitzada). Les pendents tenen un botó per gestionar-les.

**gestionar_incidencia_tecnico.php** — Gestionar una incidència
El tècnic pot escriure l'actuació que ha fet, quant de temps ha trigat, la data, i si la nota és visible per a l'usuari o només interna. També pot marcar la incidència com a finalitzada.

**tabla_actuacio_tecnico.php** — Historial d'actuacions del tècnic
Una taula amb tot el que ha fet un tècnic: totes les actuacions, de quina incidència són, quant de temps hi ha dedicat i si eren visibles o internes.

**listado_incidencias_admin.php** — Tauler de l'administrador
Vista principal de l'admin. Mostra totes les incidències pendents amb departament, tipus, tècnic assignat, prioritat i actuacions internes. Es pot cercar per ID i accedir a gestionar qualsevol incidència.

**asignar_incidencia.php** — Assignar tècnic i prioritat
Formulari per a l'administrador per assignar un tècnic a una incidència, canviar el tipus i establir la prioritat (Alta, Mitja, Baixa).

**guardar_asignacion.php** — Desa l'assignació
Rep les dades del formulari anterior, actualitza la incidència a la base de dades i redirigeix al llistat de l'admin.

**informe_tecnico.php** — Informe de càrrega de feina per tècnic
Mostra totes les incidències pendents agrupades per tècnic i ordenades per prioritat. Útil per veure qui té més feina acumulada.

**departamento_tecnico.php** — Consum per departament
Taula que mostra quantes incidències ha generat cada departament i el temps total que els tècnics hi han dedicat.

**lista_logs.php** / **estadisticas.php** — Estadístiques de visites
Panell d'estadístiques basat en les dades de MongoDB: total de visites, les tres pàgines més visitades, gràfica de visites per dia i taula dels últims accessos (hora, mètode, URL i IP). Es pot filtrar per data.

Arxius de suport
**connexio.php** — Obre la connexió amb la base de dades MySQL.

**logger.php** — S'executa a cada càrrega de pàgina. Desa a MongoDB un registre de la visita: URL, mètode, IP i navegador.

**header.php** — Capçalera comuna de totes les pàgines amb el logo, el nom de l'institut i l'enllaç a les estadístiques.

**footer.php** — Peu de pàgina fix amb els noms dels autors.

**Campsenblanc.js** — Valida que els camps del formulari de crear incidència no estiguin buits.

**Caracteres.js** — Limita els caràcters del textarea al formulari del tècnic.
